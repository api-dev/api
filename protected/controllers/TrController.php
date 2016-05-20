<?php

class TrController extends Controller
{

    public function actionIndex() {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        
        /**************************/
        //$get = array('m'=>'set', 'action'=>'transport');
        /**************************/
        
        $request = $post ? array_merge_recursive($post, $get) : $get;
        $method = strtolower($request['m']) . ucfirst(strtolower($request['action']));
        /*foreach($request['data'] as $v){
            foreach($v as $k=>$v2){
                Yii::log('(input) '.$k.' = '.$v2, 'info');
            }
        }*/
        if (method_exists($this, $method)) {
            $this->$method($request);
        } else
            return $this->result('Неверные параметры. Допустимые: m - set/get; action - transport/rate/user. Полученые: m=' . $request['m'] . ', action=' . $request['action']);
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
            return $this->result('Системная ошибка. Метод "'.$method.'" не найден.');

        $data = $request['data'];
        
        /**************************/
        
//        $data = array(
//            0 => array(
//                't_id'=>'UPR-111111111',
//                'location_from'=>'Test2',
//                'location_to'=>'Test2',
//                'user_id' => 'cheshenkov'
//            ),
//        );
        
        /**************************/

        if (!$data || empty($data)){
            return $this->result('Ошибка. Нет данных при вызове метода "'.$method.'". Попробуйте еще раз.');
        }

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
        Yii::log('Выгрузка перевозки с t_id = '.$data['t_id'], 'info');
        Yii::log('(входящее) создатель ='.$data['user_id'], 'info');
        Yii::log('(входящее) new_transport ='.$data['new_transport'], 'info');
        Yii::log('(входящее) date_close ='.$data['date_close'], 'info');
        Yii::log('(входящее) date_from ='.$data['date_from'], 'info');
        Yii::log('(входящее) date_description ='.$data['description'], 'info');
        
        /*if(!empty($tr)) {
            $tr->edit_status = 'Перевозка участвует в торгах. Изменение невозможно.';
            $tr->save();
            return $this->result('Перевозка участвует в торгах. Изменение невозможно.');
        } else {*/
            $id = $this->setOneItem('Transport', $data, 't_id');

            if ($id && $data['points']) {
                $this->setInterPoint((int) $id, $data['points']);
            }
        //}
    }

    private function setInterPoint($id, $point) {
        if (isset($id) && is_array($point) && !empty($point)) {
            TransportInterPoint::model()->deleteAll('t_id=:tid', array(':tid' => $id));
            foreach ($point as $i => $p) {

                if (!empty($p)) {
                    $new = new TransportInterPoint;
                    $new->t_id = $id;
                    $new->point = $p['point'];
                    //Yii::log('inner_point_name = '.$new->point, 'info');
                    $new->date = date('Y-m-d H:i:s', strtotime($p['date'] . ' 08:00:00'));
                    //Yii::log('inner_point = '.$new->date, 'info');
                    $new->sort = $i;

                    if (!$new->validate() || !$new->save())
                        return $this->result($new->getErrors());
                }
            }
        }
    }

    private function setOneUser($data) {
        Yii::log('Выгрузка перевозчика с inn = '.$data['inn'], 'info');
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
                
                if($model_name == 'Transport') TrChanges::saveChange($attribute['user_id'], 'Выгрузка из 1С перевозки '.$attribute['t_id']);
                else if($model_name == 'TrUser') TrChanges::saveChange('0', 'Выгрузка из 1С перевозчика '.$attribute['inn']);
            } else {
                if($model_name == 'Transport') {
                    $model->status = 1;
                    $model->rate_id = null;
                    $model->del_reason = null;
                    $model->description = null;
                    $model->auto_info = null;
                    $model->date_published = date('Y-m-d H:i:s');
                    $model->date_from = null;
                    $model->date_close_new = null;
                    
                    //$model->save();
                    
                    $rates = Rate::model()->findAll('transport_id = :id', array('id'=>$model->id));
                    TrChanges::saveChange($attribute['user_id'], 'Выгрузка из 1С перевозки '.$attribute['t_id'].', т.к. идентификатор перевозки используется повторно, то было удалено '.count($rates).' шт. ставок.');
                    Rate::model()->deleteAll('transport_id = :id', array('id'=>$model->id));
                } else if($model_name == 'TrUser') {
                    TrChanges::saveChange('0', 'Выгрузка из 1С перевозчика '.$attribute['inn']);
                }
            }
            
            foreach ($model as $name => $v) {
                if (isset($attribute[$name]) || !empty($attribute[$name])) {
                    /*if($name == 'date_close') {
                        if(!empty(trim($attribute[$name]))){
                            $model->$name = date('Y-m-d H:i:s', strtotime(trim($attribute[$name])));
                        } else {
                            TrChanges::saveChange($attribute['user_id'], 'При выгрузке из 1С перевозки '.$attribute['t_id'].', в поле "date_close" было передано пустое значение.');
                        }
                    } else $model->$name = $attribute[$name];
                    */
                    
//                    if($name == 'date_close' || $name == 'date_from' || $name == 'date_to') $model->$name = date('Y-m-d H:i:s', strtotime($attribute[$name]));
//                    //if($name == 'date_close') $model->$name = date('Y-m-d H:i:s', strtotime($attribute[$name]));
//                    else $model->$name = $attribute[$name];
                    if($name == 'date_close') {
                        $model->date_close = date('Y-m-d H:i:s', strtotime($attribute['date_close']));
                    } else if($name == 'date_to') {
                        $model->date_to = date('Y-m-d H:i:s', strtotime($attribute['date_to']));
                    } else if($name == 'date_from') {
                        $model->date_from = date('Y-m-d H:i:s', strtotime($attribute['date_from']));
                    } else $model->$name = $attribute[$name];
                    
                    if($model_name == 'TrUser') {
                        Yii::log($name.' = '.$attribute[$name], 'info');
                    }
                }
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
        //$data[new_transport] = 1;
        $data['status'] = 1;
        $data['date_published'] = date('Y-m-d H:i:s');
        //$data[del_reason] = null;
        
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
        $data['status'] = 1;
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

    private function getTransport($request)
    {
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
    
    //public function actionStat()
    private function getStatistics()
    {
        $tr = Yii::app()->db_exch->createCommand()
            ->select('*')
            ->from('transport')
            ->where('status = 0')
            ->queryAll()
        ;

        $this->renderPartial('statisticsxml', array('data' => $tr));
    }

    private function result($text) {
        $this->renderPartial('index', array('text' => $text));
        return false;
    }

}
