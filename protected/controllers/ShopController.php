<?php

class ShopController extends Controller
{
    public function actionIndex() 
    {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        $request = $post ? array_merge_recursive($post, $get) : $get;
        $method = strtolower($request['m']) . ucfirst(strtolower($request['action']));
        Yii::log('input from shop !!!!!!!!!', 'info');
        Yii::log('shop: '.$method, 'info');
        /*
        foreach($request['data'] as $v){
            foreach($v as $k=>$v2){
                Yii::log('(input) '.$k.' = '.$v2, 'info');
            }
        }
        */
        
        if (method_exists($this, $method)) {
            $this->$method($request);
        } else
            return $this->result('Неверные параметры. Допустимые: m - set; action - sparepart. Полученные: m=' . $request['m'] . ', action=' . $request['action']);
    }

    private function setSparepart($request) 
    {
        Yii::log('shop: setSparepart', 'info');
        $this->setItems($request, 'Sparepart', 'external_id');
    }
    
    private function setItems($request, $method_name, $pk) 
    {
        $method = 'setOne' . $method_name;
        if (!method_exists($this, $method))
            return $this->result('Системная ошибка. Метод "'.$method.'" не найден.');

        $data = $request['data'];

        if (!$data || empty($data)) {
            return $this->result('Ошибка. Нет данных при вызове метода "'.$method.'". Попробуйте еще раз.');
        }

        if (isset($data[$pk])) {
            $this->$method($data);
        } else {
            foreach ($data as $i=>$item):
                $this->$method($item, $i);
            endforeach;
        }
        
        return $this->result('Выгрузка запчастей закончена.');
    }
    private function setOneSparepart($data, $index = 1) 
    {
        if (empty($data['external_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        Yii::log('shop: setOneSparepart', 'info');
        $app = Yii::app();
        $transaction = $app->db_auth->beginTransaction();
        try {
            $product = Product::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$product)
                $product = new Product();

            foreach ($product as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name]))
                    $product->$name = $data[$name];
            }
            Yii::log('shop: attributes', 'info');
            //$photo = $this->setPhoto($index, $product['external_id']);
            //if($photo)
            //    $product->image = $photo;
            Yii::log('shop: before save', 'info');
            //if ($product->validate() && $product->save()) {
            if ($product->save()) {
                $transaction->commit();
                return $this->result('Сохранение '.$product->external_id.' произошло успешно.');
            }
            Yii::log('shop: after save', 'info');
            $transaction->rollback();
            return $this->result($product->getErrors());
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    
    private function setPhoto($index, $externalId)
    {   Yii::log('shop: setPhoto', 'info');
        if(!empty($_FILES))
        {
            $uploadFile = $_FILES['datafile'];
            $tmp_name = $uploadFile['tmp_name'];
            if(isset($tmp_name[$index]))
            {
                return $this->setOnePhoto(array(
                    'name' => $uploadFile['name'][$index],
                    'type' => $uploadFile['type'][$index],
                    'tmp_name' => $tmp_name[$index],
                    'error' => $uploadFile['error'][$index],
                    'size' => $uploadFile['size'][$index],
                    'login' => $externalId,
                ));
            }
        }
        return true;
    }

    private function setOnePhoto($photo)
    {
        if(!$photo['login']){
            $this->result('Пользователя '.$photo['login'].' не существует!');
            return false;
        }
        
        $dir = $this->getPhotoDir();
        $image = new Image();
        $image->mini = false;
        $image->decode = true;
        $image->dir = $dir;
        $return = $image->load($photo);
        
        if(is_array($return) && !empty($return)){
            $this->result('Фото пользователя '.$photo['login'].' успешно загружено');
            return $return[link];
        } else {
            $this->result($return);
        }
    }
    
    private function getPhotoDir()
    {
        /*if(!$id)
            return $this->result('Не найдено id категории');
            
        $group = Group::model()->findByPk($id);
        $ancestors = $group->ancestors()->findAll();
        $parent = 'images/photo';
        for($i=1; $i<count($ancestors); $i++)
        {
            $folder = Translite::rusencode($ancestors[$i]->name);
            $parent .= '/'.$folder;
        }
        return $parent;*/
        
        return 'images/shop';
    }
    
    private function result($text) {
        $this->renderPartial('index', array('text' => $text));
        return false;
    }
}

