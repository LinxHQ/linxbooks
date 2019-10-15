<?php

class TaskController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout= '//layouts/column1'; //'//layouts/column1ajax';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'my', 'gantt',
                                    'indexImplementations','delete','popoverSchedule',
                                    'accountTasksReport', 'mutiletabs', 'loadmutiletabs'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'toggleStatus', 'test', 'ajaxUpdateDescription', 'ajaxUpdateField',
                                    'updateStatus','UpdateType'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);

		// check if we need to switch subscription
		if (isset($_GET['subscription']))
		{
			Utilities::setCurrentlySelectedSubscription($_GET['subscription']);
		}
		
		// check permission
		if (!Permission::checkPermission($model, PERMISSION_TASK_VIEW)
				|| !$model->matchedCurrentSubscription())
		{
			throw new CHttpException(401,'You are not given the permission to view this page.');
			return;
		}
		
		// init task into Backlog if not yet assigned anywhere
                // MilestoneEntity::model()->initTaskToBacklog($model->project_id, $id);
                
                $data = array();
		// get task comments
		$task_comments = TaskComment::model()->getTaskParentComments($id);

		$data['model'] = $model;
		$data['task_comments'] = $task_comments;
		$data['task_comment_replies'] = array();
		$data['task_comment_documents'] = array();
		
		// get replies for each parent comment
		foreach ($task_comments as $parent) 
		{
			$parent_documents = Documents::model()->findAllCommentDocuments($parent->task_comment_id, DOCUMENT_PARENT_TYPE_TASK_COMMENT);
			$data['task_comment_documents'][$parent->task_comment_id] = $parent_documents;
			
			// if this is a  todo item, add it in
			if ($parent->task_comment_to_do == YES) // && $parent->task_comment_to_do_completed == NO)
			{
				$data['outstanding_to_do'][] = $parent;
			}
			
			// process replies
			$task_replies = TaskComment::model()->getTaskCommentReplies($parent->task_comment_id);
			if (count($task_replies))
			{
				$data['task_comment_replies'][$parent->task_comment_id] = $task_replies;
				
				// foreach each reply, find documents
				foreach ($task_replies as $reply)
				{
					$reply_documents = Documents::model()->findAllCommentDocuments($reply->task_comment_id, DOCUMENT_PARENT_TYPE_TASK_COMMENT);
					$data['task_comment_documents'][$reply->task_comment_id] = $reply_documents;
					
					// if this is an todo item, add it in
					if ($reply->task_comment_to_do == YES)// && $reply->task_comment_to_do_completed == NO)
					{
						$data['outstanding_to_do'][] = $reply;
					}
				}
			}
		}
		
		/* Get task assignees for x-editable widget */
		$task_assignees = TaskAssignee::model()->getTaskAssignees($id, true);
		$model->task_assignees = '';
		foreach ($task_assignees as $m)
		{
			$model->task_assignees .= $m->account_id . ',';
                        
                        // init Progress and Resource Plan
                        // TaskProgress::model()->initTaskProgress($id, $m->account_id);
                        // TaskResourcePlan::model()->initTaskResourcePlan($id, $m->account_id);
                        // done init progress and resource plan
		}
                
                // get milestones for x-editable widget
                // $model->getTask_milestones(); // no need to use the return data. This call will set the var
		
		Utilities::render($this, 'view', $data, false, true);
		//$this->renderPartial('view', $data, false, true);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Task;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Task']))
		{
			$model->attributes=$_POST['Task'];
			if (isset($_POST['Task']['task_description'])) 
			{
				$model->task_description = $_POST['Task']['task_description'];
			}
			$model->task_id = null;
			$model->task_owner_id = Yii::app()->user->id;
			$model->task_created_date = date('Y-m-d');
			$model->task_status = TASK_STATUS_ACTIVE;
			$model->task_start_date = date('Y-m-d');
			$model->task_last_commented_date = date('Y-m-d H:i');
                        $model->task_no = NextId::model()->getNextId('task');
			
			if($model->save())
			{
                                //
                                // any documents to upload?
                                //
                                $task_documents = CUploadedFile::getInstancesByName('task_documents'); 
                                if (isset($task_documents) && count($task_documents) > 0) {
                                    // create a new comment to hold these documents
                                    $taskComment = new TaskComment;
                                    $taskComment->task_id = $model->task_id;
                                    $taskComment->task_comment_content = 'Uploaded document(s).';
                                    
                                    if ($taskComment->save())
                                    {
                                        // go through each uploaded document
                                        foreach ($task_documents as $document) {                                                 
                                            // create document model to be saved to db
                                            $docModel = new Documents();
                                            
                                            // save document to temp path
                                            $document->saveAs($docModel->getTempFolderPath() . $document->name); 
                                            
                                            
                                            // get original name if available.
                                            // because sometimes due to same name, filename may have included additional chars
                                            // by the uploader
                                            $docModel->document_temp_name = $document->name;
                                            $docModel->document_real_name = $document->name;
                                            $docModel->document_parent_id = $taskComment->task_comment_id;
                                            $docModel->document_task_id = $taskComment->task_id;
                                            $docModel->document_parent_type = DOCUMENT_PARENT_TYPE_TASK_COMMENT;

                                            if ($docModel->save()) // save to db
                                            {
                                                    // now, move file to actual location
                                                    $docModel->moveToActualLocation();
                                            } // end saving documents to physical loc
                                        } // end foreach loop thru documents
                                    }
                                }
                                // end handling uploading documents
                                
				if ($model->task_assignees)
				{
					$task_assignees_account_ids = explode(',', $model->task_assignees);
					foreach ($task_assignees_account_ids as $acc_id_temp)
					{
						if (!$acc_id_temp || Yii::app()->user->id == $acc_id_temp) continue;
						
						$acc_id_temp = trim($acc_id_temp);
						// add assignee
						$assignee = new TaskAssignee();
						$assignee->task_id = $model->task_id;
						$assignee->task_assignee_start_date = date('Y-m-d H:i:s');
						$assignee->account_id = $acc_id_temp;
						$assignee->save();
					}
				}
                                
                                // UPDATE NEXT ID TASK
                                // NextId::model()->addNextId('task');
                                
				// add first comment
				
				if ($model->task_description) {
					$today_date = date('Y-m-d H:i');
					$taskComment = new TaskComment;
					$taskComment->task_id = $model->task_id;
					$taskComment->task_comment_owner_id = Yii::app()->user->id;
					$taskComment->task_comment_last_update = $today_date;
					$taskComment->task_comment_created_date = $today_date;
					$taskComment->task_comment_content = $model->task_description;
					$taskComment->task_comment_internal = TASK_COMMENT_INTERNAL_NO;
					$taskComment->task_comment_parent_id = 0;
					$taskComment->save();
				}
				
				// TODO: add self as assignee
				
				// show view
				// echo $_POST['Task']['project_id'];
				// $this->redirect($model->getTaskURL());
				$this->redirect(array('default/view', 'id'=>$_POST['Task']['project_id']));
				//$this->redirect(array('view','id' => $model->task_id));
			}
		}

		// render form
		$project_id = 0;
		$project_name = "";
		if (isset($_GET['project_id'])) $project_id = $_GET['project_id'];
		if (isset($_GET['project_name'])) $project_name = $_GET['project_name'];
		$renderData = array(
			'model'=>$model,
			'project_id' => $project_id,
			'project_name' => $project_name,
		);
		
		Utilities::render($this, 'create', $renderData);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Task']))
		{
			$model->attributes=$_POST['Task'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->task_id));
		}
                
		/**
		 * X-editable Bootstrap submission
		 * pk: issue_id
		 * value: attribute value
		 * name: attribute name
		 */
		if (isset($_POST['ajax_id']) && $_POST['ajax_id'] == 'bootstrap-x-editable')
		{
			$attribute = $_POST['name'];
			$value = $_POST['value'];
			$pk = $_POST['pk'];
			$model = $this->loadModel($pk);
			$model->$attribute = $value;
			
			if ($model->save())
			{
				echo SUCCESS;
			} else {
				echo FAILTURE;
			}
			
			return true;
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionPopoverSchedule($id)
	{
		$model = $this->loadModel($id);
		
		// perform update
		if (isset($_POST['Task']))
		{
			if (isset($_POST['Task']['task_start_date']))
			{
				// have to do this convert because fullcalendar send browser's timezone
				//$model->task_start_date = date('Y-m-d', strtotime($_POST['Task']['task_start_date']));
				$model->task_start_date = Utilities::convertDateToServerTimeZone($_POST['Task']['task_start_date']);
			}
			if (isset($_POST['Task']['task_end_date']))
			{
				$task_end_date = $_POST['Task']['task_end_date'];
				if ($_POST['Task']['task_end_date'] == null)
					$task_end_date = $model->task_start_date;
				// have to do this convert because fullcalendar send browser's timezone
				//$model->task_end_date = date('Y-m-d', strtotime($_POST['Task']['task_end_date']));
				$model->task_end_date = Utilities::convertDateToServerTimeZone($task_end_date);
			}
			
			if ($model->save())
			{
				echo CJSON::encode(array('result'=>'successful'));
				return;
			} else {
				echo CJSON::encode(array('result'=>'failed', 'errors'=>$model->getError()));
			}
			return;
		}
		
		// show form
		Utilities::render($this, 'popover_schedule', array('model'=>$model));
	}
	
	/**
	 * Updating task status
	 * 
	 * @param unknown $id
	 */
	public function actionToggleStatus($id)
	{
		$result = array();
		$model = $this->loadModel($id);
		
		if (!Permission::checkPermission($model, PERMISSION_TASK_UPDATE_STATUS))
		{
			$result['status'] = APP_NO_PERMISSION;
			echo CJSON::encode($result);
			return ;
		}		
		
		if ($model)
		{
			if ($model->task_status == TASK_STATUS_ACTIVE)
			{
				$model->task_status = TASK_STATUS_COMPLETED;
			} else {
				$model->task_status = TASK_STATUS_ACTIVE;
			}

			if ($model->save())
			{
				// auto add comment
				$comment = new TaskComment();
				$comment->task_id = $model->task_id;
				$comment->task_comment_content = 'Updated status to ' .
						($model->task_status == TASK_STATUS_ACTIVE ? Task::TASK_STATUS_LABEL_ACTIVE : Task::TASK_STATUS_LABEL_COMPLETED);
				$comment->save();
				
				$result['status'] =  SUCCESS;
				$result['task_status'] = $model->task_status; // updated status
				echo CJSON::encode($result);
				return;
			}
		}

		$result['status'] = FAILURE;
		echo CJSON::encode($result);
		return;
	}
        
	/**
	 * Updating task status
	 * 
	 * @param unknown $id
	 */
	public function actionUpdateStatus($id)
	{
		$result = array();
		$model = $this->loadModel($id);
		
		if (!Permission::checkPermission($model, PERMISSION_TASK_UPDATE_STATUS))
		{
			$result['status'] = APP_NO_PERMISSION;
			echo CJSON::encode($result);
			return ;
		}		
		
		if ($model && isset($_POST['status']))
		{
			$model->task_status = $_POST['status'];
			if ($model->save())
			{
				// auto add comment
				$comment = new TaskComment();
				$comment->task_id = $model->task_id;
				$comment->task_comment_content = 'Updated status to ' .
						($model->task_status == TASK_STATUS_ACTIVE ? Task::TASK_STATUS_LABEL_ACTIVE : Task::TASK_STATUS_LABEL_COMPLETED);
				$comment->save();
				
				$result['status'] =  SUCCESS;
				$result['task_status'] = $model->task_status; // updated status
				echo CJSON::encode($result);
				return;
			}
		}

		$result['status'] = FAILURE;
		echo CJSON::encode($result);
		return;
	}

	/**
	 * Update task's description
	 * @param unknown $id
	 */
	public function actionAjaxUpdateDescription($id)
	{
		$model = $this->loadModel($id);
		
		if ($model)
		{
			// save if this is a submit
			if(isset($_POST['Task']))
			{
				$model->task_description = $_POST['Task']['task_description'];
				$model->save();
				Utilities::render($this, '//layouts/plain_ajax_content', array(
					'content' => $model->task_description), false, false);

				/**
				$this->renderPartial("//layouts/plain_ajax_content", array(
					'content' => $model->task_description), false, false); // don't run any javascript 
					**/
				return;
			}
			
			// show update form if this is the start of update.
			Utilities::render($this, '_form_description', array(
				'model' => $model,
			),false, true);
			/**
			$this->renderPartial("_form_description", array(
				'model' => $model,
			), false, true);**/
		}
	}
	
	/**
	 * Use for updating a single field through inline editable
	 * such as jquery editable, bootstrap x-editable, etc.
	 *
	 * POST params
	 * pk	the primary key of this record
	 * name attribute name
	 * value value to be updated to
	 */
	public function actionAjaxUpdateField()
	{
		if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = $this->loadModel($id);
			// update
			$model->$attribute = $value;
			return $model->save();
		}
	
		return false;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		
		if ($model) 
		{
			if ($model->delete())
			{
				echo SUCCESS;
				return;
			}
		}
		
		echo FAILURE;
		return;

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_GET['project_id']))
		{
			$project_id = $_GET['project_id'];
			$taskModel = new Task('search');
			$taskModel->unsetAttributes();
			$taskModel->project_id = $project_id;
			
			if (isset($_GET['status']))
			{
				$taskModel->task_status = $_GET['status'];
			} else {
				$taskModel->task_status = TASK_STATUS_ACTIVE;
			}
			
			Utilities::render($this, 'index', array(
				'model' => $taskModel,
			), false, true);
			/**
			$this->renderPartial('index',array(
				'model' => $taskModel,
			), false, true);**/
		}
		
		//$dataProvider=new CActiveDataProvider('Task');
		//$this->render('index',array(
		//	'dataProvider'=>$dataProvider,
		//));
	}
	
	/**
	 * list implementations related to this task
	 */
	public function actionIndexImplementations($id)
	{
		$implementations = ImplementationRelatedEntity::model()->getImplementationsForEntity($id, ENTITY_TYPE_TASK, 'modelArray');
		$this->renderPartial('//implementation/_index_implementations_simple', array(
			'implementations' => $implementations
		)); // cannot process js because jquery and bootstrap is already loaded into page, that will cause conflict
	}
	
	/**
	 * list documents related to this task
	 */
	public function actionIndexDocuments()
	{
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Task('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Task']))
			$model->attributes=$_GET['Task'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionAccountTasksReport()
        {
            $account_id = $_GET['account_id'];
            $range = $_GET['range'];
            $download = isset($_GET['download']) ? $_GET['download'] : 0;
            
            // permission
            if ($account_id != Yii::app()->user->id
                    && AccountSubscription::model()->getSubscriptionOwnerID(Utilities::getCurrentlySelectedSubscription()) != Yii::app()->user->id)
            {
                throw new CHttpException(401,'You are not authorized to view this page.');
                //return false;
            }
            
            $account = Account::model()->findByPk($account_id);
            
            // get list of tasks and issues done by this user
            $account_tasks = Task::model()
                    ->getAccountTasks($account_id, 0, -1, 'modelArray',
                            'project_id ASC, task_start_date ASC, task_end_date ASC');
            $final_tasks = array();
            
            // filter by date - default is this year
            $filter_start_date = strtotime('first day of January this year');
            $filter_end_date = strtotime('last day of December this year');
            if ($range == 'last_year')
            {
                $filter_start_date = strtotime('first day of January last year');
                $filter_end_date = strtotime('last day of December last year');
            }
            
            foreach ($account_tasks as $task) {
                $task_start_date = strtotime($task->task_start_date);
                $task_end_date = strtotime($task->task_end_date);
                if (($task_start_date >= $filter_start_date && $task_end_date <= $filter_end_date) 
                        || ($task_start_date <= $filter_start_date && $task_end_date >= $filter_start_date && $task_end_date <= $filter_end_date) 
                        || ($task_end_date >= $filter_end_date && $task_start_date >= $filter_start_date && $task_start_date <= $filter_end_date)) {
                    $final_tasks[] = $task;
                }
            }

            Utilities::render($this, '_account_tasks_report', array(
                'account_tasks' => $final_tasks,
                'account' => $account,
                'range'=>$range,
                'download'=>$download
            ));
        }
        
        public function actionMy()
        {
            // account id
            $account_id = Yii::app()->user->id;
            if (isset($_GET['account_id']))
            {
                $account_id = intval($_GET['account_id']);
            }
            
            // date filter
            $start_by_date = strtotime('this saturday');
            $start_by = "this saturday";
            if (isset($_GET['start_by_date']))
            {
                $start_by_date = strtotime($_GET['start_by_date']);
                $start_by = $_GET['start_by_date'];
            }
            $member_by = $account_id;
            if (isset($_GET['member_by']))
            {
                $member_by = $_GET['member_by'];
            }
            
            // retrieve all active tasks
            $my_tasks = Task::model()->getAccountTasks($member_by, 0, 
                    TASK_STATUS_ACTIVE, 'modelArray', 'task_end_date ASC');
            
            //
            // only get those fulfill your filter
            // Basic algorithm:
            // -> for each task
            //      -> put task's project into priority baskets: high, normal or low
            //      -> if task's project is already in one basket, then simply put this task there
            //
            $my_tasks_final = array();
            foreach ($my_tasks as $task)
            {
                if (strtotime($task->task_start_date . ' 00:00:00') <= $start_by_date)
                {
                    $project_id = $task->project_id;
                    $project = Project::model()->findByPk($project_id);
                    
                    // only show projects for this subscription
                    if ($project->account_subscription_id != Utilities::getCurrentlySelectedSubscription())
                        continue;
                    
                    // if project is archived, skip it as well
                    if ($project->project_status == PROJECT_STATUS_ARCHIVED)
                    {
                        continue;
                    }
                    
                    // check if this project isn't already in the priority basket
                    // and init it
                    if (!isset($my_tasks_final[Project::PROJECT_PRORITY_HIGH][$project_id])
                            && !isset($my_tasks_final[Project::PROJECT_PRIORITY_NORMAL][$project_id])
                            && !isset($my_tasks_final[Project::PROJECT_PRIORITY_LOW][$project_id]))
                    {
                        // initialize project in its basket
                        // $my_tasks_final[priority: 1,2,3]
                        //   = array(
                        //      project_id  => array (0=> project object, 1=> array(task,...)),
                        //      project_id  => ....
                        //   )
                        //                        
                        
                        // first element is project object
                        $temp_array[0] = $project;
                        // second element is array of tasks
                        $temp_array[1] = array($task);
                        
                        if ($project->project_priority == Project::PROJECT_PRORITY_HIGH)
                        {
                            $my_tasks_final[Project::PROJECT_PRORITY_HIGH][$project->project_id]
                                    = $temp_array;
                        } else if ($project->project_priority == Project::PROJECT_PRIORITY_NORMAL) {
                            $my_tasks_final[Project::PROJECT_PRIORITY_NORMAL][$project->project_id]
                                    = $temp_array;
                        } else {
                            $my_tasks_final[Project::PROJECT_PRIORITY_LOW][$project->project_id]
                                    = $temp_array;
                        }
                        
                        // done init project into its priority basket
                    } else {
                        // it's been init before
                        // locate its basket
                        if (isset($my_tasks_final[Project::PROJECT_PRORITY_HIGH][$project_id]))
                        {
                            $my_tasks_final[Project::PROJECT_PRORITY_HIGH][$project_id][1][] = $task;
                        } else if (isset($my_tasks_final[Project::PROJECT_PRIORITY_NORMAL][$project_id])) {
                            $my_tasks_final[Project::PROJECT_PRIORITY_NORMAL][$project_id][1][] = $task;
                        } else {
                            $my_tasks_final[Project::PROJECT_PRIORITY_LOW][$project_id][1][] = $task;
                        }
                    }              
                }
            }
            
            Utilities::render($this, 'my', 
                    array(
                        'my_tasks_final' => $my_tasks_final,
                        'start_by'=>$start_by,
                        'member_by'=>$member_by,
                    ));
        }
        
        public function actionGantt()
        {            
            // account id
            $account_id = Yii::app()->user->id;
            
            // retrieve all active tasks
            $my_tasks = Task::model()->getAccountTasks($account_id, 0, 
                    TASK_STATUS_ACTIVE, 'modelArray', 'task_end_date ASC');
            
            // filtered projects
            // projects that can be listed in the dropdown list for filter form
            $filtered_projects = array();
            
            // selected projects
            // by users
            $selected_projects = array(0); // ids of selected projects
            if (isset($_GET['projects']))
            {
                $selected_projects = $_GET['projects'];
//                if ($selected_projects != 0)
//                {
                    $selected_projects = explode(',', $selected_projects);
//                }
            }
            
            //
            // only get those fulfill your filter
            // Basic algorithm:
            // -> for each task
            //      -> put task's project into priority baskets: high, normal or low
            //      -> if task's project is already in one basket, then simply put this task there
            //
            $my_tasks_final = array();
            foreach ($my_tasks as $task) {
                $project_id = $task->project_id;
                $project = Project::model()->findByPk($project_id);
                
                // skip forum tasks
                if ($task->task_type == Task::TASK_TYPE_FORUM)
                {
                    continue;
                }

                // only show projects for this subscription
                if ($project->account_subscription_id != Utilities::getCurrentlySelectedSubscription())
                    continue;

                // if project is archived, skip it as well
                if ($project->project_status == PROJECT_STATUS_ARCHIVED) {
                    continue;
                }
                
                // add this project to the filtered projects list for ease of reference
                $filtered_projects[$project->project_id] = $project;
                
                // if selected project is set, and project is not in the list
                if (isset($selected_projects) && $selected_projects[0] != 0 
                        && !in_array($project_id, $selected_projects)) {
                    continue;
                }

                // check if this project isn't already in the priority basket
                // and init it
                if (!isset($my_tasks_final[Project::PROJECT_PRORITY_HIGH][$project_id])
                        && !isset($my_tasks_final[Project::PROJECT_PRIORITY_NORMAL][$project_id])
                        && !isset($my_tasks_final[Project::PROJECT_PRIORITY_LOW][$project_id]))
                {
                    // initialize project in its basket
                    // $my_tasks_final[priority: 1,2,3]
                    //   = array(
                    //      project_id  => array (0=> project object, 1=> array(task,...)),
                    //      project_id  => ....
                    //   )
                    //                        

                    // first element is project object
                    $temp_array[0] = $project;
                    // second element is array of tasks
                    $temp_array[1] = array($task);
               
                    if ($project->project_priority == Project::PROJECT_PRORITY_HIGH)
                    {
                        $my_tasks_final[Project::PROJECT_PRORITY_HIGH][$project->project_id]
                                = $temp_array;
                    } else if ($project->project_priority == Project::PROJECT_PRIORITY_NORMAL) {
                        $my_tasks_final[Project::PROJECT_PRIORITY_NORMAL][$project->project_id]
                                = $temp_array;
                    } else {
                        $my_tasks_final[Project::PROJECT_PRIORITY_LOW][$project->project_id]
                                = $temp_array;
                    }

                    // done init project into its priority basket
                } else {
                    // it's been init before
                    // locate its basket
                    if (isset($my_tasks_final[Project::PROJECT_PRORITY_HIGH][$project_id]))
                    {
                        $my_tasks_final[Project::PROJECT_PRORITY_HIGH][$project_id][1][] = $task;
                    } else if (isset($my_tasks_final[Project::PROJECT_PRIORITY_NORMAL][$project_id])) {
                        $my_tasks_final[Project::PROJECT_PRIORITY_NORMAL][$project_id][1][] = $task;
                    } else {
                        $my_tasks_final[Project::PROJECT_PRIORITY_LOW][$project_id][1][] = $task;
                    }
                }              
                
            }
            usort($filtered_projects, function($a, $b)
            {
                return strcmp($a->project_name, $b->project_name);
            });
            
            Utilities::render($this, 'gantt', 
                array(
                    'my_tasks_final' => $my_tasks_final, 
                    'filtered_projects' => $filtered_projects,
                    'selected_projects_ids' => $selected_projects)
            );
        }
        
        public function actionUpdateType($id)
        {
            $model = $this->loadModel($id);
            if($model && isset($_POST['type_id']))
            {
                $model->task_type = $_POST['type_id'];
                if($model->save())
                {
                    $result['status'] =  SUCCESS;
                    $result['task_type'] = $model->task_type; // updated status
                    echo CJSON::encode($result);
                    return;
                }
            }
            $result['status'] =  FAILURE;
            echo CJSON::encode($result);
            return;
        }

        public function actionTest()
	{
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Task the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Task::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Task $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='task-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionMutiletabs($id_task){
		$model = $this->loadModel($id_task);
		Utilities::render($this, 'muilte_tabs', 
	        array(
	            'id_task' => $id_task,
	            'model' => $model
	        ));
	}
	public function actionLoadmutiletabs($id){
		$model = $this->loadModel($id);

		// check if we need to switch subscription
		if (isset($_GET['subscription']))
		{
			Utilities::setCurrentlySelectedSubscription($_GET['subscription']);
		}
		
		// check permission
		if (!Permission::checkPermission($model, PERMISSION_TASK_VIEW)
				|| !$model->matchedCurrentSubscription())
		{
			throw new CHttpException(401,'You are not given the permission to view this page.');
			return;
		}
		
		// init task into Backlog if not yet assigned anywhere
                // MilestoneEntity::model()->initTaskToBacklog($model->project_id, $id);
                
                $data = array();
		// get task comments
		$task_comments = TaskComment::model()->getTaskParentComments($id);

		$data['model'] = $model;
		$data['task_comments'] = $task_comments;
		$data['task_comment_replies'] = array();
		$data['task_comment_documents'] = array();
		
		// get replies for each parent comment
		foreach ($task_comments as $parent) 
		{
			$parent_documents = Documents::model()->findAllCommentDocuments($parent->task_comment_id, DOCUMENT_PARENT_TYPE_TASK_COMMENT);
			$data['task_comment_documents'][$parent->task_comment_id] = $parent_documents;
			
			// if this is a  todo item, add it in
			if ($parent->task_comment_to_do == YES) // && $parent->task_comment_to_do_completed == NO)
			{
				$data['outstanding_to_do'][] = $parent;
			}
			
			// process replies
			$task_replies = TaskComment::model()->getTaskCommentReplies($parent->task_comment_id);
			if (count($task_replies))
			{
				$data['task_comment_replies'][$parent->task_comment_id] = $task_replies;
				
				// foreach each reply, find documents
				foreach ($task_replies as $reply)
				{
					$reply_documents = Documents::model()->findAllCommentDocuments($reply->task_comment_id, DOCUMENT_PARENT_TYPE_TASK_COMMENT);
					$data['task_comment_documents'][$reply->task_comment_id] = $reply_documents;
					
					// if this is an todo item, add it in
					if ($reply->task_comment_to_do == YES)// && $reply->task_comment_to_do_completed == NO)
					{
						$data['outstanding_to_do'][] = $reply;
					}
				}
			}
		}
		
		/* Get task assignees for x-editable widget */
		$task_assignees = TaskAssignee::model()->getTaskAssignees($id, true);
		$model->task_assignees = '';
		foreach ($task_assignees as $m)
		{
			$model->task_assignees .= $m->account_id . ',';
                        
                        // init Progress and Resource Plan
                        // TaskProgress::model()->initTaskProgress($id, $m->account_id);
                        // TaskResourcePlan::model()->initTaskResourcePlan($id, $m->account_id);
                        // done init progress and resource plan
		}
                
                // get milestones for x-editable widget
                // $model->getTask_milestones(); // no need to use the return data. This call will set the var
		
		// Utilities::render($this, 'view', $data, false, true);
		$this->renderPartial('view', $data, false, true);
    }
}
