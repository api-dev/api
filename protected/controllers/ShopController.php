<?php

class ShopController extends Controller
{
    public function actionIndex()
    {   
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        /**************************/
        //$get = array('m'=>'set', 'action'=>'draftmodel');
        /**************************/
        $request = $post ? array_merge_recursive($post, $get) : $get;
        
        $method = strtolower($request['m']) . ucfirst(strtolower($request['action']));
        Yii::log('input from shop !!!!!!!!!', 'info');
        Yii::log('shop: '.$method, 'info');

        if (method_exists($this, $method)) {
            $this->$method($request);
        } else
            return $this->result('Неверные параметры. Допустимые: m - set/get/del; action - sparepart. Полученные: m=' . $request['m'] . ', action=' . $request['action']);
    }
    
    /*-------- Get Sparepart --------*/
    private function getSparepart($request) 
    {
        $data = $request['data'];
        //////////////////////////////
        /*$data = array(
            0 => array(
                'external_id'=>'MNS0016106'
            )
        );*/
        /////////////////////////////////
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных. Попробуйте еще раз.');

        $in = array();
        foreach ($data as $item)
            array_push($in, $item[external_id]);
        
        $sp = Yii::app()->db_shop->createCommand()
                ->select('*')
                ->from('product')
                ->where(array('in', 'external_id', $in))
                ->queryAll()
        ;

        $this->renderPartial('spxml', array('data' => $sp));
    }
    /*-------- End get Sparepart ----*/
    /*-------- Get Order ------------*/
    /*private function getOrder($request) 
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных. Попробуйте еще раз.');

//        $in = array();
//        foreach ($data as $item)
//            array_push($in, $item[external_id]);
//        
//        $sp = Yii::app()->db_shop->createCommand()
//                ->select('*')
//                ->from('product')
//                ->where(array('in', 'external_id', $in))
//                ->queryAll()
//        ;
        
        $this->renderPartial('orderxml', array('data' => $sp));
    }*/
    /*-------- End get Order --------------*/
    /*-------- Start get Analitics --------*/
    // get all unique analitics
    private function getAnalitics($request) 
    {
        set_time_limit(0);
        $analitics = Yii::app()->db_shop->createCommand()
            ->select('*')
            ->from('analitics')
            ->where('push_1C=:flag', array(':flag'=>true))
            ->queryAll()
        ;
        
        $temp = $analitics;
        foreach($temp as $info){
            $item = ShopAnalitics::model()->findByPk($info[id]);
            $item->push_1C = false;
            $item->save();
        }
        
        $this->renderPartial('analiticsxml', array('data' => $analitics));
    }
    
    // get all analitics by time
    private function getAnaliticsbytime($request) 
    {
        set_time_limit(0);
        $data = $request['data'];
        
        /*$data = array(
            'from'=>'2015-08-14',
            'to'=>'2015-08-19',
        );*/
        
        if(!empty($data['from']) && !empty($data['to'])) {
            $analitics = Yii::app()->db_shop->createCommand()
                ->select('*')
                ->from('analitics')
                ->where('date_created between "'.date('Y-m-d', strtotime($data['from'])).'" and "'.date('Y-m-d', strtotime($data['to'].' +1 days')).'"')
                ->queryAll()
            ;
            Yii::log('shop: getAnalitics by time ('.$data['from'].' - '.$data['to'].') - it was found '.count($analitics).' records', 'info');
        
            $this->renderPartial('analiticsxml', array('data' => $analitics));
        } else 
            Yii::log('shop: getAnalitics by time - no info data[from] or data[to]', 'info');
    }
    
    // get analitics by evp's id
    private function getAnaliticsbyevpid($request) 
    {
        set_time_limit(0);
        $data = $request['data'];
        
        /*$data = array(
            'subscription_id'=>'EVP_market1',
            'link_id'=>'1'
        );*/
        
        if(!empty($data['subscription_id']) && isset($data['link_id'])) {
            $sql = 'and link_id is null';
            if((int)$data['link_id']) {
                $sql = 'and link_id is not null';
            }

            $analitics = Yii::app()->db_shop->createCommand()
                ->select('*')
                ->from('analitics')
                ->where('subscription_id=:id '.$sql, array('id'=>$data['subscription_id']))
                ->queryAll()
            ;
            
            $this->renderPartial('analiticsxml', array('data' => $analitics));
        } else 
            Yii::log('shop: getAnalitics by evp id - no info data[subscription_id] or data[link_id]', 'info');
    }
    
    // get analitics by evp's id unique
    private function getAnaliticsbyevpidunique($request) 
    {
        set_time_limit(0);
        $data = $request['data'];
        
        /*$data = array(
            'subscription_id'=>'EVP_market1',
            'link_id'=>'1'
        );*/
        
        if(!empty($data['subscription_id']) && isset($data['link_id'])) {
            $sql = 'and link_id is null';
            if((int)$data['link_id']) {
                $sql = 'and link_id is not null';
            }

            $analitics = Yii::app()->db_shop->createCommand()
                ->select('*')
                ->from('analitics')
                ->where('subscription_id=:id and push_1C=:flag '.$sql, array('id'=>$data['subscription_id'], 'flag'=>true))
                ->queryAll()
            ;
            
            $temp = $analitics;
            foreach($temp as $info){
                $item = ShopAnalitics::model()->findByPk($info[id]);
                $item->push_1C = false;
                $item->save();
            }
            
            $this->renderPartial('analiticsxml', array('data' => $analitics));
        } else 
            Yii::log('shop: getAnalitics by evp id - no info data[subscription_id] or data[link_id]', 'info');
    }
    
