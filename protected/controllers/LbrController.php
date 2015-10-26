<?php

class LbrController extends Controller
{
    public function actionIndex()
    {   
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        /**************************/
        $get = array('m'=>'get', 'action'=>'analitics');
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
            $item = LbrAnalitics::model()->findByPk($info[id]);
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
                $item = LbrAnalitics::model()->findByPk($info[id]);
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
    
    /* -------End-DELETE-block-------- */
    private function result($text) {
        $this->renderPartial('index', array('text' => $text));
        return false;
    }
}

