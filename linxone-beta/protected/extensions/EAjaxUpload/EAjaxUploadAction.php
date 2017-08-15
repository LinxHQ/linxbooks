<?php

Yii::import("ext.EAjaxUpload.qqFileUploader");

class EAjaxUploadAction extends CAction
{
	/**
	 public function run()
	 {
		 // list of valid extensions, ex. array("jpeg", "xml", "bmp")
		 $allowedExtensions = array("jpg");
		 // max file size in bytes
		 $sizeLimit = 1 * 1024 * 1024;
	
		 $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		 $result = $uploader->handleUpload('upload/');
		 // to pass data through iframe you will need to encode all html tags
		 $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		 echo $result;
	 }
	 **/
	public function run()
	{
		$folder = Documents::model()->getTempFolderPath();
		$allowedExtensions = array("jpg", "png");//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 5 * 1024 * 1024;// maximum file size in bytes
		
		// perform upload
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($folder);
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		 
		$fileSize = filesize($folder . $result['filename']);//GETTING FILE SIZE
		$fileName = $result['filename'];//GETTING FILE NAME
		 
		echo $return;// it's array
	}
}
