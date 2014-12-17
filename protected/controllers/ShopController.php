<?php

class ShopController extends Controller
{
    public function actionIndex() 
    {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        /**************************/
        //test
        //$get = array('m'=>'set', 'action'=>'modelline');
        /**************************/
        $request = $post ? array_merge_recursive($post, $get) : $get;
        
        $method = strtolower($request['m']) . ucfirst(strtolower($request['action']));
        Yii::log('input from shop !!!!!!!!!', 'info');
        Yii::log('shop: '.$method, 'info');

        if (method_exists($this, $method)) {
            $this->$method($request);
        } else
            return $this->result('Неверные параметры. Допустимые: m - set; action - sparepart. Полученные: m=' . $request['m'] . ', action=' . $request['action']);
    }
    
    /*-------- Set Sparepart --------*/
    private function setSparepart($request) 
    {
        Yii::log('shop: setSparepart', 'info');
        $this->setItems($request, 'Sparepart', 'external_id');
    }
    
    private function setItems($request, $method_name, $pk, $parentId = false) 
    {
        $method = 'setOne' . $method_name;
        if (!method_exists($this, $method))
            return $this->result('Системная ошибка. Метод "'.$method.'" не найден.');

        $data = $request['data'];

        /**************************/
        //test
        /*
        $data = array(
            0 => array(
                'external_id'=>'333',
                'name'=>'Почвообработка и посев',
                'category'=>'333',
                'inner'=>array(
                    0 => array(
                        'external_id'=>'22',
                        'name'=>'Бороны дисковые',
                        'category'=>'333',
                        'inner'=>array(
                        ),
                    ),
                    1 => array(
                        'external_id'=>'666',
                        'name'=>'lkjlkjlkj',
                        'category'=>'333',
                        'inner'=>array(
                        ),
                    ),
                ),
            ),
            1 => array(
                'external_id'=>'888',
                'name'=>'!! Тестовый',
                'published'=>'0',
                'category'=>'666',
                'inner'=>array(
                ),
            ),
        );
        */
        /**************************/
        
        if (!$data || empty($data)) {
            return $this->result('Ошибка. Нет данных при вызове метода "'.$method.'". Попробуйте еще раз.');
        }

        if (isset($data[$pk])) {
            $this->$method($data);
        } else {
            if($parentId){
                foreach ($data as $i=>$item):
                    $this->$method($item);
                endforeach;
            } else {
                foreach ($data as $i=>$item):
                    $this->$method($item, $i);
                endforeach;    
            }
        }
        
        return $this->result('Выгрузка данных в магазин закончена.');
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
    /*-------- End Set Sparepart --------*/
    /*-------- Set Groups ---------------*/
    
    private function setGroup($request) 
    {
        Yii::log('shop: setGroup', 'info');
        $this->setItems($request, 'Group', 'external_id', true);
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
                    $group->$name = trim($data[$name]);
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
                $group->saveNode();
                if($group->moveAsLast($root)) $commit = true;
            } else {
                if($group->appendTo($root)) $commit = true;
            }
            
            if($commit) {
                $transaction->commit();

                Yii::log('Group id '.$group->id, 'info');
                if ($group->id && $data['inner']) {
                    Yii::log('Inner for ' . $group->id, 'info');
                    if(is_array($data['inner'])) {
                        foreach($data['inner'] as $item) {
                            $this->setOneGroup($item, $group->id);
                        }
                    } else $this->setOneGroup($data['inner'], $group->id);
                    
                }

                return $this->result('Сохранение группы '.$group->external_id.' произошло успешно.');
            }
            
            $transaction->rollback();
            return $this->result($group->getErrors());
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    /*-------- End Set Groups --------*/
    /*-------- Set Category ----------*/
    
    private function setCategory($request) 
    {
        Yii::log('shop: setCategory', 'info');
        $this->setItems($request, 'Category', 'external_id', true);
    }
    
    private function setOneCategory($data, $parentId = null, $prefix = '')
    {
        $commit = false;
        if (empty($data['external_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneCategory = '. $data['external_id'], 'info');

        $app = Yii::app();
        $transaction = $app->db_auth->beginTransaction();
        try {
            $category = ProductCategory::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$category) {
                $category = new ProductCategory();
            }
            
            foreach ($category as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name])){
                    $category->$name = trim($data[$name]);
                }
                
                if(isset($data['published'])) $category->published = (bool)((int)$data['published']);
                else $category->published = true;
                
                if(!empty($category->name)) $category->path = $prefix.'/'.Translite::rusencode($category->name, '-');
            }

            $root = ProductCategory::model()->findByAttributes(array('level'=>1));
            if(empty($parentId)) {
                if(empty($root)) {
                    $root = new ProductCategory;
                    $root->name = 'Все категории';
                    $root->published = true;
                    $root->saveNode();
                }
            } else {
                $root = ProductCategory::model()->findByPk($parentId);
            }
            
            if($category->id) {
                $category->saveNode();
                if($category->moveAsLast($root)) $commit = true;
            } else {
                if($category->appendTo($root)) $commit = true;
            }
            
            if($commit) {
                $transaction->commit();

                Yii::log('Category id '.$category->id, 'info');

                if ($category->id && $data['inner']) {
                    Yii::log('Inner for ' . $category->id, 'info');

                    if(is_array($data['inner'])) {
                        foreach($data['inner'] as $item) {
                            $this->setOneCategory($item, $category->id, $category->path);
                        }
                    } else $this->setOneCategory($data['inner'], $category->id, $category->path);
                    
                }
                return $this->result('Сохранение категории '.$category->external_id.' произошло успешно.');
            }
            
            $transaction->rollback();
            return $this->result($category->getErrors());
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    /*-------- End Set Category --------*/
    /*-------- Set Modelline -----------*/
    private function setModelline($request)
    {
        Yii::log('shop: setModelline', 'info');
        $this->setItems($request, 'Modelline', 'external_id', true);
    }
    
    private function setOneModelline($data, $parentId = null, $prefix = '')
    {
        $commit = false;
        if (empty($data['external_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneModelLine = '. $data['external_id'], 'info');
        
        $app = Yii::app();
        $transaction = $app->db_auth->beginTransaction();
        try {
            $modelLine = ProductModelLine::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$modelLine) {
                $modelLine = new ProductModelLine();
            }
            
            foreach ($modelLine as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name])){
                    $modelLine->$name = trim($data[$name]);
                }
                
                if(isset($data['published'])) $modelLine->published = (bool)((int)$data['published']);
                else $modelLine->published = true;
                
                $category = ProductCategory::model()->find('external_id = :external_id', array(':external_id' => $data['category']));
                if(!empty($category))$modelLine->category_id = $category->id;

                if(!empty($modelLine->name)) $modelLine->path = $prefix.'/'.Translite::rusencode($modelLine->name, '-');
            }

            $root = ProductModelLine::model()->findByAttributes(array('level'=>1));
            if(empty($parentId)) {
                if(empty($root)) {
                    $root = new ProductModelLine;
                    $root->name = 'Все модельные ряды';
                    $root->published = true;
                    $root->saveNode();
                }
            } else {
                $root = ProductModelLine::model()->findByPk($parentId);
            }
            
            if($modelLine->id) {
                $modelLine->saveNode();
                if($modelLine->moveAsLast($root)) $commit = true;
            } else {
                if($modelLine->appendTo($root)) $commit = true;
            }
            
            if($commit) {
                $transaction->commit();

                Yii::log('Modelline id '.$modelLine->id, 'info');

                if ($modelLine->id && $data['inner']) {
                    Yii::log('Inner for ' . $modelLine->id, 'info');

                    if(is_array($data['inner'])) {
                        foreach($data['inner'] as $item) {
                            $this->setOneModelline($item, $modelLine->id, $modelLine->path);
                        }
                    } else $this->setOneModelline($data['inner'], $modelLine->id, $modelLine->path);
                    
                }
                return $this->result('Сохранение модели '.$modelLine->external_id.' произошло успешно.');
            }
            
            $transaction->rollback();
            return $this->result($modelLine->getErrors());
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    
    /*-------- End Set Modelline --------*/
    
    private function result($text) {
        $this->renderPartial('index', array('text' => $text));
        return false;
    }
}

