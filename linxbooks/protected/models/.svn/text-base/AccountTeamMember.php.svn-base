<?php

/**
 * This is the model class for table "account_team_members".
 *
 * The followings are the available columns in table 'account_team_members':
 * @property integer $account_team_member_id
 * @property integer $member_account_id
 * @property integer $master_account_id
 * @property integer $is_customer
 * @property integer $is_active
 * @property integer $account_subscription_id
 */

define('ACCOUNT_TEAM_MEMBER_IS_CUSTOMER', 1);

class AccountTeamMember extends CActiveRecord
{
	public $accepting_invitation = false;
	
	const ACCOUNT_TEAM_MEMBER_IS_ACTIVE = 1;
	const ACCOUNT_TEAM_MEMBER_IS_DEACTIVATED = -1;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccountTeamMember the static model class
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
		return 'lb_sys_account_team_members';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_account_id, master_account_id, account_subscription_id', 'required'),
			array('member_account_id, master_account_id, is_active', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('account_team_member_id, member_account_id, master_account_id, is_customer, is_active, account_subscription_id', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations()
	{
		return array(
			'member_account' => array(self::BELONGS_TO, 'Account', 'member_account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'account_team_member_id' => Yii::t('lang','Account Team Member'),
			'member_account_id' => Yii::t('lang','Member Account'),
			'master_account_id' => Yii::t('lang','Master Account'),
			'is_customer' => Yii::t('lang','Customer'),
			'is_active' => Yii::t('lang','Active')
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

		$criteria->compare('account_team_member_id',$this->account_team_member_id);
		$criteria->compare('member_account_id',$this->member_account_id);
		$criteria->compare('master_account_id',$this->master_account_id);
		$criteria->compare('is_customer',$this->is_customer);
		$criteria->compare('is_active', $this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function save($runValidation = TRUE, $attributes = NULL)
	{
		if ($this->is_active === NULL || $this->is_active == 0)
				$this->is_active = $this::ACCOUNT_TEAM_MEMBER_IS_DEACTIVATED;
		
		// check permission
//		if (!$this->accepting_invitation)
//		{
//			if ($this->isNewRecord && !Permission::checkPermission($this, PERMISSION_ACCOUNT_TEAM_MEMBER_CREATE))
//				return false;
//			if (!$this->isNewRecord && !Permission::checkPermission($this, PERMISSION_ACCOUNT_TEAM_MEMBER_UPDATE))
//				return false;
//		}
		return parent::save($runValidation, $attributes);
	}
	
	public function delete()
	{
//		// check permission
//		if (!Permission::checkPermission($this, PERMISSION_ACCOUNT_TEAM_MEMBER_DELETE))
//			return false;
		
		return parent::delete();
	}
	
	/**
	 * Return team members of team that this account is the master account of.
	 * 
	 * @param unknown $master_account_id
	 * @param string $get_all_records default = false
	 * @return CActiveDataProvider if get_all_records = false, otherwise array of models
	 */
	public function getTeamMembers($subscription_id, $get_all_records = FALSE)
	{
		$dataProvider = new CActiveDataProvider('AccountTeamMember', array(
				'criteria' => array(
					'condition' => "account_subscription_id = $subscription_id",
					//'order' => 'task_last_commented_date DESC',
					'with' => array(
                        'member_account'
                    ),
				),
				//'pagination'=>array(
				//		'pageSize' => 10,
				//),
		));
		
		if ($get_all_records === true)
		{
			$dataProvider->setPagination(false);
			return $dataProvider->getData();
		}
		return $dataProvider;
	}
	
	/**
	 * Return list of all the members of other teams that this account belongs to.
	 * This is used for team that this account is NOT the master account of that team.
	 * 
	 * @param unknown $account_id
	 */
	public function getMyOtherTeams($account_id, $subscription_id)
	{
		// get all master accounts that I'm member of
//		$members = AccountTeamMember::model()->findAll('member_account_id = :account_id', 
//				array(":account_id" => $account_id));
//		$master_accounts_ids = array(0);
//		foreach($members as $mem)
//		{
//			$master_accounts_ids[] = $mem->master_account_id;
//		}
//		$master_accounts_ids_str = implode(',', $master_accounts_ids);
			
		// get all members of these master accounts
		$dataProvider = new CActiveDataProvider('AccountTeamMember', array(
				'criteria' => array(
						'condition' => "account_subscription_id = $subscription_id AND member_account_id = $account_id",
						'order' => 'master_account_id DESC',
						'with' => array(
								'member_account'
						),
				),
				//'pagination'=>array(
				//		'pageSize' => 10,
				//),
		));
			
		$dataProvider->setPagination(false);
		return $dataProvider;

	}
	
	/**
	 * Check if a team member to a master account is only a customer
	 * @param integer $master_account_id
	 * @param integer $member_account_id
	 */
	public function isCustomer($master_account_id, $member_account_id)
	{
		$teamMember = AccountTeamMember::model()->find('master_account_id = :master_account_id AND member_account_id = :member_account_id',
				array(':master_account_id' => $master_account_id, ':member_account_id' => $member_account_id));
		
		if ($teamMember && $teamMember->is_customer == ACCOUNT_TEAM_MEMBER_IS_CUSTOMER)
			return true;
		return false;
	}
	
	/**
	 * Check if an account is member of this master account 
	 * 
	 * @param integer $master_account_id
	 * @param integer $member_account_id
	 */
	public function isValidMember($master_account_id, $member_account_id)
	{
		$teamMember = AccountTeamMember::model()->find('master_account_id = :master_account_id 
				AND member_account_id = :member_account_id',
				array(
						':master_account_id' => $master_account_id, 
						':member_account_id' => $member_account_id));
	
		if ($teamMember && $teamMember->account_team_member_id > 0)
			return true;
		return false;
	}
	
	/**
	 * 
	 * @param unknown $master_account_id
	 * @param unknown $member_account_id
	 * @return boolean
	 */
	public function isActive($master_account_id = 0, $member_account_id = 0)
	{
		if ($master_account_id == 0)
			$master_account_id = $this->master_account_id;
		if ($member_account_id == 0)
			$member_account_id = $this->member_account_id;
		
		// if master and member are same user
		// that means yes
		if ($master_account_id == $member_account_id)
			return true;
		
		$teamMember = AccountTeamMember::model()->find('master_account_id = :master_account_id
				AND member_account_id = :member_account_id 
				AND is_active = :is_active',
				array(
						':master_account_id' => $master_account_id,
						':member_account_id' => $member_account_id,
						':is_active' => self::ACCOUNT_TEAM_MEMBER_IS_ACTIVE));
		
		if ($teamMember && $teamMember->account_team_member_id > 0)
			return true;
		return false;
	}
	
	/**
	 * Check if these 2 users are team members of each other.
	 * This function can even ben used when NONE are master accounts
	 * 
	 * @param unknown $my_id
	 * @param unknown $team_member_account_id
	 * @return boolean
	 */
	public function isMyTeamMember($my_id, $team_member_account_id)
	{
		// if my_id is a master account, and the other one is his/her teammate
		if ($this->isValidMember($my_id, $team_member_account_id))
			return true;
		
		// get master account id of my_id
		// get master account id of team member account id
		// if of same master account, yes, we are team members
		$my_master_account_ids = $this->getMasterAccountIDs($my_id);
		$team_member_master_account_ids = $this->getMasterAccountIDs($team_member_account_id);
		foreach ($my_master_account_ids as $master_id)
		{
			if (in_array($master_id, $team_member_master_account_ids))
			{
				// if none of us is de-activated
				if (AccountTeamMember::model()->isActive($master_id, $my_id)
						&& AccountTeamMember::model()->isActive($master_id, $team_member_account_id))
					return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Get master account for a project that this user belongs to.
	 * This is use to find master account of a project that this user is involved with.
	 * This user is assumed to be NOT a master account user
	 * 
	 * @param integer $member_account_id
	 * @param number $project_id
	 * @return mix Array of master account ids, master account id if project id is passed in.
	 */
	public function getMasterAccountIDs($member_account_id, $project_id = 0)
	{
		// find all the records that reflect team membership of this account
		$teamMembers = AccountTeamMember::model()->findAll('member_account_id = :member_account_id',
				array(':member_account_id' => $member_account_id));
		
		// if we filter project
		if ($project_id > 0)
		{
			foreach ($teamMembers as $membership)
			{
				// get subscription id
				$sub = AccountSubscription::model()->find('account_id = :account_id AND account_subscription_status_id = 1',
					array(':account_id' => $membership->master_account_id));
				
				// get project
				if ($sub)
				{
					// if matched project, return master account id
					$project = Project::model()->find('project_id = :project_id AND account_subscription_id = :account_subscription_id',
							array(':project_id' => $project_id, ':account_subscription_id' => $sub->account_subscription_id));
					
					if ($project && $project->project_id > 0)
						return $sub->account_id;
				}
			}
			
			return 0;
		}
		
		// get ids of master account
		$master_acc_ids = array();
		foreach($teamMembers as $mem)
		{
			$master_acc_ids[] = $mem->master_account_id;
		}
		
		// return array of master account ids
		return $master_acc_ids;
	}
}
