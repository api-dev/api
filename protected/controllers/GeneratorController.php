<?php

class GeneratorController extends Controller
{

    public function actionIndex()
    {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        $request = $post ? array_merge_recursive($post, $get) : $get;
        
        $this->renderPartial('index', array('request'=>$request));
    }

}
