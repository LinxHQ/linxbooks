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
				'actions'=>array('index', 'create', 'delete_pastoralcare', 'update'),
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
	public function actionIndex()
	{
		$model=new LbPastoralCare;
		LBApplication::render($this, 'index',array(
	    	'model'=>$model
	    ));
	}

	public function actionCreate() {
	    $model=new LbPastoralCare;

	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='lb-pastoral-care-create-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    */

	    if(isset($_POST['LbPastoralCare']))
	    {
	        $model->attributes=$_POST['LbPastoralCare'];
	        if($model->validate())
	        {
	        	$model->lb_pastoral_care_date = date("Y-m-d H:i:s", strtotime($_POST['LbPastoralCare']['lb_pastoral_care_date']));
	            if($model->save()){
            		$this->redirect(array('index'));
            	}
	        }
	    }
	    LBApplication::render($this, 'create',array(
	    	'model'=>$model
	    ));
	}

	public function actionUpdate($id)
	{
		$model=new LbPastoralCare;
		LBApplication::render($this, 'update',array(
	    	'model'=>$model
	    ));
	}

	public function actionDelete_pastoralcare() {
		$pastoralcare_id = $_REQUEST['pastoralcare_id'];
		LbPastoralCare::model()->deleteAll(array("condition"=>"lb_record_primary_key='$pastoralcare_id'"));
	}
}