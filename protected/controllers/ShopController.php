<?php

class ShopController extends Controller
{
    public function actionIndex() 
    {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
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
            return $this->result('Неверные параметры. Допустимые: m - set/get; action - equipmentmaker. Полученые: m=' . $request['m'] . ', action=' . $request['action']);
    }

    private function setSparepart($request) 
    {
        $this->setItems($request, 'Sparepart', 'external_id');
    }
    
    private function setItems($request, $method_name, $pk) 
    {
        /*$method = 'setOne' . $method_name;
        if (!method_exists($this, $method))
            return $this->result('Системная ошибка. Метод "'.$method.'" не найден.');

        $data = $request['data'];

        if (!$data || empty($data)){
            return $this->result('Ошибка. Нет данных при вызове метода "'.$method.'". Попробуйте еще раз.');
        }

        if (isset($data[$pk])) {
            $this->$method($data);
        } else {
            foreach ($data as $item):
                $this->$method($item);
            endforeach;
        }*/
        
        return $this->result('Выгрузка производителей техники закончена.');
    }
}

