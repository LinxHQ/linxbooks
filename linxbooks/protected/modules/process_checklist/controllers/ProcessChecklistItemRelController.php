<?php

class ProcessChecklistItemRelController extends Controller
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
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update','updatePCheckListItem','updateOrder','DeleteItemRel'),
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
//		$model=new ProcessChecklistItemRel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                if(isset($_POST['entity_type']) && isset($_POST['entity_id']) && isset($_POST['pc_id']))
                {
                    $entity_type = $_POST['entity_type'];
                    $entity_id = $_POST['entity_id'];
                    $pc_id = $_POST['pc_id'];
                    
                    $add = ProcessChecklistItemRel::model()->addChecklistItemRel($entity_type, $entity_id, $pc_id);
                    if($add)
                        echo '{"status":"success"}';
                    else
                        echo '{"stauts":"fail"}';
                }
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

		if(isset($_POST['ProcessChecklistItemRel']))
		{
			$model->attributes=$_POST['ProcessChecklistItemRel'];
			if($model->save())
                        {
                            echo "<script language='JavaScript' type='text/javascript'>history.go(-2);</script>";
                        }
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
		$dataProvider=new CActiveDataProvider('ProcessChecklistItemRel');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($entity_type,$entity_id)
	{
		$this->renderPartial('admin',array(
			'entity_type'=>$entity_type,
                        'entity_id'=>$entity_id
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ProcessChecklistItemRel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ProcessChecklistItemRel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ProcessChecklistItemRel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='process-checklist-item-rel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        function actionUpdatePCheckListItem()
        {
            if(isset($_POST['pcir_id']) && isset($_POST['status']))
            {
                $status = $_POST['status'];
                $pcir_id = $_POST['pcir_id'];
                $result_save = ProcessChecklistItemRel::model()->updateProcessChecklistItem($pcir_id,$status);
                if($result_save)
                    echo '{"status":"success"}';
                else
                    echo '{"status":"fail"}';
            }
        }
        
        public function actionUpdateOrder()
        {
            if(isset($_POST['pcir_id']))
            {
                $pcir_id_arr = $_POST['pcir_id'];
                for($i=0;$i<count($pcir_id_arr);$i++) {
                    $model = ProcessChecklistItemRel::model()->findByPk($pcir_id_arr[$i]);
                    $model->pcir_order=$i+1;
                    $model->save();
                }
                
                echo '{"status":"success"}';
            }
            else
                echo '{"status":"fail"}';
        }
        
	public function actionDeleteItemRel()
	{
                $id = $_POST['pcir_id'];
		$delete = ProcessChecklistItemRel::model()->deleteAll('pcir_id='.  intval($id));
                
                if($delete)
                    echo '{"status":"success"}';
                else
                    echo '{"status":"fail}';
	}
        
        public function actionDeletePCheckListByEntity()
        {
            $entity_type=$_POST['entity_type'];
            $entity_id=$_POST['entity_id'];
            $pc_id=$_POST['pc_id'];
            
            $ItemRel = ProcessChecklistItemRel::model()->deleteAll("pcir_entity_type='".$entity_type."' AND pcir_entity_id=".  intval($entity_id)." AND pc_id=".intval($pc_id));
            
            if($ItemRel)
                echo '{"status":"success"}';
            else
                echo '{"status":"fail"}';
        }
        
}
?>