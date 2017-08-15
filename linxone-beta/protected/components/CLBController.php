<?php
class CLBController extends Controller
{
	public $layout='//layouts/column1';
	public $default_view_path = '';
	
	public function __construct($id, $module = null)
	{
		parent::__construct($id, $module);
		
		$this->default_view_path = $this->module->id . '.views.default.';
	}
	
	/**
	 * Use for updating a single field through inline editable
	 * such as jquery editable, bootstrap x-editable, etc.
	 *
	 * POST params
	 * pk	the primary key of this record
	 * name attribute name
	 * value value to be updated to
	 */
	public function actionAjaxUpdateField()
	{
		if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = $this->loadModel($id);
			// update
			$model->$attribute = $value;
			return $model->save();
		}
	
		return false;
	}
        
        /**
         * Upload logo LbInvoice or LbQuotation
         */
        public function actionUploadLogo($sub_cription,$company_id)
        {
                Yii::import("ext.EAjaxUpload.qqFileUploader");
                
                $folder='images/logo/';// folder for uploaded files
                $file_arr = array_diff(scandir($folder),array('.','..'));
                foreach ($file_arr as $key => $file) {
                    $file_name = explode('.', $file);
                    $file_name_arr = explode('_', $file_name[0]);
                    if($file_name_arr[0] == $sub_cription && $file_name_arr[1] == $company_id){
                        unlink ($folder.$file);
                    }
                }
                $allowedExtensions = array("jpeg","jpg","gif","png");//array("jpg","jpeg","gif","exe","mov" and etc...
                $sizeLimit = 1024 * 1024 * 1024;// maximum file size in bytes
                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
                
                $result = $uploader->handleUpload($folder, false,$sub_cription, $company_id);
                $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
                echo $return;
                $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
                $fileName=$result['filename'];//GETTING FILE NAME
                
                return $return;// it's array
        }
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Task the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		return null;
	}
}