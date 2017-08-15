<?php

class WikiPageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	public function actions() {
		return array(
			'upload' => array(
				'class' => 'xupload.actions.XUploadAction', 
				'path' => Documents::model()->getTempFolderPath(),
				'subfolderVar' => false,
				"publicPath" => Yii::app()->getBaseUrl()."/wiki-attachments" ), // NEVER USE!!!
			'sortable' => array(
				'class' => 'ext.sortable.SortableAction',
				'model' => WikiPage::model()),
		);
	}
	
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
				'actions'=>array('index','view','viewProjectHome' ,'wikiTreeSource', 'formUploadView', 'upload', 'sortable'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'autoSave', 'reorderSubPages','popTemplates'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete', 'adminTemplate'),
				'users'=>array('@'),
			),
			array('allow',
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
		$model = $this->loadModel($id);
		
		// check if we need to switch subscription
		if (isset($_GET['subscription']))
		{
			Utilities::setCurrentlySelectedSubscription($_GET['subscription']);
		}
		
		// Check permission before showing form
		if (!Permission::checkPermission($model, PERMISSION_WIKI_PAGE_VIEW)
				|| !$model->matchedCurrentSubscription())
		{
			throw new CHttpException(401,'You are not given the permission to view this page.');
			return false;
		}
		
		// get peer pages
		$peer_pages = $model->getPeerPages();
		// get subpages
		$subpages = WikiPage::model()->getProjectWikiPages($model->project_id, $model->wiki_page_id, 'sort DESC, wiki_page_title ASC', true);
		$attachments = Documents::model()->findAllWikiPageAttachments($id);
		
		$data = array(
			'model'=> $model,
			'peer_pages'=>$peer_pages,
			'subpages' => $subpages,
			'attachments' => $attachments,
		);
		
		Utilities::render($this, 'view', $data);
		//$this->renderPartial('view',$data, false, true);
	}

    /**
     * Load home page of project wiki
     *
     * @param $id
     * @return bool
     * @throws CHttpException
     */
    public function actionViewProjectHome($id)
    {
        $model = $this->loadModel($id);

        // check if we need to switch subscription
        if (isset($_GET['subscription']))
        {
            Utilities::setCurrentlySelectedSubscription($_GET['subscription']);
        }

        // Check permission before showing form
        if (!Permission::checkPermission($model, PERMISSION_WIKI_PAGE_VIEW)
            || !$model->matchedCurrentSubscription())
        {
            throw new CHttpException(401,'You are not given the permission to view this page.');
            return false;
        }

        // get peer pages
        //$peer_pages = $model->getPeerPages();
        // get subpages
        $subpages = WikiPage::model()->getProjectWikiPages($model->project_id, $model->wiki_page_id, 'sort DESC, wiki_page_title ASC', true);
        $attachments = Documents::model()->findAllWikiPageAttachments($id);

        $data = array(
            'model'=> $model,
            //'peer_pages'=>$peer_pages,
            'subpages' => $subpages,
            'attachments' => $attachments,
        );

        Utilities::render($this, '_view_project_home', $data);
        //$this->renderPartial('view',$data, false, true);
    }
	
	public function actionFormUploadView($id)
	{	
		if ($id > 0)
		{
			$wikiPage = $this->loadModel($id);
		} else {
			$wikiPage = new WikiPage();
		}
		
		$model = new XUploadForm;
		$model->secureFileNames = true;
		
		$this->renderPartial('_form_upload', array(
			'model'=> $model,
			'wikiPage' => $wikiPage,
			'project_id' => $_GET['project_id'],
		), false, true);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new WikiPage;
		$project_id = isset($_GET['project_id']) ? $_GET['project_id'] : 0;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WikiPage']))
		{
			// autosave might have taken place
			// if so, forward this action to Update instead
			if (isset($_POST['WikiPage']['wiki_page_id']) && $_POST['WikiPage']['wiki_page_id'] > 0)
			{
				// ALMOST ALWAYS COME HERE IF AUTOSAVE IS SET TO HIGH FREQUENCY
				$this->actionUpdate($_POST['WikiPage']['wiki_page_id']);
				return true;
			}
			
			// else carry on
			$model->attributes=$_POST['WikiPage'];
			if($model->save())
			{
				// see if there's any document to attach
				$this_wiki_attachments = array();
				$this_wiki_attachments = $this->handleAttachments($model);
				
				// get subpages
				$subpages = WikiPage::model()->getProjectWikiPages($model->project_id, $model->wiki_page_id, 'wiki_page_order ASC', true);
				
				//$this->redirect(array('view','id' => $model->wiki_page_id));
				$this->redirect($model->getWikiPageURL());
				/**
				$this->renderPartial('view', array(
					'id' => $model->wiki_page_id,
					'model' => $model,
					'subpages' => $subpages,
					'attachments' => $this_wiki_attachments,
				), false, true);
				**/
				//return;
			}
		}
                
                // AUTO CREATE A NEW WIKI PAGE, AND REDIRECT USER TO UPDATE INSTEAD
                $model->wiki_page_title = 'Untitled Page';
                $model->wiki_page_content = '.';
                $model->account_subscription_id = Utilities::getCurrentlySelectedSubscription();
                $model->wiki_page_is_category = isset($_GET['is_category']) ? $_GET['is_category'] : 0;
                $model->wiki_page_is_template = isset($_GET['is_template']) ? $_GET['is_template'] : 0;
                $model->save();
                //$this->redirect(array('update', 'id'=>$model->wiki_page_id));
                Utilities::render($this, 'update', array(
                    'model'=>$model,
                    'attachments'=>array(),
                    'page_tree'=>array(),
                    'project_id' => $project_id,                   
                    'is_template' => $model->wiki_page_is_template,
                    'is_category' => $model->wiki_page_is_category,));
                // END AUTO CREATE WIKI PAGE AND RENDER UPDATE PAGE
                
                // *** REDUNDANT 1: FOLLOWING BLOCK WON'T BE REACHED *** //
		/**$data = array(
			'model'=>$model,
			'project_id' => $project_id,
			'project_name' => isset($_GET['project_name']) ? $_GET['project_name'] : 0,
			'is_category' => isset($_GET['is_category']) ? $_GET['is_category'] : NO,
			'is_template' => isset($_GET['is_template']) ? $_GET['is_template'] : NO,
			'page_tree'	=> !isset($_GET['is_category']) || $_GET['is_category'] == NO ? 
				WikiPage::model()->getProjectWikiTree($project_id) : array(),
			'wiki_page_parent_id' => isset($_GET['wiki_page_parent_id']) ? $_GET['wiki_page_parent_id'] : 0,
				//$this->actionWikiTreeSource($project_id, 'array') : array(),
		);
		
		Utilities::render($this, 'create', $data);**/
		// *** END REDUNDANT 1 *** //
                // 
//		$this->renderPartial('create',$data, false, true);
	}

	/**
	 * Handle attachments
	 * @param unknown $model
	 */
	private function handleAttachments($model)
	{
		$this_wiki_attachments = array();
		if(isset($_POST['temp_uploaded_file_names']))
		{
			$filenames_arr = $_POST['temp_uploaded_file_names'];

			foreach($filenames_arr as $filename) // $filename is temp name uploaded in temp folder
			{
				$doc = new Documents();

				//$filename_original_idx = str_replace('.', '_', $filename) . "_original_name";
				/**
				if (isset($_POST[$filename_original_idx]))
				{
				$filename_original = $_POST[$filename_original_idx];
				}
				**/

				$file_document_id_el = $filename . '_document_id';
				$document_id = 0;
				if (isset($_POST[$file_document_id_el]))
				{
					$document_id = $_POST[$file_document_id_el];
						
					if ($document_id > 0)
					{
						$document = Documents::model()->findByPk($document_id);
						// remove temp marker so that this file will not be cleaned up.
						// update parent's details, ie this wiki id
						if ($document != null)
						{
							$document->document_parent_id = $model->wiki_page_id; 
							$document->document_parent_type = DOCUMENT_PARENT_TYPE_WIKI_PAGE;
							$document->document_is_temp = DOCUMENT_IS_NOT_TEMP;
							if ($document->save())
							{
								// now, move file to actual location
								//$document->moveToActualLocation(); // NO NEED. ALREADY DONE DURING ADDING
								$this_wiki_attachments[] = $document;
							}
						}
					} // end updating document if exists
				} // end updating document

			} // end loop handling attachments
		} // end handling attachments if post data exists
		
		return $this_wiki_attachments;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$project_id = isset($_GET['project_id']) ? $_GET['project_id'] : 0;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WikiPage']))
		{
			$model->attributes=$_POST['WikiPage'];
			
			if($model->save())
			{
				// see if there's any document to attach
				$this_wiki_attachments = array();
				$this_wiki_attachments = $this->handleAttachments($model);
				
				// get subpages
				$subpages = WikiPage::model()->getProjectWikiPages($model->project_id, $model->wiki_page_id, 'wiki_page_order ASC', true);
				
				$this->redirect($model->getWikiPageURL());
				//$this->redirect(array('view', 'id' => $model->wiki_page_id));
				/*
				$this->renderPartial('view', array(
					'model' => $model,
					'subpages' => $subpages,
					'attachments' => $this_wiki_attachments,
				), false, true);
				return;*/
			}
		}
		
		// Check permission before showing form
		if (!Permission::checkPermission($model, PERMISSION_WIKI_PAGE_UPDATE))
		{
			throw new CHttpException(401,'You are not given the permission to view this page.');
			return false;
		}
		
		// get attachments
		$attachments = Documents::model()->findAllWikiPageAttachments($id);
		
		$data = array(
			'model'=>$model,
			'attachments'=>$attachments,
			'project_id' => $project_id,
			'is_template' => isset($_GET['is_template']) ? $_GET['is_template'] : $model->wiki_page_is_template,
			'is_category' => isset($_GET['is_category']) ? $_GET['is_category'] : $model->wiki_page_is_category,
			'page_tree'	=> !isset($_GET['is_category']) || $_GET['is_category'] == NO ? 
				WikiPage::model()->getProjectWikiTree($project_id) : array(),
				//$this->actionWikiTreeSource($project_id, 'array') : array(),
		);

		Utilities::render($this, 'update', $data);
		//$this->render('update', $data);
	}
	
	/**
	 * Called by javascript every x seconds to submit form data without closing form
	 */
	public function actionAutoSave()
	{
		$model = new WikiPage();
		$id = isset($_POST['WikiPage']) && isset($_POST['WikiPage']['wiki_page_id']) ? $_POST['WikiPage']['wiki_page_id'] : 0;
		
		$session_date = isset($_POST['WikiPage']) && isset($_POST['WikiPage']['session_date']) ? $_POST['WikiPage']['session_date'] : 0;
		
		if ($id > 0)
		{
			// update case
			$model = $this->loadModel($id);
			
			// before updating, save current version as an old revision
			// capture the time so that during this session of update, we'll only
			// add one revision to the previous revision table
			if ($session_date == 0)
			{
				// session just started, no prior save was done
				// so create revision
				$session_date = date('Y-m-d H:i:s');
				$revision = new WikiPageRevision();
				$revision->wiki_page_id = $id;
				$revision->wiki_page_revision_content = $model->wiki_page_content;
				$revision->wiki_page_revision_date = $session_date;
				$revision->wiki_page_revision_updated_by = $model->wiki_page_updated_by;
				$revision->save();
			}
		} else {
			// add case
			// give session_date now, so that next round of auto save will not create revision
			$session_date = date('Y-m-d H:i:s');
		}
		
		// get value
		$model->attributes=$_POST['WikiPage'];
		if ($model->save())
		{
			$this->handleAttachments($model);
			echo CJSON::encode(array(
					'status' => 'success', 
					'wiki_page_id' => $model->wiki_page_id,
					'time' => $model->wiki_page_date,
					'session_date' => $session_date));
		} else {
			echo CJSON::encode(array('status' => 'failure'));
		}
	}
	
	// TODO: Remove this action. DO NOT USE!!!
	public function actionHistory($id)
	{
		$revisions = WikiPageRevision::model()->getRevisions($id, true);
		
		$this->renderPartial('index_revisions', array(
				'revisions' => $revisions
		), false, true);
	}
	
	// TODO: Remove this action. DO NOT USE!!!
	public function actionRevision($page_id, $revision_id)
	{
		// if revision id is given, show revision
		if ($revision_id > 0)
		{
			$revision = WikiPageRevision::model()->findByPk($revision_id);
			echo $revision->wiki_page_revision_content;
			return;
		} else if ($revision_id == 0 && $page_id > 0) {
			// show current version
			$page = WikiPage::model()->findByPk($page_id);
			echo $page->wiki_page_content;
			return;
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		
		if ($model) 
		{
			if ($model->delete())
			{
				echo SUCCESS;
				return;
			}
		}
		
		echo FAILURE;
		return;

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// get all pages for this project
		// except for content to avoid heavy results
		$project_id = isset($_GET['project_id']) ? intval($_GET['project_id']) : 0;
		$list_id = isset($_GET['list_id']) ? intval($_GET['list_id']): 0;// for lists tab
		$tab = isset($_GET['tab']) ? $_GET['tab']: 'wiki';// for tab
		
		/**
		$criteria = array(
			'select' => 'wiki_page_id, wiki_page_title, wiki_page_summary, wiki_page_creator_id, wiki_page_updated_by, wiki_page_tags',
			'condition' => "project_id = $project_id",
			'order' => ,
		);
		$dataProvider = new CActiveDataProvider('WikiPage');
		$dataProvider->setCriteria($criteria);**/
		$dataProvider = WikiPage::model()->getProjectWikiPages($project_id, -1, 'wiki_page_date DESC' );
		$dataProviderLinks = Resource::model()->getResources($project_id,$list_id);
				
		$data = array(
			'tab'=>$tab,
			'dataProvider' => $dataProvider,
			'dataProviderLinks'=>$dataProviderLinks,
			'project_id' => $project_id,
			'project_name' => isset($_GET['project_name']) ? $_GET['project_name'] : 0,
			'wiki_categories' => WikiPage::model()->getProjectWikiCategories($project_id, true),
			'wiki_tree' => WikiPage::model()->getProjectWikiTree($project_id), //$this->actionWikiTreeSource($project_id),
		);
		Utilities::render($this, 'index', $data);
		//$this->renderPartial('index',$data, false, true);
	}
	
	/**
	 * @param integer $project_id 
	 * @param string $type json, array
	 * @return array $results = (wiki_page_id => wiki_page_title, ...);
	 */
	public function actionWikiTreeSource($project_id, $type = 'json')
	{
		// TODO: should replace this whole function with WikiPage->getProjectWikiTree();
		$results = WikiPage::model()->getProjectWikiTree($project_id);
		
		if ($type == 'json')
		{
			echo CJSON::encode($results);
			return;
		}
		
		return $results;
		
		/**
		$categories = WikiPage::model()->getProjectWikiCategories($project_id, true);
		
		$results = array();
		// for each category, find it page(s)
		foreach ($categories as $cat)
		{
			$results[$cat->wiki_page_id] = $cat->wiki_page_title;
			$results = $cat->iterWikiTree($project_id, $results);
		}
		
		return $results;**/
	}	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new WikiPage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['WikiPage']))
			$model->attributes=$_GET['WikiPage'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Show form for re-ordering pages of the same level and same parent
	 * 
	 * @param unknown $id id of parent
	 */
	public function actionReorderSubPages($id)
	{
		$model=new WikiPage('search');
		$model->unsetAttributes();  // clear any default values
		$model->wiki_page_parent_id = $id;
		
		$parentModel = $this->loadModel($id);
		
		Utilities::render($this, 'reoder', array('model' => $model, 'parent' => $parentModel));
	}

	/**
	 * show list of wiki template
	 */
	public function actionPopTemplates()
	{
		$subscription_id = $_GET['subscription'];
		$templates = WikiPage::model()->getTemplates($subscription_id);

		Utilities::renderPartial($this, '_templates', array('templates' => $templates));
	}
	
	/**
	 * admin view of templates
	 * 
	 */
	public function actionAdminTemplate()
	{
		//$subscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id, true);
		//reset($subscriptions);
		$model=new WikiPage('search');
		$model->unsetAttributes();
		$model->account_subscription_id = Utilities::getCurrentlySelectedSubscription();//key($subscriptions);
		$model->wiki_page_is_template = YES;
		
		Utilities::renderPartial($this, '_admin_templates', array('model' => $model));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return WikiPage the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=WikiPage::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param WikiPage $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='wiki-page-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
