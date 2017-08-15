<?php

/**
 * This is the model class for table "tasks".
 *
 * The followings are the available columns in table 'tasks':
 * @property integer $task_id
 * @property integer $project_id
 * @property string $task_name
 * @property string $task_start_date
 * @property string $task_end_date
 * @property integer $task_owner_id
 * @property string $task_created_date
 * @property integer $task_public_viewable
 * @property integer $task_status
 * @property integer $task_is_sticky
 * @property integer $task_type
 * @property string $task_no
 * @property integer $task_priority
 */
define('TASK_STATUS_ACTIVE', 0);
define('TASK_STATUS_COMPLETED', 1);
define('TASK_STATUS_ARCHIVED', 2);

define('TASK_PRIORITY_CODE_LOW', 'issue_priority_low');
define('TASK_PRIORITY_CODE_NORMAL', 'issue_priority_normal');
define('TASK_PRIORITY_CODE_HIGH', 'issue_priority_high');
define('TASK_PRIORITY_LIST_NAME', 'Issue Priority');


class Task extends CActiveRecord
{
        public $id;


        public $task_assignees;
        public $task_milestones;
        public $task_order; // order within milestone
	const TASK_STATUS_LABEL_ACTIVE = 'Open';
	const TASK_STATUS_LABEL_COMPLETED = 'Done';
        const TASK_IS_STICKY = 1;
        const TASK_IS_NOT_STICKY = 0;
        const TASK_TYPE_FEATURE = 1;
        const TASK_TYPE_ISSUE = 2;
        const TASK_TYPE_FORUM = 3;
        const TASK_TYPE_OTHERS = 99;
        
        public $task_types_list = array(
                    Task::TASK_TYPE_FEATURE =>'Feature', 
                    Task::TASK_TYPE_ISSUE => 'Issue',
                    Task::TASK_TYPE_FORUM => 'Forum',
                    Task::TASK_TYPE_OTHERS => 'Other');
        
