<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property string $companyId
 * @property string $appId
 * @property string $appSecret
 * @property string $token
 * @property string $adminUserOpenId
 * @property string $userName
 * @property string $authCode
 * @property string $authPwd
 * @property string $email
 * @property string $adminUserFakeId
 * @property string $loginName
 * @property string $loginPwd
 */
class Company extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('companyId, appId, authCode, email', 'length', 'max'=>32),
			array('appSecret', 'length', 'max'=>64),
			array('token, userName', 'length', 'max'=>16),
			array('adminUserOpenId, adminUserFakeId, loginName', 'length', 'max'=>45),
			array('authPwd, loginPwd', 'length', 'max'=>80),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('companyId, appId, appSecret, token, adminUserOpenId, userName, authCode, authPwd, email, adminUserFakeId, loginName, loginPwd', 'safe', 'on'=>'search'),
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
			'companyId' => 'Company',
			'appId' => 'App',
			'appSecret' => 'App Secret',
			'token' => 'Token',
			'adminUserOpenId' => 'Admin User Open',
			'userName' => 'User Name',
			'authCode' => 'Auth Code',
			'authPwd' => 'Auth Pwd',
			'email' => 'Email',
			'adminUserFakeId' => 'Admin User Fake',
			'loginName' => 'Login Name',
			'loginPwd' => 'Login Pwd',
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

		$criteria->compare('companyId',$this->companyId,true);
		$criteria->compare('appId',$this->appId,true);
		$criteria->compare('appSecret',$this->appSecret,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('adminUserOpenId',$this->adminUserOpenId,true);
		$criteria->compare('userName',$this->userName,true);
		$criteria->compare('authCode',$this->authCode,true);
		$criteria->compare('authPwd',$this->authPwd,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('adminUserFakeId',$this->adminUserFakeId,true);
		$criteria->compare('loginName',$this->loginName,true);
		$criteria->compare('loginPwd',$this->loginPwd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Company the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
