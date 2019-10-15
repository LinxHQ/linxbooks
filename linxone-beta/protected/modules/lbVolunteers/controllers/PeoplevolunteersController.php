<?php

class PeoplevolunteersController extends Controller
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
			// ),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create', 'update', 'admin', 'delete', '_search_volunteers_name', 'updateVolunteerPeople', 'deletevolunteer', 'load_volunteer'),
				'users'=>array('@'),
			),
			// ko cho phep truy cap vao module Opp khi chua login
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
		$model_state=new LbPeopleVolunteersStage;
		if(isset($_POST['LbPeopleVolunteersStage'])) {
			$model_state->attributes=$_POST['LbPeopleVolunteersStage'];
			$model_state->lb_volunteers_id = $_POST['volunteers_id'];
			$model_state->lb_people_id = $_POST['people_id'];
			$model_state->save();
		}
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
		$model=new LbPeopleVolunteers;
		$model_state=new LbPeopleVolunteersStage;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LbPeopleVolunteers']))
		{
			$model->attributes=$_POST['LbPeopleVolunteers'];
			$model->lb_entity_type = "smallgroup";
			$model->save();
			$volunteers_id = $model->getPrimaryKey(); // id of volunteer after save;

			$model_state->attributes=$_POST['LbPeopleVolunteersStage'];
			$model_state->lb_volunteers_start_date = date("Y-m-d", strtotime($_POST['LbPeopleVolunteersStage']['lb_volunteers_start_date']));
			$model_state->lb_volunteers_end_date = date("Y-m-d", strtotime($_POST['LbPeopleVolunteersStage']['lb_volunteers_end_date']));
			$model_state->lb_volunteers_id = $volunteers_id;
			if($model_state->save()){
				$this->redirect(array('admin'));
			}
				
		}
		LBApplication::render($this, 'create',array(
	    	'model'=>$model,
	    	'model_state'=>$model_state,
	    ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model_state=$this->loadModel($id);
		$model_state=new LbPeopleVolunteersStage;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LbPeopleVolunteers']))
		{
			$model->attributes=$_POST['LbPeopleVolunteers'];
			$model->lb_volunteers_start_date = date("Y-m-d", strtotime($_POST['LbPeopleVolunteers']['lb_volunteers_start_date']));
			$model->lb_volunteers_end_date = date("Y-m-d", strtotime($_POST['LbPeopleVolunteers']['lb_volunteers_end_date']));
			if($model->save())
				// $this->redirect(array('view','id'=>$model->lb_record_primary_key));
				$this->redirect(array('admin'));
		}

		LBApplication::render($this, 'update',array(
	    	'model'=>$model,
	    	'model_state'=>$model_state,
	    ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// $this->loadModel($id)->delete();
		LbPeopleVolunteers::model()->deleteAll(array("condition"=>"lb_record_primary_key='$id'"));
		LbPeopleVolunteersStage::model()->deleteAll(array("condition"=>"lb_volunteers_id='$id'"));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LbPeopleVolunteers');
		LBApplication::render($this, 'index',array(
	    	'dataProvider'=>$dataProvider,
	    ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LbPeopleVolunteers('search');
		// $model->unsetAttributes();  // clear any default values
		// if(isset($_GET['LbPeopleVolunteers']))
		// 	$model->attributes=$_GET['LbPeopleVolunteers'];
		LBApplication::render($this, 'admin',array(
	    	'model'=>$model,
	    ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbPeopleVolunteers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		// $criteria=new CDbCriteria;
  //       $criteria->condition = '`t`.`lb_record_primary_key`='.$id;
  //       $criteria->join= 'LEFT JOIN `lb_people_volunteers` ON `t`.`lb_volunteers_id` = `lb_people_volunteers`.`lb_record_primary_key`';
  //       $model = LbPeopleVolunteersStage::model()->findAll($criteria);
		$model=LbPeopleVolunteersStage::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbPeopleVolunteers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-people-volunteers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function action_search_volunteers_name()
	{
		$volunteer_people_name = $_REQUEST['volunteer_people_name'];
		$model=new LbPeopleVolunteersStage('search');
		LBApplication::renderPartial($this, '_search_volunteers_name',array(
	    	'model'=>$model,
	    	'volunteer_people_name'=>$volunteer_people_name,
	    ));
	}

	public function actionUpdateVolunteerPeople()
	{
		if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id_volunteer = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			$VolunteersStage=LbPeopleVolunteersStage::model()->findByPk($id_volunteer);
			$VolunteersStage->lb_people_id=$value;
			$VolunteersStage->update();
			return true;
		}
	
		return false;
	}
	public function actionDeletevolunteer()
	{
		$id_volunteers_stage = $_REQUEST['id_volunteers_stage'];
		// $volunteers_id = $_REQUEST['volunteers_id'];
		LbPeopleVolunteersStage::model()->deleteAll(array("condition"=>"lb_record_primary_key='$id_volunteers_stage'"));
	}
	public function actionLoad_volunteer()
	{
		$volunteers_id = $_REQUEST['volunteers_id'];
		LBApplication::renderPartial($this, 'load_volunteer',array(
	    	'volunteers_id'=>$volunteers_id,
	    ));
	}
}
