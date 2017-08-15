<?php

/**
 * This is the model class for table "projects".
 *
 * The followings are the available columns in table 'projects':
 * @property integer $project_id
 * @property string $project_name
 * @property integer $project_owner_id
 * @property string $project_start_date
 * @property string $project_description
 * @property integer $account_subscription_id
 * @property string	$project_latest_activity_date
 * @property integer $project_simple_view
 * @property integer $project_priority
 * @property integer $project_status
 * @property integer $project_ms_method
 */

define('PROJECT_STATUS_ACTIVE', 1);
define('PROJECT_STATUS_ARCHIVED', -1);

class Project extends CActiveRecord
{
        const PROJECT_PRIORITY_LOW = 3;
        const PROJECT_PRIORITY_NORMAL = 2;
        const PROJECT_PRORITY_HIGH = 1;
        
        const PROJECT_HEALTH_ZONE_RED = '1';
        const PROJECT_HEALTH_ZONE_YELLOW = '2';
        const PROJECT_HEALTH_ZONE_GREEN = '3';
        
        const PROJECT_HEALTH_ZONE_RED_LABEL = 'Your action needed.';
        const PROJECT_HEALTH_ZONE_YELLOW_LABEL = 'Better watch out.';
        const PROJECT_HEALTH_ZONE_GREEN_LABEL = 'You\'re fine.';
        
	public $project_member;
	public $project_manager;
        public $latest_task_comments; // more for API use
        
