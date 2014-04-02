<?php

/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property integer $id
 * @property string $company
 * @property integer $inn
 * @property integer $status
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $district
 * @property string $name
 * @property string $secondname
 * @property string $surname
 * @property string $login
 * @property string $password
 * @property integer $phone
 * @property integer $phone2
 * @property integer $parent
 * @property integer $type
 * @property integer $type_contact
 * @property string $email
 *
 * The followings are the available model relations:
 * @property Changes[] $changes
 * @property Message[] $messages
 * @property NfyMessages[] $nfyMessages
 * @property NfySubscriptions[] $nfySubscriptions
 * @property Rate[] $rates
 * @property UserEvent[] $userEvents
 * @property UserField[] $userFields
 */
class TrUser extends CActiveRecord
{
    const USER_NOT_CONFIRMED = 0;
    const USER_ACTIVE = 1;
    const USER_WARNING = 2;
    const USER_TEMPORARY_BLOCKED = 3;
    const USER_BLOCKED = 4;
        
    public function getDbConnection()
    {
        return Yii::app()->db_exch;
    }
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company, inn, name, surname, secondname, password, status, country, region, city, district, phone, phone2, type_contact, type, parent, email', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'changes' => array(self::HAS_MANY, 'Changes', 'user_id'),
            'messages' => array(self::HAS_MANY, 'Message', 'user_id'),
            'nfyMessages' => array(self::HAS_MANY, 'NfyMessages', 'user_id'),
            'nfySubscriptions' => array(self::HAS_MANY, 'NfySubscriptions', 'user_id'),
            'rates' => array(self::HAS_MANY, 'Rate', 'user_id'),
            'userEvents' => array(self::HAS_MANY, 'UserEvent', 'user_id'),
            'userFields' => array(self::HAS_MANY, 'UserField', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'company' => 'Комания',
            'inn' => 'ИНН/УНП ',
            'status' => 'Статус',
            'country' => 'Страна',
            'region' => 'Область',
            'city' => 'Город',
            'district' => 'Район',
            'name' => 'Имя',
            'secondname' => 'Отчество',
            'surname' => 'Фамилия',
            'password' => 'Пароль',
            'phone' => 'Телефон',
            'phone2' => 'Телефон №2',
            'parent' => 'Родитель',
            'type' => 'Тип',
            'type_contact' => 'Тип',
            'email' => 'Email',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('company',$this->company,true);
        $criteria->compare('inn',$this->inn);
        $criteria->compare('status',$this->status);
        $criteria->compare('country',$this->country,true);
        $criteria->compare('region',$this->region,true);
        $criteria->compare('city',$this->city,true);
        $criteria->compare('district',$this->district,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('secondname',$this->secondname,true);
        $criteria->compare('surname',$this->surname,true);
        $criteria->compare('login',$this->login,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('phone',$this->phone);
        $criteria->compare('phone2',$this->phone2);
        $criteria->compare('parent',$this->parent);
        $criteria->compare('type',$this->type);
        $criteria->compare('type_contact',$this->type_contact);
        $criteria->compare('email',$this->email,true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    protected function beforeSave() {
        parent::beforeSave();
        if($this->isNewRecord && isset($this->email))
        {
            $password = User::randomPassword();
            $this->password = crypt($password, User::blowfishSalt());
            
            $email = new TEmail;
            $email->from_email = 'help.ex@lbr.ru';
            $email->from_name  = 'Биржа перевозок ЛБР АгроМаркет';
            $email->to_email   = $this->email;
            $email->to_name    = '';
            $email->subject    = "Приглашение";
            $email->type = 'text/html';
            $email->body = "<h1>Уважаемый(ая) " . $this->name . ' ' . $this->secondname . ", </h1>" . 
                "Приглашаем Вас воспользоваться биржей перевозок <a href='http://exchange.lbr.ru'>ЛБР АгроМаркет</a>" . "<br>" .
                "Ваш логин: " . $this->email . "<br>" .
                "Ваш пароль: " . $password . "<br>" .
                "Изменить пароль Вы можете зайдя в кабинет пользователя с помощью указанных логина и пароля. " . 
                "<hr><p>Это сообщение является автоматическим, на него не следует отвечать</p>"
            ;
            $email->sendMail();
        }
        return true;
    }
    
    protected function afterSave() {
        parent::afterSave();
        if($this->isNewRecord)
        {
            $model = new TrUserField;
            $model->user_id = $this->id;
            $model->mail_transport_create_1 = true;
            $model->mail_transport_create_2 = true;
            $model->mail_kill_rate = false;
            $model->mail_before_deadline = false;
            $model->mail_deadline = true;
            $model->with_nds = false;
            switch($this->type)
            {
                case '0':
                    $model->show_intl = true;
                    $model->show_regl = true;
                break;
                case '1':
                    $model->mail_transport_create_1 = false;
                    $model->show_intl = false;
                    $model->show_regl = true;
                break;
                case '2':
                    $model->show_intl = true;
                    $model->show_regl = false;
                    $model->mail_transport_create_2 = false;
                break;
            }
            if($model->save())
                return true;
        }
    }

    public function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 16; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
