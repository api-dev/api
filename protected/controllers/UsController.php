<?php

class UsController extends Controller
{

    public function actionIndex()
    {
        $post = filter_input_array(INPUT_POST);
        $get = filter_input_array(INPUT_GET);
        $request = $post ? array_merge_recursive($post, $get) : $get;
        if ($request['m'] == 'set'){
            if($request['action'] == 'photo')
                $this->setPhoto();
            else
                $this->setUser($request);
        }elseif($request['m'] == 'del'){
            $this->delUser($request);
        }else{
            $this->getUser($request);
        }
    }

    public function actionForm()
    {
//        $user = User::model()->find("login='cheshenkov'");
//        if(!$user)
//            return $this->result('Пользователя cheshenkov не существует!');
//        
//        var_dump($user->g_id);
//        var_dump($ancestors);
//        $this->render('form');
    }

    private function getUser($request)
    {
        $user_db = User::model()->find('login=:login', array(':login' => $request['login']));
        var_dump($user_db);
    }

    private function delUser($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о пользователе. Попробуйте еще раз.');

        if (isset($data['login']))
            User::model()->deleteAll('login=:login', array(':login' => $data['login']));
        else{
            foreach ($data as $user):
                User::model()->deleteAll('login=:login', array(':login' => $user['login']));
            endforeach;
        }
        return $this->result('Удаление прошло успешно.');
    }

    private function setUser($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о пользователе. Попробуйте еще раз.');

        if (isset($data['login'])){
            $this->setOneUser($data);
        }else{
            foreach ($data as $user):
                $this->setOneUser($user);
            endforeach;
        }
    }

    private function setPhoto()
    {
        if(!empty($_FILES))
        {
            $uploadFile = $_FILES['datafile'];
            $tmp_name = $uploadFile['tmp_name'];
            if(is_array($tmp_name))
            {
                foreach ($tmp_name as $login=>$name)
                {
                    $this->setOnePhoto(array(
                        'name' => $uploadFile['name'][$login],
                        'type' => $uploadFile['type'][$login],
                        'tmp_name' => $uploadFile['tmp_name'][$login],
                        'error' => $uploadFile['error'][$login],
                        'size' => $uploadFile['size'][$login],
                        'login' => $login
                    ));
                }
            }
//                $this->setOnePhoto($uploadFile)
//            if ( !is_uploaded_file($tmp_name) ) 
//                die('Ошибка при загрузке файла ' . $data_filename);
            else 
            {

            }
        }
    }
    
    private function getPhotoDir($id)
    {
        if(!$id)
            return $this->result('Не найдено id категории');
            
        $group = Group::model()->findByPk($id);
        $ancestors = $group->ancestors()->findAll();
        $parent = 'images/photo';
        for($i=1; $i<count($ancestors); $i++)
        {
            $folder = Translite::rusencode($ancestors[$i]->name);
            $parent .= '/'.$folder;
        }
        return $parent;
    }

    private function setOnePhoto($photo)
    {
        $user = User::model()->find("login='".$photo['login']."'");
        if(!$user)
            return $this->result('Пользователя '.$photo['login'].' не существует!');
        
        $dir = $this->getPhotoDir($user->g_id);
        $image = new Image();
        $image->mini = false;
        $image->decode = true;
        $image->dir = $dir;
        $return = $image->load($photo);
        
        if(is_array($return) && !empty($return))
        {
            $user->photo = $return[link];
            if($user->save())
                return $this->result('Фото пользователя '.$user->surname.' '.$user->name.' успешно загружено и сохранено.');
        }else
            return $this->result('Фото пользователя '.$user->surname.' НЕ загружено! '.$return);
            
    }

    /**
     * Принимаемые параметры:
     * @login - Логин. Уникальный 1С идентефикатор
     * @email - Почта
     * @gender - Пол
     * @name - Имя
     * @surname - Фамилия
     * @secondname - Отчество
     * @f_id - Филиал (Код из трех символов)
     * @direction - Направление/Служба
     * @department - Отдел
     * @position - Должность
     * @dob - Дата рождения
     * @date_hire - Дата приема на работу
     * @phone_in - Номер внутренний
     * @phone_mb - Номер мобильный Беларусь
     * @phone_mr - Номер мобильный Россия
     * @skype - Логин скайпа
     *
     * Генерируемые параметры:
     * @id - ID пользователя в базе
     * @g_id - идентификатор группы(основан на @branch, @direction, @department, @position)
     * @password - пароль (если не активирован, то сюда записывается хэш ссылки для активации)
     * @status - статус пользователя активирован/неактивирован
     */
    private function setOneUser($user)
    {
        if (!$user['login'] || empty($user['login']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');

        $app = Yii::app();
        $transaction = $app->db_auth->beginTransaction();
        try {
            $user_db = User::model()->find('login=:login', array(':login' => $user['login']));
            if (!$user_db)
                $user_db = new User();

            foreach ($user_db as $name => $v) {
                if (isset($user[$name]) || !empty($user[$name]))
                    $user_db->$name = $user[$name];
            }
            if ($user['f_id'] && $user['position']){
                $branch = $app->db_lbr->createCommand()->
                    select('name, domain')->
                    from('contacts')->
                    where('oneC_id="'.$user['f_id'].'"')->
                    queryRow();
                $user_db->g_id = $this->returnGroup(array('branch' => $branch->name, 'direction' => $user['direction'], 'department' => $user['department'], 'position' => $user['position']));
            }else
                $this->result('Внимание!!! Невозможно сформировать группу, не указан филиал/должность.');
            
            $user_db->status = 1;
            
            if($user_db->isNewRecord)
                $user_db->password = User::randomPassword();
            
            if ($user_db->validate() && $user_db->save()) {
                    $transaction->commit();
                    return $this->result('Сохранение '.$user_db->login.' произошло успешно.');
            }
            $transaction->rollback();
            return $this->result($user_db->getErrors());
        } catch (Exception $e) {
            $this->result("Исключение: " . $e->getMessage() . "\n");
            $transaction->rollback();
            return false;
        }

    }
    

    private function returnGroup($params = false)
    {
        if (!$params)
            return $this->result('Ошибка. Невозможно сформировать группу, недостаточно данных.');

        $id = 0;
        foreach ($params as $group) {
            if ($group) {
                $group = str_replace(array("'", "/", "\\"), '', trim($group));
                $g = Group::model()->find("name='".$group."' AND parent_id='".$id."'");
                if (!$g)
                    $g = new Group();

                $g->name = $group;
                
                if ($g->getIsNewRecord()) {
                    $parent = Group::model()->findByPk($id);
                    $action = $g->appendTo($parent);
                } else {
                    $action = $g->saveNode();
                }
                if($action)
                    $id = $g->id;
            }
        }
        return $id;
    }

    private function result($text)
    {
        $this->renderPartial('index', array('text' => $text));
        return false;
    }
}
