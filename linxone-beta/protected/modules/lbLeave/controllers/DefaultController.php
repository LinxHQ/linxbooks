<?php

class DefaultController extends CLBController
{
	public function actionIndex()
	{
		$modelApplication=new LeaveApplication;
		$modelPackage=new LeavePackage;
		$modelInLieu=new LeaveInLieu;
		$modelPackageItem=new LeavePackageItem;
		$modelAssignment = new LeaveAssignment;
		$report=LeaveAssignment::model()->findall();
		LBApplication::render($this,'index',array(
			'modelApplication'=>$modelApplication,
			'modelPackage'=>$modelPackage,
			'modelInLieu'=>$modelInLieu,
			'modelPackageItem'=>$modelPackageItem,
			'modelAssignment'=>$modelAssignment,
			'report'=>$report,
			));

	}

	public function actionLoadReport()
	{
		$emp_id = $_POST['emp_id'];
		$year_id = $_POST['year_id'];
		if(isset($_POST['emp_id']) && isset($_POST['year_id']))
		$LeaveAssignment = LeaveAssignment::model()->findAll('assignment_year="'.$year_id.'" and assignment_account_id='.$emp_id);
		$this->renderPartial('_report',array(
				'LeaveAssignment'=>$LeaveAssignment,
			));
	}

	
}