<?php

class NotificationController extends Controller
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
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','updateAsRead','checkNotification','updateMultipleAsRead'),
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
		$model=new Notification;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Notification']))
		{
			$model->attributes=$_POST['Notification'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->notification_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['Notification']))
		{
			$model->attributes=$_POST['Notification'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->notification_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

        public function actionUpdateAsRead($id)
	{
		$model=$this->loadModel($id);
                
                // permission
                if ($model->notification_receivers_account_ids != Yii::app()->user->id)
                    Utilities::render($this, '//layouts/plain_ajax_content', array('content'=>'false'));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model->notification_status = Notification::NOTIFICATION_STATUS_READ;
                if ($model->save())
                {
                    $content = 'true';
                        
                } else {
                    $content = 'false';
                }

		Utilities::render($this, '//layouts/plain_ajax_content', array('content'=>'true'));
	}
        
        /**
         * Update multiple notification
         */
        public function actionUpdateMultipleAsRead()
        {
            $ids = isset($_GET['ids'])? $_GET['ids'] : '';
            
            // update all unread as read
            if ($ids == 'all')
            {
                $unread_notifications = Notification::model()->getNotificationsForAccount(null, 
                        $notification_status = Notification::NOTIFICATION_STATUS_UNREAD, 
                        $return_type = 'modelArray');
                foreach ($unread_notifications as $notification)
                {
                    $notification->updateNotificationAsRead();
                }
            } else {
                // updated only those requested 
                $ids_array = explode(',', $ids);
                foreach ($ids_array as $notification_id)
                {
                    if (intval($notification_id) > 0)
                    {
                        $model = $this->loadModel($notification_id);
                        $model->updateNotificationAsRead();
                    }
                }
            }
            
            return true;
        }
        
        /**
         * count notification and check if there's new one since last check
         */
        public function actionCheckNotification()
        {
            $past_seconds = isset($_GET['past_seconds']) ? $_GET['past_seconds'] : 30;
            
            // count unread
            $notifications = Notification::model()->getNotificationsForAccount(
                    Yii::app()->user->id,
                    Notification::NOTIFICATION_STATUS_UNREAD,
                    'modelArray');
            
            // any new ones?
            $has_new = false;
            $timestamp = time() - intval($past_seconds);
            $pit = date('Y-m-d H:i', $timestamp);
            foreach ($notifications as $notif)
            {
                if ($notif->notification_created_date >= $pit)
                {
                    $has_new = true;
                    break;
                }
            }
            
            // return
            Utilities::render($this, '//layouts/plain_ajax_content', array(
                'content'=>  CJSON::encode(array(
                    'unread'=>count($notifications),
                    'has_new'=>$has_new
                    ))));
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
		$model=new Notification('search');
		$model->unsetAttributes();  // clear any default values

                Utilities::render($this, 'index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Notification('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Notification']))
			$model->attributes=$_GET['Notification'];

                Utilities::render($this, 'admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notification the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Notification::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notification $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='notification-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
