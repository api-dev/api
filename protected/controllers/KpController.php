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
            $id = $this->getHash();
            
            if(Yii::app()->cache->set($id, serialize($request)))
                echo 'http://api.lbr.ru/?r=kp&m=get&action=paper&hash='.$id;
            else
                echo 'Fuckin cached';
        }
        
        private function getSpares($request)
        {
            $hash = Yii::app()->cache->get($request['hash']);
            if($hash)
                $text = unserialize($hash);
            
            var_dump($text);
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

}