    public function getTime($time)
    {
        $hours = (int)($time/3600);
        $time -= $hours*3600; 
        if(strlen($hours) == 1) $hours = '0'.$hours;
        $minutes = (int)($time/60);
        if(strlen($minutes) == 1) $minutes = '0'.$minutes;
        $seconds = (int)($time%60);
        if(strlen($seconds) == 1) $seconds = '0'.$seconds;
        
        return $hours.':'.$minutes.':'.$seconds;
    }
    /*-------- End get Analitics --------*/
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
        
        /*$data = array(
            0 => array(
                'external_id'=>'MNS0016106',
                'problem'=>'Пр',
                'multiplicity'=>'1',
                'date_sale_off'=>'07.07.2007',
                'product_group'=>'111',
                'product_group_name'=>'test'
            ),
        );*/
        
        /*$data = array(
            0 => array(
                'external_id'=>'UPR0000334',
                'name'=>'Барнаул',
                'inner'=>array(
                    0 => array(
                        'external_id'=>'UPR0023594',
                        'name'=>'Алтайский край2',
                    ),
                    1 => array(
                        'external_id'=>'TRM0000966',
                        'name'=>'Восточно-Казахстанская область2',
                    ),
                ),
            ),
        );*/
        /*$data = array(
            0 => array(
                'external_id'=>'MNS0003740',
                'user_id'=>'10000',
            ),
        );*/
        
        /*$data = array(
            0 => array(
                'external_id'=>'MNS-00001088',
                'name'=>'jjjjj',
                'inner'=>array(
                    0 => array('model_line_id'=>'1 051'),
                    1 => array('model_line_id'=>'1 018'),
                ),
            ),
        );*/
        
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
        /*foreach($data as $k => $v){
            Yii::log($k.' = '.$v, 'info');
        }*/
        $app = Yii::app();
        $transaction = $app->db_auth->beginTransaction();
        try {
            $product = Product::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$product)
                $product = new Product();

