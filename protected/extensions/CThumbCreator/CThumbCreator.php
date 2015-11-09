<?php
class CThumbCreator extends CApplicationComponent 
{
    public $width = 200;
    public $height = 200;
    public $directory;
    public $defaultName = "thumb";
    public $suffix;
    public $prefix;
    public $image;
    public $quality = 75;
    public $compression = 6;
    public $posX = 0;
    public $posY = 0;
    public $cutWidth;
    public $cutHeight;
    public $cutCenter = false;
    public $distX = 0;
    public $distY = 0;
    private $image_info;
    private $ext;
    private $img;
    private $tmp;
    public $square = true;

    public function init() 
    {
        if (!function_exists("imagecreatetruecolor")) {
            throw new Exception("Can't be found function imagecreatetruecolor", 500);
        }
        parent::init();
    }

    private function createImg() 
    {
        if (!$this->image) {
            throw new Exception("Image error", 500);
        }

        $this->image_info = getimagesize($this->image);
        $mime_array=explode("/", $this->image_info["mime"]);
        $extension=end($mime_array);
        $this->ext = strtolower($extension);

        switch ($this->ext) {
            case "jpg":
                $this->img = imagecreatefromjpeg($this->image);
                break;
            case "jpeg":
                $this->img = imagecreatefromjpeg($this->image);
                break;
            case "gif":
                $this->img = imagecreatefromgif($this->image);
                break;
            case "png":
                $this->img = imagecreatefrompng($this->image);
                break;
            default:
                throw new Exception("Invalid image type", 500);
        }
    }

    private function updateDimensions($width, $height) 
    {
        $this->image_info[0] = $width;
        $this->image_info[1] = $height;
    }

    public function createThumb() 
    {
        $this->createImg();
        $dimension = min($this->width / $this->image_info[0], $this->height / $this->image_info[1]);

        if ($dimension < 1) {
            $newDimension[0] = floor($dimension * $this->image_info[0]);
            $newDimension[1] = floor($dimension * $this->image_info[1]);
        } else {
            $newDimension[0] = $this->image_info[0];
            $newDimension[1] = $this->image_info[1];
        }

        if ($this->square) {
            $this->tmp = imagecreatetruecolor($this->width, $this->height);
            $white = imagecolorallocate($this->tmp, 255, 255, 255);
            imagefilledrectangle($this->tmp, 0, 0, $this->width - 1, $this->height - 1, $white);
            
            if (imagecopyresampled($this->tmp, $this->img, ($this->width - $newDimension[0]) / 2, ($this->height - $newDimension[1]) / 2, 0, 0, $newDimension[0], $newDimension[1], $this->image_info[0], $this->image_info[1])) {
                $this->updateDimensions($newDimension[0], $newDimension[1]);
            } else {
                throw new Exception("The problem with creating thumbnails", 500);
            }
        } else {
            $this->tmp = imagecreatetruecolor($newDimension[0], $newDimension[1]);
            if (imagecopyresampled($this->tmp, $this->img, 0, 0, 0, 0, $newDimension[0], $newDimension[1], $this->image_info[0], $this->image_info[1])) {
                $this->updateDimensions($newDimension[0], $newDimension[1]);
            } else {
                throw new Exception("The problem with creating thumbnails", 500);
            }
        }
    }

    public function cut() 
    {
        if (!$this->width || !$this->height) {
            throw new Exception("Width or height invalid", 500);
        }

        if (!$this->cutWidth) {
            $this->cutWidth = $this->width;
        }

        if (!$this->cutHeight) {
            $this->cutHeight = $this->height;
        }

        if ($this->cutCenter) {
            $this->distX = ($this->cutpWidth - $this->width) / 2;
            $this->distY = ($this->cutpHeight - $this->height) / 2;
        }

        if (!$this->tmp) {
            $this->createImg();
        } else {
            $this->img = $this->tmp;
        }

        $this->tmp = imagecreatetruecolor($this->cutWidth, $this->cutHeight);
        if (imagecopyresampled($this->tmp, $this->img, $this->distX, $this->distY, $this->posX, $this->posY, $this->width, $this->height, $this->width, $this->height)) {
            $this->updateDimensions($this->cutWidth, $this->cutHeight);
        } else {
            throw new Exception("Problem with image cut", 500);
        }
    }

    public function save() 
    {
        if (!$this->directory) {
            throw new Exception("Directory doesn't found", 500);
        }

        switch ($this->ext) {
            case "jpg":
            case "jpeg":
                imagejpeg($this->tmp, $this->directory . $this->prefix . $this->defaultName, $this->quality);
                //imagejpeg($this->tmp, $this->directory . $this->prefix . $this->defaultName . $this->suffix . "." . $this->ext, $this->quality);
                break;
            case "gif":
                imagegif($this->tmp, $this->directory . $this->prefix . $this->defaultName, $this->quality);
                //imagegif($this->tmp, $this->directory . $this->prefix . $this->defaultName . $this->suffix . "." . $this->ext, $this->quality);
                break;
            case "png":
                imagepng($this->tmp, $this->directory . $this->prefix . $this->defaultName, $this->compression);
                //imagepng($this->tmp, $this->directory . $this->prefix . $this->defaultName . $this->suffix . "." . $this->ext, $this->compression);
                break;
        }
    }

    public function show() 
    {
        header("content-type:" . $this->image_info['mime']);
        switch ($this->ext) {
            case "jpg":
                imagejpeg($this->tmp);
                break;
            case "jpeg":
                imagejpeg($this->tmp);
                break;
            case "gif":
                imagegif($this->tmp);
                break;
            case "png":
                imagepng($this->tmp);
                break;
        }
    }

    function __destruct() {
        imagedestroy($this->tmp);
        imagedestroy($this->img);
    }
}