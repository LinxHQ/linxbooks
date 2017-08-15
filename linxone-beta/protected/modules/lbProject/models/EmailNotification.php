<?php

/**
 * This is the model class for table "email_notifications".
 *
 * The followings are the available columns in table 'email_notifications':
 * @property integer $notification_id
 * @property integer $notification_parent_id
 * @property string $notification_parent_type
 * @property string $notification_created_date
 * @property integer $notification_sent
 * @property integer $notification_sender_account_id
 * @property integer $notification_receivers_account_ids
 * @property string $notification_hash
 */
define('NOTIFICATION_PARENT_TYPE_TASK_COMMENT', 'TASK_COMMENT');
define('NOTIFICATION_PARENT_TYPE_ISSUE_COMMENT', 'ISSUE_COMMENT');
define('NOTIFICATION_PARENT_TYPE_IMPLEMENTATION_COMMENT', 'IMPLEMENTATION_COMMENT');
define('NOTIFICATION_SENT_YES', 1);
define('NOTIFICATION_SENT_NO', 0);

class EmailNotification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailNotification the static model class
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
		return 'lb_project_email_notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notification_parent_id, notification_parent_type, notification_created_date, notification_sent, notification_sender_account_id, notification_receivers_account_ids', 'required'),
			array('notification_parent_id, notification_sent, notification_sender_account_id', 'numerical', 'integerOnly'=>true),
			array('notification_parent_type', 'length', 'max'=>60),
			array('notification_receivers_account_ids', 'length', 'max' => 225),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('notification_id, notification_parent_id, notification_parent_type, notification_created_date, notification_sent, notification_sender_account_id, notification_receivers_account_ids', 'safe', 'on'=>'search'),
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
			'notification_id' => 'Notification',
			'notification_parent_id' => 'Notification Parent',
			'notification_parent_type' => 'Notification Parent Type',
			'notification_created_date' => 'Notification Created Date',
			'notification_sent' => 'Notification Sent',
			'notification_sender_account_id' => 'Notification Sender Account',
			'notification_receivers_account_ids' => 'Notification Receivers Account Ids',
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

		$criteria->compare('notification_id',$this->notification_id);
		$criteria->compare('notification_parent_id',$this->notification_parent_id);
		$criteria->compare('notification_parent_type',$this->notification_parent_type,true);
		$criteria->compare('notification_created_date',$this->notification_created_date,true);
		$criteria->compare('notification_sent',$this->notification_sent);
		$criteria->compare('notification_sender_account_id',$this->notification_sender_account_id);
		$criteria->compare('notification_receivers_account_ids',$this->notification_receivers_account_ids);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function save($runValidation = true, $attributes = NULL)
	{
		if ($this->notification_id == 0 || $this->notification_id == null)
		{
			$this->notification_created_date = date('Y-m-d H:i:s');
			$this->notification_sender_account_id = Yii::app()->user->id;
			$this->notification_hash = md5($this->notification_parent_id 
					. $this->notification_created_date
					. uniqid());
		}
		return parent::save($runValidation = true, $attributes = NULL);
	}
	
	public function getEmailsToSend()
	{
		$emails = EmailNotification::model()->findAll('notification_sent = :notification_sent',
				array(':notification_sent' => NOTIFICATION_SENT_NO));
		
		return $emails;
	}
	
	public function updateNotificationSentStatus($sent_status)
	{
		$this->notification_sent = $sent_status;
		$this->save();
	}
	
	////////////////////////////// API /////////////////////////////
	
	/**
	 * Specify whether this model allows Service API for action List
	 * @return boolean
	 */
	public static function apiAllowsList() {
		return true;
	}
	
	public static function apiAllowsView() {
		return true;
	}
	
	public static function apiAllowsCreate() {
		return true;
	}
	
	/**
	 * the List API
	 */
	public static function apiList() {
		
	}
	
	//////////////////////// END OF API //////////////////////////////
}