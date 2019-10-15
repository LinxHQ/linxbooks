<?php

class SiteController extends Controller
{	
	/**
	public function __construct($id, $module=NULL)
	{
		require_once 'Mobile_Detect.php';
		$detect = new Mobile_Detect;
	
		if (LBApplication::mobileViewRequested()
				|| ( $detect->isMobile() && !$detect->isTablet() ) )
		{
			$this->layout = '//layouts/column1.mobile';
		}
		parent::__construct($id, $module);
	}**/

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
						'actions'=>array( 'index','contact','login','error', 'assignaccountsocial','disconnectaccountsocial'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('logout','search','subscription', 'dashboardchurchone', 'languares'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			// main contact form
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail('LinxBooks Contact <contact@linxhq.com>',$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		} else if (isset($_POST['ContactableForm'])) {
			// jquery widget
			// Assign contact info
			$name = stripcslashes($_POST['name']);
			$emailAddr = stripcslashes($_POST['email']);
			$issue = stripcslashes($_POST['issue']);
			$comment = stripcslashes($_POST['message']);
			$subject = stripcslashes($_POST['subject']);
			
			//$name='=?UTF-8?B?'.base64_encode($name).'?=';
			$subject='=?UTF-8?B?'.base64_encode($subject).'?=';

			// Format message
			$contactMessage =
			"<div>
			<p><strong>Name:</strong> $name <br />
			<strong>E-mail:</strong> $emailAddr <br />
			<strong>Issue:</strong> $issue </p>
				
			<p><strong>Message:</strong> $comment </p>
				
			<p><strong>Sending IP:</strong> $_SERVER[REMOTE_ADDR]<br />
			<strong>Sent via:</strong> $_SERVER[HTTP_HOST]</p>
			</div>";
			
			// Send and check the message status
			$message = new YiiMailMessage();
			$message->setBody($contactMessage, 'text/html');
			$message->setSubject($subject);
			$message->setTo(array('contact@linxhq.com' => 'LinxBooks Contact'));
			$message->setFrom(array($emailAddr => $name . " (LinxBooks)"));
			$message->setReplyTo(array($emailAddr => $name . " (LinxBooks)"));
			$result = Yii::app()->mail->send($message);
			
			$response = ($result) ? "success" : "failure" ;
			$output = json_encode(array("response" => $response, "result" => $result));
			header('content-type: application/json; charset=utf-8');
			echo($output);
			return;
		}
		$this->render('contact',array('model'=>$model));
	}
        
        // chuyen chu co dau thanh chu ko dau
        public function stripUnicode($str){
            if(!$str) return false;
             $unicode = array(
                'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
                'd'=>'đ',
                'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
                'i'=>'í|ì|ỉ|ĩ|ị',
                'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
                'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
                'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
             );
          foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
          return $str;
        }
        // end chuyen chu co dau thanh chu ko dau
        
        public function actionAssignAccountSocial(){
            $serviceName = Yii::app()->request->getQuery('service');
		if (isset($serviceName)) {
                    /** @var $eauth EAuthServiceBase */
                    $eauth = Yii::app()->eauth->getIdentity($serviceName);
                    $eauth->redirectUrl = Yii::app()->user->returnUrl;
                    $eauth->cancelUrl = $this->createAbsoluteUrl('site/login');

                    try {
                        if ($eauth->authenticate()) {
                            //var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes());
                            $identity = new EAuthUserIdentity($eauth);
                            // successful authentication
                            if ($identity->authenticate()) {
                                 // google_oauth, facebook
//                                var_dump($identity->id, $identity->name, Yii::app()->user->id);exit;
                                if($serviceName == "google_oauth"){
                                    $account=Account::model()->findByPk(Yii::app()->user->id);
                                    $account->account_check_email_social_google = $identity->email;
                                    $account->account_check_social_login_id_google = $identity->id;
                                    $account->check_user_activated = 1;
                                    $account->update();
                                    Yii::app()->user->setFlash('sucs', Yii::t('lang','Your account is successfully linked to social network'));
                                    $this->redirect(array('account/view/'.Yii::app()->user->id));
                                } else if ($serviceName == "facebook"){
                                    $account=Account::model()->findByPk(Yii::app()->user->id);
                                    $account->account_check_email_social_facebook = $identity->email;
                                    $account->account_check_social_login_id_facebook = $identity->id;
                                    $account->check_user_activated = 1;
                                    $account->update();
                                    Yii::app()->user->setFlash('sucs', Yii::t('lang','Your account is successfully linked to social network'));
                                    $this->redirect(array('account/view/'.Yii::app()->user->id));
                                }
                                

                            }
                            else {
                                    $eauth->cancel();
                            }
                        }
                    }
                    catch (EAuthException $e) {
                            // save authentication error to session
                            Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());

                            // close popup window and redirect to cancelUrl
                            $eauth->redirect($eauth->getCancelUrl());
                    }
		}
        }
        function actionDisconnectaccountsocial($id, $server){
        	if($server == "google"){
        		$account=Account::model()->findByPk($id);
				$account->account_check_social_login_id_google=NULL;
				$account->account_check_email_social_google=NULL;
				$account->update(); // save the change to databases
				Yii::app()->user->setFlash('sucs_disconnect', Yii::t('lang','Successfully disconnected from Google'));
				$this->redirect(array('account/view/'.$id));
        	} else if ($server == "facebook"){
        		$account=Account::model()->findByPk($id);
				$account->account_check_social_login_id_facebook=NULL;
				$account->account_check_email_social_facebook=NULL;
				$account->update(); // save the change to databases
				Yii::app()->user->setFlash('sucs_disconnect', Yii::t('lang','Successfully disconnected from Facebook'));
				$this->redirect(array('account/view/'.$id));
        	}
        	
        }
	/**
	 * Displays the login page
	 */
        // 
	public function actionLogin()
	{
		$modelCheckServer = new LbCheckServer();
		$checkServer = $modelCheckServer->checkServer();

        $serviceName = Yii::app()->request->getQuery('service');
		if (isset($serviceName)) {
			/** @var $eauth EAuthServiceBase */
			$eauth = Yii::app()->eauth->getIdentity($serviceName);
			$eauth->redirectUrl = Yii::app()->user->returnUrl;
			$eauth->cancelUrl = $this->createAbsoluteUrl('site/login');

			try {
                            if ($eauth->authenticate()) {
                                //var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes());
                                $identity = new EAuthUserIdentity($eauth);
                                // successful authentication
                                if ($identity->authenticate()) {
                                    
                                    if($serviceName == "google_oauth"){
                                        $list_account = Account::model()->findAll('account_check_social_login_id_google IN ('.$identity->id.')');
                                        if(isset($list_account[0]['account_check_social_login_id_google']) == $identity->id && $list_account[0]['check_user_activated'] == 1){
    //                                      // login
                                            $login=new LoginForm;
                                            $login->username=$list_account[0]['account_email'];
                                            $login->account_check_social_login_id_google=$identity->id;
                                            $login->rememberMe=1;
    //                                        echo $login->loginSocial(); exit;
                                            if($login->loginSocialGoogle()){
                                            	if($checkServer == 'church-one') {
													$this->redirect(array("site/dashboardchurchone"));
												} else if($checkServer == "linxone"){
													$this->redirect(array('/'.LBApplication::getCurrentlySelectedSubscription() . "/lbInvoice/dashboard"));
												}
                                            }
                                        } else if (isset($list_account[0]['account_check_social_login_id_google'])) {
                                            Yii::app()->user->setFlash('success', Yii::t('lang','You are not assigned to any module yet. Please contact the Administrator to access the system'));
                                        }else {
    //                                      register
                                            $account = new Account();
                                            $account->account_email = $identity->email;
                                            $account->account_password = "newaccount";
                                            $account->account_status = 1;
                                            $account->account_check_social_login_id_google = $identity->id;
                                            $account->check_user_activated = 0;
                                            $account->save();
                                            Yii::app()->user->setFlash('success', Yii::t('lang','Create Account Successfully'));
                                        }
                                    } else if ($serviceName == "facebook"){
                                        $list_account = Account::model()->findAll('account_check_social_login_id_facebook IN ('.$identity->id.')');
                                        if(isset($list_account[0]['account_check_social_login_id_facebook']) == $identity->id && $list_account[0]['check_user_activated'] == 1){
    //                                        // login
                                            $login=new LoginForm;
                                            $login->username=$list_account[0]['account_email'];
                                            $login->account_check_social_login_id_facebook=$identity->id;
                                            $login->rememberMe=1;
    //                                        echo $login->loginSocial(); exit;
                                            if($login->loginSocialFacebook()){
                                                if($checkServer == 'church-one') {
													$this->redirect(array("site/dashboardchurchone"));
												} else if($checkServer == "linxone"){
													$this->redirect(array('/'.LBApplication::getCurrentlySelectedSubscription() . "/lbInvoice/dashboard"));
												}
                                            }
                                        } else if (isset($list_account[0]['account_check_social_login_id_facebook'])) {
                                            Yii::app()->user->setFlash('success', Yii::t('lang','You are not assigned to any module yet. Please contact the Administrator to access the system'));
                                        }else {
    //                                      register
                                            $account = new Account();
                                            $account->account_email = $identity->email;
                                            $account->account_password = "newaccount";
                                            $account->account_status = 1;
                                            $account->account_check_social_login_id_facebook = $identity->id;
                                            $account->check_user_activated = 0;
                                            $account->save();
                                            Yii::app()->user->setFlash('success', Yii::t('lang','Create Account Successfully'));
                                        }
                                    }
//						Yii::app()->user->login($identity);
                                    //var_dump($identity->id, $identity->name, Yii::app()->user->id);exit;

                                    // special redirect with closing popup window
//						$eauth->redirect();
                                }
                                else {
                                        // close popup window and redirect to cancelUrl
                                        $eauth->cancel();
                                }
                            }

				// Something went wrong, redirect to login page
                            $this->redirect(array('site/login'));
			}
			catch (EAuthException $e) {
				// save authentication error to session
				Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());

				// close popup window and redirect to cancelUrl
				$eauth->redirect($eauth->getCancelUrl());
			}
		}
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->username=$_POST['LoginForm']['username'];
                        $model->password=$_POST['LoginForm']['password'];
                        $model->rememberMe=1;
//                        print_r($_POST['LoginForm']);
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				if($checkServer == 'church-one') {
					$this->redirect(array("site/dashboardchurchone"));
				} else if($checkServer == "linxone"){
					$this->redirect(array('/'.LBApplication::getCurrentlySelectedSubscription() . "/lbInvoice/dashboard"));
				}
			}
				//$this->redirect(array("project/index"));
					// display the login form
                        //LBApplication::renderPartial($this, 'login', array('model'=>$model));
		}
		
		// if already login, show projects index
		if (isset(Yii::app()->user->id) && Yii::app()->user->id > 0)
		{
                       
                        
			if($checkServer == 'church-one') {
				$this->redirect(array("site/dashboardchurchone"));
			} else if($checkServer == "linxone"){
				$this->redirect(array('/'.LBApplication::getCurrentlySelectedSubscription() . "/lbInvoice/dashboard"));
			}
			//$this->redirect(array("project/index"));
		}
		
		if($checkServer == 'church-one') {
			// display the login form
			LBApplication::renderPartial($this, 'login_church_one', array('model'=>$model));
		} else if($checkServer == "linxone"){
			// display the login form
			LBApplication::renderPartial($this, 'login', array('model'=>$model));
		}

		//$this->render('login',array('model'=>$model));
            
            /* CODE TICH HOP */
                /*
            $app = Yii::app();
            $request = $app->getRequest();
            $linxHQAPI = new LinxHQAuthenticationAPI;
            $remote_data = $linxHQAPI::isAuthenticated();
            if (isset($remote_data) && $remote_data->action_code == 'ALREADY_AUTHENTICATED') {
               $loginForm = new LoginForm();
               if ($loginForm->remoteLogin($remote_data))
               {
                    // if already login, show projects index
                    if (isset(Yii::app()->user->id) && Yii::app()->user->id > 0)
                    {


                            $this->redirect(array('/'.LBApplication::getCurrentlySelectedSubscription() . "/lbInvoice/dashboard"));
                            //$this->redirect(array("project/index"));
                    }
               } else {
                  $request->redirect(Yii::app()->params['linxhqAccountsURL']);
               }
            }*/
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
            Yii::app()->user->logout();
            $this->redirect(array("site/login"));
            
            /* CODE TICH HOP */
            //Yii::app()->getRequest()->redirect(Yii::app()->params['linxhqLogoutURL']);
	}
	
	public function actionSearch()
	{
		// only allow logged in user
		if (Yii::app()->user->isGuest)
			return;
		
		$query = trim($_GET['query']);
		$query = strtolower($query);
		$results = array();
		
		// search document's name
		/**
		$documents = Documents::model()->searchByKeyword($query);
		foreach ($documents as $doc)
		{
			$doc->document_real_name = LBApplication::encodeToUTF8($doc->document_real_name);
			$results[] = 
				//'<i class="icon-file"></i>'.
				LBApplication::workspaceLink(LBApplication::getShortName($doc->document_real_name, false, 20)
					. ' ' . LBApplication::displayFriendlyDateTime($doc->document_date), 
					array('document/download','id'=>$doc->document_id),
					array(
							'rel' => 'tooltip', 
							'title'=> 'Document: ' . strip_tags($doc->document_real_name),
							'style'=>'color: #333333',
							'data-linx-type'=>'linx-document',
							'data-linx-search-query'=>$query,// so that this result will show in dropdown
							'target'=>'_new'));
			//$option = $doc->document_real_name . ' ' . $doc->document_date;
		}**/
			
		header('Content-type', 'application/json');
		echo CJSON::encode(array('options' => $results));
	}
	
	/**
	 * Switch subscription
	 * 
	 * @param unknown $id
	 */
	public function actionSubscription($id)
	{
		LBApplication::setCurrentlySelectedSubscription($id);
		$this->redirect(Yii::app()->baseUrl."/index.php/".$id."/lbInvoice/dashboard");
	}
        
    /**
     * Setting Useing languares
     * 
     */
    
    public function actionLanguares($typelang = NULL)
    {
        if(!empty($typelang))
        {
//                Yii::app()->session['sess_lang'] = strtolower($typelang);
            $_SESSION["sess_lang"] = strtolower($typelang);
            lbLangUser::model()->updateLang(Yii::app()->user->id,$typelang);
            $this->redirect(Yii::app()->request->urlReferrer);
            
        }
        else
            $this->render('languages');
        
    }

    public function actionDashboardchurchone()
    {
    	$modelCheckServer = new LbCheckServer();
		$checkServer = $modelCheckServer->checkServer();

		if($checkServer == 'church-one') {
			$this->render('dashboard_church_one');
		} else if($checkServer == "linxone"){
			$this->redirect(array('/'.LBApplication::getCurrentlySelectedSubscription() . "/lbInvoice/dashboard"));
		}
		return "You do not have access";
    }
}