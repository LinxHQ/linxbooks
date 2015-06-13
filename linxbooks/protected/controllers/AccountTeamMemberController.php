<?php

class AccountTeamMemberController extends Controller
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
				'users'=>array('admin'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'update', 'dropdownSource'),
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
		$model=new AccountTeamMember;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccountTeamMember']))
		{
			$model->attributes=$_POST['AccountTeamMember'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->account_team_member_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * 
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccountTeamMember']))
		{
			$model->attributes=$_POST['AccountTeamMember'];
			if($model->save())
				$this->redirect(array('admin'));//(array('view','id'=>$model->account_team_member_id));
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
		$dataProvider=new CActiveDataProvider('AccountTeamMember');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Return an json datasource of team members 
	 * [{value: 1, text: "text1"}, {value: 2, text: "text2"}, ...]
	 */
	public function actionDropdownSource()
	{
		if (isset($_GET['account_id']))
		{
			// if current user is not part of this master account team, don't load
			$master_account_id = $_GET['account_id'];
			if (!AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id)
					&& Yii::app()->user->id != $master_account_id)
			{
				return '';
			}
			
			$account_team_members = AccountTeamMember::model()->getTeamMembers($master_account_id, true);
			
			$dd_array = array();
			foreach ($account_team_members as $m)
			{
				// skip deactivated member
				//if ($m->is_active == AccountTeamMember::ACCOUNT_TEAM_MEMBER_IS_DEACTIVATED)
				//	continue;
				$name = AccountProfile::model()->getShortFullName($m->member_account_id);
				$name = mb_check_encoding($name, 'UTF-8') ? $name : utf8_encode($name);
				
				$dd_array[] = array('value' => $m->member_account->account_id, 
						'text' => $name);
			}
			
			// add master account name
			// because getTeamMemebrs only return team member, not master account.
			$master_name = AccountProfile::model()->getShortFullName($master_account_id);
			//$master_name = mb_check_encoding($master_name, 'UTF-8') ? $master_name : utf8_encode($master_name);
			$dd_array[] = array('value' => $master_account_id, 
					'text' => $master_name);
			
			echo CJSON::encode($dd_array);
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		//$model = new AccountTeamMember('search');
		//$model->unsetAttributes();  // clear any default values
		// get team members I'm in charge
		//$model->master_account_id = Yii::app()->user->id;
            
                $subcription = LBApplication::getCurrentlySelectedSubscription();
	
		// CADP for getting list my team members of team that user is the master account of.
		$memberCADataProvider = AccountTeamMember::model()->getTeamMembers($subcription);
		
		// CADP for getting list of members from OTHER teams of which user is NOT the master account of.
		$otherMemberCADataProvider = AccountTeamMember::model()->getMyOtherTeams(Yii::app()->user->id,$subcription);
		
		// CADP for invites to this user
		$invitesToUserCADataProvider = AccountInvitation::model()->getInvitesToAccount(Yii::app()->user->id);
		
		// get master account of people whose teams I'm part of
		$model2 = new AccountTeamMember('search');
		$model2->unsetAttributes();
		$model2->member_account_id = Yii::app()->user->id;
		
		if(isset($_GET['AccountTeamMember']))
			$model->attributes=$_GET['AccountTeamMember'];

		$this->render('admin',array(
			'memberCADataProvider' => $memberCADataProvider,
			'otherMemberCADataProvider' => $otherMemberCADataProvider,
			'invitesToUserCADataProvider'=>$invitesToUserCADataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AccountTeamMember the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AccountTeamMember::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AccountTeamMember $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-team-member-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
