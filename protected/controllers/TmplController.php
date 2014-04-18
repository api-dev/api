<?php

class TmplController extends Controller {

    public function actions() {
        return array(
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionIndex() {
        
        $request = Yii::app()->request;
        
        $dir = $request->getParam('dir');
        $file = $request->getParam('f');
        
        if ($dir && $file){
            $this->renderPartial($dir.'/'.$file);
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
