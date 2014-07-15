<?php

class TrController extends Controller {

    public function actionIndex() {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        $request = $post ? array_merge_recursive($post, $get) : $get;
        $method = strtolower($request['m']) . ucfirst(strtolower($request['action']));

        if (method_exists($this, $method)) {
            $this->$method($request);
        } else
            return $this->result('Неверные параметры. Допустимые: m - set/get; action - transport/rate/user. Полученые: m=' . $request['m'] . ', action=' . $request['action']);
    }

    public function actionTest() {
//        $get = filter_input_array(INPUT_GET);
        $tr = Transport::model()->findByAttributes(array('id' => '13'));
        var_dump($tr->date_from);
        exit();
//        if(!empty($tr->rates))
//            echo 'Loool';
//        else
//            echo 'Yoooo!!!';
//        var_dump($rate);
        $old = date('Y-m-d H:i:s', strtotime('2014-02-28 08:00:00'));
        $m = strtotime($old);
        $diff = 24 * 60 * 60;
        echo (date('Y-m-d H:i:s', $m - $diff));
        exit();
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        $request = $post ? array_merge_recursive($post, $get) : $get;
        echo '<pre>';
        var_dump($request);
        echo '</pre>';
        exit();
    }

    private function setTransport($request) {
        $this->setItems($request, 'Transport', 't_id');
    }

    private function setUser($request) {
        $this->setItems($request, 'User', 'inn');
    }

    private function setItems($request, $method_name, $pk) {
        $method = 'setOne' . $method_name;
        if (!method_exists($this, $method))
            return $this->result(' Системная ошибка. Метод не найден.');

        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result(' Ошибка. Нет данных. Попробуйте еще раз.');

        if (isset($data[$pk])) {
            $this->$method($data);
        } else {
            foreach ($data as $item):
                $this->$method($item);
            endforeach;
        }
        return $this->result('Выгрузка закончена.');
    }

    private function setOneTransport($data) {
        $tr = Transport::model()->findByAttributes(array('t_id' => $data['t_id']));
        if(!empty($tr)) {
            $tr->edit_status = 'Перевозка участвует в торгах. Изменение невозможно.';
            $tr->save();
            return $this->result('Перевозка участвует в торгах. Изменение невозможно.');
        }

        //if (!empty($tr->rates))
        //    return $this->result(' Перевозка участвует в торгах. Изменение невозможно.');

        $id = $this->setOneItem('Transport', $data, 't_id');

        if ($id && $data['points']) {
            $this->setInterPoint((int) $id, $data['points']);
        }
    }

    private function setInterPoint($id, $point) {
        if (isset($id) && is_array($point) && !empty($point)) {
            TransportInterPoint::model()->deleteAll('t_id=:tid', array(':tid' => $id));
            foreach ($point as $i => $p) {

                if (!empty($p)) {
                    $new = new TransportInterPoint;
                    $new->t_id = $id;
                    $new->point = $p['point'];
                    $new->date = date('Y-m-d H:i:s', strtotime($p['date'] . ' 08:00:00'));
                    $new->sort = $i;

                    if (!$new->validate() || !$new->save())
                        return $this->result($new->getErrors());
                }
            }
        }
    }

    private function setOneUser($data) {
        $id = $this->setOneItem('TrUser', $data, 'inn');
        if ($id) {
            if ($data['persons'])
                $this->setContactPersons((int) $id, $data['persons']);
        }
    }

    private function setContactPersons($id, $persons) {
        if (isset($id) && is_array($persons) && !empty($persons)) {
            $not_in = array();
            foreach ($persons as $p) {
                if (!$p)
                    return $this->result('Неверные данные контактного лица');

                $contact = TrUser::model()->findByAttributes(array('parent' => $id, 'type_contact' => '1', 'email' => $p[email]));
                if (!$contact)
                    $contact = new TrUser;

                $company = TrUser::model()->findByPk($id);
                if ($company)
                    $contact->company = 'Контактное лицо "' . $company->company . '" (' . $contact->surname . ' ' . $contact->name . ')';

                $contact->parent = $id;
                $contact->status = TrUser::USER_ACTIVE;
                $contact->type_contact = '1';

                foreach ($contact as $name => $v) {
                    if (isset($p[$name]) || !empty($p[$name]))
                        $contact->$name = $p[$name];
                }

                if ($contact->validate() && $contact->save())
                    array_push($not_in, $contact->id);
                else
                    $this->result('Контактное лицо не сохранено. Даные не сохранены.');
            }
            if (!empty($not_in))
                Yii::app()->db_exch->createCommand()->delete('user', array('and', 'parent=' . $id, 'type_contact=1', array('not in', 'id', $not_in)));
        } else
            return $this->result('Контактные лица не сохранены. Не найден перевозчик, либо не переданы данные о контактном лице.');
    }

