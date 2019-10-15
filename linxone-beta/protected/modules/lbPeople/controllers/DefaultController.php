<?php

class DefaultController extends CLBController
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'detailPeople', 'create','delete','update','_search_info_people', 'delete_relationship', 'delete_membership'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex() {
		$model=new LbPeople;
		LBApplication::render($this, 'index',array(
			'model'=>$model,
		));
	}

	public function actionDetailPeople($id) {
		$model=new LbPeople;
		$model_relationships=new LbPeopleRelationships;
		$model_membership=new LbPeopleMemberships;
		if(isset($_POST['LbPeopleMemberships'])) {
			// save membership
			$model_membership->attributes=$_POST['LbPeopleMemberships'];
			$model_membership->lb_people_id = $id;
			$model_membership->lb_membership_start_date = date('Y-m-d', strtotime($_POST['LbPeopleMemberships']['lb_membership_start_date']));
			$model_membership->lb_membership_end_date = date('Y-m-d', strtotime($_POST['LbPeopleMemberships']['lb_membership_end_date']));
			if($model_membership->save()) {
				// save xong thi redirect ve trang detail people
				$this->redirect(array('default/detailPeople/id/'.$id));
			}
		}

		if(isset($_POST['LbPeopleRelationships'])) {
			// save relationship
			$model_relationships->lb_people_id = $id;
	        $model_relationships->lb_people_relationship_id = $_POST['LbPeopleRelationships']['lb_people_id'];
	        $model_relationships->lb_people_relationship_type = $_POST['LbPeopleRelationships']['lb_people_relationship_id'];
	        if($model_relationships->save())
            	$this->redirect(array('default/detailPeople/id/'.$id));
		}
		LBApplication::render($this, 'detail_people',array(
			'people_id' => $id,
			'model'=>$model,
			'model_membership'=>$model_membership,
			'model_relationships'=>$model_relationships,
		));
	}

	public function actionCreate() {
	    $model=new LbPeople;

	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='lb-people-create-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    */

	    if(isset($_POST['LbPeople']))
	    {
	        $model->attributes=$_POST['LbPeople'];
	        if($model->validate())
	        {
	        	$model->lb_birthday = date('Y-m-d', strtotime($_POST['LbPeople']['lb_birthday']));
	        	$model->lb_baptism_date = date('Y-m-d', strtotime($_POST['LbPeople']['lb_baptism_date']));
	            // form inputs are valid, do something here
	            if($model->save())
            		$this->redirect(array('index'));
	        }
	    }
	    LBApplication::render($this, 'create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		// echo $id;
		$model=$this->loadModel($id);

		if(isset($_POST['LbPeople']))
	    {
	        $model->attributes=$_POST['LbPeople'];
	        if($model->validate())
	        {
	        	$model->lb_birthday = date('Y-m-d', strtotime($_POST['LbPeople']['lb_birthday']));
	        	$model->lb_baptism_date = date('Y-m-d', strtotime($_POST['LbPeople']['lb_baptism_date']));
	            // form inputs are valid, do something here
	            if($model->save())
            		$this->redirect(array('index'));
	        }
	    }

		LBApplication::render($this, 'update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id) {
		// $this->loadModel($id)->delete();

		$check_delete = true;
		$volunteers_stage = LbPeopleVolunteersStage::model()->findAll('lb_people_id IN ('.$id.')');
        $small_group_people = LbSmallGroupPeople::model()->findAll('lb_people_id IN ('.$id.')');
		$pastoral_care = LbPastoralCare::model()->findAll('lb_people_id IN ('.$id.')');

        foreach ($volunteers_stage as $result_volunteers_stage) {
            $volunteers_id[] = $result_volunteers_stage->lb_volunteers_id;
        }

		if(count($volunteers_stage) > 0) {

            LbPeopleVolunteersStage::model()->deleteAll(array("condition"=>"lb_people_id='$id'"));
            foreach ($volunteers_id as $lb_record_primary_key){
                LbPeopleVolunteers::model()->deleteAll(array("condition"=>"lb_record_primary_key='$lb_record_primary_key'"));

            }

			// return;
		}

		if(count($small_group_people) > 0) {
//			$check_delete = false;
            LbSmallGroupPeople::model()->deleteAll(array("condition"=>"lb_people_id='$id'"));

			// return;
		}
		if(count($pastoral_care) > 0) {
//			$check_delete = false;
            LbPastoralCare::model()->deleteAll(array("condition"=>"lb_people_id='$id'"));
//            $check_delete =1;
			// return;
		}
		if($check_delete == ""){
			// echo "no"; exit;
		}
		if($check_delete == 1){
//			 echo "yes"; exit;
			LbPeople::model()->deleteAll(array("condition"=>"lb_record_primary_key='$id'"));
			LbPeopleRelationships::model()->deleteAll(array("condition"=>"lb_people_id='$id'"));
			LbPeopleMemberships::model()->deleteAll(array("condition"=>"lb_people_id='$id'"));
			LbDocument::model()->deleteAll("lb_document_parent_id=".$id."", "lb_document_parent_type='lbPeople'");

		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function action_search_info_people()
	{
		$model=new LbPeople;
		$info_people = $_REQUEST['info_people'];
		LBApplication::renderPartial($this, '_search_info_people',array(
			'model'=>$model,
			'info_people'=>$info_people,
		));
	}

	public function loadModel($id)
	{
		$model=LbPeople::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	function actionDelete_relationship($id_relation, $id_people) {
		$model=LbPeopleRelationships::model()->findByPk($id_relation);
		if($model->delete()){
			// delete relationship
			$this->redirect(array('default/detailPeople/id/'.$id_people));
		}
	}
	function actionDelete_membership($id_membership, $id_people) {
		$model=LbPeopleMemberships::model()->findByPk($id_membership);
		if($model->delete()){
			// delete relationship
			$this->redirect(array('default/detailPeople/id/'.$id_people));
		}
	}
}