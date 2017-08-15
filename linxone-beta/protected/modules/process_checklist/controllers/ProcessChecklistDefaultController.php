<?php

class ProcessChecklistDefaultController extends Controller
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
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','updateOrder'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new ProcessChecklistDefault;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

//		if(isset($_POST['ProcessChecklistDefault']))
//		{
//			$model->attributes=$_POST['ProcessChecklistDefault'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->pcdi_id));
//		}
                if(isset($_POST['pcdi_name']) && isset($_POST['pc_id']))
                {
                    $model->pcdi_name=$_POST['pcdi_name'];
                    $model->pc_id=$_POST['pc_id'];
                    $model->pcdi_order=0;
                    if($model->save())
                        $this->redirect(array('admin','pc_id'=>$model->pc_id));
                }

//		$this->render('create',array(
//			'model'=>$model,
//		));
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

		if(isset($_POST['ProcessChecklistDefault']))
		{
			$model->attributes=$_POST['ProcessChecklistDefault'];
			if($model->save())
				$this->redirect(array('admin','pc_id'=>$model->pc_id));
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
		$dataProvider=new CActiveDataProvider('ProcessChecklistDefault');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($pc_id)
	{
		$model= ProcessChecklistDefault::model()->getPCheckListDefaultByCheckList($pc_id);
                $modelChecklist = ProcessChecklist::model()->findByPk($pc_id);
		$this->render('admin',array(
			'model'=>$model,
                        'modelChecklist'=>$modelChecklist,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ProcessChecklistDefault the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ProcessChecklistDefault::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ProcessChecklistDefault $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='process-checklist-default-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionUpdateOrder()
        {
            if(isset($_POST['pcdi_id']))
            {
                $pcir_id_arr = $_POST['pcdi_id'];
                for($i=0;$i<count($pcir_id_arr);$i++) {
                    $model = ProcessChecklistDefault::model()->findByPk($pcir_id_arr[$i]);
                    $model->pcdi_order=$i+1;
                    $model->save();
                }
                
                echo '{"status":"success"}';
            }
            else
                echo '{"status":"fail"}';
        }
}
