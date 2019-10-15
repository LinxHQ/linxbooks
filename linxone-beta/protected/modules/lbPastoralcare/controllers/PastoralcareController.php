<?php

class PastoralcareController extends Controller
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
				'actions'=>array('index','view','_search_people_name_pc', '_search_date_time_pc'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
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
		LBApplication::render($this, 'view',array(
	    	'model'=>$this->loadModel($id),
	    ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LbPastoralCare;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LbPastoralCare']))
		{
			$model->attributes=$_POST['LbPastoralCare'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		LBApplication::render($this, 'create',array(
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

		if(isset($_POST['LbPastoralCare']))
		{
			$model->attributes=$_POST['LbPastoralCare'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		LBApplication::render($this, 'update',array(
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
		$dataProvider=new CActiveDataProvider('LbPastoralCare');
		LBApplication::render($this, 'index',array(
	    	'dataProvider'=>$dataProvider,
	    ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LbPastoralCare('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LbPastoralCare']))
			$model->attributes=$_GET['LbPastoralCare'];

		LBApplication::render($this, 'admin',array(
	    	'model'=>$model
	    ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbPastoralCare the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LbPastoralCare::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbPastoralCare $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-pastoral-care-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function action_search_people_name_pc()
	{
		$people_name_pc = $_REQUEST['people_name_pc'];
		$model=new LbPastoralCare();
		$model->unsetAttributes();  // clear any default values
		LBApplication::renderPartial($this, '_search_people_name_pc',array(
	    	'model'=>$model,
	    	'people_name_pc'=>$people_name_pc,
	    ));
	}

	public function action_search_date_time_pc()
	{
		
		$date_time_pc = date("Y-m-d G:i:s", strtotime($_REQUEST['dates']));
		// echo $date; exit;
		$model=new LbPastoralCare();
		$model->unsetAttributes();  // clear any default values
		LBApplication::renderPartial($this, '_search_date_time_pc',array(
	    	'model'=>$model,
	    	'date_time_pc'=>$date_time_pc,
	    ));
	}
}
