<?php

class DocumentController extends Controller
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
				'actions'=>array('download'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('ajaxTempUpload', 
                                    'ajaxProjectUpload',
                                    'ajaxCreate', 'ajaxDelete', 'ajaxDeletes'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view', 'admin', 'delete', 'create','update'),
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
	
	public function actionDownload($id)
	{
		$document = $this->loadModel($id);
		$this->renderPartial('download', array('model' => $document), false, true);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Documents;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Documents']))
		{
			$model->attributes=$_POST['Documents'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->document_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Upload document
	 * Attempt to move to final destination, based on parent type
	 * 
	 * @return boolean
	 */
	public function actionAjaxCreate()
	{
		$model=new Documents;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$result = array();
		if(isset($_POST['Documents']))
		{
			$model->attributes=$_POST['Documents'];
			if($model->save())
			{
				if ($model->moveToActualLocation())
				{
					$result['status'] = SUCCESS;
					$result['document_id'] = $model->document_id;
					echo CJSON::encode($result);
					return true;
				} else {
					$result['status'] = FAILURE;
					$result['message'] = 'Failed to move to final destination.';
					echo CJSON::encode($result);
					return false;
				}
			}
		}
		
		$result['status'] = FAILURE;
		echo CJSON::encode($result);
		return false;
	}
	
	/**
	 * THIS IS ONLY USED BY EAJAXUPLOAD EXTENSION!!!
	 * 
	 * Temporarily upload document to the temp location
	 * Usually at the end of the parent's process, this file will be moved to final location
	 */
	public function actionAjaxTempUpload()
	{
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		
		$folder = Documents::model()->getTempFolderPath();
		$allowedExtensions = Documents::model()->supportedTypes();//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 2 * 1024 * 1024;
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		
		$result = $uploader->handleUpload($folder);
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		
		$fileSize = filesize($folder . $result['filename']);//GETTING FILE SIZE
		$fileName = $result['filename'];//GETTING FILE NAME
		
		echo $return;// it's array
		
		//echo var_dump($result);
	}
        
        /**
	 * THIS IS ONLY USED BY EAJAXUPLOAD EXTENSION!!!
	 * 
	 * Upload document to a project (NOT related directly to any tasks,
         * or issues or any sub entities.
         * 
         * This is the full process. Document will be uploaded to actual and FINAL destination!
	 */
	public function actionAjaxProjectUpload()
	{
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		
		$folder = Documents::model()->getTempFolderPath();
		$allowedExtensions = Documents::model()->supportedTypes();//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = Yii::app()->params['maxUploadSize'] * 1024 * 1024;// maximum file size in bytes
		// $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$uploader = new qqFileUploader($allowedExtensions);
		
                // UPLOAD to SERVER
		$result = $uploader->handleUpload($folder);
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		
		$fileSize = filesize($folder . $result['filename']);//GETTING FILE SIZE
		$fileName = $result['filename'];//GETTING FILE NAME
		
                // SAVE to DB
                $doc = new Documents();
                $doc->document_temp_name = $fileName;
                $doc->document_real_name = $fileName;
                $doc->document_project_id = intval($_GET['project_id']);
                $doc->document_parent_id = intval($_GET['project_id']);
                $doc->document_parent_type = DOCUMENT_PARENT_TYPE_PROJECT;
                if ($doc->save())
                {
                    // move to final destination which is project's doc folder
                    $doc->moveToActualLocation();
                }
                
		echo $return;// it's array
		
		//echo var_dump($result);
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

		if(isset($_POST['Documents']))
		{
			$model->attributes=$_POST['Documents'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->document_id));
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
	 * Deletes a particular model through AJAX.
	 * If deletion is successful, return "success" as unformmated text
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionAjaxDelete($id)
	{
		$model = $this->loadModel($id);
		
		// delete from file system
		if($model->delete())
		{
			//$model->delete(); // delete from database
	
			echo SUCCESS;
			return;
		}
		
		echo FAILURE;
	}
	public function actionAjaxDeletes()
	{
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$model = $this->loadModel($id);
			
			// delete from file system
			if($model->delete())
			{
				//$model->delete(); // delete from database
		
				echo SUCCESS;
				return;
			}
			
			echo FAILURE;
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Documents');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Documents('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Documents']))
			$model->attributes=$_GET['Documents'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Documents the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Documents::model()->findByPk($id);
		
		if (!Permission::checkPermission($model, PERMISSION_DOCUMENT_VIEW))
			throw new CHttpException(401,'You are not authorized to access this document.');
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Documents $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='documents-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}