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
//        $post = filter_input_array(INPUT_POST);
//        $get = filter_input_array(INPUT_GET);
//        $transport = $post ? array_merge_recursive($post, $get) : $get;
//        $app = Yii::app();
//
//        $command = $app->db_exch->createCommand();
//        $old = $command->select('id')->from('transport')
//            ->where('id_1c=:t_id', array(':t_id'=>$transport['t_id']))->queryRow();
//        if($old)
//            var_dump($old);

        echo CActiveRecord::model('Transport')->getAttributeLabel('t_id');
    }

    private function setTransport($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о перевозке. Попробуйте еще раз.');

        if (isset($data['t_id'])){
            $this->setOneItem('Transport', $data, 't_id');
        }else{
            foreach ($data as $transport):
                $this->setOneItem('Transport', $transport, 't_id');
            endforeach;
            return $this->result('Выгрузка перевозок закончена.');
        }
    }

    private function setUser($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о перевозчике. Попробуйте еще раз.');

        if (isset($data['inn'])){
            $this->setOneItem('TrUser', $data, 'inn');
        }else{
            foreach ($data as $user):
                $this->setOneItem('TrUser', $user, 'inn');
            endforeach;
            return $this->result('Выгрузка перевозчиков закончена.');
        }
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
            $model = CActiveRecord::model($model_name)->find($pk.'='.$attribute[$pk]);
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
                return $this->result('Сохранение произошло успешно.');
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