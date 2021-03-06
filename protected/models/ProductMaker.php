<?php

/**
 * This is the model class for table "product_maker".
 *
 * The followings are the available columns in table 'product_maker':
 * @property integer $id
 * @property string $external_id
 * @property string $name
 * @property string $description
 * @property string $logo
 * @property boolean $published
 * @property string $country
 * @property string $path
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Product[] $products
 */
class ProductMaker extends CActiveRecord
{
        public function getDbConnection()
        {
            return Yii::app()->db_shop;
        }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_maker';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('external_id, name, description, logo, published, country, path, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, external_id, name, description, logo, published, country, path, update_time', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Product', 'product_maker_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'external_id' => 'External',
			'name' => 'Название',
			'description' => 'Описание',
			'logo' => 'Логотип',
			'published' => 'Опубликовать',
			'country' => 'Страна',
			'path' => 'Path',
			'update_time' => 'Время обновления'
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
		$criteria->compare('external_id',$this->external_id,true);
                $criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductMaker the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
