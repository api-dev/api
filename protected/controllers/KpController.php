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
            $id = 'test33';
             if(Yii::app()->cache->set($id, serialize($request)))
            {
                    var_dump('Ouuuu yyeessss!!!');
            }else{
                    echo 'Fuckin cached';
            }
        }
        
        private function getSpares($request)
        {
            var_dump(Yii::app()->cache->servers);
            $id = 'test33';
            $text = unserialize(Yii::app()->cache->get($id));
            var_dump($text);
        }
}