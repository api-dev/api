<?php

/**
 * This is the model class for table "kp".
 *
 * The followings are the available columns in table 'kp':
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property string $json
 * @property string $html
 * @property string $email
 * @property string $date_create
 * @property string $date_edit
 * @property string $date_status
 * @property string $date_finish
 * @property integer $auditor_id
 * @property integer $auditor_status
 * @property string $auditor_date_status
 * @property string $auditor_comment
 * @property integer $u_id_create
 * @property integer $u_id_edit
 */
class Kp extends CActiveRecord
{
    
        public function getDbConnection()
        {
            return Yii::app()->db_kp;
        }
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, auditor_id, auditor_status, u_id_create, u_id_edit', 'numerical', 'integerOnly'=>true),
			array('name, json, html, email, date_create, date_edit, date_status, date_finish, auditor_date_status, auditor_comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, status, json, html, email, date_create, date_edit, date_status, date_finish, auditor_id, auditor_status, auditor_date_status, auditor_comment, u_id_create, u_id_edit', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'status' => 'Status',
			'json' => 'Json',
			'html' => 'Html',
			'email' => 'Email',
			'date_create' => 'Дата создания',
			'date_edit' => 'Дата редактирования',
			'date_status' => 'Дата изменения статуса',
			'date_finish' => 'Дата окончания публикации',
			'auditor_id' => 'Аудитор',
			'auditor_status' => 'Согласование',
			'auditor_date_status' => 'Время согласования',
			'auditor_comment' => 'Коментарии к согласованию',
			'u_id_create' => 'Создатель',
			'u_id_edit' => 'Последнее редактирование',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('json',$this->json,true);
		$criteria->compare('html',$this->html,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_edit',$this->date_edit,true);
		$criteria->compare('date_status',$this->date_status,true);
		$criteria->compare('date_finish',$this->date_finish,true);
		$criteria->compare('auditor_id',$this->auditor_id);
		$criteria->compare('auditor_status',$this->auditor_status);
		$criteria->compare('auditor_date_status',$this->auditor_date_status);
		$criteria->compare('auditor_comment',$this->auditor_comment);
		$criteria->compare('u_id_create',$this->u_id_create);
		$criteria->compare('u_id_edit',$this->u_id_edit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        protected function beforeSave() 
        {
            $old = Kp::model()->findByPk($this->id);
            $date = date('Y-m-d H:i:s');
            $u_id = Yii::app()->user->_id;
            
            if($this->isNewRecord)
            {
                $this->u_id_create = $u_id;
                $this->date_create = $date;
                $this->json =   '[
                                    {
                                        "id": "1",
                                        "title": "Страница 1",
                                        "type": "page",
                                        "style": {},
                                        "content": []
                                    }
                                ]';
                $this->name = 'Новое КП';
                $this->status = '0';
                $this->auditor_status = '0';
            }
            
            if($old->status !== $this->status){
                $this->date_status = $date;
            }
            
            $this->date_edit = $date;
            $this->u_id_edit = $u_id;
            
            return parent::beforeSave();
        }

        /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
