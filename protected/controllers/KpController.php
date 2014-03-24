<?php

class KpController extends Controller
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
                return $this->result('Неверные параметры. Допустимые: m - set/get; action - paper/kp/time. Полученые: m='.$request['m'].', action='.$request['action']);
        }
        
        private function getPaper($request)
        {
            $this->renderPartial('paper', array('data'=>$request));
        }
        
        private function setSpares($request)
        {
            if($request['template']=='print'){
                $id = $this->getHash();
                if(Yii::app()->cache->set($id, serialize($request)))
                    echo 'http://api.lbr.ru/?r=kp&m=get&action=spares&hash='.$id;
                else
                    echo 'Fuckin cached';
            }else
                $this->showSpares($request);
        }
        
        private function getSpares($request)
        {
            $hash = Yii::app()->cache->get($request['hash']);
            if($hash)
                $r = unserialize($hash);
            
            if($r)
                $this->showSpares($r);
        }
        
        private function showSpares($request)
        {
            if(is_array($request[data]) && !empty($request[data]))
            {
                if($request[data][table])
                    $this->renderPartial ('spares', array('request'=>$request, 'table'=>$this->getTable($request[data][table]), 'title'=>$data[title]));
                else{
                    foreach ($request[data] as $table)
                        $this->renderPartial ('spares', array('request'=>$request, 'table'=>$this->getTable($table[table]), 'title'=>$table[title]));
                }
            }
        }
        
        private function getHash()
        {
            $id = User::randomPassword(8);
            $cache = Yii::app()->cache->get($id);
            if($cache===false){
                return $id;
            }else
                return $this->getHash();
        }
        
        public function getTest($request)
        {
//            $table = array();
//            $table[head][0][0] = '№';
//            $table[head][0][1] = 'Наименование';
//            $table[head][0][2] = 'В заказе';
//            $table[head][0][3] = 'Количество';
//            $table[head][0][4] = 'Срок поставки';
//            $table[head][0][5] = 'Цена с НДС, руб';
//            $table[head][0][6] = 'Цена с НДС со скидкой, руб';
//            $table[head][0][7] = 'Сумма с НДС со скидкой, руб';
//            
//            $table[body][0][0] = '1';
//            $table[body][0][1] = 'Фильтр масляный LF16015';
//            $table[body][0][2] = '2';
//            $table[body][0][3] = '2';
//            $table[body][0][4] = 'В наличии';
//            $table[body][0][5] = '491,64';
//            $table[body][0][6] = '417,89';
//            $table[body][0][7] = '835,79';
//            
//            $table[body][1][0] = '2';
//            $table[body][1][1][body][0][0][head][0] = 'Тип';
//            $table[body][1][1][body][0][0][head][1] = 'Тип';
//            $table[body][1][1][body][0][0][head][2] = 'Тип';
//            $table[body][1][1][body][0][0][body][0][0] = 'Фильтр масляный 1.1';
//            $table[body][1][1][body][0][0][body][0][1] = 'Фильтр масляный 1.2';
//            $table[body][1][1][body][0][0][body][0][2] = 'Фильтр масляный 1.3';
//            $table[body][1][1][body][1][0] = 'Фильтр масляный 2';
//            $table[body][1][1][body][2][1] = 'Фильтр масляный 3';
//            $table[body][1][2] = '343';
//            $table[body][1][3] = '525';
//            $table[body][1][4][body][0][0] = 'В наличии';
//            $table[body][1][4][body][0][1] = 'Под заказ';
//            $table[body][1][5][body][0][2] = '431,64';
//            $table[body][1][5][body][1][3] = '431,64';
//            $table[body][1][5][body][2][4] = '431,64';
//            $table[body][1][6] = '477,89';
//            $table[body][1][7] = '805,79';
        
            $data = array();
            $data[1][title] = 'Title';
            
            $data[1][table][head][0][0] = '№';
            $data[1][table][head][0][1] = 'Наименование';
            $data[1][table][head][0][2] = 'Количество';
            $data[1][table][head][0][3] = 'Цена';
            $data[1][table][head][0][4] = 'Сумма';

            $data[1][table][body][0][0] = '1';
            $data[1][table][body][0][1] = 'Запчасть под номер 1';
            $data[1][table][body][0][2][body][0][0] = '345';
            $data[1][table][body][0][2][body][0][1] = '7323';
            $data[1][table][body][0][3] = '34';
            $data[1][table][body][0][4] = '11730';

            $data[1][table][body][1][0] = '2';
            $data[1][table][body][1][1] = 'Вторая ЗЧ';
            $data[1][table][body][1][2][body][0][0] = '345';
            $data[1][table][body][1][2][body][1][0] = '565';
            $data[1][table][body][1][3][body][0][0] = '35';
            $data[1][table][body][1][3][body][1][0] = '37';
            $data[1][table][body][1][4] = '32980';
            
            $this->renderPartial ('spares', array('request'=>$request, 'table'=>$this->getTable($data[1][table]), 'title'=>$data[1][title]));
        }

        private function getTable($table)
        {
            if(!$table || empty($table))
                return $this->result('Ошибка. Данные о таблице не переданы.');
            
            return Table::generateTable($table, 'parent');
        }
        
        public function result($text)
        {
            $this->renderPartial('index', array('text' => $text));
            return false;
        }
}