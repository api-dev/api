<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $external_id
 * @property string $name
 * @property string $product_group_id
 * @property string $price_id
 * @property string $catalog_number
 * @property string $product_maker_id
 * @property string $image
 * @property integer $count
 * @property string $liquidity
 * @property integer $min_quantity
 * @property string $additional_info
 * @property boolean $published
 *
 * The followings are the available model relations:
 * @property Analog[] $analogs
 * @property Analog[] $analogs1
 * @property AttributeValue[] $attributeValues
 * @property OrderProduct[] $orderProducts
 * @property ProductMaker $productMaker
 * @property Price $price
 * @property ProductGroup $productGroup
 * @property RelatedProduct[] $relatedProducts
 * @property RelatedProduct[] $relatedProducts1
 */
class Product extends CActiveRecord
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
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('count, min_quantity', 'numerical', 'integerOnly'=>true),
			array('external_id, name, product_group_id, price_id, catalog_number, product_maker_id, image, liquidity, additional_info, published', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, external_id, name, product_group_id, price_id, catalog_number, product_maker_id, image, count, liquidity, min_quantity, additional_info, published', 'safe', 'on'=>'search'),
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
			'analogs' => array(self::HAS_MANY, 'Analog', 'analog_product_id'),
			'analogs1' => array(self::HAS_MANY, 'Analog', 'product_id'),
			'attributeValues' => array(self::HAS_MANY, 'AttributeValue', 'product_id'),
			'orderProducts' => array(self::HAS_MANY, 'OrderProduct', 'product_id'),
			'productMaker' => array(self::BELONGS_TO, 'ProductMaker', 'product_maker_id'),
			'price' => array(self::BELONGS_TO, 'Price', 'price_id'),
			'productGroup' => array(self::BELONGS_TO, 'ProductGroup', 'product_group_id'),
			'relatedProducts' => array(self::HAS_MANY, 'RelatedProduct', 'related_product_id'),
			'relatedProducts1' => array(self::HAS_MANY, 'RelatedProduct', 'product_id'),
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
			'name' => 'Name',
			'product_group_id' => 'Product Group',
			'price_id' => 'Price',
			'catalog_number' => 'Catalog Number',
			'product_maker_id' => 'Product Maker',
			'image' => 'Image',
			'count' => 'Count',
			'liquidity' => 'Liquidity',
			'min_quantity' => 'Min Quantity',
			'additional_info' => 'Additional Info',
			'published' => 'Published',
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
		$criteria->compare('product_group_id',$this->product_group_id,true);
		$criteria->compare('price_id',$this->price_id,true);
		$criteria->compare('catalog_number',$this->catalog_number,true);
		$criteria->compare('product_maker_id',$this->product_maker_id,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('count',$this->count);
		$criteria->compare('liquidity',$this->liquidity,true);
		$criteria->compare('min_quantity',$this->min_quantity);
		$criteria->compare('additional_info',$this->additional_info,true);
		$criteria->compare('published',$this->published);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
