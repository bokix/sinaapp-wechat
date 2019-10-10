<?php

/**
 * This is the model class for table "orderItem".
 *
 * The followings are the available columns in table 'orderItem':
 * @property integer $id
 * @property string $companyId
 * @property integer $orderNum
 * @property integer $itemId
 * @property integer $orderId
 * @property string $createTime
 * @property string $orderPersonWXId
 * @property string $itemName
 * @property string $itemDesc
 * @property integer $isValid
 * @property integer $categoryId
 * @property string $img80
 * @property string $unit
 * @property double $price
 * @property double $totalPrice
 * @property integer $count
 */
class OrderItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orderItem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('companyId, itemId, orderPersonWXId, itemName, categoryId, price, totalPrice', 'required'),
			array('orderNum, itemId, orderId, isValid, categoryId, count', 'numerical', 'integerOnly'=>true),
			array('price, totalPrice', 'numerical'),
			array('companyId, orderPersonWXId', 'length', 'max'=>32),
			array('itemName', 'length', 'max'=>64),
			array('itemDesc', 'length', 'max'=>256),
			array('img80', 'length', 'max'=>1024),
			array('unit', 'length', 'max'=>12),
			array('createTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, companyId, orderNum, itemId, orderId, createTime, orderPersonWXId, itemName, itemDesc, isValid, categoryId, img80, unit, price, totalPrice, count', 'safe', 'on'=>'search'),
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
			'orderNum' => 'Order Num',
			'itemId' => 'Item',
			'orderId' => 'Order',
			'createTime' => 'Create Time',
			'orderPersonWXId' => 'Order Person Wxid',
			'itemName' => 'Item Name',
			'itemDesc' => 'Item Desc',
			'isValid' => 'Is Valid',
			'categoryId' => 'Category',
			'img80' => 'Img80',
			'unit' => 'Unit',
			'price' => 'Price',
			'totalPrice' => 'Total Price',
			'count' => 'Count',
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
		$criteria->compare('orderNum',$this->orderNum);
		$criteria->compare('itemId',$this->itemId);
		$criteria->compare('orderId',$this->orderId);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('orderPersonWXId',$this->orderPersonWXId,true);
		$criteria->compare('itemName',$this->itemName,true);
		$criteria->compare('itemDesc',$this->itemDesc,true);
		$criteria->compare('isValid',$this->isValid);
		$criteria->compare('categoryId',$this->categoryId);
		$criteria->compare('img80',$this->img80,true);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('totalPrice',$this->totalPrice);
		$criteria->compare('count',$this->count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
