<?php

class TestController extends Controller
{
    public function actionIndex() {
        $model = Transport::model()->findByPk(76);
        echo '<pre>';
        var_dump($model); exit;
        //$model->rate_id = null;
        //$model->save();
    }
}
