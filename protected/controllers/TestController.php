<?php

class TestController extends Controller
{
    public function actionIndex() {
        $model = Transport::model()->findByPk(76);
        
        echo '<pre>';
        
        
        
        $model->rate_id = null;
        
        
        if(!$model->save()) {
            print_r($model->getErrors());
            
        }
        
        var_dump($model->rate_id); 
        exit;
    }
}
