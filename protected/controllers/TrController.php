<?php

class TrController extends Controller
{

    public function actionIndex()
    {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        $request = $post ? array_merge_recursive($post, $get) : $get;
        $method = strtolower($request['m']).ucfirst(strtolower($request['action']));
        if(method_exists($this, $method)){
            $this->$method($request);
        }else
            return $this->result('Неверные параметры. Допустимые: m - set/get; action - transport/rate/user. Полученые: m='.$request['m'].', action='.$request['action']);

    }

    public function actionTest()
    {
        echo date('Y-m-d H:i:s', strtotime('2014-02-28 08:00:00'));
        exit();
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        $request = $post ? array_merge_recursive($post, $get) : $get;
        echo '<pre>';
            var_dump($request);
        echo '</pre>';
        exit();
    }

    private function setTransport($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result(' Ошибка. Нет данных о перевозке. Попробуйте еще раз.');

        if (isset($data['t_id'])){
            $id = $this->setOneItem('Transport', $data, 't_id');
            if($id && $data['points'])
                $this->setInterPoint((int)$id, $data['points']);
        }else{
            foreach ($data as $transport):
                $id = $this->setOneItem('Transport', $transport, 't_id');
                if($id && $transport['points'])
                    $this->setInterPoint((int)$id, $transport['points']);
            endforeach;
            return $this->result(' Выгрузка перевозок закончена.');
        }
    }

    private function setUser($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о перевозчике. Попробуйте еще раз.');

        if (isset($data['inn'])){
            $id = $this->setOneItem('TrUser', $data, 'inn');
            if($id){
                $this->setUserField($id);
                if($data['persons'])
                    $this->setContactPersons((int)$id, $data['persons']);
            }
        }else{
            foreach ($data as $user):
                $id = $this->setOneItem('TrUser', $user, 'inn');
                if($id){
                    $this->setUserField($id);
                    if($data['persons'])
                        $this->setContactPersons((int)$id, $data['persons']);
                }
            endforeach;
            return $this->result('Выгрузка перевозчиков закончена.');
        }
    }
    
    private function setUserField($id)
    {
        $model = new TrUserField;
        $model->user_id = $id;
        $model->mail_transport_create_1 = false;
        $model->mail_transport_create_2 = false;
        $model->mail_kill_rate = false;
        $model->mail_before_deadline = false;
        $model->mail_deadline = true;
        $model->with_nds = false;
        if($model->save())
            return $this->result('Дополнительные поля успешно сохранены.');
    }
    private function setContactPersons($id, $persons)
    {
        if(isset($id) && is_array($persons) && !empty($persons))
        {
            foreach ($persons as $p)
            {
                if(!$p)
                    return $this->result('Неверные данные контактного лица');
                
                $contact = TrUserContact::model()->findByAttributes(array('u_id'=>$id, 'c_id'=>$p['c_id']));
                if(!$contact)
                    $contact = new TrUserContact;
                
                $contact->u_id = $id;
                $contact->status = 1;
                foreach ($contact as $name => $v){
                    if (isset($p[$name]) || !empty($p[$name]))
                        $contact->$name = $p[$name];
                }
                
                if(!$contact->validate() || !$contact->save())
                    return $this->result('Контактное лицо не сохранено. Даные не сохранены.');
                    
            }
        }
        else
            return $this->result('Контактные лица не сохранены. Не найден перевозчик, либо не переданы данные о контактном лице.');
    }


    private function delTransport($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о перевозке. Попробуйте еще раз.');

        if (isset($data['t_id']))
            Transport::model()->deleteAll('t_id=:tid', array(':tid' => $data['t_id']));
        else{
            foreach ($data as $user):
                Transport::model()->deleteAll('t_id=:tid', array(':tid' => $user['t_id']));
            endforeach;
        }
        return $this->result('Удаление прошло успешно.');
    }

    private function delUser($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о перевозчике. Попробуйте еще раз.');

        if (isset($data['inn']))
            TrUser::model()->deleteAll('inn=:inn', array(':inn' => $data['inn']));
        else{
            foreach ($data as $user):
                TrUser::model()->deleteAll('inn=:inn', array(':inn' => $user['inn']));
            endforeach;
        }
        return $this->result('Удаление прошло успешно.');
    }
    private function addDefaultTransportCollum($data)
    {
        $data[new_transport] = 1;
        $data[status] = 1;
        $data[date_published] = date('Y-m-d H:i:s');

        return $data;
    }

    private function addDefaultTrUserCollum($data)
    {
        $data[status] = 1;
        return $data;
    }

    private function getRate($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных. Попробуйте еще раз.');


//        if(is_array($data))
//            $where = array('in', 'id', $data);
//        else
//            $where = 'id='.$data;
//
//        $app = Yii::app();
//        $return = $app->db_exch->createCommand()
//            ->select('transport.id, rate.*')
//            ->from('transport')
//            ->where($where)
//            ->queryAll();
//
//        var_dump($return);
    }

    private function setOneItem($model_name, $attribute, $pk)
    {
        if (!$attribute[$pk] || empty($attribute[$pk]))
            return $this->result('Ошибка. Нет уникального номера '.CActiveRecord::model($model_name)->getAttributeLabel($pk));

        $app = Yii::app();
        $transaction = $app->db_exch->beginTransaction();
        try {
            $model = CActiveRecord::model($model_name)->find($pk."='".$attribute[$pk]."'");
            if(!$model)
            {
                $model = new $model_name;
                $method = 'addDefault'.$model_name.'Collum';
                $attribute = $this->$method($attribute);
            }

            foreach ($model as $name => $v){
                if (isset($attribute[$name]) || !empty($attribute[$name]))
                    $model->$name = $attribute[$name];
            }
            if ($model->validate() && $model->save()){
                $transaction->commit();
                return $model->id;
            }
            $transaction->rollback();
            return $this->result($model->getErrors());
        }catch (Exception $e) {
            $transaction->rollback();
            return $this->result("Исключение: " . $e->getMessage() . "\n");
        }
    }

    private function result($text)
    {
        $this->renderPartial('index', array('text' => $text));
        return false;
    }
}