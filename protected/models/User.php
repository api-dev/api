<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $g_id
 * @property string $login
 * @property string $password
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $secondname
 * @property boolean $gender
 * @property string $dob
 * @property string $date_hire
 * @property string $phone_in
 * @property string $phone_mb
 * @property string $phone_mr
 * @property string $photo
 * @property string $skype
 * @property integer $status
 * @property string $f_id
 */
class User extends CActiveRecord
{
    
        public function getDbConnection()
        {
            return Yii::app()->db_auth;
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
			array('g_id, status', 'numerical', 'integerOnly'=>true),
			array('f_id, login, password, email, name, surname, secondname, gender, dob, date_hire, phone_in, phone_mb, phone_mr, photo, skype', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, g_id, login, password, email, name, surname, secondname, gender, dob, date_hire, phone_in, phone_mb, phone_mr, photo, skype, status, f_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'g_id' => 'G',
			'login' => 'Login',
			'password' => 'Password',
			'email' => 'Email',
			'name' => 'Name',
			'surname' => 'Surname',
			'secondname' => 'Secondname',
			'gender' => 'Gender',
			'dob' => 'Dob',
			'date_hire' => 'Date Hire',
			'phone_in' => 'Phone In',
			'phone_mb' => 'Phone Mb',
			'phone_mr' => 'Phone Mr',
			'photo' => 'Photo',
			'skype' => 'Skype',
			'status' => 'Status',
			'f_id' => 'Филиал',
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
		$criteria->compare('g_id',$this->g_id);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('secondname',$this->secondname,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('date_hire',$this->date_hire,true);
		$criteria->compare('phone_in',$this->phone_in,true);
		$criteria->compare('phone_mb',$this->phone_mb,true);
		$criteria->compare('phone_mr',$this->phone_mr,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('skype',$this->skype,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('f_id',$this->f_id);

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
        
        public static function randomPassword($count = 16) {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < (int)$count; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }

        /**
         * @param string $login user login
         * @param string $type print - div view for print, email - table view for e-mail
         * @return html vCard User
         */ 
        public static function getPasteboard($login, $type = 'print')
        {
            $model = User::model()->findByAttributes(array('login' => $login));
            if(!$model)
                return false;
            $return = '';
            $phone = implode('; ', array_diff(array($model->phone_mb, $model->phone_mr), array('-', '', ' ', '0', null)));
            if($type=='print'){
                $return .= '<div class="pasteboard">';
                    if($model->photo && $model->photo!='1')
                    {
                        $return .= '<div class="photo">';
                            $return .= '<img src="http://api.lbr.ru'.$model->photo.'" alt="Фото персонального менеджера">';
                        $return .= '</div>';
                    }
                    $return .= '<div class="desc">';
                        $return .= '<div class="you-manage">Ваш персональный менеджер:</div>';
                        
                        if($model->name && $model->surname)
                            $return .= '<div class="name">'.$model->surname.' '.$model->name.' '.$model->secondname.'</div>';
                        
                        if($phone)
                            $return .= '<div class="phone"><b>Телефон:</b> '.$phone.'</div>';
                        
                        if($model->skype)
                            $return .= '<div class="skype"><b>Skype:</b> '.$model->skype.'</div>';
                        
                        if($model->email)
                            $return .= '<div class="email"><b>E-mail:</b> '.$model->email.'</div>';
                        
                        $return .= '<div class="sitelink"><a href="http://www.lbr.ru/" target="_blank">www.lbr.ru</a></div>';
                    $return .= '</div>';
                $return .= '</div>';
            }elseif($type=='email'){
                $return .= '<table cellspacing="0" cellpadding="0"  style="margin: 0; padding: 0px; border: 0;">';
                    $return .= '<tr>';
                        if($model->photo && $model->photo!='1')
                        {
                            $return .= '<td style="padding-right: 15px;" valign="top">';
                                $return .= '<img src="http://api.lbr.ru'.$model->photo.'" height="130" border="0" alt="Фото персонального менеджера">';
                            $return .= '</td>';
                        }
                        $return .= '<td valign="top">';
                            $return .= '<table cellspacing="0" cellpadding="0"  style="margin: 0; padding: 0px; border: 0;">';
                                $return .= '<tr>';
                                    $return .= '<td><b style="font-size: 1.1em;">Ваш персональный менеджер:</b></td>';
                                $return .= '</tr>';
                                if($model->name && $model->surname){
                                    $return .= '<tr>';
                                        $return .= '<td>'.$model->surname.' '.$model->name.' '.$model->secondname.'</td>';
                                    $return .= '</tr>';
                                }
                                if(!empty($phone)){
                                    $return .= '<tr>';
                                        $return .= '<td><b>Телефон:</b> '.$phone.'</td>';
                                    $return .= '</tr>';
                                }
                                if($model->skype){
                                    $return .= '<tr>';
                                        $return .= '<td><b>Skype:</b> '.$model->skype.'</td>';
                                    $return .= '</tr>';
                                }
                                if($model->email){
                                    $return .= '<tr>';
                                        $return .= '<td><b>Телефон:</b> '.$model->email.'</td>';
                                    $return .= '</tr>';
                                }
                                $return .= '<tr>';
                                    $return .= '<td><a href="http://www.lbr.ru/" target="_blank">www.lbr.ru</a></td>';
                                $return .= '</tr>';
                            $return .= '</table>';
                        $return .= '</td>';
                    $return .= '</tr>';
                $return .= '</table>';
            }
            
            return $return;
        }
}
