<?php

class ShopController extends Controller
{
    public function actionIndex() 
    {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        /**************************/
        //test
        //$get = array('m'=>'set', 'action'=>'group');
        /**************************/
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
    
    private function setGroup($request) 
    {
        Yii::log('shop: setGroup', 'info');
        $this->setGroups($request, 'Group', 'external_id');
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
        foreach($data as $k => $v){
            Yii::log($k.' = '.$v, 'info');
        }
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
            $index = 1;
            Yii::log('=== Image Name = '.$data['image_name'], 'info');
            //$photo = $this->setPhoto($index, $data['external_id']);
            $photo = $this->setPhoto($index, $data['image_name']);
            if($photo)
                $product->image = $photo;
            Yii::log('shop: before save', 'info');
            //if ($product->validate() && $product->save()) {
            $product->published = true;
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
    
    private function setPhoto($index, $name)
    {   Yii::log('shop: setPhoto', 'info');
        if(!empty($_FILES))
        {   Yii::log('shop: photo !empty', 'info');
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
                    'login' => $name,
                ));
            }else Yii::log('shop: no index', 'info');
        } else Yii::log('shop: photo empty', 'info');
        return true;
    }

    private function setOnePhoto($photo)
    {   Yii::log('shop: setOnePhoto', 'info');
        if(!$photo['login']){
            $this->result('Запчасти '.$photo['login'].' не существует!');
            return false;
        }
        
        //$dir = 'images/product'; //$this->getPhotoDir();
        $dir = 'images/shop'; //$this->getPhotoDir();
        Yii::log('shop: photo dir = '.$dir, 'info');
        $image = new Image();
        $image->mini = false;
        $image->decode = true;
        $image->dir = $dir;
        // /var/www/vhosts/lbr.ru/httpdocs/shoplbr/images/product
        //$image->externalDir = '/var/www/vhosts/lbr.ru/httpdocs/shoplbr/images/product'; //$server['DOCUMENT_ROOT'].'/../shoplbr/'.$dir;
        $return = $image->load($photo);
        //foreach($return as $mes) Yii::log('=== '.$mes, 'info');
        if(is_array($return) && !empty($return)){
            $this->result('Фото запчасти '.$photo['login'].' успешно загружено');
            //return $return[link];
            $ext = end(explode('.', strtolower($photo['name'])));
            $link = '/'.$dir.'/'.$photo['login'].'.'.$ext;
            return $link;
        } else {
            $this->result($return);
        }
    }
    
    private function result($text) {
        $this->renderPartial('index', array('text' => $text));
        return false;
    }
    
    private function setGroups($request, $method_name, $pk) 
    {
        $method = 'setOne' . $method_name;
        if (!method_exists($this, $method))
            return $this->result('Системная ошибка. Метод "'.$method.'" не найден.');
        
        $data = $request['data'];

        /**************************/
        //test
        /*$data = array(
            'external_id'=>'333',
            'name'=>'333',
            'inner'=>array(
                'external_id'=>'22',
                'name'=>'22',
                'inner'=>array(
                    'external_id'=>'11',
                    'name'=>'11',
                ),
            ),
        );*/
        /**************************/
        
        if (!$data || empty($data)) {
            return $this->result('Ошибка. Нет данных при попытке записи групп "'.$method.'". Попробуйте еще раз.');
        }
        
        if (isset($data[$pk])) {
            $this->$method($data);
        } else {
            foreach ($data as $i=>$item):
                $this->$method($item);
            endforeach;
        }
        
        return $this->result('Выгрузка запчастей закончена.');
    }
    
    private function setOneGroup($data, $parentId = null)
    {
        $commit = false;
        if (empty($data['external_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        Yii::log('shop: setOneGroup = '. $data['external_id'], 'info');

        $app = Yii::app();
        $transaction = $app->db_auth->beginTransaction();
        try {
            $group = ProductGroup::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$group){
                $group = new ProductGroup();
            }
            
            foreach ($group as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name]))
                    $group->$name = $data[$name];
            }

            $root = ProductGroup::model()->findByAttributes(array('level'=>1));
            if(empty($parentId)) {
                if(empty($root)) {
                    $root = new ProductGroup;
                    $root->name = 'Все группы';
                    $root->saveNode();
                }
            } else {
                $root = ProductGroup::model()->findByPk($parentId);
            }
            
            if($group->id) {
                if($group->moveAsFirst($root)) $commit = true;
            } else {
                if($group->appendTo($root)) $commit = true;
            }
            
            if($commit) {
                $transaction->commit();

                Yii::log('Group id '.$group->id, 'info');

                if ($group->id && $data['inner']) {
                    Yii::log('Inner for ' . $group->id, 'info');
                    $this->setOneGroup($data['inner'], $group->id); 
                }

                return $this->result('Сохранение группы '.$group->external_id.' произошло успешно.');
            }
            
            Yii::log('shop group: after save', 'info');
            $transaction->rollback();
            return $this->result($group->getErrors());
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
}

