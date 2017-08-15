<?php

class LeaveApplicationController extends CLBController
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
				'actions'=>array('create','update','FormCreate','AjaxUpdateField','appStatus','appStatusApprover','SearchLeaveAplication','SearchLeaveAplicationStatus','FormViewReject','delete'),
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
		$model=new LeaveApplication;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LeaveApplication']))
		{
			$model->attributes=$_POST['LeaveApplication'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->leave_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionFormViewReject()
	{

		if(isset($_POST['leave_id']))
		{
			$model=$this->loadModel($_POST['leave_id']);
			if (isset($_POST['status'])) {
				$model->leave_status = $_POST['status'];
				$model->save();
			}
			

			if(isset($_POST['send']))
			{
				$approve_id = $model->account_id;
				$account = Account::model()->findByPk($approve_id);
				// $tempAccount = Account::model()->getAccountByEmail(trim($approve_id));
				// echo $account;
				// exit();
				if($account){
					// send email
					$message = new YiiMailMessage();
					
					// if this invitee already has an account with LinxCircle
					// use a different invitation template
					
					
					//userModel is passed to the view
					$message->setBody($_POST['confirm_reject'],'text/html');
					
					$message->setSubject('Confirmation mail request for leave');
					//$message->setBody($body, 'text/html');
					//$message->addTo($model->account_invitation_to_email);
					$message->addTo($account->account_email);
					$message->setFrom(Yii::app()->params['adminEmail']);
					Yii::app()->mail->send($message);
				}
			}else{
				$this->renderPartial('_form_view_reject',array(
					'model'=>$model,
				));
			}
		}


	}

	public function actionAppStatusApprover()
	{	
		if(isset($_POST['leave_id'])){
			$leave_arr = explode(",",$_POST['leave_id']);
			foreach ($leave_arr as $value) {
				$model=LeaveApplication::model()->findByPk($value);
				if($model){
					$model->leave_status = $_POST['status'];
					if($model->save()){
						$approve_id = $model->account_id;
						$ccreceiver_id = $model->leave_ccreceiver;
						$account_id = explode(',', $ccreceiver_id);
						$account = Account::model()->findByPk($approve_id);
						$account_cc = array();
						foreach ($account_id as $value) {
							$account_cc[] = Account::model()->findByPk($value);
						}
						if($account && $account_cc){
							// send email
							$message = new YiiMailMessage();
							
							// if this invitee already has an account with LinxCircle
							// use a different invitation template
							
							
							//userModel is passed to the view
							$message->setBody('<p>
													<span>Hi, </span><br>
													<span>You are allowed to leave for work!</span>
													<br>
													<span>Thanks!</span>
												</p>', 
									'text/html');
							
							$message->setSubject('Request for leave confirmation mail');
							//$message->setBody($body, 'text/html');
							//$message->addTo($model->account_invitation_to_email);
							$message->addTo($account->account_email);
							$count = count($account_cc);
							$acmsg_cc = array();
							for ($i=0; $i < $count; $i++) { 
									$acmsg_cc[] = $account_cc[$i]->account_email;
									
							}
							foreach($acmsg_cc as $value) {
							  $message->AddBCC($value); // if you want more than one email 
							  echo $message->AddBCC($value);

							}
							$message->setFrom(Yii::app()->params['adminEmail']);
							Yii::app()->mail->send($message);
						}
					}
				}
			}
			
		}
	}

	public function actionAppStatus()
	{	
		if(isset($_POST['leave_id'])){
			$leave_arr = explode(",",$_POST['leave_id']);
			foreach ($leave_arr as $value) {
				$model=LeaveApplication::model()->findByPk($value);
				
				if($model){
					$model->leave_status = $_POST['status'];
					$model->leave_date_submit = date('Y-m-d H:i:s');
					if($model->save()){
						$approve_id = $model->leave_approver;
						$ccreceiver_id = $model->leave_ccreceiver;

						$account_id = explode(',', $ccreceiver_id);
						

						$account = Account::model()->findByPk($approve_id);
						$account_cc = array();
						foreach ($account_id as $value) {
							$account_cc[] = Account::model()->findByPk($value);
						}
						



						if($account && $account_cc){

							// send email
							$message = new YiiMailMessage();
							
							// if this invitee already has an account with LinxCircle
							// use a different invitation template
							
							
							//userModel is passed to the view
							$message->setBody('<p>
												<span>Hi,</span><br>
												<span>There is a staff requested for leave on <a href="https://lk.office4c.com/index.php/lbLeave/default/index">Click hehe</a> Please log in the system and reply his/her leave requests.</span><br>
												<span>Have a good day !</span><br>
												<span>Thanks!</span>
												</p>', 
									'text/html');
							
							$message->setSubject('Request for leave approval');
							//$message->setBody($body, 'text/html');
							//$message->addTo($model->account_invitation_to_email);
							$message->addTo($account->account_email);
							$count = count($account_cc);
							$acmsg_cc = array();
							for ($i=0; $i < $count; $i++) { 
								$acmsg_cc[] = $account_cc[$i]->account_email;
								
							}
							foreach($acmsg_cc as $value) {
							  $message->AddBCC($value); // if you want more than one email 
							  // echo $message->AddBCC($value);

							}
							// exit();
							$message->setFrom(Yii::app()->params['adminEmail']);
							Yii::app()->mail->send($message);
						}
						
					}
				}
			}
			
		}
	}

	public function actionFormCreate()
        {
	        $model=new LeaveApplication;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
	        
			if(isset($_POST['LeaveApplication']))
			{


				$model->attributes=$_POST['LeaveApplication'];
				$model->leave_name_approvers_by =  0;
				// setup post start date
				$model->leave_startdate = $_POST['LeaveApplication']['leave_startdate'];

				// setup post end date
				$model->leave_enddate = $_POST['LeaveApplication']['leave_enddate'];

				// leave_list_day
				$leave_list_date = $_POST['leave_list_day'];

				$leave_status_day = $_POST['leave_application_style_date'];
				array_splice($leave_status_day,0,1);

				$leave_list_day = array();
				for ($i=0; $i<count($leave_list_date); $i++) {
				   $leave_list_day[] = $leave_list_date[$i];
				   $leave_list_day[] = $leave_status_day[$i];
				}

				$model->leave_list_day=implode(',', $leave_list_day);

				// leave_sum_day 

				$countDay = count($leave_status_day);
				for ($i=0; $i < $countDay; $i++) { 
					if ($leave_status_day[$i] === "Full day") {
						$leave_status_day[$i] = 1;
					}
					if ($leave_status_day[$i] === "Half day leave (morning)" || $leave_status_day[$i] === "Half day leave (afternoon)") {
						$leave_status_day[$i] = 1/2;
						
					}
				}
				$sumLeaveDay =  array_sum($leave_status_day);
				$model->leave_sum_day = $sumLeaveDay;

				// cc-receiver
				$leave_ccreceiver = $_POST['leave_ccreceiver'];
				$model->leave_ccreceiver=implode(',', $leave_ccreceiver);
				$model->leave_status = 47;
				$model->account_id = Yii::app()->user->id;

				if($model->save())
					$this->redirect(Yii::app()->createUrl('/lbLeave/default/index'));
			}

			$this->renderPartial('create',array(
				'model'=>$model,
			));
			// LBApplication::renderPartial($this,'_form', array('model'=>$model, 'leave_id'=>$_POST['leave_id']));
        
        }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$leave_ccreceiver = explode(',', $model->leave_ccreceiver);

		$listDateLeave = explode(',', $model->leave_list_day);

		$oddDate = array();
		$evenStatusDate = array();
		foreach( $listDateLeave as $key => $value ) {
		    if( 0 === $key%2) { //Even
		        $oddDate[] = $value;
		    }
		    else {
		        $evenStatusDate[] = $value;
		    }
		}




		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LeaveApplication']))
		{
			$model->attributes=$_POST['LeaveApplication'];
			$model->leave_name_approvers_by =  0;
				// setup post start date
				$model->leave_startdate = $_POST['LeaveApplication']['leave_startdate'];

				// setup post end date
				$model->leave_enddate = $_POST['LeaveApplication']['leave_enddate'];

				// leave_list_day
				$leave_list_date = $_POST['leave_list_day'];

				$leave_status_day = $_POST['leave_application_style_date'];
				array_splice($leave_status_day,0,1);

				$leave_list_day = array();
				for ($i=0; $i<count($leave_list_date); $i++) {
				   $leave_list_day[] = $leave_list_date[$i];
				   $leave_list_day[] = $leave_status_day[$i];
				}

				$model->leave_list_day=implode(',', $leave_list_day);

				// leave_sum_day 

				$countDay = count($leave_status_day);
				for ($i=0; $i < $countDay; $i++) { 
					if ($leave_status_day[$i] === "Full day") {
						$leave_status_day[$i] = 1;
					}
					if ($leave_status_day[$i] === "Half day leave (morning)" || $leave_status_day[$i] === "Half day leave (afternoon)") {
						$leave_status_day[$i] = 1/2;
						
					}
				}
				$sumLeaveDay =  array_sum($leave_status_day);
				$model->leave_sum_day = $sumLeaveDay;

				// cc-receiver
				$leave_ccreceiver = $_POST['leave_ccreceiver'];
				$model->leave_ccreceiver=implode(',', $leave_ccreceiver);
				$model->leave_status = 47;
				$model->account_id = Yii::app()->user->id;
			if($model->save())
				$this->redirect(Yii::app()->createUrl('/lbLeave/default/index'));
		}

		$this->render('update',array(
			'model'=>$model,
			'evenStatusDate'=>$evenStatusDate,
			'oddDate'=>$oddDate,
			'leave_ccreceiver'=>$leave_ccreceiver
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
		$dataProvider=new CActiveDataProvider('LeaveApplication');
		print_r($dataProvider);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LeaveApplication('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LeaveApplication']))
			$model->attributes=$_GET['LeaveApplication'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LeaveApplication the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LeaveApplication::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LeaveApplication $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='leave-application-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSearchLeaveAplication(){
		$model=new LeaveApplication('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['employee_id']))
			$model->account_id = $_POST['employee_id'];

		if(isset($_POST['status_id']))
			$model->leave_status = $_POST['status_id'];
		
		if(isset($_POST['year_id']))
			$model->leave_enddate = $_POST['year_id'];
		

		LBApplication::renderPartial($this,'lbLeave.views.leaveApplication._griview_leave_application',array(
			'model'=>$model,
		));
	}

}
