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
                $this->setPhoto($request);
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
        $user_db = User::model()->find('u_id=:u_id', array(':u_id' => $request['u_id']));
        var_dump($user_db);
    }

    private function delUser($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о пользователе. Попробуйте еще раз.');

        if (isset($data['u_id']))
            User::model()->deleteAll('u_id=:uid', array(':uid' => $data['u_id']));
        else{
            foreach ($data as $user):
                User::model()->deleteAll('u_id=:uid', array(':uid' => $user['u_id']));
            endforeach;
        }
        return $this->result('Удаление прошло успешно.');
    }

    private function setUser($request)
    {
        $data = $request['data'];
        if (!$data || empty($data))
            return $this->result('Ошибка. Нет данных о пользователе. Попробуйте еще раз.');

        if (isset($data['u_id'])){
            $this->setOneUser($data);
        }else{
            foreach ($data as $user):
                $this->setOneUser($user);
            endforeach;
        }
    }

    private function setPhoto($request)
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
        $image->dir = $dir;
        $return = $image->load($photo);
        
        if(is_array($return) && !empty($return))
        {
            $user->photo = $return;
            if($user->save())
                return $this->result('Фото пользователя '.$user->surname.' '.$user->name.' успешно загружено и сохранено.');
        }else
            return $this->result($return);
            
    }

    /**
     * Принимаемые параметры:
     * @u_id - Уникальный 1С идентефикатор
     * @login - Логин
     * @email - Почта
     * @gender - Пол
     * @name - Имя
     * @surname - Фамилия
     * @secondname - Отчество
     * @branch - Филиал
     * @direction - Направление/Служба
     * @department - Отдел
     * @position - Должность
     * @dob - Дата рождения
     * @date_hire - Дата приема на работу
     * @phone_in - Номер внутренний
     * @phone_mb - Номер мобильный Беларусь
     * @phone_mr - Номер мобильный Россия
     * @skype - Логин скайпа
     * @photo - Фотография !!!ВНИМАНИЕ!!! - это пока не рабочий параметр
     *
     * Генерируемые параметры:
     * @id - ID пользователя в базе
     * @g_id - идентификатор группы(основан на @branch, @direction, @department, @position)
     * @password - пароль (если не активирован, то сюда записывается хэш ссылки для активации)
     * @status - статус пользователя активирован/неактивирован
     */
    private function setOneUser($user)
    {
        if (!$user['u_id'] || empty($user['u_id']))
            return $this->result('Ошибка. Нет уникального идентефикатора 1С.');

        $app = Yii::app();
        $transaction = $app->db_auth->beginTransaction();
        try {
            $user_db = User::model()->find('u_id=:u_id', array(':u_id' => $user['u_id']));
            if (!$user_db)
                $user_db = new User();

            foreach ($user_db as $name => $v) {
                if (isset($user[$name]) || !empty($user[$name]))
                    $user_db->$name = $user[$name];
            }
            if ($user['branch'] && $user['position'])
                $user_db->g_id = $this->returnGroup(array('branch' => $user['branch'], 'direction' => $user['direction'], 'department' => $user['department'], 'position' => $user['position']));
            else
                $this->result('Внимание!!! Невозможно сформировать группу, не указан филиал/должность.');

            if ($user_db->validate() && $user_db->save()) {
                    $transaction->commit();
                    return $this->result('Сохранение '.$user_db->u_id.' произошло успешно.');
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
                $g = Group::model()->find('name = :name AND parent_id = :p_id',
                    array(':name' => $group, ':p_id' => $id));
                if (!$g)
                    $g = new Group();

                $g->name = $group;

                if ($g->getIsNewRecord()) {
                    $parent = Group::model()->findByPk($id);
                    $g->appendTo($parent);
                } else {
                    $g->saveNode();
                }
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