	//public $task_description;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Task the static model class
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
		return 'lb_project_tasks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, task_name, task_owner_id, task_created_date', 'required'),
			array('project_id, task_owner_id, task_public_viewable, task_status, task_is_sticky, task_priority', 'numerical', 'integerOnly'=>true),
			array('task_name', 'length', 'max'=>255),
                        array('task_no', 'length', 'max'=>20),
			array('task_type, task_is_sticky, task_milestones, task_assignees, task_start_date, task_end_date, task_description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('task_id, project_id, task_name,task_priority, task_no, task_start_date, task_end_date, task_owner_id, task_created_date, task_public_viewable, task_status, task_last_commented_date', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'TaskComment', 'task_id',
					'order' => 'comments.task_comment_last_update DESC'),
			'assignees' => array(self::HAS_MANY, 'TaskAssignee', 'task_id'),
			'latest_comment' => array(self::HAS_MANY, 'TaskComment', 'task_id',
					'condition' => 'task_comment_last_update = (SELECT MAX(task_comment_last_update) FROM task_comments WHERE task_id = :ypl0)'),
			'todoCount' => array(self::STAT, 'TaskComment', 'task_id',
					'condition'=>'task_comment_to_do= 1 AND task_comment_to_do_completed = 0'),
			'project' =>array(self::BELONGS_TO, 'Project', 'project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'task_id' => YII::t('core','Task'),
			'project_id' => YII::t('core','Task Project'),
			'task_name' => YII::t('core','Task Name'),
			'task_start_date' => YII::t('core','Task Start Date'),
			'task_end_date' => YII::t('core','Task End Date'),
			'task_owner_id' => YII::t('core','Task Owner'),
			'task_created_date' => YII::t('core','Task Created Date'),
			'task_public_viewable' => YII::t('core','Task Public Viewable'),
			'task_status' => YII::t('core','Task Status'),
			'task_description' => YII::t('core','Description'),
			'task_assignees' => YII::t('core','Assignees'),
                        'task_milestones' => YII::t('core','Milestones'),
                        'task_is_sticky' => YII::t('core','Sticky'),
                        'task_type' => YII::t('core','Type'),
                        'task_no'=>YII::t('core','id'),
                        'task_priority'=>YII::t('core','Priority')
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
         * @param string    $order  sql order phrase
         * @param string    $limit  number of records per fetch
         * @param string    $task_type type of task to fetch: 'all', 'all_but_issues', or specific task_type code
         * 
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($order = 'task_last_commented_date DESC', $limit = 20, $task_type = 'all')
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
                $criteria->select = "t.task_name,t.task_id,t.project_id,t.task_end_date,t.task_status,t.task_type,t.task_status,t.task_no";
                
//		// if current user is not master account
//		// only load item that current user is allowed to see
//		// MUST be before compare(),
		$project = Project::model()->findByPk($this->project_id);
		if ($project && 
				!Account::model()->isMasterAccount($project->account_subscription_id) && 
                        !ProjectMember::model()->isProjectManager($this->project_id,Yii::app()->user->id))
		{
			//require_once 'ProjectMember.php';
                    
                        $criteria->join = 'INNER JOIN '.TaskAssignee::model()->tableName().' ta ON ta.task_id = t.task_id AND ta.account_id = '.  intval(Yii::app()->user->id);
//			$criteria->join = 'LEFT JOIN project_members pm ON pm.project_id = t.project_id AND pm.account_id = '.Yii::app()->user->id.' AND '
//                                . 'pm.project_member_is_manager = '.  intval(1);
//                        $criteria->compare('pm.project_member_is_manager',intval(1));
                        
//			$criteria->condition = 't.task_id in (SELECT task_id FROM task_assignees WHERE account_id = ' . 
//				Yii::app()->user->id . ')' .
//				' OR t.project_id in (SELECT project_id FROM project_members WHERE account_id = ' . 
//				Yii::app()->user->id . ' AND project_member_is_manager = ' . PROJECT_MEMBER_IS_MANAGER . ')'; 
		}
//                
                // task type filtering
                if (is_numeric($task_type))
                {
                    $criteria->compare('task_type', $task_type);
                } else {
                    switch ($task_type):
                        case 'all':
                            // do nothing
                            break;
                        case 'all_but_issues':
                            if (strlen($criteria->condition) > 1) $criteria->condition.= ' AND ';
                            $criteria->condition .= ' t.task_type != ' . Task::TASK_TYPE_ISSUE;
                            break;
                        default:
                            break;
                    endswitch;
                } // end task type filtering
//		$criteria->join = 'INNER JOIN task_comments tc ON tc.task_id = t.task_id AND ' .
//				'tc.task_comment_last_update = (SELECT MAX(task_comment_last_update) FROM task_comments WHERE task_id = t.task_id)';
		
		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('t.project_id',$this->project_id);
		$criteria->compare('task_name',$this->task_name,true);
//		$criteria->compare('task_start_date',$this->task_start_date,true);
//		$criteria->compare('task_end_date',$this->task_end_date,true);
//		$criteria->compare('task_owner_id',$this->task_owner_id);
//		$criteria->compare('task_created_date',$this->task_created_date,true);
//		$criteria->compare('task_public_viewable',$this->task_public_viewable);
		$criteria->compare('task_status', $this->task_status);
//		$criteria->compare('task_last_commented_date',$this->task_last_commented_date);
//		$criteria->compare('task_description', $this->task_description);
//                $criteria->compare('task_is_sticky', $this->task_is_sticky);
                $criteria->compare('task_no', $this->task_no);
                
                
		//$criteria->order = $order;
		/**
		$criteria->with = array(
				"comments" => array(
						'condition' => 'task_comment_last_update = (SELECT MAX(task_comment_last_update) FROM task_comments WHERE task_id = t.task_id)'));
		**/
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination'=> array('pageSize' => $limit),
			'sort'=> array(
				'defaultOrder'=>$order,
				'attributes'=>array(
					'task_name','task_last_commented_date','task_end_date',	
				),
			),
		));
	}
	
	/**
	 * Search task by keyword, we'll look into task name, description and all its comments.
	 * 
	 * @param string $keyword
	 * @return array array of found Task models
	 */
	public function searchByKeyword($keyword)
	{
		$results = array();
		$account_id = Yii::app()->user->id;
		
		// get user projects
		$account_projects = Project::model()->getActiveProjects($account_id);
		foreach ($account_projects as $project)
		{
			// get user ACTIVE tasks
			$account_tasks = $this->getAccountTasks($account_id, $project->project_id, 
					TASK_STATUS_ACTIVE, 'modelArray');
			
			foreach ($account_tasks as $task_)
			{
				// if task description or title contain keyword, add
				if (mb_strpos(strtolower($task_->task_name), $keyword) !== false
						|| mb_strpos(strtolower($task_->task_description), $keyword) !== false)
				{
					$results[] = $task_;
					continue; // no need to continue to search in task comment
				}
				
				// get comments
				$task_comments = TaskComment::model()->getTaskComments($task_->task_id);
				foreach ($task_comments as $comment)
				{
					// if task comment contains keyword, add
					if (mb_strpos(strtolower($comment->task_comment_content), $keyword) !== false)
					{
						$results[] = $task_;
						break; // no need to continue to search other comment
					}
				}
			}
			
			// get user completed tasks
			$account_tasks_completed = $this->getAccountTasks($account_id, $project->project_id,
					TASK_STATUS_COMPLETED, 'modelArray');
				
			foreach ($account_tasks_completed as $task_)
			{
				// if task description or title contain keyword, add
				if (mb_strpos(strtolower($task_->task_name), $keyword) !== false
						|| mb_strpos(strtolower($task_->task_description), $keyword) !== false)
				{
					$results[] = $task_;
					continue; // no need to continue to search in task comment
				}
			
				// get comments
				$task_comments = TaskComment::model()->getTaskComments($task_->task_id);
				foreach ($task_comments as $comment)
				{
					// if task comment contains keyword, add
					if (mb_strpos(strtolower($comment->task_comment_content), $keyword) !== false)
					{
						$results[] = $task_;
						break; // no need to continue to search other comment
					}
				}
			}
		}
		
		return $results;
	}
	
	/**
	 * count number of matches this needle appears in this task: title, description, and commments.
	 * 
	 * @param string $needle
	 * @return int count
	 */
	public function countMatches($needle, $task_id = 0)
	{
		$count = 0;
		$task = $this;
		if ($task_id > 0)
		{
			$task = Task::model()->findByPk($task_id);
		}
		
		// count matches in task name and description
		$count += substr_count(strtolower($task->task_name), $needle);
		$count += substr_count(strtolower($task->task_description), $needle);
		
		// count matches in task comments
		// get comments
		$task_comments = TaskComment::model()->getTaskComments($task->task_id);
		foreach ($task_comments as $comment)
		{
			// if task comment contains keyword, add
			if (mb_strpos(strtolower($comment->task_comment_content), $needle) !== false)
			{
				$count += substr_count(strtolower($comment->task_comment_content), $needle);
			}
		}
		
		return $count;
	}
	
	/**
	 * GEt most recent active tasks. Tasks that have comments recently.
	 * 
	 * @param integer $project_id ID of project
	 * @param number $limit number of recent tasks
         * @param boolean $get_data whether to return array of model objects or CActiveDataProvider. Default is the latter.
         * 
	 * @return CActiveDataProvider $cADP CActiveDataProvider object. do ->getData() to get all results in array of models
	 */
	public function getRecentTasks($project_id, $limit = 3, $get_data = false)
	{
		$dataProvider = new CActiveDataProvider('Task', array(
				'criteria'=> array(
						'condition' => "task_status = " . TASK_STATUS_ACTIVE . " AND project_id = $project_id",
						'order' => 'task_last_commented_date DESC',
				),
				'pagination'=>array(
						'pageSize' => 10,
				),
		));
		
                if ($get_data)
                {
                        $dataProvider->setPagination(false);
			return $dataProvider->getData();
                }
		
		return $dataProvider;
		/*
		$this->getDbCriteria()->mergeWith(array(
			'condition' => "task_status = " . TASK_STATUS_ACTIVE . " AND project_id = $project_id",
				'order' => 'task_last_commented_date DESC',
				'limit' => $limit,
		));
		
		return $this->findAll();*/
	}
	
	/**
	 * GEt all project tasks based on project id and status
	 * @param integer $project_id
	 * @param integer $status default to -1.
	 * @param mixed	$returnDataType modelArray, dataProvider, datasourceArray, datasourceJson
	 * 
	 * @return array array of Task models found
	 */
	public function getProjectTasks($project_id, $status = -1, $returnDataType = 'modelArray')
	{
		$condition = 'project_id = :project_id';
		$value = array(':project_id' => $project_id);
		
		if ($status != -1)
		{
			$condition .= ' AND task_status = :task_status';
			$value[':task_status'] = $status;
		}
		
		$results = $this->findAll($condition, $value);
		
		switch ($returnDataType)
		{
			case 'datasourceArray':
				$return_arr = array();
				foreach ($results as $task)
				{
					$return_arr[$task->task_id] = $task->task_name;
				}
				
				return $return_arr;
				break;
			default:
				break;
		}
		
		return $results;
	}
	
	/**
	 * 
	 * @param int $account_id
	 * @param int $project_id
	 * @param string $task_status -1 for all, otherwise use TASK_STATUS_..... const
	 * @param string $type dataProvider, modelArray, datasourceArray, datasourceJson: the type of data that result should be passed back as.
	 */
	public function getAccountTasks($account_id, $project_id = 0,
                $task_status = -1, $type = 'dataProvider',
                $order_by = 'task_last_commented_date DESC')
	{
                $criteria=new CDbCriteria;
                $criteria->select = 't.*, '.TaskAssignee::model()->tableName().'.account_id, '.TaskAssignee::model()->tableName().'.task_assignee_id, '.TaskAssignee::model()->tableName().'.task_assignee_start_date';
                // condition MUST be before compare(),
                    $criteria->condition = "(".TaskAssignee::model()->tableName().".account_id = $account_id OR task_owner_id = $account_id) "  
                                            . ($task_status != -1 ? " AND task_status = $task_status" : " ")
                                            . ($project_id > 0 ? " AND project_id = $project_id" : " ");
                    $criteria->join = 'LEFT JOIN '.TaskAssignee::model()->tableName().' ON '.TaskAssignee::model()->tableName().'.task_id = t.task_id'; 
                //$criteria->order = $order_by;
                $criteria->group = 't.task_id'; // to avoid duplicate;
                $dataProvider = new CActiveDataProvider($this, array(
                        
			'criteria' => $criteria,
			//'pagination'=> array('pageSize' => $limit),
			'sort'=> array(
				'defaultOrder'=>$order_by,
				'attributes'=>array(
					'project_id','task_name','task_start_date','task_last_commented_date','task_end_date',	
				),
			),
		));
                
                /**
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=> array(
				'condition' => "(task_assignees.account_id = $account_id OR task_owner_id = $account_id) "  
					. ($task_status != -1 ? " AND task_status = " . $task_status : "")
                                        . ($project_id > 0 ? " AND project_id = $project_id" : " "),
				'join' => 'LEFT JOIN task_assignees ON task_assignees.task_id = t.task_id',
				'order' => $order_by,
				'group' => 't.task_id', // to avoid duplicate
			),
		));**/
		
		switch ($type)
		{
			case 'dataProvider':
				return $dataProvider;
			case 'modelArray':
				$dataProvider->setPagination(false);
				return $dataProvider->getData();
			case 'datasourceArray':
				$dataProvider->setPagination(false);
				$modelArray = $dataProvider->getData();
				$ds = array();
				foreach ($modelArray as $item)
				{
					$ds[$item->task_id] = $item->task_name;
				}
				return $ds;
			case 'datasourceJson':
				$dataProvider->setPagination(false);
				$modelArray = $dataProvider->getData();
				$ds = array();
				foreach ($modelArray as $item)
				{
					$ds[$item->task_id] = $item->task_name;
				}
				return CJSON::encode($ds);
		}
		
	}
	
	/**
	 * 
	 * @param integer $project_id
	 * @param string $task_status
         * @param string    $task_type type of task to fetch: 'all', 'all_but_issues', or specific task_type code or array of task_type codes
	 */
	public function countTasks($project_id, $task_status = TASK_STATUS_ACTIVE, $task_type = 'all')
	{
            $task_type_filter_sql = '';
            if (is_numeric($task_type) || is_array($task_type))
            {
                // only a specific type
                if (is_numeric($task_type))
                {
                    $task_type_filter_sql = ' AND task_type = ' . $task_type;
                } else {
                    $task_type_filter_sql = ' AND (';
                    $task_type_condition_arr = array();
                    foreach ($task_type as $type_code)
                    {
                        $task_type_condition_arr[] .= ' task_type = ' . $type_code; 
                    }
                    $task_type_filter_sql .= implode(' OR ', $task_type_condition_arr) . ') ';
                }
            } else {
                switch ($task_type):
                    case 'all':
                        break;
                    case 'all_but_issues':
                        $task_type_filter_sql = ' AND task_type != ' . Task::TASK_TYPE_ISSUE;
                        break;
                    default:
                        break;
                endswitch;
            }
		return $this->count('project_id = :project_id AND task_status = :task_status ' . $task_type_filter_sql, array(
				'project_id' => $project_id, 
				'task_status' => TASK_STATUS_ACTIVE));
	}
	
	/**
	 * Summary of latest activity of this task. Usually it's the summary of latest comment
	 * @return unknown account given name, followed by summary of comment made.
	 */
	public function getSummary($len = 50)
	{
		$str = '';
	
		// we assume that task record is joined with latest comment, if any
		if (isset($this->latest_comment[0]) && isset($this->latest_comment[0]->task_comment_content)
				&& isset($this->latest_comment[0]->task_comment_owner_id))
		{
			$account_id = $this->latest_comment[0]->task_comment_owner_id;
			$content = $this->latest_comment[0]->task_comment_content;
			$accountProfile = AccountProfile::model()->getProfile($account_id);
			if ($accountProfile)
			{
				$str .= $accountProfile->getShortFullName() . ': ';
	
				// short summary, word wrap
				//$len = 150;
				if (strlen($content) >= $len)
				{
					$short_summary_wr = preg_replace('/\s+?(\S+)?$/', '', substr($content, 0, $len));
					$short_summary_wr .= '...';
				} else {
					$short_summary_wr = $content;
				}
	
				$str .= $short_summary_wr;
			}
		} else {
			$str = Utilities::getSummary($this->task_description, true, $len);
		}

		return strip_tags(str_replace('<br/>', '. ', $str));
	}
	
	public function delete()
	{		
		if (!Permission::checkPermission($this, PERMISSION_TASK_DELETE))
		{
			return false;
		}
		
		if ($this->task_id == null || $this->task_id == 0)
		{
			return false;
		}
		
		$task_id = $this->task_id;// because afted exec delete(), id will be gone fro model
		
		// delete comments
		// delete documents
		$taskComments = TaskComment::model()->findAll('task_id = ?', array($task_id));
		foreach ($taskComments as $comment)
		{
			$comment->delete(); // document is deleted in this function as well
		}
		
		return parent::delete();;
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		// create case
		if ($this->task_id == 0 || $this->task_id == NULL)
		{
			if (!Permission::checkPermission($this, PERMISSION_TASK_CREATE))
				return false;
			$this->task_start_date = date('Y-m-d');
			$this->task_end_date = date('Y-m-d');
                        if ($this->task_type == 0)
                        {
                            $this->task_type = Task::TASK_TYPE_FEATURE;
                        }
		}
		
		// check permission for update case
		if ($this->task_id > 0)
		{
			if (!Permission::checkPermission($this, PERMISSION_TASK_UPDATE_GENERAL_INFO))
				return false;
		}
                
                // sticky task
                if ($this->task_is_sticky == NULL
                        || ($this->task_is_sticky != Task::TASK_IS_STICKY
                        && $this->task_is_sticky != Task::TASK_IS_NOT_STICKY))
                {
                    $this->task_is_sticky = Task::TASK_IS_NOT_STICKY;
                }
		
		$is_new_record = $this->isNewRecord;
		$result = parent::save($runValidation, $attributes);
		
		if ($result && $is_new_record)
		{
			// by default, assign creator
			$assignee = new TaskAssignee;
			$assignee->task_assignee_start_date = date('Y-m-d H:i:s');
			$assignee->task_id = $this->task_id;
			$assignee->account_id = Yii::app()->user->id;
			$assignee->save();
		}
		
		return $result;
	}
        
        public function updateSheduleTask($task_id, $task_start, $task_end)
        {
            $task = Task::model()->findByPk($task_id);
            $task->task_start_date = $task_start;
            $task->task_end_date = $task_end;
            $task->save();
        }
	
	/**
	 * update just the last commented date
	 * @param unknown $date
	 */
	public function updateLatestCommentedDate($date)
	{
		if (!Permission::checkPermission($this, PERMISSION_TASK_UPDATE_OTHERS))
			return false;
		
		$this->task_last_commented_date = $date;
		
		return parent::save();
	}
	
	/**
	 * get URL of a task
	 * 
	 * @param number $task_id
	 */
	public function getTaskURL($task_id = 0)
	{		
                $task = $this;
		if ($task_id > 0)
		{
			$task = Task::model()->findByPk($task_id);
		}
                
                if ($task === null)
                {
                    return Utilities::getAppLinkiProjects();
                    //return array("$current_subscription");
                }		
                
		$project = Project::model()->findByPk($task->project_id);		
		$task_subscription = $project->account_subscription_id;//Utilities::getCurrentlySelectedSubscription();
		
		// return array("/$task_subscription/default/{$task->project_id}-" 
		// 		. $project->getURLEncodedProjectName()
		// 		."/task/{$task->task_id}-"
		// 		.$task->getURLEncodedTaskName());	
		
		return array('task/view', 'id' => $task->task_id);
	}
	
	public function getURLEncodedTaskName($task_id = 0)
	{
		$task = $this;
		if ($task_id > 0)
		{
			$task = Task::model()->findByPk($task_id);
		}
	
		$task_name = str_replace(' ','-', $task->task_name);
		$task_name = preg_replace('/[^A-Za-z0-9\-]/', '', $task_name);
		return urlencode($task_name);
	}
	
	public function getCreateURL($project_id = 0)
	{
		if ($project_id == 0)
			$project_id = $this->project_id;
		$project = Project::model()->findByPk($project_id);
		
		return array('task/create', 'project_id' => $project_id, 'project_name' => $project->project_name);
	}
	
	/**
	 * As a security measure
	 * This helps check if this task is matched with currently viewed subscription.
	 *
	 * @return boolean
	 */
	public function matchedCurrentSubscription()
	{
		$current_subscription = Utilities::getCurrentlySelectedSubscription();
		$project = Project::model()->findByPk($this->project_id);
		
		if ($current_subscription == $project->account_subscription_id)
			return true;
	
		return false;
	}
	
        /**
         * Get tasks by project and status
         * 
         * @param int $project_id
         * @param int $task_status TASK_STATUS_ACTIVE, ... if -99, don't use this filter
         * @param boolean $get_data
         * @param mixed $after_date in 'Y-m-d' format, to get only task with start date after this date, avoiding overload
         * @return mixed if get_data is true, return array of models. default to false, return activedataprovider
         */
        public function getTasksByProject($project_id, $task_status = -99, $get_data = false, $after_date = false)
        {
            $criteria = new CDbCriteria();
            
            if ($after_date)
            {
                $after_date = date('Y-m-d', strtotime($after_date));
                $criteria->condition = " task_start_date > '$after_date'";
            }
            
            $criteria->compare('project_id', $project_id);
            if ($task_status != -99)
                $criteria->compare('task_status', $task_status);
            $adp = new CActiveDataProvider(new Task, array(
			'criteria' => $criteria,
            ));
            
            if ($get_data)
            {
                $adp->setPagination(false);
                $records = $adp->getData();
                return $records;
            }
            
            return $adp;
        }

        /**
	 * get value of $this->task_assignees variable from db, delimited ids by comma and return this string
	 * @return string
	 */
	public function getTask_assignees($task_id = 0)
	{
            $task = $this;
            if ($task_id == 0)
            {
                $task_id = $this->task_id;
            } else {
                $task = Task::model()->findByPk($task_id);
            }
            
		if (!$task->task_assignees){
			$task_assignees = TaskAssignee::model()->getTaskAssignees($task_id, true);
			$task->task_assignees = '';
			foreach ($task_assignees as $m)	
		{
				$task->task_assignees .= $m->account_id . ',';
			}
		}
		
		return $task->task_assignees;
	}
        
        /**
	 * get value of $this->task_milestones variable from db, 
         * delimited ids by comma and return this string
	 * @return string
	 */
	public function getTask_milestones()
	{
                Yii::app()->getModule('milestone');
		if (!$this->task_milestones){
			$taskMilestonesDP = MilestoneEntity::model()
                                ->getMilestoneEntities(MilestoneEntity::ENTITY_TYPE_TASK,$this->task_id);
                        $taskMilestonesDP->setPagination(false);
                        $task_milestones = $taskMilestonesDP->getData();
			$this->task_milestones = '';
			foreach ($task_milestones as $m)
			{
				$this->task_milestones .= $m->milestone_id . ',';
			}
		}
		
		return $this->task_milestones;
	}
        
        /**
         * Get the milestone of this task, if any
         * color-coded
         * 
         * @param type $task_id
         * @return string html of the milestone display
         */
        public function getTaskMilestoneLabel($task_id = 0)
        {
            $labels = '';
            Yii::app()->getModule('milestone');
            
            $task = $this;
            if ($task_id > 0)
            {
                $task = Task::model()->findByPk($task_id);
            }
            
            // get task milestone
            $task_milestones = MilestoneEntity::model()->findAllByAttributes(array(
                'me_entity_type' => MilestoneEntity::ENTITY_TYPE_TASK,
                'me_entity_id' => $task->task_id
            ));
            
            if (count($task_milestones) == 0) 
            {
                return '';
            } else {
                foreach ($task_milestones as $taskMilestoneEntity)
                {
                    $labels .= Milestones::model()->getMilestoneLabel($taskMilestoneEntity->milestone_id);
                }
            }
            
            return $labels;
        }
        
        /**
         * Get the name of the task type (text value)
         * 
         * @param type $task_id
         * @return type the text value of task type
         */
        public function getTaskTypeLabel($task_id = 0)
        {
            $task = $this;
            if ($task_id > 0)
            {
                $task = Task::model()->findByPk($task_id);
            }
            
            return $task->task_types_list[$task->task_type];
        }
        
        /**
         * Get task type color-coded in badge style
         * 
         * @param type $task_id
         * @return type html of the badge with type label enclosed.
         */
        public function getTaskTypeBadge($task_id = 0)
        {
            $task = $this;
            if ($task_id > 0)
            {
                $task = Task::model()->findByPk($task_id);
            }
            
            $badge = '';
            // info badge if task type is feature
            if ($task->task_type == Task::TASK_TYPE_FEATURE) {
                $badge = 'badge-info';
            }                
            // warning if task type is issue
            else if ($task->task_type == Task::TASK_TYPE_ISSUE) {
                $badge = 'badge-warning';
            }
            // none if the rest
            
            return "<span class='badge $badge'>".$task->getTaskTypeLabel()."</span>";
        }


        /**
         * Check if a taskis overdue
         * @param type $task_id
         * @return boolean
         */
        public function isOverdue($task_id = false)
        {
            $task = $this;
            if ($task_id > 0)
            {
                $task = Task::model()->findByPk($task_id);
            }
            
            // check if task is overdue
            if ($task)
            {
                if (isset($task->task_end_date) 
                        && $task->task_end_date < date("Y-m-d")
                        && $task->task_status == TASK_STATUS_ACTIVE)
                {
                    return true;
                }
            }
            
            return false;
        }
        
        /**
         * Check if a task should be in progress.
         * That means task is not yet overdue, but already started
         * or should've started according to schedule.
         * 
         * @param type $task_id
         * @return boolean
         */
        public function isInProgress($task_id = false)
        {
            $task = $this;
            if ($task_id > 0)
            {
                $task = Task::model()->findByPk($task_id);
            }
            
            // check if task is in progress
            if ($task)
            {
                if (!$task->isOverdue() 
                        && isset($task->task_start_date) 
                        && $task->task_start_date <= date("Y-m-d")
                        && $task->task_status == TASK_STATUS_ACTIVE)
                {
                    return true;
                }
            }
            
            return false;
        }
        
        /**
         * Check if task is mark as Done
         * 
         * @param type $task_id
         * @return boolean
         */
        public function isDone($task_id = false)
        {
            $task = $this;
            if ($task_id > 0)
            {
                $task = Task::model()->findByPk($task_id);
            }
            
            // check if task is in progress
            if ($task)
            {
                if ($task->task_status == TASK_STATUS_COMPLETED)
                {
                    return true;
                }
            }
            
            return false;
        }
       
        /**
         * Tính tổng số thời gian lên kế hoạch của các open task trong 1 dự án được gán cho nhân viên
         * @param type $project_id
         * @param type $accout_id
         * @param type $status
         */
        public function calculateTotalHousrPlanOpenTask($project_id,$account_id)
        {
            $task = $this->getAccountTasks($account_id, $project_id,0);
            $total = 0;$task_plan=array();
            foreach ($task->data as $task_item) {
                $task_plan = TaskResourcePlan::model()->getTaskResourcePlan($task_item->task_id, $account_id);
                if(count($task_plan)>0)
                    $total += $task_plan->trp_effort * 8;
            }
            
            return $total;
        }
        
               /**
         * Lấy thời gian bé nhất trong các open task của 1 project
         * @param type $project_id
         * @param type $account_id
         * @param type $status
         * @return string
         */
        public function getEarliestStartDateForOpenTasks($project_id,$account_id)
        {
//            $task = $this->getAccountTasks($account_id, $project_id,0, 'task_start_date', 'ASC');
            $task = $this->getAccountTasks($account_id, $project_id, 0, 'dataProvider', 'task_start_date ASC');
            
            if(count($task->data)>0)
            {
                if($task->data[0]->task_start_date=='0000-00-00')
                    return 'Null';
                return date('d-M-Y',  strtotime($task->data[0]->task_start_date));
            }
            else
                return '';
        }
        
        /**
         * Lấy thời gian lơn nhất trong các open task của 1 project
         * @param type $project_id
         * @param type $account_id
         * @param type $status
         * @return string
         */
        public function getLatestEndDateForOpenTasks($project_id,$account_id)
        {
            $task = $this->getAccountTasks($account_id, $project_id, 0, 'dataProvider', 'task_start_date DESC');
            
            if(count($task->data)>0)
            {
                if($task->data[0]->task_end_date=='0000-00-00')
                    return '';
                return date('d-M-Y',strtotime($task->data[0]->task_end_date)) ;
            }
            else
                return '';
        }
        
        public function getTaskTypesList(){
                $task_types_list = array(
                    Task::TASK_TYPE_FEATURE =>YII::t('core', 'Feature'), 
                    Task::TASK_TYPE_ISSUE => YII::t('core', 'Issue'),
                    Task::TASK_TYPE_FORUM => YII::t('core', 'Forum'),
                    Task::TASK_TYPE_OTHERS => YII::t('core', 'Other'));
                return $task_types_list;
        }
        
	/**
	 * GEt all project tasks based on project id and status
	 * @param integer $project_id
	 * @param integer $status default to -1.
	 * @param mixed	$returnDataType modelArray, dataProvider, datasourceArray, datasourceJson
	 * 
	 * @return array array of Task models found
	 */
	public function getProjectTasksEstimate($project_id, $task_status = -1)
	{
                $criteria = new CDbCriteria();
                $criteria->compare('project_id', $project_id);
                $criteria->compare('task_status', $task_status);
                $criteria->order="project_id ASC, task_start_date ASC, task_end_date ASC";
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
        
	/**
	 * Get issue priority code. One of these:
	 * 		issue_priority_low, issue_priority_high, issue_priority_normal
	 * 
	 * @param number $task_id
	 */
	public function getTaskPriorityCode($task_id = 0)
	{
		$task = $this;
		if ($task_id > 0)
		{
			$task = Task::model()->findByPk($task_id);
		}
		
		// get id of priority
		$task_priority_id = $task->task_priority;
		
		// search that against system list table
		$item = SystemListItem::model()->findByPk($task_priority_id);
		if ($item)
		{
			return $item->system_list_item_code;
		}
		
		return '';
	}
        
	public function getTaskPriorityLabel($task_id = 0)
	{
		$task = $this;
		if ($task_id > 0)
		{
			$task = Task::model()->findByPk($task_id);
		}
		
		// get id of priority
		$task_priority_id = $task->task_priority;
		
		// search that against system list table
		$item = SystemListItem::model()->findByPk($task_priority_id);
		if ($item)
		{
                    if($item->system_list_item_code == 'issue_priority_high')
			return LinxUI::getPriorityLabelHigh($item->system_list_item_name);
                    if($item->system_list_item_code == 'issue_priority_normal')
			return LinxUI::getPriorityLabelNormal($item->system_list_item_name);
                    if($item->system_list_item_code == 'issue_priority_low')
			return LinxUI::getPriorityLabelLow($item->system_list_item_name);
		}
		
		return '';
	}
        
        public function getTaskNotAssingeMilestone($project_id){
           
          $MilestoneEntities = MilestoneEntity::model()->findAll();
          $task_miles_arr = array();
          foreach ($MilestoneEntities as $ml_item) {
               $task_miles_arr[]= $ml_item->me_entity_id;
          }
            
          $criteria = new CDbCriteria();
            
            if(count($task_miles_arr)>0)
                $criteria->condition = " task_id NOT IN(".  implode(',', $task_miles_arr)." )";
            
            $criteria->compare('project_id', $project_id);
            $criteria->compare('task_status', 0);
            $adp = new CActiveDataProvider(new Task, array(
			'criteria' => $criteria,
			'pagination'=> false,
			'sort'=> array(
				'defaultOrder'=>'task_end_date ASC',
			),
            ));
            return $adp;
        }

        public static function sortTasksByOrderAndEndDate($tasks_array)
        {
            usort($tasks_array, function($a, $b){
                if ($a->task_order == $b->task_order)
                {
                  if($a->task_end_date == $b->task_end_date) return 0 ;
                  return ($a->task_end_date < $b->task_end_date) ? -1 : 1;
                }
                else
                  return ($a->task_order < $b->task_order) ? -1 : 1;
            });
            
            return $tasks_array;
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
                // TODO
        }
}
