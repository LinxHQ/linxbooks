<?php

class ProjectMemberController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
				'actions'=>array( 'dropdownSource'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','createMultiple', 'ajaxUpdateProjectManager'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','admin','delete','update'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Update project members (NOT Project Manager). For ProjectManager see actionAjaxUpdateProjectManager
	 * 
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ProjectMember;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProjectMember']))
		{
			$model->attributes=$_POST['ProjectMember'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->project_member_id));
		}
		
		// this could be a bootstrap x-editable submission
		if(isset($_POST['id']) && $_POST['id'] == 'bootstrap-x-editable')
		{
			$success = true;
			$project_id = $_POST['pk'];
			$member_acc_ids =  isset($_POST['value']) ? $_POST['value'] : array();
			
			// Some filter
			// those no longer in, delete
			// those no change, remove from sbumission list
			// those new, do nothing, add in later.
			if ($project_id > 0)
			{
				// find all NON-ProjectManager members
				$members = ProjectMember::model()->findAll(
							"project_id = :project_id AND (project_member_is_manager = 0 OR project_member_is_manager is NULL)",
							array('project_id' => $project_id));
				foreach ($members as $member) 
				{
					// delete if not in submitted list
					if (!in_array($member->account_id, $member_acc_ids))
						$member->delete();
					else {
					// if in submitted list, remove from list so that we don't re-add
						if(($key = array_search($member->account_id, $member_acc_ids)) !== FALSE) {
							unset($member_acc_ids[$key]);
						}
					}
				}
			}
			
			// add new members in the submitted list
			foreach ($member_acc_ids as $key => $id)
			{
				$member = new ProjectMember;
				$member->project_id = $project_id;
				$member->account_id = $id;
				$member->project_member_start_date = date('Y-m-d H:i:s');
				if (!$member->save())
				{
					$success = false;
				}				
			}
			return $success;
		}

		$render_data = array(
			'model'=>$model,
			'project_id' => (isset($_GET['project_id']) ? $_GET['project_id'] : 0),
		);
		Utilities::render($this, 'create', $render_data);
		/**
		$this->render('create',array(
			'model'=>$model,
			'project_id' => (isset($_GET['project_id']) ? $_GET['project_id'] : 0),
		));**/
	}
	


	/**
	 * Creates multiple new model.
	 * If creation is successful, the browser will be redirected to the respective project's 'view' page.
	 */
	public function actionCreateMultiple()
	{	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model = new ProjectMember();
		if(isset($_POST['ProjectMember']))
		{
			$model->attributes=$_POST['ProjectMember'];
			
			// invalid submission
			if ($model->project_id <= 0)
			{
				$this->redirect(array(Utilities::getCurrentlySelectedSubscription() . "/"));
				//$this->redirect(array('project/index'));
			}
			
			// add manager if any
			$manager = new ProjectMember();
			if($model->manager)
			{
				$manager->project_id = $model->project_id;
				$manager->account_id = $model->manager;
				$manager->project_member_start_date = date('Y-m-d H:i:s');
				$manager->project_member_is_manager = PROJECT_MEMBER_IS_MANAGER;
				$manager->save();
			}
			
			// add members if any
			if (is_array($model->members_array) && sizeof($model->members_array) > 0)
			{
				foreach($model->members_array as $mem_acc_id)
				{
					// if this account is the same as manager, skip
					if ($mem_acc_id == $manager->account_id)
						continue;
					
					$member = new ProjectMember();
					$member->project_id = $model->project_id;
					$member->account_id = $mem_acc_id;
					$member->project_member_start_date = date('Y-m-d H:i:s');
					$member->project_member_is_manager = PROJECT_MEMBER_IS_NOT_MANAGER;
					$member->save();
				}
			}
			
			// go to project's page
			//$this->redirect(array('project/view','id'=>$model->project_id));
			$this->redirect(Project::model()->getProjectURL($model->project_id));
		}
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

		if(isset($_POST['ProjectMember']))
		{
			$model->attributes=$_POST['ProjectMember'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->project_member_id));
		}

		$this->render('update',array(
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
	 * value value to be updated to, in this case it's account id of member to be assigned as project manager
	 * 
	 * @param integer	$id projectmember record id
	 */
	public function actionAjaxUpdateProjectManager($id)
	{
		$project_id = $_GET['project_id'];
		$project = Project::model()->findByPk($project_id);
		if (!Permission::checkPermission($project, PERMISSION_PROJECT_UPDATE_MANAGER))
		{
			return false;
		}
		
		if ($id == 0)
		{
			// add new project manager if not yet one exists
			
			$pm = new ProjectMember();
			$pm->project_id = $project_id;
			$pm->project_member_start_date = date('Y-m-d H:i:s');
			$pm->project_member_is_manager = PROJECT_MEMBER_IS_MANAGER;
		} else {
			// update existing one
			$pm = $this->loadModel($id);
		}		
		
		if ($pm && isset($_POST['value']))
		{
			$pm->account_id = $_POST['value'];
		
			// save project manager
			// if this PM exists as normal member, alert, and do not save
			$member = ProjectMember::model()->find('account_id = :account_id AND project_id = :project_id
					 AND (project_member_is_manager is NULL OR  project_member_is_manager = ' . PROJECT_MEMBER_IS_NOT_MANAGER . ')',
					array(':account_id' => $pm->account_id, ':project_id' => $project_id));
			if ($member && $member->project_member_id > 0)
			{
				echo 'This pserson is already assigned as a normal project member. Please remove him/her from Project Memebrs list first.';
				throw new CHttpException(404,'This pserson is already assigned as a normal project member. Please remove him/her from Project Memebrs list first.');
				return false;
			}
			return $pm->save();
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ProjectMember');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ProjectMember('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ProjectMember']))
			$model->attributes=$_GET['ProjectMember'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Return json data source for ajax listing
	 * json format: [{value: 1, text: "text1"}, {value: 2, text: "text2"}, ...]
	 */
	public function actionDropdownSource($id)
	{
		$project_members = ProjectMember::model()->getProjectMembers($id, true);
		$dd_array = array();
		foreach ($project_members as $m)
		{
			$name= AccountProfile::model()->getShortFullName($m->member_account->account_id);
			$name = Utilities::encodeToUTF8($name);
			$dd_array[] = array('value' => $m->member_account->account_id,
						'text' => $name);//, $m->member_account->account_profile->account_profile_preferred_display_name);
		}
		echo CJSON::encode($dd_array);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ProjectMember the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ProjectMember::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ProjectMember $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-member-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
