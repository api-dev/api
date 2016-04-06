<?php

class TestController extends Controller
{
    public function actionIndex() {
        $model = Transport::model()->findByPk(76);
        $model->rate_id = null;
        $model->save();
    }
}
