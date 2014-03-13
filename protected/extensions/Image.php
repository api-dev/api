<?php
class Image {
    
    public $dir = 'images/uploads';
    public $ext = array('jpg', 'jpeg', 'png', 'gif');
    public $size = 4194304;
    public $mini = true;
    public $minW = '250';
    public $minH = '150';

    public function load($array){
        
        if(!$array)
            $array = $_FILES['datafile'];
        
        $return = array();
        
        if (empty($array))
            return $this->error("Файл не выбран.");
        
        $server = filter_input_array(INPUT_SERVER);
        
        $uploadDir = $server['DOCUMENT_ROOT'].'/'.$this->dir;
        $imageDir = 'http://'.$server['SERVER_NAME'].'/'.$this->dir;
        
        $ext = end(explode('.', strtolower($array['name'])));
        
        if (!in_array($ext, $this->ext) || $this->size < $array['size'])
            return $this->error("Недопустимое расширение, либо размер файла.");

        if (is_uploaded_file($array['tmp_name'])){
            $dir = $uploadDir;
            if(!file_exists($dir)){
               if(!mkdir($dir, 0755, true))
                   return $this->error('Ошибка создания каталога.');
            }
            $fileName = $dir.$array['name']; 
            $file = $array['name'];
            //если файл с таким именем уже существует...
            if (file_exists($fileName)) {
                //...добавляем текущее время к имени файла
                $nameParts = explode('.', $array['name']);
                $nameParts[count($nameParts)-2] .= time();
                $file = implode('.', $nameParts);
                $fileName = $dir.$file;
            }
            if(move_uploaded_file($array['tmp_name'], $fileName)){
                if($this->mini){
                    $resize = $this->resize($file, $dir, $this->minW, $this->minH);
                    if($resize){
                        $return['min'] = $imageDir.'tmp/'.$file;
                    }else{
                        return $this->error('Ошибка создания миниатюры.');
                    }
                    $return['min'] = '/' . $this->dir . '/tmp/'. $file;
                }
                $return['link'] = '/' . $this->dir . '/' . $file;
                $return['name'] = $file;
            }else{
                return $this->error('Файл не загружен.');
            }
            
        }
        return $return;
    }
    
    protected function error($text){
        return 'Ошибка загрузки файла. '.$text;
    }
    
    protected function resize($filename, $dir, $width, $height){
        if (!is_dir($dir."tmp/")) {
                mkdir($dir."tmp/", 0755);
        }
        $imageopt = '';
        if (!$imageopt = getimagesize($dir.$filename)){
            return false;
        }
        $width_orig = $imageopt[0];
        $height_orig = $imageopt[1];
        $ratio_orig = $width_orig/$height_orig;
        $width = $ratio_orig*$height;
        $image_p = imagecreatetruecolor($width, $height);
        switch ($imageopt['mime']) {
                case "image/jpg":
                        $image = imagecreatefromjpeg($dir.$filename);
                        break;
                case "image/jpeg":
                        $image = imagecreatefromjpeg($dir.$filename);
                        break;
                case "image/png":
                        $image = imagecreatefrompng($dir.$filename);
                        break;
                case 'image/gif':
                        $image = imagecreatefromgif($dir.$filename);
                        break;

                default:
                        continue;
                        break;
        }
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        if(imagejpeg($image_p, $dir."tmp/$filename")){
            return true;
        }else{
            return false;
        }
    }
}
?>
