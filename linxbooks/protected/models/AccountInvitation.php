<?php

/**
 * This is the model class for table "account_invitations".
 *
 * The followings are the available columns in table 'account_invitations':
 * @property integer $account_invitation_id
 * @property integer $account_invitation_master_id
 * @property string $account_invitation_to_email
 * @property string $account_invitation_date
 * @property integer $account_invitation_status
 * @property string $account_invitation_rand_key
 * @property integer $account_invitation_project
 * @property integer $account_invitation_type
 * @property integer $account_invitation_subscription_id
 */
class AccountInvitation extends CActiveRecord
{
	public $account_invitation_message;
	public $account_invitation_project;
	const ACCOUNT_INVITATION_TYPE_MEMBER = 0;
	const ACCOUNT_INVITATION_TYPE_CUSTOMER = 1;
	const ACCOUNT_INVITATION_STATUS_PENDING = 0;
	const ACCOUNT_INVITATION_STATUS_ACCEPTED = 1;
	const ACCOUNT_INVITATION_STATUS_NAME_PENDING = 'Pending';
	const ACCOUNT_INVITATION_STATUS_NAME_ACCEPTED = 'Accepted';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccountInvitation the static model class
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
		return 'lb_sys_account_invitations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_invitation_master_id, account_invitation_to_email, account_invitation_date, account_invitation_status, account_invitation_rand_key, account_invitation_subscription_id', 'required'),
			array('account_invitation_master_id, account_invitation_status, account_invitation_project, account_invitation_type', 'numerical', 'integerOnly'=>true),
			array('account_invitation_to_email', 'length', 'max'=>255),
			array('account_invitation_rand_key', 'length', 'max'=>100),
			array('account_invitation_project, account_invitation_message', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('account_invitation_id, account_invitation_master_id, account_invitation_to_email, account_invitation_date, account_invitation_status, account_invitation_rand_key, account_invitation_subscription_id', 'safe', 'on'=>'search'),
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
			'account_invitation_id' => 'Account Invitation',
			'account_invitation_master_id' => 'Account Invitation Master',
			'account_invitation_to_email' => 'Email(s)',
			'account_invitation_date' => 'Account Invitation Date',
			'account_invitation_status' => 'Account Invitation Status',
			'account_invitation_rand_key' => 'Account Invitation Rand Key',
			'account_invitation_message' => 'Message',
			'account_invitation_project' => 'Project to join',
			'account_invitation_type' => 'Customer Account',
                        'account_invitation_subscription_id'=>'Subscription',
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

		$criteria->condition = 'account_invitation_master_id = ' . Yii::app()->user->id;
		$criteria->compare('account_invitation_id',$this->account_invitation_id);
		$criteria->compare('account_invitation_master_id',$this->account_invitation_master_id);
		$criteria->compare('account_invitation_to_email',$this->account_invitation_to_email,true);
		$criteria->compare('account_invitation_date',$this->account_invitation_date,true);
		$criteria->compare('account_invitation_status',$this->account_invitation_status);
		$criteria->compare('account_invitation_rand_key',$this->account_invitation_rand_key,true);
                $criteria->compare('account_invitation_subscription_id',$this->account_invitation_subscription_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		// check permission
		// only subscriber can invite
		// but if we're updating status of an invitation, as long as key and invitation id are correct, let it pass
		if (!AccountSubscription::model()->isSubscriber(Yii::app()->user->id))
		{
			if ($this->account_invitation_id > 0)
			{
				//if (isset($_GET['key']) && $_GET['key'] == $this->account_invitation_rand_key)
					return parent::save($runValidation=true, $attributes=NULL);
			}
			
			throw new CHttpException(401,'You must be a subscriber to invite someone. Subscribe here.');
			return false;
		}
		
		if ($this->account_invitation_type == null)
		{
			$this->account_invitation_type = AccountInvitation::ACCOUNT_INVITATION_TYPE_MEMBER;
		}
		
		return parent::save($runValidation=true, $attributes=NULL);
	}
	
	public static function generateInvitationKey() {
		return md5(uniqid());
	}
	
	public static function generateInvitationURL($id, $key) {
		$url = Yii::app()->createAbsoluteUrl('accountInvitation/accept',
				array('id' => $id, 'key' => $key, ));
		return $url;
	}
	
	/**
	 * 
	 * @param unknown $account_id
	 * @param string $get_data
	 * @return <multitype: array,CActiveDataProvider>
	 */
	public function getInvitesToAccount($account_id, $get_data = false)
	{
		$account = Account::model()->findByPk($account_id);
		$dataProvider = new CActiveDataProvider('AccountInvitation', array(
				'criteria' => array(
					'condition' => "account_invitation_to_email = '{$account->account_email}'",
				),
		));
		
		if ($get_data === true)
		{
			$dataProvider->setPagination(false);
			return $dataProvider->getData();
		}
		return $dataProvider;
	}
	
	/**
	 * 
	 * @param unknown $status_id
	 */
	public function getInvitationStatusName($invitation_id = 0)
	{
		$invite = $this;
		if ($invitation_id > 0)
			$invite = $this->findByPk($invitation_id);
		
		if ($invite->account_invitation_status == self::ACCOUNT_INVITATION_STATUS_PENDING)
			return self::ACCOUNT_INVITATION_STATUS_NAME_PENDING;
		if ($invite->account_invitation_status == self::ACCOUNT_INVITATION_STATUS_ACCEPTED)
			return self::ACCOUNT_INVITATION_STATUS_NAME_ACCEPTED;
		
		return '';
	}
}