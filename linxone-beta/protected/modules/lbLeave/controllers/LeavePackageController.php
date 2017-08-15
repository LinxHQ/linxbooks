<?php

class LeavePackageController extends CLBController
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
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','FormCreatePackage','delete','DeleteAll'),
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
		$model=new LeavePackage;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LeavePackage']))
		{
			$model->attributes=$_POST['LeavePackage'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->leave_package_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionFormCreatePackage()
	{
		$model=new LeavePackage;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LeavePackage']))
		{
			$model->attributes=$_POST['LeavePackage'];
			if($model->save())
				$this->redirect(Yii::app()->createUrl('/lbLeave/default/index'));
		}

		$this->renderPartial('create',array(
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

		if(isset($_POST['LeavePackage']))
		{
			$model->attributes=$_POST['LeavePackage'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->leave_package_id));
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

	public function actionDeleteAll()
	{
		$id = $_POST['id'];
		$deletePackage = $this->loadModel($id)->delete();
		$delete = LeavePackageItem::model()->deleteAll("item_leave_package_id = ".$id );

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if($delete )
			echo 'success';
		else
			echo 'fail';
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LeavePackage');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LeavePackage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LeavePackage']))
			$model->attributes=$_GET['LeavePackage'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LeavePackage the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LeavePackage::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LeavePackage $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='leave-package-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	
}
