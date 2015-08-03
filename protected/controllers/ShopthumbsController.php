<?php

class ShopthumbsController extends Controller {

    public function actionSmall() 
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $folder = $_SERVER['DOCUMENT_ROOT'].'/images/shop/spareparts/';
        $images = scandir($folder);
        foreach ($images as $image) {
            if (($image != '.') && ($image != '..') && (exif_imagetype($folder.$image) == IMAGETYPE_JPEG)) {
                $thumb = Yii::app()->thumb;
                $thumb->image = $folder.$image;
                $thumb->width = 100;
                $thumb->height = 100;
                $thumb->square = true;
                $thumb->defaultName = $image;
                $thumb->directory = $folder."s/";
                $thumb->createThumb();
                $thumb->save();
            }
        }
    }
    
    public function actionMedium() 
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $folder = $_SERVER['DOCUMENT_ROOT'].'/images/shop/spareparts/';
        $images = scandir($folder);
        foreach ($images as $image) {
            if (($image != '.') && ($image != '..') && (exif_imagetype($folder.$image) == IMAGETYPE_JPEG)) {
                $thumb = Yii::app()->thumb;
                $thumb->image = $folder.$image;
                $thumb->width = 160;
                $thumb->height = 120;
                $thumb->square = true;
                $thumb->defaultName = $image;
                $thumb->directory = $folder."m/";
                $thumb->createThumb();
                $thumb->save();
            }
        }
    }
}
