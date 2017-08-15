<?php

/**
 * This is the model class for table "task_assignees".
 *
 * The followings are the available columns in table 'task_assignees':
 * @property integer $task_assignee_id
 * @property integer $task_id
 * @property integer $account_id
 * @property string $task_assignee_start_date
 */
class TaskAssignee extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TaskAssignee the static model class
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
		return 'lb_project_task_assignees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('task_id, account_id, task_assignee_start_date', 'required'),
			array('task_id, account_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('task_assignee_id, task_id, account_id, task_assignee_start_date', 'safe', 'on'=>'search'),
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
			'assignee_account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'assignee_task' => array(self::BELONGS_TO, 'Task', 'task_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'task_assignee_id' => YII::t('core','Task Assignee'),
			'task_id' => YII::t('core','Task'),
			'account_id' => YII::t('core','Account'),
			'task_assignee_start_date' => YII::t('core','Task Assignee Start Date'),
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

		$criteria->compare('task_assignee_id',$this->task_assignee_id);
		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('task_assignee_start_date',$this->task_assignee_start_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Get task assignee, this will include their account and profile
	 *
	 * @param unknown $task_id Task ID
	 * @param boolean	$get_data whether to return array of models or CActiveDataProvider.
	 * 								Default is false, which means return CActiveDataProvider
	 * @return unknown $data if $get_data is true, return array of models, else return CACtiveDataProvider
	 */
	public function getTaskAssignees($task_id, $get_data = false)
	{
		$dataProvider = new CActiveDataProvider('TaskAssignee', array(
				'criteria' => array(
						'condition' => "task_id = " . $task_id,
						//'order' => 'task_last_commented_date DESC',
						'with' => array(
								'assignee_account'
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
	
	public function save($runValidation=true, $attributes=NULL)
	{
		$task = Task::model()->findByPk($this->task_id);
		if (!Permission::checkPermission($task, PERMISSION_TASK_UPDATE_MEMBER))
		{
			return false;
		}
		
		// check if its a new record
		$isNewRecord = $this->isNewRecord;
                
                // check for duplicate
                if (TaskAssignee::model()->isValidMember($this->task_id, $this->account_id))
                        return false;
                
		$result = parent::save($runValidation, $attributes);
		
		// // post save
		// if ($result)
		// {
		// 	// if new record, 
		// 	if ($isNewRecord)
		// 	{
		// 		// notify newly assigned person(s) thru email
		// 		$this->notifyNewAssignee();
                                
  //                               // add to activity notification as new task assigned
  //                               $notification = new Notification();
  //                               $notification->saveNewNotification(Notification::NOTIFICATION_TYPE_NEW_TASK,
  //                                       $task, $this->account_id);
                                
  //                               //init task progress, if not yet (because we might be re-adding)
  //                               TaskProgress::model()->initTaskProgress($this->task_id, $this->account_id);
                                
  //                               // int task resource plan, if not yet (cos we might be re-adding)
  //                               TaskResourcePlan::model()->initTaskResourcePlan($this->task_id, $this->account_id);
		// 	}
		// }
		
		return $result;
	}
	
	public function delete()
	{
		$task = Task::model()->findByPk($this->task_id);
		if (!Permission::checkPermission($task, PERMISSION_TASK_UPDATE_MEMBER))
		{
			return false;
		}
		return parent::delete();
	}
	
	// 1 - email notification to newly assigned users
	private function notifyNewAssignee()
	{
		// don't send to self
		if ($this->account_id == Yii::app()->user->id)
			return;
	
		// get task
		$task = Task::model()->findByPk($this->task_id);
	
		if ($task)
		{
			// get project
			$project = Project::model()->findByPk($task->project_id);
				
			if ($project)
			{
				$message = new YiiMailMessage();
				$message->view = "newTaskAssigned";
				$message->setBody(array(
						'model' => $this,
						'task'=>$task,
						'project'=>$project), 'text/html');

				$message->setSubject('['.$project->project_name.'] '.YII::t('core','You are assigned to a new task'));
	
				// send to
				$receiverAccount = Account::model()->findByPk($this->account_id);
				if ($receiverAccount)
				{
					$message->addTo($receiverAccount->account_email);
						
					// from
					$message->setFrom(array(Yii::app()->params['adminEmail'] => "LinxCircle Admin"));
						
					// send now
					Yii::app()->mail->send($message);
				}
			}// end if project exists
		}
	}
        
	/**
	 * Check if this account is a valid member of this task
	 *
	 * @param unknown $task_id
	 * @param unknown $account_id
	 * @return boolean
	 */
	public function isValidMember($task_id, $account_id)
	{
		$member = TaskAssignee::model()->find('task_id = :task_id AND account_id = :account_id',
				array(':task_id' => $task_id, ':account_id' => $account_id));
	
		if ($member)
		{
			// if this member is a de-activated account team member, consider invalid
			$task = Task::model()->findByPk($task_id);
			$master_account_id = AccountTeamMember::model()->getMasterAccountIDs($account_id,
					$task->project_id);
			if (!AccountTeamMember::model()->isActive($master_account_id, $account_id)
					&& Project::model()->findProjectMasterAccount($task->project_id) != $account_id)
				return false;
			
			return true;
		}
	
		return false;
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
                case 'get_task_assignees':
                    $results = array();
                    
                    if (isset($_GET['task_id']))
                    {
                        $task_assignees = TaskAssignee::model()->getTaskAssignees($_GET['task_id'], true);
                        
                        if (count($task_assignees) > 0)
                        {
                            foreach ($task_assignees as $assignee)
                            {
                                // get short full name
                                $task_assignee_name = AccountProfile::model()->getShortFullName($assignee->account_id);
                                $assignee->getMetaData()->columns =
                                    array_merge($assignee->getMetaData()->columns,
                                        array('task_assignee_name' => ''));
                                $assignee->task_assignee_name = $task_assignee_name;
                                $results[] = $assignee;
                            }
                        }
                    } // end if isset task_id
                    
                    return $results;
                    
                    break;
                    
                    // end case get_task_assignees
                default:
                    break;
            } // end switch for list_type
        }// end if for list_type
	}

}