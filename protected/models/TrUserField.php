<?php

/**
 * This is the model class for table "user_field".
 *
 * The followings are the available columns in table 'user_field':
 * @property integer $id
 * @property integer $user_id
 * @property boolean $mail_transport_create_1
 * @property boolean $mail_transport_create_2
 * @property boolean $mail_kill_rate
 * @property boolean $mail_deadline
 * @property boolean $mail_before_deadline
 * @property boolean $with_nds
 * @property boolean $show_intl
 * @property boolean $show_regl
 *
 * The followings are the available model relations:
 * @property User $user
 */
class TrUserField extends CActiveRecord
{
    
        public function getDbConnection()
        {
            return Yii::app()->db_exch;
        }
	 /* @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_field';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'numerical', 'integerOnly'=>true),
			//array('mail_transport_create_1, mail_transport_create_2, mail_kill_rate, mail_deadline, mail_before_deadline, site_transport_create_1, site_transport_create_2, site_kill_rate, site_deadline, site_before_deadline', 'safe'),
			array('with_nds, mail_transport_create_1, mail_transport_create_2, mail_kill_rate, mail_deadline, mail_before_deadline, show_intl, show_regl', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, with_nds, user_id, mail_transport_create_1, mail_transport_create_2, mail_kill_rate, mail_deadline, mail_before_deadline, show_intl, show_regl', 'safe', 'on'=>'search'),
		        //array('new_confirm', 'compare', 'compareAttribute'=>'new_password', 'message'=>'Пароли не совпадают'),
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
			'user' => array(self::BELONGS_TO, 'TrUser', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'mail_transport_create_1' => 'При создании международной заявки на перевозку',
			'mail_transport_create_2' => 'При создании региональной заявки на перевозку',
			'mail_kill_rate' => 'Если перебита ставка',
			'mail_deadline' => 'При закрытии перевозки',
			'mail_before_deadline' => 'Mail Before Deadline',
			'with_nds' => 'Показывать цену с НДС',
                        'show_intl' => 'Показывать международные перевозки',
                        'show_regl' => 'Показывать региональные перевозки',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('mail_transport_create_1',$this->mail_transport_create_1);
		$criteria->compare('mail_transport_create_2',$this->mail_transport_create_2);
		$criteria->compare('mail_kill_rate',$this->mail_kill_rate);
		$criteria->compare('mail_deadline',$this->mail_deadline);
		$criteria->compare('mail_before_deadline',$this->mail_before_deadline);
		$criteria->compare('show_intl',$this->show_intl);
		$criteria->compare('show_regl',$this->show_regl);

		return new CActiveDataProvider($this, array(
	             'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserField the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
