<?php

class AccountInvitationController extends Controller
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
				'actions'=>array('accept'),
				'users'=>array('*'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','joinTeam'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
		// check permission
		// only subscriber can invite
		if (!AccountSubscription::model()->isSubscriber(Yii::app()->user->id))
		{
			throw new CHttpException(401,'You must be a subscriber to invite someone.');
			return;
		}
		
		$model=new AccountInvitation;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccountInvitation']))
		{
			$model->attributes=$_POST['AccountInvitation'];
			//$model->account_invitation_message = $_POST['AccountInvitation']['account_invitation_message'];
			if($this->createAccountInvitation($model)) 
			{
				$this->redirect(array('admin'));
				//$this->actionAdmin();
			}
		}

		$data = array(
			'model'=>$model,
		);
		
		LBApplication::render($this, 'create', $data);
		//$this->render('create',array(
		//	'model'=>$model,
		//));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		// check permission
		// only subscriber can invite
		if (!AccountSubscription::model()->isSubscriber(Yii::app()->user->id))
		{
			throw new CHttpException(401,'You must be a subscriber to invite someone.');
			return;
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccountInvitation']))
		{
			$model->attributes=$_POST['AccountInvitation'];
			//$model->account_invitation_message;
			if($this->createAccountInvitation($model))
				$this->redirect(array('view','id'=>$model->account_invitation_id));
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
		$dataProvider=new CActiveDataProvider('AccountInvitation', array(
				'criteria'=>array(
				        'condition'=>'account_invitation_master_id = ' . Yii::app()->user->id,
				    ),
				));
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AccountInvitation('search');
		$model->unsetAttributes();  // clear any default values
		$model->account_invitation_master_id = Yii::app()->user->id;
		
		if(isset($_GET['AccountInvitation']))
			$model->attributes=$_GET['AccountInvitation'];

		LBApplication::render($this, 'admin', array(
			'model'=>$model,
		));
		/**
		$this->render('admin',array(
			'model'=>$model,
		));**/
	}
	
	public function actionAccept($id, $key)
	{
		// must not be logged in user
		if (!Yii::app()->user->isGuest)
		{
			$this->redirect(array('site/page', 'view' => 'must_log_out'));
		}
		
		$model = $this->loadModel($id);
		
		// must match both id and random key
		if (!$model)
		{
			echo "Hi. Somehow this invitation is missing or removed. Please contact the person who invited you.";
			return;
		}
		
		if ($model->account_invitation_rand_key != $key)
		{
			echo "Hi there. Looks like your invitation is no longer valid. Please contact the person who invited you.";
			return;
		}
		
		if ($model->account_invitation_status == 1)
		{
			echo "Looks like you already accepted this invitation.";
			return;
		}
		
		$account = new Account();
		
		// SUBMISSION PROCESS
		// Get account invitation record that has this unique key
		// 1. Update invitation status to accepted
		// 2. Create new account for this user
		// 3. Put this user under team member of the master account
		if (isset($_POST['Account']['account_password']))
		{
			$model->account_invitation_status = 1;
			if ($model->save())
			{
				
				$account->account_email = $model->account_invitation_to_email;
				$account->account_password = $_POST['Account']['account_password'];
				$account->account_status = ACCOUNT_STATUS_ACTIVATED;
				if ($account->save())
				{
					// create account profile
					$accountProfile = new AccountProfile();
					$accountProfile->account_id = $account->account_id;
					$accountProfile->account_profile_surname = $_POST['AccountProfile']['account_profile_surname'];
					$accountProfile->account_profile_given_name = $_POST['AccountProfile']['account_profile_given_name'];
					$accountProfile->account_profile_preferred_display_name = 
						$accountProfile->account_profile_given_name . ' ' . $accountProfile->account_profile_surname;
					if ($accountProfile->save())
					{
						// create team member record
						$teamMember = new AccountTeamMember();
						$teamMember->accepting_invitation = true;
						$teamMember->master_account_id = $model->account_invitation_master_id;
						$teamMember->member_account_id = $account->account_id;
                                                $teamMember->account_subscription_id = $model->account_invitation_subscription_id;
						$teamMember->is_active = AccountTeamMember::ACCOUNT_TEAM_MEMBER_IS_ACTIVE;
						if ($model->account_invitation_type == AccountInvitation::ACCOUNT_INVITATION_TYPE_CUSTOMER)
							$teamMember->is_customer = ACCOUNT_TEAM_MEMBER_IS_CUSTOMER;
						else $teamMember->is_customer = 0;
						
						if ($teamMember->save())
						{
							//$companyContact = 
							
							// create project member record if any
							if ($model->account_invitation_project > 0)
							{
								$projectMember = new ProjectMember;
								$projectMember->project_id = $model->account_invitation_project;
								$projectMember->account_id = $account->account_id;
								$projectMember->project_member_start_date = date('Y-m-d H:i:s');
								$projectMember->project_member_is_manager = PROJECT_MEMBER_IS_NOT_MANAGER;
								$projectMember->accepting_invitation = true;
								$projectMember->save();
							}
							
							$this->redirect(array('site/page', 'view' => 'account_activated'));
						}
					}
				}
			}
		}
		// SHOW VIEW
		// show acceptance form, where user has to enter password
		$this->render('accept', array(
			'model' => $model,
			'account' => $account,
		));
	}
	
	/**
	 * This action is used for an existing account who is invited to another team.
	 */
	public function actionJoinTeam()
	{
		if (isset($_GET['invite_id']))
		{
			$invite_id = $_GET['invite_id'];
			
			// get invite
			$model = $this->loadModel($invite_id);
			$model->account_invitation_status = 1;
			$model->save();
			
			// create team member record
			$teamMember = new AccountTeamMember();
			$teamMember->accepting_invitation = true;
			$teamMember->master_account_id = $model->account_invitation_master_id;
                        $teamMember->account_subscription_id = $model->account_invitation_subscription_id;
			$teamMember->member_account_id = Yii::app()->user->id;
			$teamMember->is_active = AccountTeamMember::ACCOUNT_TEAM_MEMBER_IS_ACTIVE;
			if ($model->account_invitation_type == AccountInvitation::ACCOUNT_INVITATION_TYPE_CUSTOMER)
				$teamMember->is_customer = ACCOUNT_TEAM_MEMBER_IS_CUSTOMER;
			else $teamMember->is_customer = 0;
			
                        if($teamMember->save())
                            $this->redirect(array('accountTeamMember/admin'));
			if ($teamMember->save())
			{
				// create project member record if any
				if ($model->account_invitation_project > 0)
				{
					$projectMember = new ProjectMember;
					$projectMember->project_id = $model->account_invitation_project;
					$projectMember->account_id = Yii::app()->user->id;
					$projectMember->project_member_start_date = date('Y-m-d H:i:s');
					$projectMember->project_member_is_manager = PROJECT_MEMBER_IS_NOT_MANAGER;
					$projectMember->accepting_invitation = true;
					$projectMember->save();
				}
			}
		}
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AccountInvitation the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AccountInvitation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AccountInvitation $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-invitation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * 
	 * @param AccountInvitation $model
	 * @return boolean
	 */
	public function createAccountInvitation($model) {
		// foreach email create one separate invitation record
		$emails = explode(',', $model->account_invitation_to_email);
		
		foreach ($emails as $invite)
		{
			$inviteModel = new AccountInvitation();
			$inviteModel->account_invitation_to_email = trim($invite);
			$inviteModel->account_invitation_master_id = Yii::app()->user->id;
			$inviteModel->account_invitation_date = date('Y-m-d H:i');
			$inviteModel->account_invitation_status = 0;
			$inviteModel->account_invitation_rand_key = AccountInvitation::generateInvitationKey();
			$inviteModel->account_invitation_project = $model->account_invitation_project;
			$inviteModel->account_invitation_type = $model->account_invitation_type;
                        $inviteModel->account_invitation_subscription_id = $model->account_invitation_subscription_id;
			
			$result_return = $inviteModel->save();
			
			if($result_return) {
				// send email
				$message = new YiiMailMessage();
				$sender_name = AccountProfile::model()->getShortFullName(Yii::app()->user->id);
				
				// if this invitee already has an account with LinxCircle
				// use a different invitation template
				$tempAccount = Account::model()->getAccountByEmail(trim($invite));
				if ($tempAccount != null)
				{
					$message->view = "invitationEmailExistingAccount";
					$subject = $sender_name . ' invited you to join a team on ' . Yii::app()->name;
				} else {
					$message->view = "invitationEmail";
					$subject = $sender_name . ' invites you to join ' . Yii::app()->name;
				}
				
				//userModel is passed to the view
				$message->setBody(
						array(
								'invitation_accept_url' => AccountInvitation::generateInvitationURL($inviteModel->account_invitation_id, $inviteModel->account_invitation_rand_key),
								'invitation_message' => $model->account_invitation_message,
								), 
						'text/html');
				
				$message->setSubject($subject);
				//$message->setBody($body, 'text/html');
				//$message->addTo($model->account_invitation_to_email);
				$message->addTo($invite);
				$message->setFrom('thongnv@lionsoftwaresolutions.com');
				Yii::app()->mail->send($message);
			}
		}
		return true;
	}
}
