<?php
$echo = '<?xml version="1.0" encoding="UTF-8" ?>';
$echo .= '<data count="'.  count($data).'">';
foreach ($data as $sp):
    $productGroup = ProductGroup::model()->findByPk($sp[product_group_id]);
    $productMaker = ProductMaker::model()->findByPk($sp[product_maker_id]);
    $productModels = ProductInModelLine::model()->findAll('product_id=:id', array(':id'=>$sp[id]));
    $echo .= '<sparepart external_id="'.$sp[external_id].'">';
        $echo .= '<name>'.$sp[name].'</name>';
        $echo .= '<product_group>'.$productGroup->external_id.'</name>';
        $echo .= '<catalog_number>'.$sp[catalog_number].'</catalog_number>';
        $echo .= '<count>'.$sp[count].'</count>';
        $echo .= '<liquidity>'.$sp[liquidity].'</liquidity>';
        $echo .= '<min_quantity>'.$sp[min_quantity].'</min_quantity>';
        $echo .= '<additional_info>'.$sp[additional_info].'</additional_info>';
        $echo .= '<published>'.(int)$sp[published].'</published>';
        if(count($productModels)) {
            $echo .= '<models>';
                foreach ($productModels as $modelId):
                   $model = ProductModelLine::model()->findByPk($modelId);
                   $echo .= '<model external_id="'.$model->external_id.'">'.$model->external_id.'</model>';
                endforeach;
            $echo .= '</models>';
        }
    $echo .= '</sparepart>';
endforeach;
$echo .= '</data>';
echo $echo;