        /** params needed for health report **/
        public $project_health_zone = '';
        public $project_completed = -1;
        public $project_planned = -1;
        public $project_lapsed = -1;
        public $project_lapsed_from = -1;
        public $project_lapsed_to = -1;
        public $hasOverdueMS = -1;
        public $hasTask = -1;
        public $hasOverdueTask = -1;
        // end health report param
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Project the static model class
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
		return 'lb_project_projects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_name, project_owner_id, project_start_date, project_status, account_subscription_id', 'required'),
			array('project_owner_id, project_simple_view, project_ms_method', 'numerical', 'integerOnly'=>true),
			array('project_name', 'length', 'max'=>255),
			array('project_description', 'length', 'max'=>1000),
			array('project_member, project_manager, project_priority, project_ms_method', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('project_id, account_subscription_id, project_name, project_owner_id, project_start_date, project_description, project_latest_activity_date', 'safe', 'on'=>'search'),
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
			'project_members' => array(self::HAS_MANY, 'ProjectMember', 'project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'project_id' => Yii::t('core','Project'),
			'project_name' => Yii::t('core','Project Name'),
			'project_owner_id' => 'Project Owner',
			'project_start_date' => Yii::t('core','Project Start Date'),
			'project_description' => Yii::t('core','Project Description'),
			'account_subscription_id' => 'Subscription',
			'project_simple_view' => 'Use Simple View',
                        'project_priority' => Yii::t('core','Priority'),
                        'project_ms_method' => Yii::t('core','Milestone View'),
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

		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('project_name',$this->project_name,true);
		$criteria->compare('project_owner_id',$this->project_owner_id);
		$criteria->compare('project_start_date',$this->project_start_date,true);
		$criteria->compare('project_description',$this->project_description,true);
		$criteria->compare('account_subscription_id',$this->account_subscription_id,true);
                $criteria->compare('project_priority', $this->project_priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		// check permission
		// if adding, check create permission
		if (($this->isNewRecord)
				&& !Permission::checkPermission($this, PERMISSION_PROJECT_CREATE))
		{
			return false;
                }
//		} else {
//			// if updating, check update permission
//			if (!Permission::checkPermission($this, PERMISSION_PROJECT_UPDATE_GENERAL_INFO))
//				return false;
//		}
		// end checking permission		
		
		// if adding, must have these fields
		if ($this->isNewRecord)
		{
			$this->project_owner_id = Yii::app()->user->id;
			$this->project_status = PROJECT_STATUS_ACTIVE;
		}
                
                // if (Project::canCreateMoreProject() == false)
                // {
                //     $this->addError('project_name',
                //             Yii::t('core','Your subscription has exceeded its max number of projects allowed') . '. ' .
                //             Yii::t('core','Please contact admin to upgrade') . ': ' . CHtml::link(Yii::app()->params['contactEmail']),'mailto:'.Yii::app()->params['contactEmail']);
                //     return false;
                // }
                
		// validate if this user has the right to assign this project to the selected subscription
		// TODO
		
		return parent::save($runValidation, $attributes);
	}
        
        // check if current user and his current subscription is qualified to create more
        // if it's free package, the current limit is met, inform user to email admin instead
        public static function canCreateMoreProject() {            
            if (AccountSubscription::model()->isAlreadySubscribedToPackage(SubscriptionPackage::SUBSCRIPTION_PACKAGE_FREE)) {
                return false;
            }

            if (AccountSubscription::model()->isAlreadySubscribedToPackage(SubscriptionPackage::SUBSCRIPTION_PACKAGE_FREE)) {
                return false;
            }
            
            return true;
        }
	
	/**
	 * update just the last activity date
	 * @param unknown $date
	 */
	public function updateLatestActivityDate($date)
	{
		if (!Permission::checkPermission($this, PERMISSION_PROJECT_UPDATE_OTHERS))
			return false;
	
		$this->project_latest_activity_date = $date;
	
		return parent::save();
	}
	
	public function delete()
	{
		if (!Permission::checkPermission($this, PERMISSION_PROJECT_DELETE))
			return false;
		
		// delete all tasks
		$all_tasks = Task::model()->getProjectTasks($this->project_id);
		foreach ($all_tasks as $task)
		{
			$task->delete();
		}
		
		return parent::delete();
	}
	
	/**
	 * Check if an account is the master account of this project
	 * 
	 * @param unknown $account_id
	 * @param number $project_id
	 * @return boolean
	 */
	public function isOfMasterAccount($account_id, $project_id = 0)
	{
		$project = $this;
		if ($project_id > 0)
			$project = Project::model()->findByPk($project_id);
		
		// get subscription id of account
		$subscriptions = AccountSubscription::model()->findSubscriptions($account_id, true);
		if (count($subscriptions))
		{
			reset($subscriptions);
			$account_subscription_id = key($subscriptions);
			if ($account_subscription_id == $project->account_subscription_id)
				return true;
		}
		
		return false;
	}
	
	/**
	 * 
	 * @param unknown $account_id
	 * @param string $type modelArray (default), datasourceArray (id => name, ...), dataProvider
	 * @param boolean $filter_selected_subscription see if we should only return projects that belong to the currently 
	 * 					selected subscription
         * @param boolean $sort_by_priority default is false
	 */
	public static function getActiveProjects($account_id, $type = 'modelArray', 
                $filter_selected_subscription = false,
                $sort_by_priority = false) {	
            
		$results = array();
		
		// CASE 1:
		// project that this account is assigned to
		$dataProvider = new CActiveDataProvider('ProjectMember', array(
				'criteria' => array(
						'condition' => "account_id = " . $account_id,
				),
		));
		
		$added_project_keys = array();
		$dataProvider->setPagination(false);
		$memberRecords = $dataProvider->getData();
		foreach ($memberRecords as $member)
		{
			// get project model for this membership
			$proj = Project::model()->find('project_id = :project_id AND project_status = :status_id',
					array(':project_id' => $member->project_id, ':status_id' => PROJECT_STATUS_ACTIVE));
			if ($proj)
			{
				// not so neccessary, but just in case same user is added as both member and proj manager
				if (!in_array($proj->project_id, $added_project_keys))
				{
					// check if this account is a de-activated team member of this project's master member
					$master_account_id = AccountTeamMember::model()->getMasterAccountIDs($account_id, $proj->project_id);
					if (AccountTeamMember::model()->isActive($master_account_id, $account_id))
					{
						$results[] = $proj;
						$added_project_keys[] = $proj->project_id;
					}
				}
			}
		}
		
		// END CASE 1
		
		// CASE 2.
		// get subscription that this account is in
		//  retrieve projects that are under his/her own subscription (s/he is master account),
		$subscriptions = AccountSubscription::model()->findSubscriptions($account_id, true);
		$conditions = array();
		
		if (count($subscriptions) > 0)
		{
			// this case, account is master account
			// get first subscript in result. There should be only 1 anyway.
			reset($subscriptions);
			$conditions[] = ' account_subscription_id = ' . key($subscriptions) . ' ';
			
			// project status
			$conditions[] = ' project_status = :status_id ';
			
			// exclude projects that are already in results;
			if (sizeof($added_project_keys) > 0)
			{
				$conditions[] = ' project_id NOT IN (' . implode(',', $added_project_keys) .')';
			}
			
			// find project under subscription of which this account is master acc.
			$results_sub= Project::model()->findAll(implode(' AND ', $conditions), array(':status_id' => PROJECT_STATUS_ACTIVE));
			foreach ($results_sub as $proj_2)
			{
				$results[] = $proj_2;
			}
		}
		// END CASE 2
		
		// Filter by selected subscription if any
		if ($filter_selected_subscription
				&& isset(Yii::app()->user->linx_app_selected_subscription))
		{
			$selected_subscription_id = Yii::app()->user->linx_app_selected_subscription;
			$temp_results = array();
			foreach ($results as $project)
			{
				if ($project->account_subscription_id != $selected_subscription_id)
					continue; // skip
				
				$temp_results[] = $project;
			}
			
			$results = $temp_results;
		}
                
                // sort by priority or not?
                if ($sort_by_priority)
                {
                    $arr_low = array();
                    $arr_normal = array();
                    $arr_high = array();
                    
                    foreach ($results as $tmp_project)
                    {
                        $project_priority = $tmp_project->project_priority;
                        if ($project_priority == Project::PROJECT_PRORITY_HIGH)
                        {
                            $arr_high[] = $tmp_project;
                        } elseif ($project_priority == Project::PROJECT_PRIORITY_NORMAL) {
                            $arr_normal[] = $tmp_project;
                        } else {
                            $arr_low[] = $tmp_project;
                        }
                    }
                    
                    //$results = $arr_high + $arr_normal + $arr_low;
                    $results = array_merge($arr_high, $arr_normal,$arr_low);
                }
		
		if ($type == 'datasourceArray')
		{
			$result_array = array();
			foreach ($results as $proj)
			{
				$result_array[$proj->project_id] = $proj->project_name;
			}
			
			return $result_array;
		} else if ($type == 'dataProvider')
		{
			$results_array = array();
			
			foreach ($results as $r_project)
			{
				$temp_array = $r_project->getAttributes();
				$temp_array['id'] = $r_project->project_id;
				$results_array[] = $temp_array;
			}
			$arrayDataProvider=new CArrayDataProvider($results_array, array(
				'id'=>'project_list',
				'pagination'=>array(
					'pageSize'=>10,
				),
			));
			
			return $arrayDataProvider;
				
		}
		return $results;
	}
        
        
        
        /**
         * 
         * @param type $account_id project of this account id
         * @param type $filter_selected_subscription filter the count to restrict to the currently selected subscription only
         * @return int number of active projects
         */
        public static function countActiveProjects($account_id, $filter_selected_subscription = true)
        {
            $active_projects = Project::getActiveProjects($account_id, 'modelArray', $filter_selected_subscription);
            if ($active_projects)
                return count($active_projects);
            
            return 0;
        } // end countActiveProjects
	
	/**
	 * 
	 * @param number $account_id
	 * @param string $type modelArray (default), datasourceArray (id => name, ...), dataProvider
	 * @param boolean $filter_selected_subscription
	 * @return multitype depending on $type passed in
	 */
	public static function getArchivedProjects($account_id, $type = 'modelArray', $filter_selected_subscription = false) {
		$results = array();
	
		// CASE 1:
		// project that this account is assigned to
		$dataProvider = new CActiveDataProvider('ProjectMember', array(
				'criteria' => array(
						'condition' => "account_id = " . $account_id,
				),
		));
	
		$added_project_keys = array();
		$dataProvider->setPagination(false);
		$memberRecords = $dataProvider->getData();
		foreach ($memberRecords as $member)
		{
			// get project model for this membership
			$proj = Project::model()->find('project_id = :project_id AND project_status = :status_id',
					array(':project_id' => $member->project_id, ':status_id' => PROJECT_STATUS_ARCHIVED));
			if ($proj)
			{
				// not so neccessary, but just in case same user is added as both member and proj manager
				if (!in_array($proj->project_id, $added_project_keys))
				{
					// check if this account is a de-activated team member of this project's master member
					$master_account_id = AccountTeamMember::model()->getMasterAccountIDs($account_id, $proj->project_id);
					if (AccountTeamMember::model()->isActive($master_account_id, $account_id))
					{
						$results[] = $proj;
						$added_project_keys[] = $proj->project_id;
					}
				}
			}
		}
	
		// END CASE 1
	
		// CASE 2.
		// get subscription that this account is in
		//  retrieve projects that are under his/her own subscription (s/he is master account),
		$subscriptions = AccountSubscription::model()->findSubscriptions($account_id, true);
		$conditions = array();
	
		if (count($subscriptions) > 0)
		{
			// this case, account is master account
			// get first subscript in result. There should be only 1 anyway.
			reset($subscriptions);
			$conditions[] = ' account_subscription_id = ' . key($subscriptions) . ' ';
				
			// project status
			$conditions[] = ' project_status = :status_id ';
				
			// exclude projects that are already in results;
			if (sizeof($added_project_keys) > 0)
			{
				$conditions[] = ' project_id NOT IN (' . implode(',', $added_project_keys) .')';
			}
				
			// find project under subscription of which this account is master acc.
			$results_sub= Project::model()->findAll(implode(' AND ', $conditions), 
					array(':status_id' => PROJECT_STATUS_ARCHIVED));
			foreach ($results_sub as $proj_2)
			{
				$results[] = $proj_2;
			}
		}
		// END CASE 2
	
		// Filter by selected subscription if any
		if ($filter_selected_subscription
				&& isset(Yii::app()->user->linx_app_selected_subscription))
		{
			$selected_subscription_id = Yii::app()->user->linx_app_selected_subscription;
			$temp_results = array();
			foreach ($results as $project)
			{
				if ($project->account_subscription_id != $selected_subscription_id)
					continue; // skip
	
				$temp_results[] = $project;
			}
				
			$results = $temp_results;
		}
	
		if ($type == 'datasourceArray')
		{
			$result_array = array();
			foreach ($results as $proj)
			{
				$result_array[$proj->project_id] = $proj->project_name;
			}
				
			return $result_array;
		} else if ($type == 'dataProvider')
		{
			$results_array = array();
				
			foreach ($results as $r_project)
			{
				$temp_array = $r_project->getAttributes();
				$temp_array['id'] = $r_project->project_id;
				$results_array[] = $temp_array;
			}
			$arrayDataProvider=new CArrayDataProvider($results_array, array(
					'id'=>'project_list',
					'pagination'=>array(
							'pageSize'=>10,
					),
			));
				
			return $arrayDataProvider;
	
		}
		return $results;
	}
	
	/**
	 * 
	 * @param number $account_id
	 * @param string $type default 'modelArray', 'datasourceArray', 'dataProvider'
	 */
	public function getProjectsCreatedBy($account_id, $type = 'modelArray')
	{
		$dataProvider = new CActiveDataProvider('Project', array(
				'criteria' => array(
						'condition' => "project_owner_id = " . $account_id,
						'order' => 'project_name ASC',
				),
		));
		
		switch ($type)
		{
			case 'dataProvider':
				return $dataProvider;
			case 'modelArray':
				$dataProvider->setPagination(false);
				return $dataProvider->getData();
			case 'datasourceArray':
				$dataProvider->setPagination(false);
				$projects = $dataProvider->getData();
				$results = array();
				foreach ($projects as $proj)
				{
					$results[$proj->project_id] = $proj->project_name;
				}
				return $results;
		}
		
		return $dataProvider;
	}
	
	/**
	 * Get the master account of this project
	 * 
	 * @param number $project_id
	 * @param boolean $get_model if true, return AccountSubscription model. Otherwise, return account id.
	 * 							DEFAULT is false.
	 * @return mixed
	 */
	public function findProjectMasterAccount($project_id = 0, $get_model = false)
	{
		$project = $this;
		
		if ($project_id > 0)
		{
			$project = $this->findByPk($project_id);
                        if ($project === null) return 0;
		}
		
		$project_subscription_id = $project->account_subscription_id;
		
		// find subscription record
		$account_subscription = AccountSubscription::model()->findByPk($project_subscription_id);
		if ($get_model) {
			return $account_subscription;
		}
		
		return $account_subscription->account_id;
	}
	
	/**
	 * Check if project is archived or not.
	 * 
	 * @param number $project_id
	 * @return boolean $archived
	 */
	public function isArchived($project_id = 0)
	{
		$project = $this;
		if ($project_id > 0)
		{
			$project = $this->findByPk($project_id);
		}
		
		if ($project && $project->project_status == PROJECT_STATUS_ARCHIVED)
			return true;
		
		return false;
	}
	
	/**
	 * Compare two projects based on activity date
	 * this function is usually used by usort
	 * 
	 * @param unknown $project_a
	 * @param unknown $project_b
	 */
	public static function compareByLatestActivity($project_a, $project_b)
	{
		if (!isset($project_a->project_latest_activity_date)
				|| !isset($project_b->project_latest_activity_date))
			return 1;
		
		$date_a = $project_a->project_latest_activity_date;
		$date_b = $project_b->project_latest_activity_date;
		
		if ($date_a == $date_b) {
			return 0;
		}
		return ($date_a > $date_b) ? +1 : -1;
	}
	
	/**
	 * 
	 * @param number $project_id
	 * @return array $url of 1 element string
	 */
	public function getProjectURL($project_id = 0, $params = array())
	{
		$project = $this;
		
		if ($project_id > 0)
		{
			$project = Project::model()->findByPk($project_id);
		}
		
		$current_subscription = Utilities::getCurrentlySelectedSubscription();
		$url = "/$current_subscription/lbProject/{$project->project_id}-" 
				. $this->getURLEncodedProjectName($project_id);
		
		// add params if available
		if (is_array($params) && count($params))
		{
			$url .= '?';
			foreach ($params as $param_=>$val)
			{
				$url .= "$param_=$val&"; 
			}
		}
		
		return array($url);
		//return array('project/view', 'id' => $project_id);
	}
        
	public function getCreateURL()
	{
		return array('project/create');
	}
	
	public function getURLEncodedProjectName($project_id = 0)
	{
		$project = $this;
		if ($project_id > 0)
		{
			$project = Project::model()->findByPk($project_id);
		}
		
		$project_name = str_replace(' ','-', $project->project_name);
		$project_name = preg_replace('/[^A-Za-z0-9\-]/', '', $project_name);
		return urlencode($project_name);
	}
        
        /**
         * Check if a project has overdue task or not
         * 
         * @param type $project_id
         * @return mixed false if none, positive number (count) if true
         */
        public function hasOverdueTask($project_id = 0)
        {
            $project = $this;
            if ($project_id > 0)
            {
                $project = Project::model()->findByPk($project_id);
            }
            
            $count = 0;
            // get all active tasks of this project
            $tasks = Task::model()->getTasksByProject($project->project_id, TASK_STATUS_ACTIVE, true);
            // if any of them is overdue, return status as true
            foreach ($tasks as $t_)
            {
                if ($t_->isOverdue() && $t_->task_type != Task::TASK_TYPE_FORUM)
                {
                    $count++;
                }
            }
            
            if ($count > 0) {
                return $count;
            }
            
            return false;
        }
        
        /**
         * Just a wrapper for an existing milestone function.
         * check if a project has any overdue ms or not
         * 
         * @param int project_id
         * @return boolean
         */
        public function hasOverdueMilestone($project_id = 0)
        {
            $project = $this;
            if ($project_id > 0)
            {
                $project = Project::model()->findByPk($project_id);
            }
            $project_id = $project->project_id;
            
            return Milestones::model()->projectHasOverdueMilestones($project_id);
        }


        /**
         * Check if project has any in progress job
         * @param type $project_id
         * @return boolean
         */
        public function hasInprogressTask($project_id = 0)
        {
            $project = $this;
            if ($project_id > 0)
            {
                $project = Project::model()->findByPk($project_id);
            }
            
            // get all active tasks of this project
            $tasks = Task::model()->getTasksByProject($project->project_id, TASK_STATUS_ACTIVE, true);
            // if any of them is overdue, return status as true
            foreach ($tasks as $t_)
            {
                if ($t_->isInProgress() && $t_->task_type != Task::TASK_TYPE_FORUM)
                {
                    return true;
                }
            }
            
            return false;
        }
	
	/**
	 * As a security measure
	 * This helps check if this project is matched with currently viewed subscription.
	 * 
	 * @return boolean
	 */
	public function matchedCurrentSubscription()
	{
		$current_subscription = Utilities::getCurrentlySelectedSubscription();
		
		if ($current_subscription == $this->account_subscription_id)
			return true;
		
		return false;
	}
        
        /**
         * Get project priority array, used as datasource
         * 
         * @return array    Array in this format (int => priority name, int => priority name,...)
         */
        public static function getPriorityArray()
        {
            return array(
                Project::PROJECT_PRIORITY_LOW => 'Low',
                Project::PROJECT_PRIORITY_NORMAL => 'Normal',
                Project::PROJECT_PRORITY_HIGH => 'High');
        }
        
        /**
         * Get the label for a priority, e.g. 'high', 'low',...
         * @param int $priority
         * @return string the label for the corresponding name
         */
        public function getPriorityName($priority = 0)
        {
            $arr = Project::getPriorityArray();
            
            if ($priority > 0)
            {                
                return $arr[$priority];
            }
            
            return $arr[$this->project_priority];
        }
        
        public function getPriorityLabel($priority = 0)
        {
            if ($priority == 0) $priority = $this->project_priority;
            
            $label = $this->getPriorityName($priority);
            
            if ($priority == Project::PROJECT_PRORITY_HIGH) {
                $label = LinxUI::getPriorityLabelHigh($label);
            } else if ($priority == Project::PROJECT_PRIORITY_NORMAL) {
                $label = LinxUI::getPriorityLabelNormal($label);
            } else {
                $label = LinxUI::getPriorityLabelLow($label);
            }
            
            return $label;
        }
        
        /**
         * Get the zone that this project belongs to
         * 
         * @param int project_id
         * @return const Project::PROJECT_HEALTH_ZONE_RED, ..._YELLOW, ..._GREEN
         */
        public function getProjectHealthZone($project_id = 0)
        {
            $project = $this;
            if ($project_id > 0)
            {
                $project = Project::model()->findByPk($project_id);
            }
            $project_id = $project->project_id; // for ease of ref
            
            // if already set, return now
            if ($project->project_health_zone)
            {
                return $project->project_health_zone;
            }
            
            /**
             * 3 main factors determining a project's zone, ranking by priority
             * of importance in our consideration:
             * 1. Completed work vs. planned work.
             * 2. Milestones
             * 3. Overdue task
             * 
             * This is actually a guess approach for now.
             * Perhaps only (1) matters eventually.
             */
            if ($project->project_completed == -1) $project->project_completed = TaskProgress::model()->getProjectActualProgress($project_id);
            $completed = $project->project_completed;
            
            if ($project->project_planned == -1) $project->project_planned = TaskProgress::model()->getProjectPlannedProgress($project_id);
            $planned = $project->project_planned;
            
            if ($project->hasOverdueMS == -1) $project->hasOverdueMS = $project->hasOverdueMilestone();
            $hasOverdueMS = $project->hasOverdueMS;
            
            if ($project->hasOverdueTask == -1) $project->hasOverdueTask = $project->hasOverdueTask();
            $hasOverdueTask = $project->hasOverdueTask;
            
            if ($project->hasTask == -1) $project->hasTask = Task::model()->countTasks($project_id, TASK_STATUS_ACTIVE, array(Task::TASK_TYPE_ISSUE, Task::TASK_TYPE_FEATURE));
            $hasTask = $project->hasTask;
            
            if ($project->project_lapsed == -1) {
                $project_lapsed_arr = TaskProgress::model()->getProjectLapsed($project_id);
                $project->project_lapsed = $project_lapsed_arr['lapsed'];
                $project->project_lapsed_from = $project_lapsed_arr['from'];
                $project->project_lapsed_to = $project_lapsed_arr['to'];
            }
            
            $project_priority = $project->project_priority;
            
            // RED ZONE:
            // overdue milestone
            // and has overdue task
            if ($hasOverdueMS && $hasOverdueTask && $project_priority != Project::PROJECT_PRIORITY_LOW)
            {
                $project->project_health_zone = Project::PROJECT_HEALTH_ZONE_RED;
                //return Project::PROJECT_HEALTH_ZONE_RED;
            } else {
                // YELLOW ZONE:
                // completed == planned or (completed - planned)/planned <= 5%
                // and has overdue task
                if ($project_priority != Project::PROJECT_PRIORITY_LOW
                        && ($completed <= $planned // behind schedule
                        || ($completed > $planned && $planned > 0 && ($completed-$planned)/$planned <= 0.05) // only 5% early
                        || ($planned == 0 && $hasTask))) // no plans while there're tasks to be done.
                {
                    $project->project_health_zone = Project::PROJECT_HEALTH_ZONE_YELLOW;
                    //return Project::PROJECT_HEALTH_ZONE_YELLOW;
                } else {
                    // GREEN:
                    // everything else, of course
                    $project->project_health_zone = Project::PROJECT_HEALTH_ZONE_GREEN;
                    //return Project::PROJECT_HEALTH_ZONE_GREEN;
                }
            }   
            
            return $project->project_health_zone;
        }
                
        /**
         * Get hex code of the color of a zone
         * @param string $zone
         * @return string hex code
         */
        public function getProjectHealthZoneColor($zone)
        {
            $color = 'green';
            if ($zone == Project::PROJECT_HEALTH_ZONE_RED)
            {
                $color = 'red';
            } else if ($zone == Project::PROJECT_HEALTH_ZONE_YELLOW) {
                $color = 'yellow';
            }
            
            return TaskProgress::model()->getHealthColorHex($color);
        }
        
        public function getProjectHealthZoneLabel($zone)
        {
            $label = Project::PROJECT_HEALTH_ZONE_GREEN_LABEL;
            if ($zone == Project::PROJECT_HEALTH_ZONE_RED)
            {
                $label = Project::PROJECT_HEALTH_ZONE_RED_LABEL;
            } else if ($zone == Project::PROJECT_HEALTH_ZONE_YELLOW) {
                $label = Project::PROJECT_HEALTH_ZONE_YELLOW_LABEL;
            } else {
                
            }
            
            return $label;
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
                if (isset($_GET['list_type']))
                {
                        $list_type = $_GET['list_type'];
                        switch($list_type)
                        {
                                case 'get_latest_activities':
                                        $results = array();
                                
                                        // load for a specific project or load for all active projects?
                                        $active_projects = array();
                                        if (isset($_GET['project_id']))
                                            $active_projects[] = Project::model()->findByPk($_GET['project_id']);
                                        else
                                            // get all active projects
                                            $active_projects = Project::model()->getActiveProjects(Yii::app()->user->id);
                                        
                                        // get recent tasks based on comment activities
                                        foreach ($active_projects as $project)
                                        {
                                                $recent_tasks = Task::model()->getRecentTasks($project->project_id, 3, true);
                                                // get the first task on the list
                                                // get its latest comment
                                                
                                                if (count($recent_tasks) > 0)
                                                {
                                                        $recent_tasks_latest_comments = array();
                                                        //$task = $recent_tasks[0];
                                                        $counter = 0;
                                                        foreach ($recent_tasks as $task)
                                                        {
                                                                if ($counter++ > 9)
                                                                        break;
                                                                
                                                                $latest_task_comment = TaskComment::model()->getLatestTaskComment($task->task_id);

                                                                if ($latest_task_comment == null
                                                                    || $latest_task_comment->task_comment_id == null)
                                                                {
                                                                        $latest_task_comment = new TaskComment;
                                                                        $latest_task_comment->task_id = $task->task_id;
                                                                }
                                                                // strip html tags from comment content
                                                                $latest_task_comment->task_comment_content 
                                                                        = strip_tags($latest_task_comment->task_comment_content);

                                                                // if comment doesn't exist, just put in placeholder text
                                                                if ($latest_task_comment->task_comment_content === null
                                                                    || $latest_task_comment->task_comment_content == '')
                                                                        $latest_task_comment->task_comment_content  = 'New task. No comments yet.';

                                                                $latest_task_comment->getMetaData()->columns = 
                                                                        array_merge($latest_task_comment->getMetaData()->columns, 
                                                                                array('task_name' => ''));
                                                                $latest_task_comment->task_name = $task->task_name;
                                                                $latest_task_comment->getMetaData()->columns = 
                                                                        array_merge($latest_task_comment->getMetaData()->columns, 
                                                                                array('task_comment_owner_photo_url' => ''));
                                                                $latest_task_comment->task_comment_owner_photo_url = AccountProfile::model()->getProfilePhotoURL($latest_task_comment->task_comment_owner_id);
                                                                //$project->setAttribute('latest_task_comments', $latest_task_comment);
                                                                $project->getMetaData()->columns = 
                                                                        array_merge($project->getMetaData()->columns, 
                                                                                array('latest_task_comments' => $latest_task_comment));
                                                                $recent_tasks_latest_comments[] = $latest_task_comment;
                                                        }
                                                        $project->latest_task_comments = $recent_tasks_latest_comments;
                                                }
                                            
                                                // GET RECENT ISSUES
                                                $recent_issues = Issue::model()->getRecentIssues($project->project_id, 3, 'modelArray');
                                                if (count($recent_issues) > 0)
                                                {
                                                        $recent_issues_latest_comments = array();
                                                        $counter = 0;
                                                        foreach ($recent_issues as $issue)
                                                        {
                                                                if ($counter++ > 9)
                                                                    break;
                                                    
                                                                $latest_issue_comment = IssueComment::model()->getLatestIssueComment($issue->issue_id);
                                                    
                                                                if ($latest_issue_comment == null
                                                                    || $latest_issue_comment->issue_comment_id == null)
                                                                {
                                                                        $latest_issue_comment = new IssueComment;
                                                                        $latest_issue_comment->issue_id = $issue->issue_id;
                                                                }
                                                                // strip html tags from comment content
                                                                $latest_issue_comment->issue_comment_content
                                                                    = strip_tags($latest_issue_comment->issue_comment_content);
                                                    
                                                                // if comment doesn't exist, just put in placeholder text
                                                                if ($latest_issue_comment->issue_comment_content === null
                                                                    || $latest_issue_comment->issue_comment_content == '')
                                                                {
                                                                        $latest_issue_comment->issue_comment_content  = 'No comments yet.';
                                                                }
                                                    
                                                                $latest_issue_comment->getMetaData()->columns =
                                                                    array_merge($latest_issue_comment->getMetaData()->columns,
                                                                                array('issue_name' => ''));
                                                                $latest_issue_comment->issue_name = $issue->issue_name;
                                                            
                                                                $latest_issue_comment->getMetaData()->columns =
                                                                    array_merge($latest_issue_comment->getMetaData()->columns,
                                                                                array('issue_comment_owner_photo_url' => ''));
                                                                $latest_issue_comment->issue_comment_owner_photo_url = AccountProfile::model()->getProfilePhotoURL($latest_issue_comment->issue_comment_owner_id);
                                                                $project->getMetaData()->columns =
                                                                    array_merge($project->getMetaData()->columns,
                                                                                array('latest_issue_comments' => $latest_issue_comment));
                                                                $recent_issues_latest_comments[] = $latest_issue_comment;
                                                        }// end foreach recent issues
                                                        $project->latest_issue_comments = $recent_issues_latest_comments;
                                                } // end count recent issues
                                            
                                                $results[] = $project;
                                        }
                                        return $results;
                                        break;
                                case 'get_projects':
                                        // get active projects
                                        $active_projects = Project::model()->getActiveProjects(Yii::app()->user->id);
                                        return $active_projects;
                                        break;
                                default:
                                        break;
                        }
                } else {
                        
                }
	}
}