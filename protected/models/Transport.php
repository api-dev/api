<?php

/**
 * This is the model class for table "transport".
 *
 * The followings are the available columns in table 'transport':
 * @property integer $id
 * @property string $t_id
 * @property integer $new_transport
 * @property integer $rate_id
 * @property integer $start_rate
 * @property integer $status
 * @property integer $type
 * @property string $user_id
 * @property integer $currency
 * @property string $location_from
 * @property string $location_to
 * @property string $auto_info
 * @property string $description
 * @property string $date_close
 * @property string $date_from
 * @property string $date_to
 * @property string $date_published
 *
 * The followings are the available model relations:
 * @property Rate[] $rates
 * @property TransportFieldEq[] $transportFieldEqs
 * @property TransportInterPoint[] $transportInterPoints
 * @property UserEvent[] $userEvents
 */
class Transport extends CActiveRecord
{
        CONST INTER_TRANSPORT = 0;
        CONST RUS_TRANSPORT = 1;
        CONST INTER_PRICE_STEP = 50;
        CONST RUS_PRICE_STEP = 200;
        
        public function getDbConnection()
        {
            return Yii::app()->db_exch;
        }
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transport';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('new_transport, rate_id, start_rate, status, type, currency', 'numerical', 'integerOnly'=>true),
			array('t_id, user_id', 'length', 'max'=>64),
			array('location_from, location_to, auto_info, description, date_close, date_from, date_to, date_published', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, t_id, new_transport, rate_id, start_rate, status, type, user_id, currency, location_from, location_to, auto_info, description, date_close, date_from, date_to, date_published', 'safe', 'on'=>'search'),
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
			'rates' => array(self::HAS_MANY, 'Rate', 'transport_id'),
			'transportFieldEqs' => array(self::HAS_MANY, 'TransportFieldEq', 'transport_id'),
                        'transportInterPoints' => array(self::HAS_MANY, 'TransportInterPoint', 't_id'),
			'userEvents' => array(self::HAS_MANY, 'UserEvent', 'transport_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			't_id' => 'T',
			'new_transport' => 'New Transport',
			'rate_id' => 'Rate',
			'start_rate' => 'Start Rate',
			'status' => 'Status',
			'type' => 'Type',
			'user_id' => 'User',
			'currency' => 'Currency',
			'location_from' => 'Location From',
			'location_to' => 'Location To',
			'auto_info' => 'Auto Info',
			'description' => 'Description',
                        'date_close' => 'Время закрытия заявки',
			'date_from' => 'Date From',
			'date_to' => 'Date To',
			'date_published' => 'Date Published',
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
		$criteria->compare('t_id',$this->t_id,true);
		$criteria->compare('new_transport',$this->new_transport);
		$criteria->compare('rate_id',$this->rate_id);
		$criteria->compare('start_rate',$this->start_rate);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('currency',$this->currency);
		$criteria->compare('location_from',$this->location_from,true);
		$criteria->compare('location_to',$this->location_to,true);
		$criteria->compare('auto_info',$this->auto_info,true);
		$criteria->compare('description',$this->description,true);
                $criteria->compare('date_close',$this->date_close,true);
		$criteria->compare('date_from',$this->date_from,true);
		$criteria->compare('date_to',$this->date_to,true);
		$criteria->compare('date_published',$this->date_published,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        protected function beforeSave() {
            parent::beforeSave();
            $this->date_from = date('Y-m-d H:i:s', strtotime($this->date_from . ' 08:00:00'));
            return true;
        }
}
