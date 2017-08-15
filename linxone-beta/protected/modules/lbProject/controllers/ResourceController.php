<?php

class ResourceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','go'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('@'),
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
		// check permission
		if (!Permission::checkPermission($model, Permission::PERMISSION_RESOURCE_LINK_VIEW))
		{
			throw new CHttpException(401,'You are not given the permission to view this page.');
			return;
		}
		
		$this->render('view',array(
			'model'=>$model,
		));
	}
	
	public function actionGo()
	{
		$url = $_GET['url'];
		Yii::app()->request->redirect('http://'.urldecode($url));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$project_id = isset($_GET['project_id']) ? $_GET['project_id'] : 0;
		$model=new Resource;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Resource']))
		{
			$model->attributes=$_POST['Resource'];
			if($model->save())
			{	
				// Assign to list(s)?
				if ($model->resource_assigned_lists)
				{
					$resource_assigned_lists_ids = explode(',', $model->resource_assigned_lists);
					foreach ($resource_assigned_lists_ids as $user_list_id)
					{				
						$user_list_id = trim($user_list_id);
						// add to user list
						$userList = new ResourceAssignedList();
						$userList->resource_id = $model->resource_id;
						$userList->resource_user_list_id = $user_list_id;
						$userList->save();
					}
				}
				
				// redirect to project page is this is added from project view
				if ($model->project_id)
					$this->redirect(Project::model()->getProjectURL($model->project_id, array('tab'=>'lists')));
				//$this->redirect(array('view','id'=>$model->resource_id));
				$this->redirect(Utilities::getAppLinkiWikiLinks());
			}
		}

		/**
		$this->render('create',array(
			'model'=>$model,
		));**/
		Utilities::render($this, 'create', array(
			'model'=>$model,
			'project_id'=>$project_id,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$project_id = isset($_GET['project_id']) ? $_GET['project_id'] : 0;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Resource']))
		{
			$model->attributes=$_POST['Resource'];
			if($model->save())
			{
				// Assign to list(s)?
				if ($model->resource_assigned_lists)
				{
					// delete all previous assignment
					ResourceAssignedList::model()->deleteAllAssignment($id);
					$resource_assigned_lists_ids = explode(',', $model->resource_assigned_lists);
					foreach ($resource_assigned_lists_ids as $user_list_id)
					{
						$user_list_id = trim($user_list_id);
						// add to user list
						$userList = new ResourceAssignedList();
						$userList->resource_id = $model->resource_id;
						$userList->resource_user_list_id = $user_list_id;
						$userList->save();
					}
				}
				
				//$this->redirect(array('view','id'=>$model->resource_id));
				$this->redirect(Utilities::getAppLinkiWikiLinks());
			}
		}

		/**
		$this->render('update',array(
			'model'=>$model,
		));**/
		Utilities::render($this, 'update', array(
			'model'=>$model,
			'project_id'=>$project_id,
		));
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
		$dataProvider=new CActiveDataProvider('Resource');
		$data = array(
			'dataProvider'=>$dataProvider,
		);
		/**
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));**/
		Utilities::render($this, 'index', $data);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Resource('search');
		$model->unsetAttributes();  // clear any default values
		$model->account_subscription_id = Utilities::getCurrentlySelectedSubscription();// currenly sub only
		
		if (isset($_GET['project_id']) && $_GET['project_id']>0)
		{
			$model->project_id = $_GET['project_id'];
		}
		
		if(isset($_GET['Resource']))
			$model->attributes=$_GET['Resource'];

		/**
		$this->render('admin',array(
			'model'=>$model,
		));**/
		Utilities::render($this,'admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Resource the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Resource::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		// get assigned list
		$user_lists = ResourceAssignedList::model()->getAssignedList($model->resource_id,true);
		$model->resource_assigned_lists = '';
		foreach ($user_lists as $l_)
		{
			$model->resource_assigned_lists .= $l_->resource_user_list_id . ',';
		}
		$model->resource_assigned_lists = substr($model->resource_assigned_lists, 0,-1);
		
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Resource $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='resource-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
