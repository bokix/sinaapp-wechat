<?php

/**
 * This is the model class for table "item".
 *
 * The followings are the available columns in table 'item':
 * @property integer $id
 * @property string $companyId
 * @property string $itemName
 * @property string $itemDesc
 * @property integer $isValid
 * @property integer $categoryId
 * @property string $img80
 * @property string $unit
 * @property double $price
 */
class Item extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('companyId, itemName, categoryId, price', 'required'),
			array('id, isValid, categoryId', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('companyId', 'length', 'max'=>32),
			array('itemName', 'length', 'max'=>64),
			array('itemDesc', 'length', 'max'=>256),
			array('img80', 'length', 'max'=>1024),
			array('unit', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, companyId, itemName, itemDesc, isValid, categoryId, img80, unit, price', 'safe', 'on'=>'search'),
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
			'companyId' => 'Company',
			'itemName' => 'Item Name',
			'itemDesc' => 'Item Desc',
			'isValid' => 'Is Valid',
			'categoryId' => 'Category',
			'img80' => 'Img80',
			'unit' => 'Unit',
			'price' => 'Price',
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
		$criteria->compare('companyId',$this->companyId,true);
		$criteria->compare('itemName',$this->itemName,true);
		$criteria->compare('itemDesc',$this->itemDesc,true);
		$criteria->compare('isValid',$this->isValid);
		$criteria->compare('categoryId',$this->categoryId);
		$criteria->compare('img80',$this->img80,true);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Item the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