    private function setOneItem($model_name, $attribute, $pk) {
        if (!$attribute[$pk] || empty($attribute[$pk]))
            return $this->result('Ошибка. Нет уникального номера ' . CActiveRecord::model($model_name)->getAttributeLabel($pk));

        $app = Yii::app();
        $transaction = $app->db_exch->beginTransaction();
        try {
            $model = CActiveRecord::model($model_name)->find($pk . "='" . $attribute[$pk] . "'");
            if (!$model) {
                $model = new $model_name;
                $method = 'addDefault' . $model_name . 'Collum';
                $attribute = $this->$method($attribute);
            }
            Yii::log(' test for date_close2 = '.$attribute['date_close'], 'info');
            foreach ($model as $name => $v) {
                if (isset($attribute[$name]) || !empty($attribute[$name]))
                    $model->$name = $attribute[$name];
            }
            
            if ($model->validate() && $model->save()) {
                $transaction->commit();
                return $model->id;
            }
            $transaction->rollback();
            return $this->result($model->getErrors());
        } catch (Exception $e) {
            $transaction->rollback();
            return $this->result("Исключение: " . $e->getMessage() . "\n");
        }
    }

    private function addDefaultTransportCollum($data) {
        $app = Yii::app();
        $data[new_transport] = 1;
        $data[status] = 1;
        $data[date_published] = date('Y-m-d H:i:s');
        
        /*
        if ($data[type] == Transport::INTER_TRANSPORT)
            $data[date_close] = date('Y-m-d H:i:s', strtotime($data[date_from]) - ($app->params['timeToCloseInter'] * 60 * 60));
        elseif ($data[type] == Transport::RUS_TRANSPORT)
            $data[date_close] = date('Y-m-d H:i:s', strtotime($data[date_from]) - ($app->params['timeToCloseReg'] * 60 * 60));
        */
        //Yii::log(' test for date_close = '.$data[date_close], 'info');
        //$data[date_close] = date('Y-m-d H:i:s', strtotime($data[date_close]));
        return $data;
    }

    private function addDefaultTrUserCollum($data) {
        $data[status] = 1;
        return $data;
    }

    /* -------Start-DELETE-block-------- */

    private function delTransport($request) {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о перевозке. Попробуйте еще раз.');

        if (isset($data['t_id']))
            Transport::model()->deleteAll('t_id=:tid', array(':tid' => $data['t_id']));
        else {
            foreach ($data as $user):
                Transport::model()->deleteAll('t_id=:tid', array(':tid' => $user['t_id']));
            endforeach;
        }
        return $this->result('Удаление прошло успешно.');
    }

    private function delUser($request) {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о перевозчике. Попробуйте еще раз.');

        if (isset($data['inn']))
            TrUser::model()->deleteAll('inn=:inn', array(':inn' => $data['inn']));
        else {
            foreach ($data as $user):
                TrUser::model()->deleteAll('inn=:inn', array(':inn' => $user['inn']));
            endforeach;
        }
        return $this->result('Удаление прошло успешно.');
    }

    /* -------Start-GET-block-------- */

    private function getTransport($request) {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных. Попробуйте еще раз.');

        $in = array();
        foreach ($data as $item)
            array_push($in, $item[t_id]);

        $tr = Yii::app()->db_exch->createCommand()
                ->select('*')
                ->from('transport')
                ->where(array('in', 't_id', $in))
                ->queryAll();

        $this->renderPartial('trxml', array('data' => $tr));
    }

    private function result($text) {
        $this->renderPartial('index', array('text' => $text));
        return false;
    }

}
