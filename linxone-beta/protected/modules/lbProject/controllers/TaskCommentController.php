<?php

class TaskCommentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1ajax';

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
				'actions'=>array('index','delete','birdview'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'cancelCreate', 'ajaxUpdate', 'cancelUpdate', 'ajaxUpdateField','UpdateTotoComplete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','view'),
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
	
	public function actionBirdView($id)
	{
		$this->render('birdView',array(
				'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TaskComment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TaskComment']))
		{
			$model->attributes = $_POST['TaskComment'];
			$model->task_comment_created_date = date('Y-m-d H:i:s');
			/**
			$now = date('Y-m-d H:i:s');
			$model->task_comment_owner_id = Yii::app()->user->id;
			$model->task_comment_last_update = $now;
			$model->task_comment_created_date = $now;
			if ($model->task_comment_parent_id === null) $model->task_comment_parent_id = 0;
			else {
				if ($model->task_comment_parent_id > 0) 
				{
					// check if its parent is actually a reply. 
					// if the parent is a reply, disallow create
					$tempComment = TaskComment::model()->findByPk($model->task_comment_parent_id);
					if ($tempComment && $tempComment->task_comment_parent_id > 0)
					{
						return "";
					}
				}
			}**/
                        
                        // if there's uploaded document, but user doesn't 
                        // enter any comment, use "uploaded" as comment
                        if(isset($_POST['temp_uploaded_file_names'])
                                && $model->task_comment_content == NULL)
                        {
                            $model->task_comment_content = 'Uploaded';
                        }
			
			if($model->save())
			{				
				// check if there's any file uploaded to temp folder
				// if yes, move it to actual folder for this comment's task
				$this_comment_documents = array();
				$task_comment_documents = array();
				if(isset($_POST['temp_uploaded_file_names']))
				{
					$filenames_arr = $_POST['temp_uploaded_file_names'];
					
					foreach($filenames_arr as $filename) // $filename is temp name uploaded in temp folder
					{
						$doc = new Documents();
						//$uploaded_date = date('Y-m-d H:i:s');
						
						// get original name if available.
						// because sometimes due to same name, filename may have included additional chars 
						// by the uploader
						$filename_original = $filename;
						$filename_original_idx = str_replace('.', '_', $filename_original) . "_original_name";
						if (isset($_POST[$filename_original_idx]))
						{
							$filename_original = $_POST[$filename_original_idx];
						}
						$doc->document_temp_name = $filename;
						$doc->document_real_name = $filename_original;
						//$doc->document_date = $uploaded_date;
						//$doc->document_encoded_name = $doc->encodeDocumentName();
						//$doc->document_revision = 0;
						//$doc->document_root_revision_id = 0;
						$doc->document_parent_id = $model->task_comment_id;
						$doc->document_task_id = $model->task_id;
						$doc->document_parent_type = DOCUMENT_PARENT_TYPE_TASK_COMMENT;
						//$doc->document_owner_id = Yii::app()->user->id;
						
						if ($doc->save())
						{
							// now, move file to actual location
							$doc->moveToActualLocation();
							$this_comment_documents[] = $doc;
						}
					}
					
					$task_comment_documents[$model->task_comment_id] = $this_comment_documents;
				}
                                
                                // save progress if available
                                if (isset($_POST['tp_assignee_startAt_'.$model->task_comment_owner_id])
                                        && isset($_POST['tp_days_completed_'.$model->task_comment_owner_id]))
                                {
                                    $taskProgress = new TaskProgress;
                                    $taskProgress->AddTaskProgress($model->task_id, 
                                            $model->task_comment_owner_id, 
                                            $_POST['tp_assignee_startAt_'.$model->task_comment_owner_id],
                                            $_POST['tp_days_completed_'.$model->task_comment_owner_id]);
                                }
				
				//$this->redirect(array('view','id'=>$model->task_comment_id));

				// Add email notifications to selected parties
				//$this->addEmailNotifications($model);
				
				// Render result view
				Utilities::render($this, '/taskComment/_viewThread', array(
						'comment' => $model,
						'task_id' => $model->task_id,
						'task_comment_documents' => $task_comment_documents,
						//'debug' => (isset($_POST[$filename . '_original_name']) ? isset($_POST[$filename . '_original_name']) : '???'),
				), false, true);
				/**
				$this->renderPartial('//taskComment/_viewThread', array(
						'comment' => $model,
						'task_id' => $model->task_id,
						'task_comment_documents' => $task_comment_documents,
						//'debug' => (isset($_POST[$filename . '_original_name']) ? isset($_POST[$filename . '_original_name']) : '???'),
				), false, true);
				**/
				return;
			}
		}

		/**
		$this->render('create',array(
			'model'=>$model,
		));**/
		// show create form
		if(isset($_GET['task_id'])){
			$task_assignees = TaskAssignee::model()->getTaskAssignees($_GET['task_id'], true);

			$data = array(
				'comment' => (isset($_GET['task_comment_id']) && $_GET['task_comment_id'] != null)? TaskComment::model()->findByPk($_GET['task_comment_id']) : new TaskComment(),
				'task_id' => isset($_GET['task_id']) ? 	$_GET['task_id'] : 0,
				'is_reply' => isset($_GET['is_reply']) ? $_GET['is_reply'] : 0,
				'task_assignees' => $task_assignees,
			);
			Utilities::render($this, '_form', $data, false, true);
		}

		if(isset($_REQUEST['task_id']) && isset($_REQUEST['replay'])){
			$task_assignees = TaskAssignee::model()->getTaskAssignees($_REQUEST['task_id'], true);

			$data = array(
				'comment' => (isset($_REQUEST['comment_id']) && $_REQUEST['comment_id'] != null)? TaskComment::model()->findByPk($_REQUEST['comment_id']) : new TaskComment(),
				'task_id' => isset($_REQUEST['task_id']) ? 	$_REQUEST['task_id'] : 0,
				'is_reply' => isset($_REQUEST['is_reply']) ? $_REQUEST['is_reply'] : 0,
				'task_assignees' => $task_assignees,
			);
			Utilities::render($this, '_form', $data, false, true);
		}
		//$this->renderPartial('_form', $data , false, true);
	}
	
	/**
	 * NOTE:  This is moved to TaskComment.php 
	 * Add email notification when a comment is created or updated.
	 * 
	 * @param unknown $model
	 */
	/**
	private function addEmailNotifications ($model)
	{
		$comment_id = $model->task_comment_id;
		if (isset($_POST['assignee_notify_task_' . $model->task_id]))
		{
			$receivers_ids = $_POST['assignee_notify_task_' . $model->task_id];
			
			$notification = new EmailNotification();
			$notification->notification_parent_id = $comment_id;
			$notification->notification_parent_type = NOTIFICATION_PARENT_TYPE_TASK_COMMENT;
			$notification->notification_sent = NOTIFICATION_SENT_NO;
			$notification->notification_receivers_account_ids = implode(',', $receivers_ids);
			$notification->save(); 
		}
	}**/
	
	/**
	 * Perform update 
	 * or load update/add form
	 * 
	 * @param unknown $id
	 */
	public function actionAjaxUpdate()
	{
		if(isset($_REQUEST['task_comment_id'])){
			$model = $this->loadModel($_REQUEST['task_comment_id']);
		}
		
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['TaskComment']))
		{
			$model = new TaskComment();
			$model->attributes = $_POST['TaskComment'];
			
			if($model->save())
			{
				// check if there's any file uploaded to temp folder
				// if yes, move it to actual folder for this comment's task
				$this_comment_documents = array();
				$task_comment_documents = array();
				if(isset($_POST['temp_uploaded_file_names']))
				{
					$filenames_arr = $_POST['temp_uploaded_file_names'];
						
					foreach($filenames_arr as $filename) // $filename is temp name uploaded in temp folder
					{
						$doc = new Documents();
						// get original name if available.
						// because sometimes due to same name, filename may have included additional chars
						// by the uploader
						$filename_original = $filename;
						$filename_original_idx = str_replace('.', '_', $filename_original) . "_original_name";
						if (isset($_POST[$filename_original_idx]))
						{
							$filename_original = $_POST[$filename_original_idx];
						}
						$doc->document_temp_name = $filename;
						$doc->document_real_name = $filename_original;
						$doc->document_parent_id = $model->task_comment_id;
						$doc->document_task_id = $model->task_id;
						$doc->document_parent_type = DOCUMENT_PARENT_TYPE_TASK_COMMENT;

						if ($doc->save())
						{
							// now, move file to actual location
							$doc->moveToActualLocation();
							//$this_comment_documents[$doc->document_id] = $doc;
						}
					}
						
					//$task_comment_documents[$model->task_comment_id] = $this_comment_documents;
				}
                                
                                // save progress if available
                                if (isset($_POST['tp_assignee_startAt_'.$model->task_comment_owner_id])
                                        && isset($_POST['tp_days_completed_'.$model->task_comment_owner_id]))
                                {
                                    $taskProgress = new TaskProgress;
                                    $taskProgress->AddTaskProgress($model->task_id, 
                                            $model->task_comment_owner_id, 
                                            $_POST['tp_assignee_startAt_'.$model->task_comment_owner_id],
                                            $_POST['tp_days_completed_'.$model->task_comment_owner_id]);
                                }
				
				// get all documents
				$existing_docs = Documents::model()->findAllCommentDocuments($model->task_comment_id, DOCUMENT_PARENT_TYPE_TASK_COMMENT);
				foreach ($existing_docs as $ed)
				{
					// insert using document_id as index
					$task_comment_documents[$model->task_comment_id][$ed->document_id] = $ed;
				}
				
				// add email notification to involved parties
				//$this->addEmailNotifications($model);
				
				$this->renderPartial('_view', array(
					'comment' => $model,
					'task_comment_documents' => $task_comment_documents,
				), false, true);
				
				return;
			}
		}
		
		// show form
		// get task assignees for notification settings
		$task_assignees = TaskAssignee::model()->getTaskAssignees($model->task_id, true);
		$this->renderPartial('_form',array(
				'comment' => $model,
				'task_id' => $model->task_id,
				'task_assignees' => $task_assignees,
				'is_reply' => ($model->task_comment_parent_id > 0 ? YES : NO),
				'is_update' => YES,
		), false, true);
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
	
	public function actionCancelUpdate($comment_id)
	{
		$model = $this->loadModel($comment_id);
		
		Utilities::render($this, '//layouts/plain_ajax_content', array(
				'content' => $model->task_comment_content,
				'task_id' => $model->task_id,
				'is_reply' => ($model->task_comment_parent_id > 0 ? YES : NO),
		), false, true);
		/**
		$this->renderPartial('//layouts/plain_ajax_content',array(
				'content' => $model->task_comment_content,
				'task_id' => $model->task_id,
				'is_reply' => ($model->task_comment_parent_id > 0 ? YES : NO),
		), false, true);
		**/
	}
	
	public function actionCancelCreate()
	{
		$task_id = (isset($_GET['task_id']) ? $_GET['task_id'] : 0);
		$is_reply = (isset($_GET['is_reply']) ? $_GET['is_reply'] : 0);
		$comment_id = (isset($_GET['comment_id']) ? $_GET['comment_id'] : 0); 
		$ajax_options = array();
		if ($is_reply == 1)
		{
			$ajax_options = array('update' => '#comment-thread-reply-form-' . $comment_id);
		} else {
			$ajax_options = array('update' => '#form-comment');
		}

		// $link = CHtml::ajaxLink(
		// 	( $is_reply == NO ? YII::t('core','Comment or upload document') : YII::t('core','Click to Reply')),
		// 	array('taskComment/create', 
		// 			'task_id' => $task_id, 
		// 			'is_reply' => $is_reply, 
		// 			'task_comment_id' => $comment_id,
		// 			'ajax' => 1), // Yii URL
		// 	$ajax_options,
		// 	array('id' => 'ajax-id-'.uniqid(),'live'=>false)
		// );

		$link = '<a id="ajax-id-'.uniqid().'" href="#" onclick="create_comment_task('.$task_id.'); return false;">'.YII::t('core','Comment or upload document').'</a>';;
		
		Utilities::render($this, '//layouts/plain_ajax_content', array('content' => $link ), false, true);
		//$this->renderPartial('//layouts/plain_ajax_content', 
		//		array('content' => $link ), false, true);
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

		if(isset($_POST['TaskComment']))
		{
			$model->attributes=$_POST['TaskComment'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->task_comment_id));
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
	public function actionDelete()
	{
		$model = $this->loadModel($_REQUEST['task_comment_id']);
		if ($model->delete())
		{
			echo SUCCESS;
			return;
		}
		
		echo FAILURE;

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_GET['ajax']))
		//	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TaskComment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TaskComment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TaskComment']))
			$model->attributes=$_GET['TaskComment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
	public function actionUpdateTotoComplete()
	{

		if(isset($_POST['TodoComplete']) && isset($_POST['comment_id']))
		{
                    	$model=$this->loadModel($_POST['comment_id']);
			$model->task_comment_to_do_completed=$_POST['TodoComplete'];
                        if($model->save())
                        {
                            $result['status'] =  SUCCESS;
                            $result['todo_complete'] = $model->task_comment_to_do_completed;
                            echo CJSON::encode($result);
                            return;
                        }
				
		}
                $result['status'] =  FAILURE;
                echo CJSON::encode($result);
                return;

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TaskComment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TaskComment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TaskComment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='task-comment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
