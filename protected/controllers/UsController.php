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
        $this->render('form');
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
            User::model()->deleteAll('login=:uid', array(':uid' => $data['login']));
        else{
            foreach ($data as $user):
                User::model()->deleteAll('login=:uid', array(':uid' => $user['login']));
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

    private function setPhoto($request)
    {
        Yii::log(serialize($_FILES), 'info');
        Yii::log(serialize($request), 'info');
        var_dump($_FILES);
        var_dump($request);
    }

    /**
     * Принимаемые параметры:
     * @login - Логин. Уникальный 1С идентефикатор
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
            if ($user['branch'] && $user['position'])
                $user_db->g_id = $this->returnGroup(array('branch' => $user['branch'], 'direction' => $user['direction'], 'department' => $user['department'], 'position' => $user['position']));
            else
                $this->result('Внимание!!! Невозможно сформировать группу, не указан филиал/должность.');

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