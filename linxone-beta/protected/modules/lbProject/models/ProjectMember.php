<?php

/**
 * This is the model class for table "project_members".
 *
 * The followings are the available columns in table 'project_members':
 * @property integer $project_member_id
 * @property integer $project_id
 * @property integer $account_id
 * @property date	 $project_member_start_date
 * @property integer $project_member_is_manager
 */
define('PROJECT_MEMBER_IS_MANAGER', 1);
define('PROJECT_MEMBER_IS_NOT_MANAGER', 0);

class ProjectMember extends CActiveRecord
{
	public $members_array;
	public $manager;
	public $accepting_invitation = false;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProjectMember the static model class
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
		return 'lb_project_project_members';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, account_id', 'required'),
			array('project_id, account_id, project_member_is_manager', 'numerical', 'integerOnly'=>true),
			array('members_array, manager', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('project_member_id, project_id, account_id, project_member_start_date', 'safe', 'on'=>'search'),
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
			'member_account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			//'projects' => array(self::HAS_ONE, 'Project', 'project_id'),
                        'projects' => array(self::BELONGS_TO, 'Project', 'project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'project_member_id' => YII::t('core','Project Member'),
			'project_id' => YII::t('core','Project'),
			'account_id' => YII::t('core','Account'),
			'project_member_start_date' => YII::t('core','Since'),
			'project_member_is_manager' => YII::t('core','Manager'),
			'members_array' => YII::t('core','Members')
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

		$criteria->compare('project_member_id',$this->project_member_id);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('project_member_start_date',$this->project_member_start_date);
		$criteria->compare('project_member_is_manager', $this->project_member_is_manager);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
  //           // only account that can update project manager is allowed to update project member
  //           // unless this is an invitation
  //           if ($this->accepting_invitation == false && AccountTeamMember::model()->isAcountAdmin()==false) {
  //               // if user is trying to update the PM of this project
  //               // but she is not given permission to update PM of the project
  //               // reject
		// if ($this->project_member_is_manager == PROJECT_MEMBER_IS_MANAGER 
  //                       && !Permission::checkPermission($this, PERMISSION_PROJECT_UPDATE_MANAGER))
		// {
		// 	return false;
		// }
                
  //               // if user is trying to update a normal member
  //               // but she's not the PM of the project
  //               // reject
  //               if ($this->project_member_is_manager != PROJECT_MEMBER_IS_MANAGER // updating normal member
  //                       && !ProjectMember::model()->isProjectManager($this->project_id, Yii::app()->user->id) // not manager
  //                       && !Permission::checkPermission($this, PERMISSION_PROJECT_UPDATE_MANAGER)) // includes not master acc
  //               {
  //                   return false;
  //               }
  //           }
                    
                
  //               // NOTE: if this is in invitation
  //               // this project, and the invitation are already the same.
  //               // because project id was taken from invitation record in the database
  //               // not by form submission
                
  //               // If not by invitation
  //               // check if this user is part of the team of the master account of this project
  //               if ($this->accepting_invitation == false && AccountTeamMember::model()->isAcountAdmin()==false)
  //               {
  //                   // get master account
  //                   $project = Project::model()->findByPk($this->project_id);
  //                   $account_subscription_id = $project->account_subscription_id;
  //                   $master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($account_subscription_id);
  //                   if (!AccountTeamMember::model()->isValidMember($master_account_id, $this->account_id))
  //                   {
  //                       return false;
  //                   }
  //               }
		
		return parent::save($runValidation=true, $attributes=NULL);
	}
        
        public function delete() {
            if ($this->canDelete()) {
                return parent::delete();
            }
            
            return false;
        }


        /**
	 * Get project members, this will include their account and profile
	 * 
	 * @param unknown $project_id Project ID
	 * @param boolean	$get_data whether to return array of models or CActiveDataProvider. 
	 * 								Default is false, which means return CActiveDataProvider
	 * @return unknown $data if $get_data is true, return array of models, else return CACtiveDataProvider
	 */
	public function getProjectMembers($project_id, $get_data = false)
	{
		$dataProvider = new CActiveDataProvider('ProjectMember', array(
				'criteria' => array(
						'condition' => "project_id = " . $project_id,
						//'order' => 'task_last_commented_date DESC',
                                                'group'=>'member_account.account_id',
						'with' => array(
							'member_account'
						),
				),
				//'pagination'=>array(
				//		'pageSize' => 10,
				//),
		));
		
		if ($get_data === true){
			$dataProvider->setPagination(false);
			return $dataProvider->getData();
		}
		
		else return $dataProvider;
	}
	
        /**
         * Get project manager
         * @param type $project_id
         * @return ProjectManager ProjectManager model
         */
	public function findProjectManager($project_id)
	{
		$member = $this->find('project_id = :project_id AND project_member_is_manager = ' . PROJECT_MEMBER_IS_MANAGER,
				array(':project_id' => $project_id));
		
		return $member;
	}
        
        /**
         * Get project manager
         * @param type $project_id
         * @return ProjectMember project member model
         */
        public function getProjectManager($project_id)
        {
            return $this->findProjectManager($project_id);
        }
	
	/**
	 * Check if an account is a Project Manager of a project
	 * 
	 * @param integer $project_id
	 * @param integer $account_id
	 * @return boolean	TRUE or FALSE
	 */
	public function isProjectManager($project_id, $account_id)
	{
		$member = $this->find('project_id = :project_id AND account_id = :account_id', 
				array(':project_id' => $project_id, ':account_id' => $account_id));
		
		if ($member && $member->project_member_is_manager == PROJECT_MEMBER_IS_MANAGER)
		{
			// assignment exists
			// but if account is deactivated
			// then don't consider this is a valid project manager
			// AND
			// this account is NOT the master account of this project
			$master_account_id = AccountTeamMember::model()->getMasterAccountIDs($account_id, $project_id);
			if (!AccountTeamMember::model()->isActive($master_account_id, $account_id)
					&& Project::model()->findProjectMasterAccount($project_id) != $account_id)
				return false;
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * Check if this account is a valid member of this project
	 * 
	 * @param unknown $project_id
	 * @param unknown $account_id
	 * @return boolean
	 */
	public function isValidMember($project_id, $account_id)
	{
                // if master account of project, yes
                if (Project::model()->findProjectMasterAccount($project_id) == $account_id && $account_id > 0)
                {
                    return true;
                }
                
                // normal member:
		$member = ProjectMember::model()->find('project_id = :project_id AND account_id = :account_id',
			array(':project_id' => $project_id, ':account_id' => $account_id));
		
		if ($member && $member->account_id > 0) 
		{
			// if this member is deactivated
			// consinder not a valid member
			$master_account_id = AccountTeamMember::model()->getMasterAccountIDs($account_id, $project_id);
			if (!AccountTeamMember::model()->isActive($master_account_id, $account_id))
				return false;
			
			return true;
		}
		
		return false;
	}
        
        public function canUpdate()
        {
            // only account that can update project manager is allowed to update project member
            // unless this is an invitation
		if (!Permission::checkPermission($this, PERMISSION_PROJECT_UPDATE_MANAGER)
				&& $this->accepting_invitation == false)
		{
			return false;
		}
                
                // NOTE: if this is in invitation
                // this project, and the invitation are already the same.
                // because project id was taken from invitation record in the database
                // not by form submission
                
                // If not by invitation
                // check if this user is part of the team of the master account of this project
                if ($this->accepting_invitation == false)
                {
                    // get master account
                    $project = Project::model()->findByPk($this->project_id);
                    $account_subscription_id = $project->account_subscription_id;
                    $master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($account_subscription_id);
                    if (!AccountTeamMember::model()->isValidMember($master_account_id, $this->account_id))
                    {
                        return false;
                    }
                }
                
                return true;
        }
        
        public function canDelete()
        {
                // only account that can delete project manager is allowed to delete project member
		if (!Permission::checkPermission($this, PERMISSION_PROJECT_UPDATE_MEMBER))
		{
			return false;
		}
                
                return true;
        }
        
        /**
         * Lấy danh sách các dự án có account này là trưởng nhóm
         * @param type $account_id
         */
        public function getProjectByMemberManage($account_id,$get_data=false){
		$dataProvider = new CActiveDataProvider('ProjectMember', array(
				'criteria' => array(
						'condition' => "project_member_is_manager = 1 AND "
                                                . " t.account_id = " . $account_id,
						//'order' => 'task_last_commented_date DESC',
						'with' => array(
							'member_account'
						),
				),
				//'pagination'=>array(
				//		'pageSize' => 10,
				//),
		));
		
		if ($get_data === true){
			$dataProvider->setPagination(false);
			return $dataProvider->getData();
		}
		
		else return $dataProvider; 
        }
        
        /**
         * Lấy danh sách các
         * @param type $account_id
         * @return \CActiveDataProvider
         */
        public function getProjectByMember($account_id)
        {
            $selected_subscription_id = Yii::app()->user->linx_app_selected_subscription;
            $criteria = new CDbCriteria();
            $criteria->with = array('projects');
            $criteria->compare('account_id', intval($account_id));
            $criteria->compare('projects.project_status', 1);
            $criteria->compare('projects.account_subscription_id', $selected_subscription_id);
            
            $dataProvider=new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
            ));
            
            return $dataProvider;
        }
        
        /**
         * Lấy thời gian bé nhất trong các open task của 1 project
         * @param type $project_id
         * @param type $account_id
         * @param type $status
         * @return string
         */
        public function getStartTaskProject($project_id,$account_id)
        {
            $task = $this->taskProject($project_id, $account_id,0, 'task_start_date', 'ASC');
            
            if(count($task->data)>0)
            {
                if($task->data[0]->task_start_date=='0000-00-00')
                    return 'Null';
                return date('d-M-Y',  strtotime($task->data[0]->task_start_date));
            }
            else
                return 'Null';
        }
        
        /**
         * Lấy thời gian lơn nhất trong các open task của 1 project
         * @param type $project_id
         * @param type $account_id
         * @param type $status
         * @return string
         */
        public function getEndTaskProject($project_id,$account_id)
        {
            $task = $this->taskProject($project_id, $account_id,0, 'task_start_date', 'DESC');
            
            if(count($task->data)>0)
            {
                if($task->data[0]->task_end_date=='0000-00-00')
                    return 'Null';
                return date('d-M-Y',strtotime($task->data[0]->task_end_date)) ;
            }
            else
                return 'Null';
        }
}