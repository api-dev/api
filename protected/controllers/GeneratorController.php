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

        $kp = Kp::model()->cache(1000, $dependency)->findAll('status<2');

        $this->renderPartial('json', array('data' => $kp));
    }

    public function actionOne($id) {

        $result = array();

        if($id === 'new')
        {
            $kp = new Kp();
            $kp->save();
            echo '{"id":"'.$kp->id.'"}';
            return true;
        }else{
            $kp = Kp::model()->find(array(
                'condition' => 'id=:id',
                'params' => array(':id' => $id),
            ));
        }

        $rawBody = Yii::app()->request->rawBody;

        if(is_null( $result = json_decode($rawBody, true))){
            if(function_exists('mb_parse_str')) {
                mb_parse_str(Yii::app()->request->rawBody, $result);
            } else {
                parse_str(Yii::app()->request->rawBody, $result);
            }
        }

        if(!is_array($result)){
            $result = $_POST;
        }

        if($result)
        {
            unset($result['id']);
            $kp->attributes = $result;

            $kp->u_id_create = $result['u_id_create']['id'];
            $kp->auditor_id = $result['auditor_id']['id'];
            $kp->u_id_edit = $result['u_id_edit']['id'];

            $kp->json = CJSON::encode($result['json']);

            if($kp->save())
                Yii::log($kp->json, 'info');
            else
                Yii::log(serialize($kp->getErrors()), 'info');

        }else{
            $this->renderPartial('json', array('data' => $kp));
        }
    }

    public function actionTrash($id)
    {
        $kp = Kp::model()->findByPk($id);
        if($kp)
        {
            $kp->status = 2;
            if($kp->save()){
                echo true;
            }
        }
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
