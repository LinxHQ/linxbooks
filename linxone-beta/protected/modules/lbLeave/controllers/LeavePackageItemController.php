<?php

class LeavePackageItemController extends CLBController
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
				'actions'=>array('create','update','FormCreatePackageItem','AddPackageItem','SearchLeavePackageItem','AjaxUpdateField','delete','DeletePackageItem'),
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
		$model=new LeavePackageItem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LeavePackageItem']))
		{
			$model->attributes=$_POST['LeavePackageItem'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->item_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionFormCreatePackageItem()
	{
		$model=new LeavePackageItem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LeavePackageItem']))
		{
			$model->attributes=$_POST['LeavePackageItem'];
			if($model->save())
				$this->redirect(Yii::app()->createUrl('/lbLeave/default/index'));
		}

		$this->renderPartial('create',array(
			'model'=>$model,
		));
	}

	public function actionAddPackageItem()
        {
            $model = new LeavePackageItem();
            if(isset($_POST['item_leave_package']) && isset($_POST['item_leave_type']) && isset($_POST['item_total_days']))
            {
            	// print_r($model);
            	// exit();
                $model->item_leave_package_id = $_POST['item_leave_package'];
                $model->item_leave_type_id = $_POST['item_leave_type'];
                $model->item_total_days = $_POST['item_total_days'];
                if($model->save())
                    echo json_encode (array('status'=>'success'));
                else 
                    echo json_encode (array('status'=>'failed'));
            }
        }

    public function actionSearchLeavePackageItem(){
		$model=new LeavePackageItem('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_POST['item_leave_package_id'])) {
			$model->item_leave_package_id = $_POST['item_leave_package_id'];
		}
		
		LBApplication::renderPartial($this,'lbLeave.views.leavePackageItem.admin',array(
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

		if(isset($_POST['LeavePackageItem']))
		{
			$model->attributes=$_POST['LeavePackageItem'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->item_id));
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




	// function actionDeletePackageItem($id)
 //        {
 //            $translateModel = Translate::model()->findByPk($item_id);

 //            if($translateModel->delete())
 //                echo json_encode (array('status'=>'success'));
 //            else 
 //                echo json_encode (array('status'=>'failed'));
 //        }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LeavePackageItem');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LeavePackageItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LeavePackageItem']))
			$model->attributes=$_GET['LeavePackageItem'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LeavePackageItem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LeavePackageItem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LeavePackageItem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='leave-package-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	
}
