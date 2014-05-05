<?php

class GeneratorController extends Controller {

    public function actionIndex() {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        $request = $post ? array_merge_recursive($post, $get) : $get;
        $app = Yii::app();
        if($app->user->isGuest)
        {
            $app->request->redirect('http://auth.'.$app->params['host']);
        }else{
            $this->renderPartial('index', array('request' => $request));
        }
        
    }

    public function actionList() {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        $request = $post ? array_merge_recursive($post, $get) : $get;

        $dependency = new CDbCacheDependency('SELECT MAX(date_edit) FROM kp');
        $dependency->connectionID = 'db_kp';
        
        $kp = Kp::model()->cache(1000, $dependency)->findAll();
        
        $this->renderPartial('json', array('data' => $kp));
    }

    public function actionOne($id) {
        
        $kp = Kp::model()->find(array(
            'condition' => 'id=:id',
            'params' => array(':id' => $id),
        ));
        $this->renderPartial('json', array('data' => $kp));
//         echo CJavaScript::jsonEncode($kp);
    }
    
    /*
     * Генерирует рандомный идентификатор
     * @return string Возвращает 8 знаковый, уникальный идентификатор
     */

    private function getHash() {
        $id = User::randomPassword(8);
        $cache = Yii::app()->cache->get($id);
        if ($cache === false) {
            return $id;
        } else
            return $this->getHash();
    }

}
