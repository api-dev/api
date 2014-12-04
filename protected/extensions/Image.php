<?php
class Image {
    
    public $dir = 'images/uploads';
    public $ext = array('jpg', 'jpeg', 'png', 'gif');
    public $size = 4194304;
    public $mini = true;
    public $minW = '250';
    public $minH = '150';
    public $decode = false;

    public function load($array){
        
        if(!$array)
            $array = $_FILES['datafile'];
        
        $return = array();
        
        if (empty($array))
            return $this->error("Файл не выбран.");
        
        $server = filter_input_array(INPUT_SERVER);
        
        $dir = $server['DOCUMENT_ROOT'].'/'.$this->dir;
//        $imageDir = 'http://'.$server['SERVER_NAME'].'/'.$this->dir;
        //Yii::log('dir: '.$dir, 'info');
        $ext = end(explode('.', strtolower($array['name'])));
        
        if (!in_array($ext, $this->ext))
            return $this->error("Недопустимое расширение файла(".$ext.").");

        if($this->size < $array['size'])
            return $this->error ("Недопустимый размер файла.");
        
        if (is_uploaded_file($array['tmp_name'])){
            
            if(!file_exists($dir)){
               if(!mkdir($dir, 0755, true))
                   return $this->error('Ошибка создания каталога.');
            }
            
            $file = $dir.'/'.$array['login'].'.'.$ext; 
            
            //если файл с таким именем уже существует, то удаляем его
            if (file_exists($file)) 
                unlink($file);
            
            $data = file_get_contents($array['tmp_name']);

            $return[link] = '/'.$this->dir.'/'.$array['login'].'.'.$ext;
            
            // Декодирование файла
            if ($this->decode)
                $data = base64_decode($data);
            /*
            if(is_array($data)){
                foreach($data as $d){
                    Yii::log('data: '.$d, 'info');
                }
            } else Yii::log('data: '.$data, 'info');
            Yii::log('open: '.@fopen($array['tmp_name'], 'wb'), 'info');
            */
            if ( !empty($data) && ($fp = @fopen($array['tmp_name'], 'wb')) )
            {
                if(@fwrite($fp, $data) && @fclose($fp))
                {
                    if(move_uploaded_file($array['tmp_name'], $file))
                        return $return;
                    else
                        return $this->error ("Файл не скопирован. Ошибка.");
                }
                else
                    return $this->error ("Ошибка декодирования файла");
            } else
                return $this->error('Ошибка при записи файла '.$array['name']);
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
