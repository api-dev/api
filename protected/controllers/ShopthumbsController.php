<?php
class ShopthumbsController extends Controller 
{
    //----------------- Thumbnail -----------------------------------------------------------------
    /*
     * create small thumbnail
     */
    public function actionSmall() 
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        
        $root = $_SERVER['DOCUMENT_ROOT'].'/images/shop/spareparts/';
        $folder = $root.'large/';
        $saveFolder = $root."small/";
        $width = $height = 100;
        
        $images = scandir($folder);
        foreach ($images as $image) {
            if (($image != '.') && ($image != '..') && (exif_imagetype($folder.$image) == IMAGETYPE_JPEG)) {
                $thumb = Yii::app()->thumb;
                $thumb->image = $folder.$image;
                $thumb->width = $width;
                $thumb->height = $height;
                $thumb->square = true;
                $thumb->defaultName = $image;
                $thumb->directory = $saveFolder;
                $thumb->createThumb();
                $thumb->save();
            }
        }
    }
    /*
     * create medium thumbnail
     */
    public function actionMedium() 
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        
        $root = $_SERVER['DOCUMENT_ROOT'].'/images/shop/spareparts/';
        $folder = $root.'large/';
        $saveFolder = $root."medium/";
        $width = 160;
        $height = 120;
        
        $images = scandir($folder);
        foreach ($images as $image) {
            if (($image != '.') && ($image != '..') && (exif_imagetype($folder.$image) == IMAGETYPE_JPEG)) {
                $thumb = Yii::app()->thumb;
                $thumb->image = $folder.$image;
                $thumb->width = $width;
                $thumb->height = $height;
                $thumb->square = true;
                $thumb->defaultName = $image;
                $thumb->directory = $saveFolder;
                $thumb->createThumb();
                $thumb->save();
            }
        }
    }
    //----------------- Watermark -----------------------------------------------------------------
    /*
     * set watermark
     */
    public function actionWatermark() 
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $root = $_SERVER['DOCUMENT_ROOT'].'/images/shop/spareparts/';
        $folder = $root.'large/';
        $watermarkImg = $root.'watermark/watermark.png';
        $images = scandir($folder);
        foreach ($images as $image) {
            if (($image != '.') && ($image != '..') && (exif_imagetype($folder.$image) == IMAGETYPE_JPEG)) {
                $imagePath = $folder.$image;
                $image = imagecreatefromjpeg($imagePath);
                
                // if something wrong
                if ($image === false) {
                    return false;
                }
                
                $size = getimagesize($imagePath);
                if(($size[0] >= 250) || ($size[1] >= 250)) {
                    // create watermark
                    $watermark = imagecreatefrompng($watermarkImg);
                    // get watermark's height/widht
                    $watermarkWidth = imagesx($watermark);
                    $watermarkHeight = imagesy($watermark);
                    // change watermark's size
                    $kW = $watermarkHeight/$watermarkWidth;
                    $kH = $watermarkWidth/$watermarkHeight;

                    $k1 = $size[0]/$watermarkWidth;
                    $k2 = $size[1]/$watermarkHeight;

                    if($k1 > $k2) {
                        $k = $k1;
                        $w = $watermarkWidth*$k;
                        $h = $w*$kW;
                    } else {
                        $k = $k2;
                        $h = $watermarkHeight*$k;
                        $w = $h*$kH;
                    }

                    // put watermark to image
                    imagealphablending($image, true);
                    imagealphablending($watermark, true);
                    // create new image
                    imagecopyresampled($image, $watermark, 0, 0, 0, 0, $w, $h, $watermarkWidth, $watermarkHeight);
                    imagejpeg($image, $imagePath);
                    // clear memeory
                    imagedestroy($watermark);  
                }
                imagedestroy($image);
            }
        }
    }
}
