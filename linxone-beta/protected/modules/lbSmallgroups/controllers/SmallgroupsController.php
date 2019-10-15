<?php

class SmallgroupsController extends Controller
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
				'actions'=>array('index','view', '_search_leader_name', '_search_location_name'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'deletePeopleSmallGroup'),
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
		$SmallGroupPeople = new LbSmallGroupPeople();

		if(isset($_POST['LbSmallGroupPeople']))
		{
			$SmallGroupPeople->attributes=$_POST['LbSmallGroupPeople'];
			$SmallGroupPeople->lb_small_group_id = $id;
			if($SmallGroupPeople->save())
				$this->redirect(array('smallgroups/view/id/'.$id));
		}
		
		LBApplication::render($this, 'view',array(
	    	'model'=>$this->loadModel($id),
	    	'model_small_group_people' => $SmallGroupPeople
	    ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LbSmallGroups;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LbSmallGroups']))
		{
			$model->attributes=$_POST['LbSmallGroups'];
			$model->lb_group_since = date("Y-m-d", strtotime($_POST['LbSmallGroups']['lb_group_since']));
			if($model->save())
				// $this->redirect(array('view','id'=>$model->lb_record_primary_key));
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

		if(isset($_POST['LbSmallGroups']))
		{
			$model->attributes=$_POST['LbSmallGroups'];
			$model->lb_group_since = date("Y-m-d", strtotime($_POST['LbSmallGroups']['lb_group_since']));
			if($model->save())
				// $this->redirect(array('view','id'=>$model->lb_record_primary_key));
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
		$dataProvider=new CActiveDataProvider('LbSmallGroups');
		LBApplication::render($this, 'index',array(
	    	'dataProvider'=>$dataProvider,
	    ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LbSmallGroups('search');
		$SmallGroupPeople = new LbSmallGroupPeople('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LbSmallGroups']))
			$model->attributes=$_GET['LbSmallGroups'];

		LBApplication::render($this, 'admin',array(
	    	'model'=>$model,
	    	'model_small_group_people' => $SmallGroupPeople
	    ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbSmallGroups the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LbSmallGroups::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbSmallGroups $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-small-groups-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDeletePeopleSmallGroup()
	{
		$small_group_people_id = $_REQUEST['small_group_people_id'];
		LbSmallGroupPeople::model()->deleteAll(array("condition"=>"lb_record_primary_key='$small_group_people_id'"));
	}
	public function action_search_leader_name(){
        $leader_name = $_REQUEST['leader_name'];
		$model=new LbSmallGroups('search');
		$SmallGroupPeople = new LbSmallGroupPeople('search');
		$model->unsetAttributes();  // clear any default values
		LBApplication::renderPartial($this, '_search_leader_name',array(
	    	'model'=>$model,
	    	'model_small_group_people' => $SmallGroupPeople,
	    	'leader_name'=>$leader_name,
	    ));
    }

    public function action_search_location_name(){
        $localtion_name = $_REQUEST['localtion_name'];
		$model=new LbSmallGroups('search');
		$SmallGroupPeople = new LbSmallGroupPeople('search');
		$model->unsetAttributes();  // clear any default values

		LBApplication::renderPartial($this, '_search_localtion_name',array(
	    	'model'=>$model,
	    	'model_small_group_people' => $SmallGroupPeople,
	    	'localtion_name'=>$localtion_name,
	    ));
		// $SmallGroupPeople = new LbSmallGroupPeople('search');
		// $model->unsetAttributes();  // clear any default values
		// LBApplication::renderPartial($this, '_search_leader_name',array(
	 //    	'model'=>$model,
	 //    	'model_small_group_people' => $SmallGroupPeople,
	 //    	'leader_name'=>$leader_name,
	 //    ));
    }
}
