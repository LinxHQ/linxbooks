<?php

class DefaultController extends CLBController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout= '//layouts/column1';
	const INDEX_DISPLAY_STYLE_TILE = 'tile';
	const INDEX_DISPLAY_STYLE_LIST = 'list';

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
				'actions'=>array('index','view', 'progress','overview', 'loadOverviewPanel','projectResourceReport'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'ajaxUpdateField','delete','listTaskProjectHeader','prototype', 'taskall', 'documentall', 'wikiall', 'projectall', 'indextask', 'loadDivAddMemberProject'),
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
        
        public function actionOverview($id)
        {
                $model = $this->loadModel($id);
		$ms_chart = isset($_GET['ms_chart']) ? $_GET['ms_chart'] : 0; // to show or hide milestone chart
                
		// check if we need to switch subscription
		if (isset($_GET['subscription']))
		{
			Utilities::setCurrentlySelectedSubscription($_GET['subscription']);
		}
		
		// check permission for viewing
		if (!Permission::checkPermission($model, PERMISSION_PROJECT_VIEW)
				|| !$model->matchedCurrentSubscription())
		{
			throw new CHttpException(404,'You do not have permission to this page.');
			return false;
		}
                
                // get project health number:
                $model->getProjectHealthZone();
                $project_health = array();
                $project_health['project_actual_progress'] = $model->project_completed;// TaskProgress::model()->getProjectActualProgress($id);
                $project_health['project_planned_progress'] = $model->project_planned;// TaskProgress::model()->getProjectPlannedProgress($id);
                $project_health['time_lapsed'] = $model->project_lapsed;// TaskProgress::model()->getProjectLapsed($id);
                
                $data = array(
                    'model'=>$model,
                    'project_health'=>$project_health,
                    'ms_chart'=>$ms_chart,
                );
                
                Utilities::render($this, '_overview', $data);
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
		
		// check permission for viewing
		if (!Permission::checkPermission($model, PERMISSION_PROJECT_VIEW)
				|| !$model->matchedCurrentSubscription())
		{
			throw new CHttpException(404,'You do not have permission to this page.');
			return false;
		}
		
		// get recent tasks
		//$recentTasksCActiveDataProvider = Task::model()->getRecentTasks($id);
		//$recentIssuesCActiveDataProvider = Issue::model()->getRecentIssues($id);
		$taskModel = new Task('search');
		$taskModel->unsetAttributes();
		if(isset($_GET['Task'])) 
		{
			$taskModel->attributes=$_GET['Task'];
		}
		$taskModel->project_id = $id;
		$taskModel->task_status = TASK_STATUS_ACTIVE;
				
		// prepare documents model for grid and search
		$documentModel = new Documents('getDocuments');
		$documentModel->unsetAttributes();
		if(isset($_GET['Documents'])) 
		{
			$documentModel->attributes=$_GET['Documents'];
			//echo $documentModel->document_real_name; return;
		}
		
		/* Get project members for x-editable widget */
		$project_members = ProjectMember::model()->getProjectMembers($id, true);
		$model->project_member = '';
		foreach ($project_members as $m)
		{
			if ($m->project_member_is_manager == PROJECT_MEMBER_IS_MANAGER)
			{
				$model->project_manager = $m->account_id;
				continue;
			}
			// $name = $m->member_account->account_profile->account_profile_preferred_display_name;
			$model->project_member .= $m->account_id . ', ';
		}

        // get wiki home page
        //$wikiHome = WikiPage::model()->getProjectWikiHome($model->project_id);
		
		$renderData = array(
					'model' => $model,
					'taskModel' => $taskModel,
					'documentModel' => $documentModel,
			);
		
		Utilities::render($this, 'view',$renderData, false, true);
	}
        
        public function actionLoadOverviewPanel($id)
        {
            $model = $this->loadModel($id);
            if ($model == null) return;
            
            // check if we need to switch subscription
            if (isset($_GET['subscription'])) {
                Utilities::setCurrentlySelectedSubscription($_GET['subscription']);
            }

            // check permission for viewing
            if (!Permission::checkPermission($model, PERMISSION_PROJECT_VIEW) || !$model->matchedCurrentSubscription()) {
                throw new CHttpException(404, 'You do not have permission to this page.');
                return false;
            }
            
            // get recent updates
            $notification = new Notification('search');
            $notification->notification_project_id = $model->project_id;
            $notification->notification_receivers_account_ids = Yii::app()->user->id;
            
            Utilities::render($this, '_overview_panel',array(
                'model' => $model,
                'notification' => $notification,
            ), false, true);
        }
	
	public function actionProgress()
	{
		$results = array();
		$outstanding_todos = array();
		
		// get active projects
		$active_projects = Project::getActiveProjects(Yii::app()->user->id, 'modelArray', true);
		if (count($active_projects) > 0)
		{
			// order them by latest activity date
			usort($active_projects, array("Project", "compareByLatestActivity"));
			
			// get most recently active project
			$most_recently_active_project = $active_projects[count($active_projects) - 1];
			$most_recent_date = $most_recently_active_project->project_latest_activity_date;
			$most_recent_date = date('Y-m-d', strtotime($most_recent_date)); // remove the time element
			
			// set viewing window to $most_recent_date - 7 days for first call
			// otherwise, start -7 days for subsequent lazy loading
			$viewing_window_end_date = strtotime("$most_recent_date - 15 days" );
			
			/**
			 * foreach date in viewing_window
					foreach project of user
						get all tasks, issues and implementations with activities in this date of this project
						if any activity took place in this date of this project
							day[this date][this project]	= [issues ...], [tasks...], [implementations...]
						endif
					endfor loop for projects
				endfor loop through viewing_window
			 */
			$date_counter = strtotime($most_recent_date);
			while($date_counter >= $viewing_window_end_date)
			{
				$date_str = date('Y-m-d', $date_counter);
				
				foreach ($active_projects as $project)
				{					
					// get task comments on this day
					$task_comments = TaskComment::model()->getTaskCommentsByProjectAndDate($project->project_id, $date_str);
					// get issue comments on this day
					$issue_comments = IssueComment::model()->getIssueCommentsByProjectAndDate($project->project_id, $date_str);
					// get implementation comments on this day 
					$impl_comments = array();
					
					// if there's any activity at all
					// this project should appear in this date entry
					if ($task_comments || $issue_comments || $impl_comments)
					{
						// arrray init
						if (!isset($results[$date_str]))
							$results[$date_str] = array();
						// array init
						if (!isset($results[$date_str][$project->project_id]))
							$results[$date_str][$project->project_id] = array();
						
						$results[$date_str][$project->project_id]['project'] = $project;
						
						// TASK ACTIVITIES
						if ($task_comments)
						{
							// check permission
							$task_comments_final = array();
							foreach ($task_comments as $comment)
							{
								$task = Task::model()->findByPk($comment->task_id);
								if (!Permission::checkPermission($task, PERMISSION_TASK_VIEW))
									continue;
								$task_comments_final[] = $comment;
							}
							// put data
							$results[$date_str][$project->project_id]['task_comments'] = $task_comments_final;
						}
						
						// ISSUE ACTIVITIES
						if ($issue_comments)
						{
							// check permission
							$issue_comments_final = array();
							foreach ($issue_comments as $comment)
							{
								$issue = Issue::model()->findByPk($comment->issue_id);
								if (!Permission::checkPermission($issue, PERMISSION_ISSUE_VIEW))
									continue;
								$issue_comments_final[] = $comment;
							}
							// put data
							$results[$date_str][$project->project_id]['issue_comments'] = $issue_comments_final;
						}
					}
				}
				
				// minus 1 day
				$date_counter -= 60*60*24*1;
			}// end loop for org data into date window	
			
			/**
			 * GET outstanding todos
			 * 
			 */
			foreach ($active_projects as $project)
			{
				$user_tasks = Task::model()->getAccountTasks(Yii::app()->user->id, $project->project_id, TASK_STATUS_ACTIVE, 'modelArray') + 
						Task::model()->getAccountTasks(Yii::app()->user->id, $project->project_id, TASK_STATUS_COMPLETED, 'modelArray');
				// for each task, get todos
				foreach ($user_tasks as $u_task)
				{
					$task_todos = TaskComment::model()->getTodos($u_task->task_id);
					if (count($task_todos))
					{
						$outstanding_todos += $task_todos;
					}
				}// end for looping user tasks to get todos
			}
			// end get getting todos
		} // end active projects if
		
		$renderData = array(
			'results' => $results,
			'outstanding_todos'=>$outstanding_todos,
		);
		
		Utilities::render($this, 'progress',$renderData, false, true);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Project;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Project']))
		{
			$today = date("Y-m-d H:i:s");
			$model->attributes=$_POST['Project'];
			$model->project_latest_activity_date = $today;

			
			// after saving project successfully, let user add member(s) to project
			if($model->save())
				$this->redirect(array('projectMember/create',
						'project_id' => $model->project_id));
				//$this->redirect(array('view','id'=>$model->project_id));
		}

		// show create form
		// because this is a new project, we need to put in the subscription id of current user 
		// for permission checking
		$thisSubscription = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id, true);
		reset($thisSubscription);
		$model->account_subscription_id = key($thisSubscription);
		Utilities::render($this, 'create',array(
					'model'=>$model,
			), false, true);
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

		if(isset($_POST['Project']))
		{
			$model->attributes=$_POST['Project'];
			if($model->save())
				//$this->redirect(array('view','id'=>$model->project_id));
				$this->redirect($model->getProjectURL());
		}

		Utilities::render($this, 'update',array(
					'model'=>$model,
			));
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
		$delete_project = Project::model()->deleteAll(array("condition"=>"project_id='$id'"));
		if ($delete_project)
		{
			echo SUCCESS;
			return;
		}
		
		echo FAILURE;
		return;

		// $model = $this->loadModel($id);
		
		// if ($model->delete())
		// {
		// 	echo SUCCESS;
		// 	return;
		// }
		
		// echo FAILURE;
		// return;
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// check if we need to switch subscription
		if (isset($_GET['subscription']))
		{
			Utilities::setCurrentlySelectedSubscription($_GET['subscription']);
		}
		
		// get display style
		if (isset($_GET['display']))
		{
			$display = $_GET['display'];
		} else {
			// Any mobile device (phones or tablets).
			if ( Utilities::mobileViewRequested()
					|| Utilities::isMobile() ) {
				$display = $this::INDEX_DISPLAY_STYLE_LIST;
			} else {
				$display = $this::INDEX_DISPLAY_STYLE_TILE;
			}
		}
		$params = array('display_style' => $display);
		
		// different data storage for diff kind of styles
		if ($display == $this::INDEX_DISPLAY_STYLE_LIST)
		{
			$dataProvider=Project::getActiveProjects(Yii::app()->user->id, 'dataProvider', true, true);
			$params['dataProvider'] = $dataProvider;
		} else {
			$active_projects = Project::getActiveProjects(Yii::app()->user->id, 'modelArray', true, true);
			$params['active_projects'] = $active_projects;
			// order them by latest activity date
			//usort($active_projects, array("Project", "compareByLatestActivity"));
		}
		//$dataProvider=new CActiveDataProvider('Project');
		
		// get archived projects
		$archived_projects = Project::model()->getArchivedProjects(Yii::app()->user->id, 'modelArray', true);
		$params['archived_projects'] = $archived_projects;
                
                // sort options if available
                $params['sort'] = isset($_GET['sort']) ? $_GET['sort'] : 1;
		
		Utilities::render($this, 'index', $params, false, true);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Project('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Project']))
			$model->attributes=$_GET['Project'];

		Utilities::render($this, 'admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Project the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Project::model()->findByPk($id);
		
		// check permission for viewing
		if (!Permission::checkPermission($model, PERMISSION_PROJECT_VIEW))
		{
			throw new CHttpException(404,'You do not have permission to this page.');
			return null;
		}
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Project $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionProjectResourceReport()
        {
            $project_id = $_GET['project_id'];
            
            // get list of tasks and issues done by this user
            $project_tasks = Task::model()->getProjectTasksEstimate($project_id,0);
            $project = Project::model()->findByPk($project_id);
            $project_hight = strip_tags(Project::model()->getPriorityLabel($project->project_priority));
            $project_member = ProjectMember::model()->getProjectMembers($project_id)->totalItemCount;
            
            $total_est = 0;$total_complate=0;
            foreach ($project_tasks->data as $tasks) {
                $total_est += TaskResourcePlan::model()->getTotalPlanTask($tasks->task_id);
                $total_complate += TaskProgress::model()->getTotalActualTask($tasks->task_id);
            }
            
            Utilities::render($this, '_export_resource_report', array(
                'final_tasks' => $project_tasks,
                'project_name' => $project->project_name,
                'project_hight'=>$project_hight,
                'project_member'=>$project_member,
                'total_est'=>$total_est,
                'total_complate'=>$total_complate,
            ));
        }
        
        /**
         *
         * @param type $id
         * @param type $task_type
         */
        function actionListTaskProjectHeader($id)
        {
            $taskModel = new Task('search');
            $taskModel->unsetAttributes();
            if(isset($_POST['WordSearch'])) 
            {
                if(intval($_POST['WordSearch'])>0)
                    $taskModel->task_no=$_POST['WordSearch'];
                else 
                    $taskModel->task_name=$_POST['WordSearch'];
            }
            $task_type = "all";
            if(isset($_POST['task_type'])) 
            {
                $task_type=$_POST['task_type'];
            }
            $taskModel->project_id = $id;
            $taskModel->task_status = TASK_STATUS_ACTIVE;
            $page = false;
            Utilities::render($this, '_list_task_header', array(
                'taskModel'=>$taskModel->search('task_created_date DESC',$page, $task_type),
            ));
        }
        
        function actionPrototype()
        {
            Utilities::render($this, 'prototype',array());
        }
        function actionTaskall(){
        	$taskModel = new Task();
        	Utilities::renderPartial($this, 'task_all',array(
				'taskModel'=>$taskModel,
			));
        }
        function actionDocumentall(){
        	$documentModel = new Documents();
        	Utilities::renderPartial($this, 'document_all',array(
				'documentModel'=>$documentModel,
			));
        }
        function actionWikiall(){
        	$wikiModel = new WikiPage();
        	Utilities::renderPartial($this, 'wiki_all',array(
				'wikiModel'=>$wikiModel,
			));
        }
        function actionProjectall(){
        	Utilities::renderPartial($this, 'project_all',array());
        }
}
