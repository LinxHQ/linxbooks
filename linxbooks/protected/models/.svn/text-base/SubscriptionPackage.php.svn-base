<?php

/**
 * This is the model class for table "subscription_packages".
 *
 * The followings are the available columns in table 'subscription_packages':
 * @property integer $subscription_package_id
 * @property string $subscription_package_name
 * @property integer $subscription_package_status
 */
class SubscriptionPackage extends CActiveRecord
{

	const SUBSCRIPTION_PACKAGE_FREE = 4;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriptionPackage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_sys_subscription_packages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscription_package_name, subscription_package_status', 'required'),
			array('subscription_package_status', 'numerical', 'integerOnly'=>true),
			array('subscription_package_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subscription_package_id, subscription_package_name, subscription_package_status', 'safe', 'on'=>'search'),
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
			'subscription_package_id' => 'Subscription Package',
			'subscription_package_name' => 'Subscription Package Name',
			'subscription_package_status' => 'Subscription Package Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('subscription_package_id',$this->subscription_package_id);
		$criteria->compare('subscription_package_name',$this->subscription_package_name,true);
		$criteria->compare('subscription_package_status',$this->subscription_package_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getActivePackages() {
		$condition = 'subscription_package_status = :status_id';
		return SubscriptionPackage::model()->findAll($condition, array(':status_id' => 1));
	}
	
	public function getPackageName($package_id = 0)
	{
		$package = $this;
		if ($package_id > 0)
			$package = $this->findByPk($package_id);
		
		return $package->subscription_package_name;
	}
}