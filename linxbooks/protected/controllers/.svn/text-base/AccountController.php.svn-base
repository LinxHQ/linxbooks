<?php

class AccountController extends Controller
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
				'actions'=>array('index', 'view','update', 'updatePassword'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id, $param = '')
	{		
		$account = $this->loadModel($id);
		
		// check permission
//		if (!Permission::checkPermission($account, PERMISSION_ACCOUNT_VIEW))
//		{
//			throw new CHttpException(401,'You are not given the permission to view this page.');
//			return false;
//		}
		
		$attributes_array = array();
		if ($account != null) {
			$attributes_array = $account->attributes;
		}
		
		// get profile
		$profile = AccountProfile::model()->getProfile($account->account_id);
		
		 $this->render('view',array(
		 		'model'=> $account,
		 		'profile'=> $profile,
		 ));
		
		// return JSONs
		//echo $param;
		//WebService::sendJSONResponse(200, array("account" => $attributes_array));
				
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		// if user is already logged in
		// redirect to dash board
		if (!Yii::app()->user->isGuest)
			$this->redirect(array('project/index'));
		
		$model=new Account;
		//$companyModel = new Company();
		//$companyContactModel = new CompanyContact();
		$accountSubscriptionModel = new AccountSubscription();
		$accountProfile = new AccountProfile();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		/**
		 * Process form's submission
		 * param's name must be in this format, e.g. "Account[account_email]"
		 */
		if(isset($_POST['Account']))
		{
			$model->attributes=$_POST['Account'];
			$model->account_id = null;
			//$companyModel->attributes = $_POST['Company'];
			//$companyContactModel->attributes = $_POST['CompanyContact'];
			$accountSubscriptionModel->attributes = $_POST['AccountSubscription'];
			$accountProfile->attributes = $_POST['AccountProfile'];
			
			/**
			$model->account_company_name = $companyModel->company_name;
			$model->account_contact_surname = $companyContactModel->contact_surname;
			$model->account_contact_given_name = $companyContactModel->contact_given_name;
			$model->account_subscription_package_id = $accountSubscriptionModel->account_subscription_package_id;
			**/
			
			// SAVE ACCOUNT
			//$model->account_password = $model->hashPassword($model->account_password);
			$model->account_status = ACCOUNT_STATUS_ACTIVATED;// ACCOUNT_STATUS_NOT_ACTIVATED;
			
			$save_result = '';
			// save user account record to database
			$save_result = $model->save();
			
			if ($save_result) {
				// create/update subscription record
				$accountSubscriptionModel->account_id = $model->account_id;
				$accountSubscriptionModel->account_subscription_start_date = date('Y-m-d H:i');
				$accountSubscriptionModel->account_subscription_status_id = 1;
				$accountSubscriptionModel->save();
				
				// create account profile
				$accountProfile->account_id = $model->account_id;
				$accountProfile->account_profile_preferred_display_name 
					= $accountProfile->account_profile_given_name . ' ' . $accountProfile->account_profile_surname;
				$accountProfile->save();
			
				/**
				// create company record
				$companyModel->company_master_account_id = $model->account_id;
				$companyModel->company_is_master = COMPANY_IS_MASTER;
			
				// save company record to database,
				// if successful, create contact record
				if ($companyModel->save()) {
					// create contact record
					$companyContactModel->contact_email1 = $model->account_email;
					$companyContactModel->company_id = $companyModel->company_id;
					$companyContactModel->account_id = $model->account_id;
					// save contact record to database
					$companyContactModel->save();
				}**/
			
				// notify user through email
				$model->sendSuccessfulSignupEmailNotification();
			}
			
			// redirect to view
			if($save_result)
				//$this->redirect(array('view','id'=>$model->account_id));
				$this->redirect(Yii::app()->baseUrl . '/product/signup-success.php');
		}

		/** 
		 * otherwise just show creation form
		 */
		$active_subscription_packages = SubscriptionPackage::getActivePackages();
		$active_subscription_package_names = array();
		foreach ($active_subscription_packages as $item) {
			$active_subscription_package_names[$item->subscription_package_id] = $item->subscription_package_name;
		}
		
		$data = array(
			'model' => $model,
			//'companyModel' => $companyModel,
			//'companyContactModel' => $companyContactModel,
			'accountProfileModel' => $accountProfile,
			'accountSubscriptionModel' => $accountSubscriptionModel, 
			'active_subscription_packages' => $active_subscription_package_names,
		);
		LBApplication::render($this, 'create', $data);
		//$this->render('create',);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$accountProfile = new AccountProfile();
		
//		// check permission
//		if (!Permission::checkPermission($model, PERMISSION_ACCOUNT_UPDATE))
//		{
//			throw new CHttpException(401,'You are not given the permission to view this page.');
//			return false;
//		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Account']))
		{
			$model->attributes=$_POST['Account'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->account_id));
		}

		$this->render('update',array(
			'model'=>$model,
			'accountProfileModel' => $accountProfile,
		));
	}
	
	public function actionUpdatePassword($id)
	{
		$model=$this->loadModel($id);
		
//		// check permission
//		if (!Permission::checkPermission($model, PERMISSION_ACCOUNT_UPDATE))
//		{
//			throw new CHttpException(401,'You are not given the permission to view this page.');
//			return false;
//		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Account']))
		{
			$model->attributes=$_POST['Account'];
			$result = $model->updatePassword();
			if($result === true)
			{
				$this->redirect(array('view','id'=>$model->account_id));
			}
		}
		
		$this->render('_form_changepassword',array(
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
		// DISABLE DELETION FOR NOW.
		return false;
		
		$model = $this->loadModel($id);

		// check permission
//		if (!Permission::checkPermission($model, PERMISSION_ACCOUNT_UPDATE))
//		{
//			throw new CHttpException(401,'You are not given the permission to view this page.');
//			return false;
//		}
		
		$model->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// Only allow admin to do this for now
		if (Yii::app()->user->id != Yii::app()->params['adminID'])
		{
			throw new CHttpException(401,'You are not given the permission to view this page.');
			return false;
		}
		
		$dataProvider=new CActiveDataProvider('Account');
		//echo "ME";
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Account('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Account']))
			$model->attributes=$_GET['Account'];

		
	}
	
	/**
	 * Activate newly signed up account
	 * @param string $id	ID of this account
	 * @param string $key	Activation key
	 */
	public function actionActivate($id, $key) {
		$account = $this->loadModel($id);
		$status = false;
		
		$message = '';
		if ($account->account_id) {
			
			if ($account->isActivated()) {
				$status = false;
				$message = "Account is already activated.";
			} else {
				$status = $account->activateAccount($key);
				if ($status == false)
					$message = "Account activation failed. Please contact the Administrator.";
				
				//$message = "ID: " . $account->account_id . ". Current Status: " . $account->account_status 
				//	. "Given key $key and actual key " . $account->getActivationKey();
			}
		} else {
			$message = 'Cannot find account';
		}
		
		$this->render('activation',array(
				'activation_status' => $status,
				'activation_message' => $message,
				'account' => $account,
		));
	}
	
	public function actionTestEmail() {
		$message = new YiiMailMessage();
		$message->setSubject('Account Activation');
			
		$body = '<p>Hi.</p><p>Please activiate your account here: </p>';
		$body .= '<p><a href="">Activate my account now.</a></p>';
		$message->setBody($body, 'text/html');
			
		$message->addTo("joseph.pnc@lionsoftwaresolutions.com");
		$message->from = Yii::app()->params['adminEmail'];
		Yii::app()->mail->send($message);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Account the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Account::model()->findByPk($id);
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
			
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Account $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
