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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('create', 'activate'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','download', 'view','update', 'updatePassword','UploadDocument','deleteDocument'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'testEmail'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionView()
        {
            $this->render('view');
        }
        public function actionUploadDocument($id)
        {
                $module_name ="";
                if(isset($_REQUEST['module_name']))
                    $module_name = $_REQUEST['module_name'];
                
                Yii::import("ext.EAjaxUpload.qqFileUploader");

                $folder='uploads/';// folder for uploaded files
                $allowedExtensions = array("jpeg","jpg","gif","png","pdf","odt","docx","doc","dia");//array("jpg","jpeg","gif","exe","mov" and etc...
                $sizeLimit = 2 * 1024 * 1024;// maximum file size in bytes
                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
                $result = $uploader->handleUpload($folder, false);
                $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

                $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
                $fileName=$result['filename'];//GETTING FILE NAME

                
                $documentModel = new LbDocument();
                $documentModel->addDocument($module_name,$id,$fileName);
                return $return;// it's array
        }
         public function actionDeleteDocument($id)
        {
            $documentModel = LbDocument::model()->findByPk($id);
            $documentModel->delete();
        }
        
        public function actionDownload($id) {
                $file = LbDocument::model()->findByPk($id);
                $filePath = $file->lb_document_url;

                $material = LbDocument::model()->findByPk($id);
                $src = $file->lb_document_url;
                
                $length = strlen($src);
                $src =  substr($src,  1, $length);
                
                //kiem tra nguoi dung
                if(isset(Yii::app()->user))
                {
                    if(@file_exists($src)) {
                            $path_parts = @pathinfo($src);
                            //$mime = $this->__get_mime($path_parts['extension']);
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            //header('Content-Type: '.$mime);
                            header('Content-Disposition: attachment; filename='.basename($src));
                            header('Content-Transfer-Encoding: binary');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                            header('Pragma: public');
                            header('Content-Length: ' . filesize($src));
                            ob_clean();
                            flush();
                            readfile($src);
                    } else {
                            header("HTTP/1.0 404 Not Found");
                            exit();
                    }

                }
            }
        
}
