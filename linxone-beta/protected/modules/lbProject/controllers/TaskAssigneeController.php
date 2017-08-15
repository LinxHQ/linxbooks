<?php

class TaskAssigneeController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('admin'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','update'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TaskAssignee;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TaskAssignee']))
		{
			$model->attributes=$_POST['TaskAssignee'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->task_assignee_id));
		}
		
		// this could be a bootstrap x-editable submission
		if(isset($_POST['ajax_id']) && $_POST['ajax_id'] == 'bootstrap-x-editable')
		{
			$success = true;
			$task_id = $_POST['pk'];
			$member_acc_ids = isset($_POST['value']) ? $_POST['value'] : array();
			
			// first delete all members
			if ($task_id > 0)
			{
				$members = TaskAssignee::model()->findAll(
						"task_id = :task_id",
						array('task_id' => $task_id));
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
				$member = new TaskAssignee;
				$member->task_id = $task_id;
				$member->account_id = $id;
				$member->task_assignee_start_date = date('Y-m-d H:i:s');
				if (!$member->save())
				{
					$success = false;
				}
			}
			return $success;
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TaskAssignee']))
		{
			$model->attributes=$_POST['TaskAssignee'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->task_assignee_id));
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('TaskAssignee');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TaskAssignee('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TaskAssignee']))
			$model->attributes=$_GET['TaskAssignee'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TaskAssignee the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TaskAssignee::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TaskAssignee $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='task-assignee-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