            foreach ($product as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name])) {
                    if($name == 'problem') {
                        $product->problem = mb_strtolower($data['problem'], 'UTF-8');
                    } else if($name == 'date_sale_off') {
                        $product->date_sale_off = date_format(date_create_from_format('d.m.Y', $data['date_sale_off']), 'Y-m-d');
                    } else if($name == 'original') {
                        $product->original = (int)$data['original'];
                    } else {
                        $product->$name = $data[$name];
                    }
                }
                Yii::log($name.' = '.$product->$name, 'info');
            }
            
            $groupId = ProductGroup::model()->find('external_id=:external_id', array(':external_id' => $data['product_group']))->id;
            if(!empty($groupId)) {
                $product->product_group_id = $groupId;
            } else {
                /*$root = ProductGroup::model()->findByAttributes(array('level'=>1));
                $group = new ProductGroup();
                $group->name = $data['product_group_name'];
                $group->appendTo($root);
                $product->product_group_id = $group->id;*/
                $product->product_group_id = null;
            }
            
            $makerId = ProductMaker::model()->find('external_id=:external_id', array(':external_id' => $data['product_maker']))->id;
            if(!empty($makerId)) $product->product_maker_id = $makerId;
            
            Yii::log('shop: attributes', 'info');
            $index = 1;
            Yii::log('=== Image Name = '.$data['image_name'], 'info');
            
            //$photo = $this->setPhoto($index, $data['external_id']);
            
            /*
            $photo = $this->setPhoto($index, $data['image_name']);
            if($photo)
                $product->image = $photo;
            */
            
            $product->image = $data['image_name'];
            Yii::log('shop: before save', 'info');
            //if ($product->validate() && $product->save()) {
            $product->published = true;
            $product->update_time = date('Y-m-d H:i:s');
                
            if ($product->save()) {
                if(!empty($product->name)) {
                    $product->path = '/sparepart/'.$product->id.'-'.Translite::rusencode($product->name, '-').'/';
                    $product->save();
                }
                
                $transaction->commit();
                if(is_array($data['inner'])) {
                    foreach($data['inner'] as $item) {
                        $model = ProductModelLine::model()->find('external_id=:external_id', array(':external_id' => $item['model']));
                        if (!$model) {
                            Yii::log('Model '.$item['model']." was't found.", 'info');
                        } else {
                            $exists = ProductInModelLine::model()->exists('product_id = :product_id and model_line_id = :model_id', array(':product_id'=>$product->id, ':model_id'=>$model->id));
                            if(!$exists){
                                $transact = $app->db_auth->beginTransaction();
                                $element = new ProductInModelLine;
                                $element->model_line_id = $model->id;
                                $element->product_id = $product->id;
                                if($element->save()) {
                                    $transact->commit();
                                    Yii::log('Сохранение продукта (id = '.$product->id.') в модельный ряд '.$item['model'].' произошло успешно.', 'info');
                                } else {
                                    $transact->rollback();
                                    Yii::log('Ошибка при сохранении товара в модельный ряд '.$item['model'], 'info');
                                }
                            } else Yii::log('Продукт id='.$product->id.' в модельном ряду id='.$model->id.' уже существует. ', 'info');
                        }
                    }
                }
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
                    'size'  => $uploadFile['size'][$index],
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
        
        if(empty($data['user_id']))
            return $this->result('Ошибка. Нет данных о пользователе, совершающем транзакцию. Попробуйте еще раз.');
        
        Yii::log('shop: setOneGroup = '. $data['external_id'], 'info');
        
        $app = Yii::app();
        $transaction = $app->db_auth->beginTransaction();
        try {
            $group = ProductGroup::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$group) {
                $group = new ProductGroup();
                ShopChanges::saveChange($data['user_id'], 'Через api создана группа с id='.$data['external_id']);
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
                //$group->saveNode();
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
            set_time_limit(0);
            
            if (!$category) {
                $category = new ProductCategory();
            }
            /*else {
                // del all children
                $allChildren = $category->children()->findAll();
                foreach($allChildren as $oneChild){
                   $oneChild->deleteNode();
                }
            }*/
            
            foreach ($category as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name])) {
                    preg_match('/\d{1,}\./i', $data[$name], $result);
                    if(!empty($result[0])) {
                        $strlen = strlen($result[0]);
                        $category->name = substr($data[$name], $strlen);
                    } else 
                        $category->$name = trim($data[$name]);
                }
                
                if(isset($data['published'])) $category->published = (bool)((int)$data['published']);
                else $category->published = true;
                
                if(!empty($category->name)) $category->path = $prefix.'/'.Translite::rusencode($category->name, '-');
            }
            
            $makerId = ProductMaker::model()->find('external_id=:external_id', array(':external_id' => $data['equipment_maker']))->id;
            if(!empty($makerId)) $product->product_maker_id = $makerId;
            
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
            
            $category->update_time = date('Y-m-d H:i:s');
            if($category->id) {
                $category->saveNode();
                //if($category->moveAsLast($root)) 
                $commit = true;
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
        Yii::log('shop: category = '. $data['category'], 'info');
        Yii::log('shop: maker = '. $data['maker'], 'info');
        
        $app = Yii::app();
        $transaction = $app->db_auth->beginTransaction();
        try {
            $modelLine = ProductModelLine::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$modelLine) {
                $modelLine = new ProductModelLine();
            }
            
            foreach ($modelLine as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name])) {
                    $modelLine->$name = trim($data[$name]);
                }
                
                if(isset($data['published'])) $modelLine->published = (bool)((int)$data['published']);
                else $modelLine->published = true;
                
                $category = ProductCategory::model()->find('external_id = :external_id', array(':external_id' => $data['category']));
                if(!empty($category)) $modelLine->category_id = $category->id;
                
                $maker = EquipmentMaker::model()->find('external_id = :external_id', array(':external_id' => $data['maker']));
                if(!empty($maker)) $modelLine->maker_id = $maker->id;

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
            
            $modelLine->update_time = date('Y-m-d H:i:s');
            if($modelLine->id) {
                $modelLine->saveNode();
                //if($modelLine->moveAsLast($root))
                $commit = true;
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
    /*-------- Set ModelProduct --------*/
    
    /*private function setModelproduct($request) 
    {
        Yii::log('shop: setModelProduct', 'info');
        $this->setItems($request, 'ModelProduct', 'model_line');
    }
    
    private function setOneModelproduct($data)
    {
        if (empty($data['model_line']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneModelProduct = '. $data['model_line'], 'info');
        
        try {
            $model = ProductModelLine::model()->find('external_id=:external_id', array(':external_id' => $data['model_line']));
            if (!$model) {
                return $this->result('Ошибка. Модель не найдена.');
            }
            
            ProductInModelLine::model()->deleteAll('model_line_id=:model_line_id', array(':model_line_id' => $model->id));
            if(is_array($data['inner'])) {
                foreach($data['inner'] as $item) {
                    $this->saveProductInModel($item['product_id'], $model->id);
                }
                return $this->result('Выгрузка продуктов для модельного ряда '.$data['model_line'].' закончена.');
            }
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    
    private function saveProductInModel($id, $modelId)
    {
        $app = Yii::app();
        $product = Product::model()->find('external_id=:external_id', array(':external_id' => $id));
        if($product) {
            $transaction = $app->db_auth->beginTransaction();
            $element = new ProductInModelLine;
            $element->model_line_id = $modelId;
            $element->product_id = $product->id;
            if($element->save()) {
                $transaction->commit();
                return $this->result('Сохранение продукта (id = '.$id.') в модельный ряд произошло успешно.');
            } else {
                $transaction->rollback();
                return $this->result($element->getErrors());
            }
        } else {
            return $this->result('Ошибка. Продукт с id='.$id.' не найден.');
        }
    }*/
    /*-------- End Set ModelProduct --------*/
    /*-------- Set ModelEquipment ----------*/
    
    /*private function setModelEquipment($request) 
    {
        Yii::log('shop: setModelEquipment', 'info');
        $this->setItems($request, 'ModelEquipment', 'model');
    }
    
    private function setOneModelEquipment($data)
    {
        if (empty($data['model']) || empty($data['maker']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneModelEquipment (model = '.$data['model'].'; maker = '. $data['maker'].')', 'info');
        
        try {
            $maker = EquipmentMaker::model()->find('external_id=:external_id', array(':external_id' => $data['maker']));
            if (!$maker) {
                return $this->result('Ошибка. Производитель техники не найден.');
            }
            
            $model = ProductModelLine::model()->find('external_id=:external_id', array(':external_id' => $data['model']));
            if (!$model) {
                return $this->result('Ошибка. Модель не найдена.');
            }
            $app = Yii::app();
            Yii::log('shop: model ('.$model->id.') and maker('.$maker->id.') - ok', 'info');
            //EquipmentInModelLine::model()->deleteAll('model_id=:model_line_id', array(':model_line_id' => $model->id));
            Yii::log('shop: after delete', 'info');
            
            $transaction = $app->db_auth->beginTransaction();
            
            $element = new EquipmentInModelLine;
            $element->model_id = $model->id;
            $element->maker_id = $maker->id;
            Yii::log('shop: set values', 'info');
            if($element->save()) {
                Yii::log('shop: commit', 'info');
                $transaction->commit();
                return $this->result('Сохранение соотношения в таблицу equipment_maker_in_model произошло успешно.');
            } else {
                Yii::log('shop: rollback', 'info');
                $transaction->rollback();
                return $this->result($element->getErrors());
            }
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }*/
    /*-------- End ModelEquipment ----------*/
    /*-------- Set RelatedProduct ----------*/
    private function setRelatedProduct($request) 
    {
        Yii::log('shop: setRelatedProduct', 'info');
        $this->setItems($request, 'RelatedProduct', 'product_id');
    }
    
    private function setOneRelatedProduct($data)
    {
        if (empty($data['product_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneRelatedProduct = '. $data['product_id'], 'info');
        
        try {
            $model = Product::model()->find('external_id=:external_id', array(':external_id' => $data['product_id']));
            if (!$model) {
                return $this->result('Ошибка. Продукт не найден.');
            }
            
            RelatedProduct::model()->deleteAll('product_id=:product_id', array(':product_id' => $model->id));
            if(is_array($data['inner'])) {
                foreach($data['inner'] as $item) {
                    $this->saveRelatedProduct($item['related_id'], $model->id);
                }
                return $this->result('Выгрузка сопутствующих товаров для продукта '.$data['product_id'].' закончена.');
            } 
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    
    private function saveRelatedProduct($id, $modelId)
    {
        $app = Yii::app();
        $product = Product::model()->find('external_id=:external_id', array(':external_id' => $id));
        if($product) {
            $transaction = $app->db_auth->beginTransaction();
            $element = new RelatedProduct;
            $element->product_id = $modelId;
            $element->related_product_id = $product->id;
            if($element->save()) {
                $transaction->commit();
                return $this->result('Сохранение сопутствующего товара (id = '.$id.') произошло успешно.');
            } else {
                $transaction->rollback();
                return $this->result($element->getErrors());
            }
        } else {
            return $this->result('Ошибка. Сопутствующий товар с id='.$id.' не найден.');
        }
    }
    /*-------- End Set RelatedProduct ------*/
    /*-------- Set AnalogProduct -----------*/
    private function setAnalogProduct($request)
    {
        Yii::log('shop: setAnalogProduct', 'info');
        $this->setItems($request, 'AnalogProduct', 'product_id');
    }
    
    private function setOneAnalogProduct($data)
    {
        if (empty($data['product_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneAnalogProduct = '. $data['product_id'], 'info');
        
        try {
            $model = Product::model()->find('external_id=:external_id', array(':external_id' => $data['product_id']));
            if (!$model) {
                return $this->result('Ошибка. Продукт не найден.');
            }
            
            ProductAnalog::model()->deleteAll('product_id=:product_id', array(':product_id' => $model->id));
            if(is_array($data['inner'])) {
                foreach($data['inner'] as $item) {
                    Yii::log('inner = '. $item['analog_id'], 'info');
                    $this->saveAnalogProduct($item['analog_id'], $model->id);
                }
                return $this->result('Выгрузка аналогов для продукта '.$data['product_id'].' закончена.');
            } 
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    
    private function saveAnalogProduct($id, $modelId)
    {
        $app = Yii::app();
        $product = Product::model()->find('external_id=:external_id', array(':external_id' => $id));
        if($product) {
            $transaction = $app->db_auth->beginTransaction();
            $element = new ProductAnalog;
            $element->product_id = $modelId;
            $element->analog_product_id = $product->id;
            if($element->save()) {
                $transaction->commit();
                return $this->result('Сохранение аналога (id = '.$id.') произошло успешно.');
            } else {
                $transaction->rollback();
                return $this->result($element->getErrors());
            }
        } else {
            return $this->result('Ошибка. Аналог с id='.$id.' не найден.');
        }
    }
    /*-------- End Set AnalogProduct ------*/
    /*-------- Set ProductMaker -----------*/
    private function setProductMaker($request)
    {
        Yii::log('shop: setProductMaker', 'info');
        $this->setMaker($request, 'ProductMaker', 'external_id');
    }
    
    private function setMaker($request, $method_name, $pk, $parentId = false) 
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
                'external_id'=>'55555',
                'name'=>'kljlkj',
            ),
        );
        */
        
        /**************************/
        
        if (!$data || empty($data)) {
            return $this->result('Ошибка. Нет данных при вызове метода "'.$method.'". Попробуйте еще раз.');
        }

        if (isset($data[$pk])) {
            $this->$method($data, $model_name);
        } else {
            foreach ($data as $item):
                $this->$method($item, $model_name);
            endforeach;
        }
        
        return $this->result('Выгрузка данных в магазин закончена.');
    }
    
    private function setOneProductMaker($data, $model_name)
    {
        if (empty($data['external_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneProductMaker = '. $data['external_id'], 'info');
        
        try {
            $model = ProductMaker::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$model)
                $model = new ProductMaker;
            
            $app = Yii::app();
            $transaction = $app->db_auth->beginTransaction();
            foreach ($model as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name]))
                    $model->$name = $data[$name];
            }
            
            if(!empty($model->name)) $model->path = '/'.Translite::rusencode($model->name, '-');
            $model->published = true;
            
            if(!empty($data['image_name'])) {
                $index = 1;
                $photo = $this->setMakerPhoto($index, $data['image_name']);
                if(!empty($photo))
                    $model->logo = $photo;
            }
            
            if($model->save()) {
                $transaction->commit();
                return $this->result('Сохранение производителя запчастей (id = '.$data['external_id'].') произошло успешно.');
            } else {
                $transaction->rollback();
                return $this->result($model->getErrors());
            }
            
            return $this->result('Выгрузка производителя запчастей '.$data['external_id'].' закончена.');
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    
    private function setMakerPhoto($index, $name)
    {   Yii::log('shop: setMakerPhoto', 'info');
        if(!empty($_FILES))
        {   Yii::log('shop: photo !empty', 'info');
            $uploadFile = $_FILES['datafile'];
            $tmp_name = $uploadFile['tmp_name'];
            if(isset($tmp_name[$index]))
            {
                return $this->setOneMakerPhoto(array(
                    'name' => $uploadFile['name'][$index],
                    'type' => $uploadFile['type'][$index],
                    'tmp_name' => $tmp_name[$index],
                    'error' => $uploadFile['error'][$index],
                    'size'  => $uploadFile['size'][$index],
                    'id' => $name,
                ));
            }else Yii::log('shop: no index', 'info');
        } else Yii::log('shop: photo empty', 'info');
        return true;
    }

    private function setOneMakerPhoto($photo)
    {   
        Yii::log('shop: setOnePhoto', 'info');
        if(!$photo['id']){
            $this->result('Запчасти '.$photo['id'].' не существует!');
            return false;
        }
        
        //$dir = 'images/product'; //$this->getPhotoDir();
        $dir = 'images/shop/maker'; //$this->getPhotoDir();
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
            $this->result('Фото производителя '.$photo['id'].' успешно загружено');
            //return $return[link];
            $ext = end(explode('.', strtolower($photo['name'])));
            $link = '/'.$dir.'/'.$photo['id'].'.'.$ext;
            return $link;
        } else {
            $this->result($return);
        }
    }
    
    /*-------- End Set ProductMaker -------*/
    /*-------- Set EquipmentMaker -----------*/
    private function setEquipmentMaker($request)
    {
        Yii::log('shop: setEquipmentMaker', 'info');
        $this->setMaker($request, 'EquipmentMaker', 'external_id');
    }
    
    private function setOneEquipmentMaker($data, $model_name)
    {
        if (empty($data['external_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneEquipmentMaker = '. $data['external_id'], 'info');
        
        try {
            $model = EquipmentMaker::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$model)
                $model = new EquipmentMaker;
            
            $app = Yii::app();
            $transaction = $app->db_auth->beginTransaction();
            foreach ($model as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name]))
                    $model->$name = $data[$name];
            }
            
            if(!empty($model->name)) $model->path = '/'.Translite::rusencode($model->name, '-');
            $model->published = true;
            
            if(!empty($data['image_name'])) {
                $index = 1;
                $photo = $this->setMakerPhoto($index, $data['image_name']);
                if(!empty($photo))
                    $model->logo = $photo;
            }
            
            if($model->save()) {
                $transaction->commit();
                return $this->result('Сохранение производителя техники (id = '.$data['external_id'].') произошло успешно.');
            } else {
                $transaction->rollback();
                return $this->result($model->getErrors());
            }
            
            return $this->result('Выгрузка производителя запчастей '.$data['external_id'].' закончена.');
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    /*-------- End Set EquipmentMaker -------*/
    /*-------- Set Draft for product --------*/
    
    private function setDraft($request) 
    {
        Yii::log('shop: setDraft', 'info');
        $this->setItems($request, 'Draft', 'external_id');
    }
    
    private function setOneDraft($data)
    {
        if (empty($data['external_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneDraft = '. $data['external_id'], 'info');
        
        try {
            $model = Draft::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$model) {
                $model = new Draft;
            }
            //if(!empty($data['name']))$model->name = $data['name'];
            //if(!empty($data['image']))$model->image = $data['image'];
            foreach ($model as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name]))
                    $model->$name = $data[$name];
            }
            $model->save();
            
            ProductInDraft::model()->deleteAll('draft_id=:id', array(':id' => $model->id));
            if(is_array($data['inner'])) {
                foreach($data['inner'] as $item) {
                    $this->saveProductInDraft($item, $model->id);
                }
                return $this->result('Выгрузка запчастей для сборочного черетежа '.$data['external_id'].' закончена.');
            }
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    
    private function saveProductInDraft($data, $draftId)
    {
        $app = Yii::app();
        $product = Product::model()->find('external_id=:external_id', array(':external_id' => $data['product_id']));
        if($product) {
            $transaction = $app->db_auth->beginTransaction();
            $element = new ProductInDraft;
            $element->draft_id = $draftId;
            $element->product_id = $product->id;
            $element->level = $data['level'];
            $element->count = $data['count'];
            if($element->save()) {
                $transaction->commit();
                return $this->result('Сохранение продукта (id = '.$data['product_id'].') в чертеже произошло успешно.');
            } else {
                $transaction->rollback();
                return $this->result($element->getErrors());
            }
        } else {
            return $this->result('Ошибка. Продукт с id='.$data['product_id'].' не найден.');
        }
    }
    /*-------- End Set Draft for product --------*/
    /*-------- Set Draft for model --------*/
    
    private function setDraftmodel($request) 
    {        
        Yii::log('shop: setDraftmodel', 'info');
        $this->setItems($request, 'Draftmodel', 'external_id');
    }
    
    private function setOneDraftmodel($data)
    {
        if (empty($data['external_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneDraftmodel = '. $data['external_id'], 'info');
        
        try {
            $model = Draft::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$model) {
                $model = new Draft;
            }
            //if(!empty($data['name']))$model->name = $data['name'];
            //if(!empty($data['image']))$model->image = $data['image'];
            foreach ($model as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name]))
                    $model->$name = $data[$name];
            }
            $model->save();
            
            DraftInModelLine::model()->deleteAll('draft_id=:id', array(':id' => $model->id));
            if(is_array($data['inner'])) {
                foreach($data['inner'] as $item) {
                    $this->saveDraftInModel($item, $model->id);
                }
                return $this->result('Выгрузка запчастей для сборочного черетежа '.$data['external_id'].' закончена.');
            }
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    
    private function saveDraftInModel($data, $draftId)
    {
        $app = Yii::app();
        $modelline = ModelLine::model()->find('external_id=:external_id', array(':external_id' => $data['model_line_id']));
        if($modelline) {
            $transaction = $app->db_auth->beginTransaction();
            $element = new DraftInModelLine;
            $element->draft_id = $draftId;
            $element->model_line_id = $modelline->id;
            if($element->save()) {
                $transaction->commit();
                return $this->result('Сохранение чертежа для модельного ряда (id = '.$data['model_line_id'].') произошло успешно.');
            } else {
                $transaction->rollback();
                return $this->result($element->getErrors());
            }
        } else {
            return $this->result('Ошибка. Модельный ряд с id='.$data['model_line_id'].' не найден.');
        }
    }
    
    /*-------- End Set Draft for model --------*/
    /*-------- Set Filial ----------*/
    
    private function setFilial($request)
    {
        Yii::log('shop: setFilial', 'info');
        $this->setItems($request, 'Filial', 'external_id', true);
    }
    
    private function setOneFilial($data, $parentId = null)
    {
        $commit = false;
        if (empty($data['external_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneFilial = '. $data['external_id'], 'info');

        $app = Yii::app();
        $transaction = $app->db_auth->beginTransaction();
        try {
            $filial = Filial::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (empty($filial)) {
                $filial = new Filial;
            }
            $filial->name = $data['name'];
            $filial->external_id = $data['external_id'];
            
            $root = Filial::model()->findByAttributes(array('level'=>1));
            if(empty($parentId)) {
                if(empty($root)) {
                    $root = new Filial;
                    $root->name = 'Все филиалы';
                    $root->saveNode();
                }
            } else {
                $root = Filial::model()->findByPk($parentId);
            }
            
            $filial->update_time = date('Y-m-d H:i:s');
            if($filial->id) {
                $filial->saveNode();
                $commit = true;
            } else {
                if($filial->appendTo($root)) $commit = true;
            }
            
            if($commit) {
                $transaction->commit();

                Yii::log('Filial id '.$filial->id, 'info');

                if ($filial->id && !empty($data['inner'])) {
                    Yii::log('Inner for filial with id = ' . $filial->id, 'info');

                    foreach($data['inner'] as $item) {
                        $this->setOneFilial($item, $filial->id);
                    }
                }
                return $this->result('Сохранение филиала '.$filial->external_id.' произошло успешно.');
            }
            
            $transaction->rollback();
            return $this->result($filial->getErrors());
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    /*-------- End Set Filial --------*/
    /*-------- Set Filial Price ------*/
    private function setPrice($request) 
    {
        Yii::log('shop: setPrice', 'info');
        $this->setItems($request, 'Price', 'filial_id', true);
    }
    
    private function setOnePrice($data)
    {
        if (empty($data['filial_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора филиала.');
            
        if (empty($data['product_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора продукта.');
        
        if (empty($data['currency_code']))
            return $this->result('Ошибка. Нет уникального идентефикатора валюты.');
        
        Yii::log('shop: setOnePrice', 'info');
        try {
            $product = Product::model()->find('external_id=:external_id', array(':external_id' => $data['product_id']));
            if($product) {
                $filial = Filial::model()->find('external_id=:external_id', array(':external_id' => $data['filial_id']));
                if($filial){
                    PriceInFilial::model()->deleteAll('product_id=:product_id and filial_id=:filial_id', array(':product_id' => $product->id, ':filial_id' => $filial->id));
                    $currency = Currency::model()->find('external_id=:external_id', array(':external_id' => $data['currency_code']));
                    if(empty($currency)) return $this->result('Ошибка. Валюта с id='.$data['currency_code'].' не найден.');
                } else {
                    return $this->result('Ошибка. Филиал с id='.$data['filial_id'].' не найден.');
                }
            } else {
                return $this->result('Ошибка. Продукт с id='.$data['product_id'].' не найден.');
            }
            //////////////////////////////////
            $model = new PriceInFilial;
            $app = Yii::app();
            $transaction = $app->db_auth->beginTransaction();
            foreach ($model as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name]))
                    $model->$name = $data[$name];
            }
            $model->currency_code = $currency->id;
            $model->filial_id = $filial->id;
            $model->product_id = $product->id;
            $model->update_time = date('Y-m-d H:i:s');
            if($model->save()) {
                $transaction->commit();
                return $this->result('Сохранение цены для запчасти (id = '.$data['product_id'].') произошло успешно.');
            } else {
                $transaction->rollback();
                return $this->result($model->getErrors());
            }

            return $this->result('Выгрузка цен закончена.');
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }   
    }
    /*-------- End Set Filial Price ----*/
    /*-------- Set Currency -----------*/
    private function setCurrency($request)
    {
        Yii::log('shop: setCurrency', 'info');
        $this->setItems($request, 'Currency', 'external_id');
    }
    
    private function setOneCurrency($data, $model_name)
    {
        if (empty($data['external_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');
        
        Yii::log('shop: setOneCurrency = '. $data['external_id'], 'info');
        
        try {
            $model = Currency::model()->find('external_id=:external_id', array(':external_id' => $data['external_id']));
            if (!$model)
                $model = new Currency;
            
            $app = Yii::app();
            $transaction = $app->db_auth->beginTransaction();
            foreach ($model as $name => $v) {
                if (isset($data[$name]) || !empty($data[$name]))
                    $model->$name = $data[$name];
            }
            $model->update_time = date('Y-m-d H:i:s');
            
            if($model->save()) {
                $transaction->commit();
                return $this->result('Сохранение валюты (id = '.$data['external_id'].') произошло успешно.');
            } else {
                $transaction->rollback();
                return $this->result($model->getErrors());
            }
            
            return $this->result('Выгрузка валюты '.$data['external_id'].' закончена.');
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }
    }
    /*-------- End Set Currency --------*/
    /* -------Start-DELETE-block-------- */
    /*private function delSparepart($request) 
    {
        $data = $request['data'];
        
        //////////////////////////////
//        $data = array(
//            0 => array(
//                'user_id' => '1',
//                'external_id'=>'MNS0002444'
//            )
//        );
        /////////////////////////////////
        
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных. Попробуйте еще раз.');
        
        if (isset($data['external_id'])) {
            if(!empty($data['user_id'])){
                $product = Product::model()->find('external_id=:id', array(':id'=>$data['external_id']));
                if(!empty($product)) {
                    ProductInModelLine::model()->deleteAll('product_id = :id', array(':id'=>$product->id));
                    Wishlist::model()->deleteAll('product_id = :id', array(':id'=>$product->id));
                    Product::model()->deleteAll('external_id=:id', array(':id' => $data['external_id']));
                    
                    Yii::log('shop: delSparepart = '. $data['external_id'], 'info');
                    Yii::log('shop: user_id = '.$data['user_id'], 'info');
                    ShopChanges::saveChange($data['user_id'], 'Через api удалена запчасть с id='.$data['external_id']);
                }
            } else return $this->result('Ошибка. Нет данных о пользователе, совершающем транзакцию. Попробуйте еще раз.');
        } else {
            foreach ($data as $sparepart) {
               if(!empty($sparepart['user_id'])) {
                    $product = Product::model()->find('external_id=:id', array(':id'=>$sparepart['external_id']));
                    if(!empty($product)) {
                        ProductInModelLine::model()->deleteAll('product_id = :id', array(':id'=>$product->id));
                        Wishlist::model()->deleteAll('product_id = :id', array(':id'=>$product->id));
                        Product::model()->deleteAll('external_id=:id', array(':id' => $sparepart['external_id']));
                        
                        Yii::log('shop: delSparepart = '. $sparepart['external_id'], 'info');
                        Yii::log('shop: user_id = '.$sparepart['user_id'], 'info');
                        ShopChanges::saveChange($sparepart['user_id'], 'Через api удалена запчасть с id='.$sparepart['external_id']);
                    }    
                } else return $this->result('Ошибка. Нет данных о пользователе, совершающем транзакцию. Попробуйте еще раз.');
            } 
        }
        return $this->result('Удаление прошло успешно.');
    }
    
    private function delGroup($request) 
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных. Попробуйте еще раз.');

        if (isset($data['external_id'])) {
            if(!empty($data['user_id'])) {
                Yii::log('shop: delGroup = '. $data['external_id'], 'info');
                $groupId = ProductGroup::model()->findByAttributes(array('external_id'=>$data['external_id']))->id;
                Product::model()->deleteAll('product_group_id=:id', array('id'=>$groupId));
                ProductGroup::model()->deleteAll('external_id=:id', array(':id' => $data['external_id']));
                
                ShopChanges::saveChange($data['user_id'], 'Через api удалена группа запчастей с id='.$data['external_id'].' и все запчасти, входящие в нее.');
            } else return $this->result('Ошибка. Нет данных о пользователе, совершающем транзакцию. Попробуйте еще раз.');
        } else {
            foreach ($data as $group) {
               if(!empty($group['user_id'])) {
                    Yii::log('shop: delGroup = '.$group['external_id'], 'info');
                    $groupId = ProductGroup::model()->findByAttributes(array('external_id'=>$group['external_id']))->id;
                    Product::model()->deleteAll('product_group_id=:id', array('id'=>$groupId));
                    ProductGroup::model()->deleteAll('external_id=:id', array(':id' => $group['external_id']));
                    
                    ShopChanges::saveChange($group['user_id'], 'Через api удалена группа запчастей с id='.$group['external_id'].' и все запчасти, входящие в нее.');
               } else return $this->result('Ошибка. Нет данных о пользователе, совершающем транзакцию. Попробуйте еще раз.');
            } 
        }
        return $this->result('Удаление прошло успешно.');
    }*/
    
    private function delModelline($request) 
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных. Попробуйте еще раз.');

        if (isset($data['external_id'])) {
            if(!empty($data['user_id'])) {
                Yii::log('shop: delModelline = '. $data['external_id'].', user_id = '.$data['user_id'], 'info');
                $model = ProductModelLine::model()->findByAttributes(array('external_id' => $data['external_id']));
                if($model) {
                    ProductInModelLine::model()->deleteAll('model_line_id=:id', array('id' => $model->id));
                    $model->deleteNode();
                    ShopChanges::saveChange($data['user_id'], 'Через api удален модельный ряд с id='.$data['external_id'].'.');
                }
            } else return $this->result('Ошибка. Нет данных о пользователе, совершающем транзакцию. Попробуйте еще раз.');
        } else {
            foreach ($data as $item) {
               if(!empty($item['user_id'])) {
                    Yii::log('shop: delModelline = '.$item['external_id'].', user_id = '.$item['user_id'], 'info');
                    $model = ProductModelLine::model()->findByAttributes(array('external_id' => $item['external_id']));
                    if($model) {
                        ProductInModelLine::model()->deleteAll('model_line_id=:id', array('id' => $model->id));
                        $model->deleteNode();
                        ShopChanges::saveChange($item['user_id'], 'Через api удален модельный ряд с id='.$item['external_id'].'.');
                    }
               } else return $this->result('Ошибка. Нет данных о пользователе, совершающем транзакцию. Попробуйте еще раз.');
            } 
        }
        return $this->result('Удаление прошло успешно.');
    }
    
    private function delProductfrommodelline($request) 
    {
        $data = $request['data'];
        
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных. Попробуйте еще раз.');
        
        foreach ($data as $item) {
            if(!empty($item['user_id'])) {
                Yii::log('shop: ProductFromModelline modelline = '.$item['modelline_id'].', product_id = '.$item['product_id'].', user_id = '.$item['user_id'], 'info');
                $product = Product::model()->findByAttributes(array('external_id' => $item['product_id']));
                $modelline = ProductModelLine::model()->findByAttributes(array('external_id' => $item['modelline_id']));
                if(!empty($product->id) && !empty($modelline->id)) {
                    ProductInModelLine::model()->deleteAll('model_line_id=:id and product_id=:product_id', array('id' => $modelline->id, 'product_id' => $product->id));
                    ShopChanges::saveChange($item['user_id'], 'Через api из модельного ряда с id='.$item['modelline_id'].' удалена запчасть '.$item['product_id'].'.');
                } else {
                    Yii::log('One of params modelline = '.$item['modelline_id'].' or product_id = '.$item['product_id'].' not found', 'info');
                }
            } else return $this->result('Ошибка. Нет данных о пользователе, совершающем транзакцию. Попробуйте еще раз.');
         } 
         
         return $this->result('Удаление прошло успешно.');
    }
    
    /* -------End-DELETE-block-------- */
    private function result($text) {
        $this->renderPartial('index', array('text' => $text));
        return false;
    }
}

