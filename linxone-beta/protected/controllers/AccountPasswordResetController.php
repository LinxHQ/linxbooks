<?php

class AccountPasswordResetController extends Controller
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
				'actions'=>array('index','view','update'),
				'users'=>array('admin'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'reset'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new AccountPasswordReset;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccountPasswordReset']))
		{
			$model->attributes=$_POST['AccountPasswordReset'];
			
			if($model->save()){
				$this->render('success');
				return;
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	/**
	 * action to reset password
	 */
	public function actionReset()
	{		
		if (isset($_GET['email']) && isset($_GET['key']))
		{
			$model = AccountPasswordReset::model()->findByRandomKey($_GET['email'], $_GET['key']);
			if ($model != null)
			{
				$model->account_email = $_GET['email'];
				
				// check if this is a correct reset request
				if ($model->isExpired())
				{
					echo 'Link expired.';
					return;
				}
				
				if (isset($_POST['AccountPasswordReset']))
				{
					//$model = new AccountPasswordReset;
					$model->attributes=$_POST['AccountPasswordReset'];
						
					if($model->reset()){
						$this->render('success', array('type' => 'password'));
						return;
					}
				}
		
				// show form				
				$this->render('reset',array(
					'model'=>$model,
				));
			}
		}
		
		echo 'Wrong password reset link.';
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

		if(isset($_POST['AccountPasswordReset']))
		{
			$model->attributes=$_POST['AccountPasswordReset'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->account_password_reset_id));
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
		$dataProvider=new CActiveDataProvider('AccountPasswordReset');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AccountPasswordReset('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AccountPasswordReset']))
			$model->attributes=$_GET['AccountPasswordReset'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AccountPasswordReset the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AccountPasswordReset::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AccountPasswordReset $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-password-reset-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
