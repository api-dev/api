<?php

/**
 * This is the model class for table "model_line".
 *
 * The followings are the available columns in table 'model_line':
 * @property integer $id
 * @property string $external_id
 * @property string $name
 * @property integer $category_id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $parent
 * @property boolean $published
 * @property integer $level
 * @property string $path
 * @property integer $maker_id
 *
 * The followings are the available model relations:
 * @property EquipmentMakerInModel[] $equipmentMakerInModels
 * @property EquipmentMaker $maker
 * @property Category $category
 * @property ProductInModelLine[] $productInModelLines
 */
class ProductModelLine extends CActiveRecord
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
		return 'model_line';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('name', 'required'),
			array('category_id, lft, rgt, parent, level, maker_id', 'numerical', 'integerOnly'=>true),
			array('external_id, name, published, path', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, external_id, name, category_id, lft, rgt, parent, published, level, path, maker_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		/*return array(
			'equipmentMakerInModels' => array(self::HAS_MANY, 'EquipmentMakerInModel', 'model_id'),
			'maker' => array(self::BELONGS_TO, 'EquipmentMaker', 'maker_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'productInModelLines' => array(self::HAS_MANY, 'ProductInModelLine', 'model_line_id'),
		);*/
                return array(
			'productInModelLines' => array(self::HAS_MANY, 'ProductInModelLine', 'model_line_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
                        'maker' => array(self::BELONGS_TO, 'EquipmentMaker', 'maker_id'),
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
			'category_id' => 'Category',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'parent' => 'Parent',
			'published' => 'Опубликовать',
			'level' => 'Level',
			'path' => 'Path',
			'maker_id' => 'Maker',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('published',$this->published);
		$criteria->compare('level',$this->level);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('maker_id',$this->maker_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelLine the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function behaviors()
        {
            return array(
                'nestedSetBehavior'=>array(
                    'class'=>'ext.yiiext.behaviors.trees.NestedSetBehavior',
                    'leftAttribute'=>'lft',
                    'rightAttribute'=>'rgt',
                    'levelAttribute'=>'level',
                    'rootAttribute'=>'parent',
                    'hasManyRoots'=>true,
                ),
            );
        }
}
