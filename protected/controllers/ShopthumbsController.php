<?php

class ShopthumbsController extends Controller 
{
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
    
    public function actionWatermark() 
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $folder = $_SERVER['DOCUMENT_ROOT'].'/images/shop/new/';
        $watermarkImg = $_SERVER['DOCUMENT_ROOT'].'/images/shop/watermark/watermark_new.png';
        $images = scandir($folder);
        foreach ($images as $image) {
            if (($image != '.') && ($image != '..') && (exif_imagetype($folder.$image) == IMAGETYPE_JPEG)) {
                $image_path = $folder.$image;
                $image = imagecreatefromjpeg($image_path);
                // if something wrong
                if ($image === false) {
                    return false;
                }
                $size = getimagesize($image_path);

                if(($size[0]>=250)||($size[1]>=250)){
                    // create watermark
                    $watermark = imagecreatefrompng($watermarkImg);  

                    // het watermark's height/widht
                    $watermark_width = imagesx($watermark);
                    $watermark_height = imagesy($watermark); 

                    // change watermark's size
                    $k_w=$watermark_height/$watermark_width;
                    $k_h=$watermark_width/$watermark_height;

                    $k1=$size[0]/$watermark_width;
                    $k2=$size[1]/$watermark_height;

                    if($k1>$k2){
                        $k=$k1;
                        $w=$watermark_width*$k;
                        $h=$w*$k_w;
                    }
                    else{
                        $k=$k2;
                        $h=$watermark_height*$k;
                        $w=$h*$k_h;
                    }

                    // put watermark to image
                    imagealphablending($image, true);
                    imagealphablending($watermark, true);

                    // create new image
                    imagecopyresampled($image,$watermark,0,0,0,0,$w,$h,$watermark_width,$watermark_height);
                    imagejpeg($image,$image_path);
                    // clear memeory
                    imagedestroy($watermark);  
                }

                imagedestroy($image);
            }
        }
    }
}
