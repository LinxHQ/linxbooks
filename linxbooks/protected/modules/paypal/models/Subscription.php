<?php

/**
 * This is the model class for table "subscription".
 *
 * The followings are the available columns in table 'subscription':
 * @property integer $subscription_id
 * @property string $subscription_name
 * @property integer $subscription_cycle
 * @property string $subscription_value
 */
class Subscription extends CActiveRecord
{
        var $module_name = 'paypal';
	/**
	 * Returns the static model of the specified AR class.
	 * @return Subscription the static model class
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
		return 'lb_subscription';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscription_name, subscription_cycle, subscription_value', 'required'),
			array('subscription_cycle', 'numerical', 'integerOnly'=>true),
			array('subscription_name, subscription_value', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subscription_id, subscription_name, subscription_cycle, subscription_value', 'safe', 'on'=>'search'),
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
			'subscription_id' => 'Subscription',
			'subscription_name' => 'Subscription Name',
			'subscription_cycle' => 'Subscription Cycle',
			'subscription_value' => 'Subscription Value',
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

		$criteria->compare('subscription_id',$this->subscription_id);
		$criteria->compare('subscription_name',$this->subscription_name,true);
		$criteria->compare('subscription_cycle',$this->subscription_cycle);
		$criteria->compare('subscription_value',$this->subscription_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getArraySubscription()
        {
            
        }
        
}