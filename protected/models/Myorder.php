<?php

/**
 * This is the model class for table "myorder".
 *
 * The followings are the available columns in table 'myorder':
 * @property integer $id
 * @property string $companyId
 * @property string $orderPersonWXId
 * @property string $orderPersonName
 * @property string $phone
 * @property string $orderTime
 * @property integer $orderNum
 * @property integer $orderPersonNum
 * @property integer $isTakeOut
 * @property string $orderRemark
 * @property string $createTime
 * @property integer $dealSts
 * @property integer $resourceId
 * @property string $companyRemark
 * @property string $companyDealTime
 * @property integer $isDelete
 */
class Myorder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'myorder';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('companyId, phone, createTime', 'required'),
			array('orderNum, orderPersonNum, isTakeOut, dealSts, resourceId, isDelete', 'numerical', 'integerOnly'=>true),
			array('companyId, orderPersonWXId', 'length', 'max'=>32),
			array('orderPersonName, phone', 'length', 'max'=>16),
			array('orderRemark, companyRemark', 'length', 'max'=>255),
			array('orderTime, companyDealTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, companyId, orderPersonWXId, orderPersonName, phone, orderTime, orderNum, orderPersonNum, isTakeOut, orderRemark, createTime, dealSts, resourceId, companyRemark, companyDealTime, isDelete', 'safe', 'on'=>'search'),
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
			'orderPersonWXId' => 'Order Person Wxid',
			'orderPersonName' => 'Order Person Name',
			'phone' => 'Phone',
			'orderTime' => 'Order Time',
			'orderNum' => 'Order Num',
			'orderPersonNum' => 'Order Person Num',
			'isTakeOut' => 'Is Take Out',
			'orderRemark' => 'Order Remark',
			'createTime' => 'Create Time',
			'dealSts' => 'Deal Sts',
			'resourceId' => 'Resource',
			'companyRemark' => 'Company Remark',
			'companyDealTime' => 'Company Deal Time',
			'isDelete' => 'Is Delete',
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
		$criteria->compare('orderPersonWXId',$this->orderPersonWXId,true);
		$criteria->compare('orderPersonName',$this->orderPersonName,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('orderTime',$this->orderTime,true);
		$criteria->compare('orderNum',$this->orderNum);
		$criteria->compare('orderPersonNum',$this->orderPersonNum);
		$criteria->compare('isTakeOut',$this->isTakeOut);
		$criteria->compare('orderRemark',$this->orderRemark,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('dealSts',$this->dealSts);
		$criteria->compare('resourceId',$this->resourceId);
		$criteria->compare('companyRemark',$this->companyRemark,true);
		$criteria->compare('companyDealTime',$this->companyDealTime,true);
		$criteria->compare('isDelete',$this->isDelete);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Myorder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
