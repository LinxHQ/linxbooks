<?php

/**
 * This is the model class for table "task_comments".
 *
 * The followings are the available columns in table 'task_comments':
 * @property integer $task_comment_id
 * @property integer $task_id
 * @property integer $task_comment_owner_id
 * @property string $task_comment_last_update
 * @property string $task_comment_created_date
 * @property string $task_comment_content
 * @property integer $task_comment_internal
 * @property integer $task_comment_to_do
 * @property integer $task_comment_to_do_completed
 * @property string $task_comment_api
 */

define('TASK_COMMENT_INTERNAL_NO', 0);
define('TASK_COMMENT_INTERNAL_YES', 1);
define('TASK_COMMENT_API_EMAIL', 'EMAIL'); // task comment added from email

class TaskComment extends CActiveRecord
{
	public $task_comment_documents;
	public $notification_email_view = 'commentNotification';
        public $task_name; // mostly used for Web Service API
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TaskComment the static model class
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
		return 'lb_project_task_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('task_id, task_comment_owner_id, task_comment_last_update, task_comment_created_date, task_comment_content', 'required'),
			array('task_id, task_comment_owner_id, task_comment_parent_id, task_comment_to_do, task_comment_to_do_completed', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('task_comment_api', 'safe'),
			array('task_comment_id, task_id, task_comment_owner_id, task_comment_last_update, task_comment_created_date, task_comment_content, task_comment_internal', 'safe', 'on'=>'search'),
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
			'task' =>array(self::BELONGS_TO, 'Task', 'task_id'),
			'commenter' =>array(self::BELONGS_TO, 'AccountProfile', 'task_comment_owner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'task_comment_id' => 'Task Comment',
			'task_id' => 'Task',
			'task_comment_owner_id' => 'Task Comment Owner',
			'task_comment_last_update' => 'Task Comment Last Update',
			'task_comment_created_date' => 'Task Comment Created Date',
			'task_comment_content' => 'Task Comment Content',
			'task_comment_internal' => 'Task Comment Internal',
			'task_comment_to_do' => 'To-do',
			'task_comment_to_do_completed' => 'To-do Status',
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

		$criteria->compare('task_comment_id',$this->task_comment_id);
		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('task_comment_owner_id',$this->task_comment_owner_id);
		$criteria->compare('task_comment_last_update',$this->task_comment_last_update,true);
		$criteria->compare('task_comment_created_date',$this->task_comment_created_date,true);
		$criteria->compare('task_comment_content',$this->task_comment_content,true);
		$criteria->compare('task_comment_internal',$this->task_comment_internal);
		$criteria->compare('task_comment_to_do', $this->task_comment_to_do);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		$now = date('Y-m-d H:i:s');
		//$this->task_comment_owner_id = Yii::app()->user->id;
		$this->task_comment_last_update = $now;
		if ($this->task_comment_parent_id === null) $this->task_comment_parent_id = 0;
		else {
			if ($this->task_comment_parent_id > 0)
			{
				// check if its parent is actually a reply.
				// if the parent is a reply, disallow create
				$tempComment = TaskComment::model()->findByPk($this->task_comment_parent_id);
				if ($tempComment && $tempComment->task_comment_parent_id > 0)
				{
					echo "FAILED TaskComment:: trying to add child comment to an existin child comment. ";
					return false;
				}
			}
		}
		
		// if comment is added first time, and it's a to do, save to do completed as not completed
		if ($this->task_comment_id == 0 || $this->task_comment_id == null)
		{
			if ($this->task_comment_to_do > 0)
			{
				$this->task_comment_to_do_completed = 0;
			} else {
				$this->task_comment_to_do = 0;
			}
                        
            $this->task_comment_created_date = date('Y-m-d H:i:s');
			$this->task_comment_owner_id = Yii::app()->user->id;
			
			// check add permission
			$task = Task::model()->findByPk($this->task_id);
			if (!Permission::checkPermission($task, PERMISSION_TASK_COMMENT_ADD))
				return false;
		}
		
		// if updating, check permission to update
		if ($this->task_comment_id > 0)
		{
			if (!Permission::checkPermission($this, PERMISSION_TASK_COMMENT_UPDATE))
				return false;
		}
		
		$success = parent::save($runValidation, $attributes);
		if ($success)
		{
			//save Task's last_commented_date and latest comment id 
			$task = Task::model()->findByPk($this->task_id);
			if ($task)
			{
				/**
				$task->task_last_commented_date = $now;
				$task->save();**/
				$task->updateLatestCommentedDate($now);
			}
			
			$project = Project::model()->findByPk($task->project_id);
			$project->updateLatestActivityDate(date('Y-m-d H:i:s'));
			
			// add notification to email pool
			// $this->addEmailNotifications();
                        
                        // add activity to Notifications
                        // $this->saveNewNotification();
		}
		
		return $success; 
	}
	
	/**
	 * Delete a comment and all its child(ren)
	 */
	public function delete()
	{
		// check permission
		if (!Permission::checkPermission($this, PERMISSION_TASK_COMMENT_DELETE))
			return false;
		
		// delete all the children comments
		$childrenComments = TaskComment::model()->findAll('task_comment_parent_id = ?', array($this->task_comment_id));
		foreach ($childrenComments as $cmt)
		{
			$cmt->delete();
		}
		
		// delete related docs
		$documents = Documents::model()->findAll('document_parent_id = :parent_id 
				AND document_parent_type = :parent_type', 
				array('parent_id' => $this->task_comment_id, 'parent_type' => DOCUMENT_PARENT_TYPE_TASK_COMMENT));
		foreach ($documents as $doc)
		{
			//$doc->deleteFile();
			$doc->delete();	
		}
		
		return parent::delete();
	}
	
	public function getTaskComments($task_id)
	{
		$this->getDbCriteria()->mergeWith(array(
				'condition' => "task_id = $task_id",
				'order' => 'task_comment_created_date DESC',
		));
		
		return $this->findAll();
	}
	public function getTaskCommentss($task_id)
	{
		$this->getDbCriteria()->mergeWith(array(
				'condition' => "task_id = $task_id",
				'order' => 'task_comment_created_date DESC',
				'limit'=>1
		));
		
		return $this->findAll();
	}
	public function getTaskCommentsDetail($task_id){
		$task_comment = $this->getTaskCommentss($task_id);
		$task_comment_detail = "";
		foreach($task_comment as $result_task_comment){
			
			$task_comment_detail .= $result_task_comment['task_comment_content'];
		}
		return $task_comment_detail;
	}
	
	public function getTaskParentComments($task_id, $limit_offset = 0, $limit_rowcount = 10)
	{
		$this->getDbCriteria()->mergeWith(array(
				'condition' => "task_id = $task_id AND task_comment_parent_id = 0",
				'order' => 'task_comment_created_date DESC',
				'limit' => "$limit_offset, $limit_rowcount",
		));
		
		return $this->findAll();
	}
	
	public function getTaskCommentReplies($comment_id, $limit_offset = 0, $limit_rowcount = 5)
	{
		$this->getDbCriteria()->mergeWith(array(
				'condition' => "task_comment_parent_id = $comment_id",
				'order' => 'task_comment_created_date ASC',
				//'limit' => "$limit_offset, $limit_rowcount",
		));
		
		return $this->findAll();
	}
	
	/**
	 * Get latest task comment
	 * @param unknown $task_id
	 * @return TaskComment $taskComment model TaskComment as result
	 */
	public function getLatestTaskComment($task_id)
	{
		$model = $this->findByAttributes(
				array('task_id' => $task_id), 
				'task_comment_last_update = (SELECT MAX(task_comment_last_update) FROM task_comments WHERE task_id = ?)',
				array($task_id));
		
		if ($model == null)
		{
			return new TaskComment;// return empty object
		}
		
		return $model;
	}
	
	/**
	 * Get task comments by a project and date
	 * 
	 * @param integer $project_id
	 * @param string $date date without time parts (Y-m-d)
	 * @return NULL|array array of models or null if none found
	 */
	public function getTaskCommentsByProjectAndDate($project_id, $date)
	{
		// project filtering
		$conditions = "task_id in "
				. " (SELECT task_id FROM tasks "
					. " WHERE project_id = :project_id "
					. " AND DATE_FORMAT(task_last_commented_date, '%Y-%m-%d') = :comment_date)";
		$params = array();
		$params[':project_id'] = $project_id;

		// date filtering
		$conditions .= " AND DATE_FORMAT(`task_comment_last_update`, '%Y-%m-%d') = :comment_date";
		$params[':comment_date'] = $date;
		
		$results = $this->findAll(
				array(
						'condition' => $conditions, 
						'order' => 'task_comment_last_update ASC',
						'params' => $params));
		
		if (count($results) <= 0)
		{
			return null;
		}
		
		return $results;
	}
	
	/**
	 * 
	 * @return unknown account given name, followed by summary of comment made.
	 */
	public function getSummary()
	{
		$str = '';
		
		if ($this->task_comment_owner_id)
		{
			$accountProfile = AccountProfile::model()->getProfile($this->task_comment_owner_id);
			if ($accountProfile)
			{
				$str .= $accountProfile->getShortFullName() . ': ';
				
				// short summary, word wrap
				$len = 70;
				if (strlen($this->task_comment_content) >= $len)
				{
					$short_summary_wr = preg_replace('/\s+?(\S+)?$/', '', substr($this->task_comment_content, 0, $len));
					$short_summary_wr .= '...';
				} else {
					$short_summary_wr = $this->task_comment_content;
				}
				
				$str .= $short_summary_wr;
			}
		}
		return $str;
	}
	
	/**
	 * Check if a comment is an outstanding todo
	 * @param number $task_comment_id
	 * @return boolean
	 */
	public function isOutstandingTodo($task_comment_id=0)
	{
		$task_comment = $this;
		if ($task_comment_id > 0)
		{
			$task_comment = TaskComment::model()->findByPk($task_comment_id);
		}
		
		return ($task_comment->task_comment_to_do && $task_comment->task_comment_to_do_completed == 0);
	}
	
	public function countTodos($task_id)
	{
		return $this->count('task_id = :task_id AND task_comment_to_do = :task_comment_to_do
				AND task_comment_to_do_completed = :task_comment_to_do_completed',
				array(':task_id' => $task_id, ':task_comment_to_do' => YES, ':task_comment_to_do_completed' => NO));
	}
	
	/**
	 * Get incompleted todos
	 * @param unknown $task_id
	 * @param string $todo_completed_status
	 * @return Array of models
	 */
	public function getTodos($task_id, $todo_completed_status = NO)
	{
		return $this->findAll('task_id = :task_id AND task_comment_to_do = :task_comment_to_do
				AND task_comment_to_do_completed = :task_comment_to_do_completed',
				array(':task_id' => $task_id, ':task_comment_to_do' => YES, ':task_comment_to_do_completed' => $todo_completed_status));
	}
	
	/**
	 * Send email notifications to task assignees about new task comment
	 */
	public function sendEmailNotification($taskAssignee) {
		$message = new YiiMailMessage();
	
		$message->view = "commentNotification";
		//userModel is passed to the view
		$message->setBody(array('model' => $this, 'assignee' => $taskAssignee), 'text/html');
	
		$message->setSubject('New Comment by ');
		$message->addTo($taskAssignee->assignee_account->account_email);
		$message->from = Yii::app()->params['adminEmail'];
		Yii::app()->mail->send($message);
	}
	
	/**
	 * Add email notification when a comment is created or updated.
	 *
	 */
	private function addEmailNotifications ()
	{
		$comment_id = $this->task_comment_id;
		
		if (isset($_POST['assignee_notify_task_' . $this->task_id]))
		{
			$receivers_ids = $_POST['assignee_notify_task_' . $this->task_id];
				
			$notification = new EmailNotification();
			$notification->notification_parent_id = $comment_id;
			$notification->notification_parent_type = NOTIFICATION_PARENT_TYPE_TASK_COMMENT;
			$notification->notification_sent = NOTIFICATION_SENT_NO;
			$notification->notification_receivers_account_ids = implode(',', $receivers_ids);
			$notification->save();
		}
	}
        
        /**
         * Save new notification (activity)
         */
        private function saveNewNotification()
        {
            // get task assignees
            $task_assignees = TaskAssignee::model()->getTaskAssignees($this->task_id, true);
            
            foreach ($task_assignees as $taskAssignee)
            {
                $notification = new Notification();
                $notification->saveNewNotification(Notification::NOTIFICATION_TYPE_TASK_COMMENT, 
                        $this, $taskAssignee->account_id); 
            }
        }
	
	public function getAgeInDays($task_comment_id = 0)
	{
		$comment = $this;
		if ($task_comment_id > 0)
		{
			$comment = $this->findByPk($task_comment_id);
		}
		
		$timestamp_created_date = strtotime($comment->task_comment_created_date);
		$timestamp_now = strtotime(date('Y-m-d H:i:s'));
		return ($timestamp_now - $timestamp_created_date)/(24*60*60);
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
                                case 'get_task_comments':
                                        $results = array();
                                        if (!isset($_GET['task_id']))
                                                break;
                                        
                                        $parent_comments = TaskComment::model()->getTaskParentComments($_GET['task_id']);
                                        
                                        // for each parent comments
                                        // - get account profile name and photo
                                        // - get replies
                                        foreach ($parent_comments as $comment)
                                        {
                                                $accountProfile = AccountProfile::model()->getProfile($comment->task_comment_owner_id);
                                                $accountName = $accountProfile->getShortFullName();
                                                $accountPhotoURL = $accountProfile->getProfilePhotoURL();
                                                
                                                // add these attributes to cactiverecord
                                                // must use this method in order for API Controller to be able to retrieve them through attributes()
                                                $comment->getMetaData()->columns = 
                                                                array_merge($comment->getMetaData()->columns, 
                                                                        array('task_comment_owner_name' => ''));
                                                $comment->task_comment_owner_name = $accountName;
                                                $comment->getMetaData()->columns = 
                                                                array_merge($comment->getMetaData()->columns, 
                                                                        array('task_comment_owner_photo_url' => ''));
                                                $comment->task_comment_owner_photo_url = $accountPhotoURL;
                                                        
                                                // get replies
                                                $comment_replies_final = array();
                                                $replies = $comment->getTaskCommentReplies($comment->task_comment_id);
                                                foreach ($replies as $reply)
                                                {
                                                        $replyAccountProfile = AccountProfile::model()->getProfile($reply->task_comment_owner_id);
                                                        $replyAccountName = $replyAccountProfile->getShortFullName();
                                                        $replyAccountPhotoURL = $replyAccountProfile->getProfilePhotoURL();
                                                        
                                                        // add these attributes to cactiverecord
                                                        // must use this method in order for API Controller to be able to retrieve them through attributes()
                                                        $reply->getMetaData()->columns = 
                                                                        array_merge($reply->getMetaData()->columns, 
                                                                                array('task_comment_owner_name' => ''));
                                                        $reply->task_comment_owner_name = $replyAccountName;
                                                        $reply->getMetaData()->columns = 
                                                                        array_merge($reply->getMetaData()->columns, 
                                                                                array('task_comment_owner_photo_url' => ''));
                                                        $reply->task_comment_owner_photo_url = $replyAccountPhotoURL;
                                                        $comment_replies_final[] = $reply;
                                                } // end for replies
                                                
                                                // put replies into comment as an attribute so that it'll be part of the json result
                                                $comment->getMetaData()->columns = 
                                                                array_merge($comment->getMetaData()->columns, 
                                                                        array('task_comment_replies' => ''));
                                                $comment->task_comment_replies = $comment_replies_final;
                                                
                                                $results[] = $comment;
                                        } // end for comments
                                        
                                        return $results;
                                        
                                        break;
                                        // end case get task comments
                                default:
                                        break;
                                        
                        } // end switch
                } // end if list type
        }
}