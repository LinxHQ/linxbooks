<?php

class WikiPageRevisionController extends Controller
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
				'actions'=>array('view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'restore'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('@'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 * @param integer $id the ID of the $latest revision 
	 */
	public function actionView($id, $page)
	{
		$latest = WikiPage::model()->findByPk($page);
		
		if ($id > 0)
		{
			$model = $this->loadModel($id);
			$page = $model->wiki_page_id;
		} else {
			$model = new WikiPageRevision();
		}
		
		// get revisions list
		$revisions_nokeys = WikiPageRevision::model()->getRevisions($page, true);
		// add keys
		$revisions = array();
		$key = 0;
		$this_revision_key = 0;
		foreach ($revisions_nokeys as $rev)
		{
			$revisions[$key] = $rev;
			
			if ($rev->wiki_page_revision_id == $model->wiki_page_revision_id)
			{
				$this_revision_key = $key;
			}
			$key++;
		}
		
		// get all lines of this revision's content
		if ($id > 0)
		{
			// selected revision's content
			$this_rev_lines = preg_split("/((\r?\n)|(\r\n?))/", 
				 	htmlspecialchars($model->wiki_page_revision_content));
		
			// get all lines of the revision before 
			if (isset($revisions[$this_revision_key+1]))
			{
				$bf_rev_lines = preg_split("/((\r?\n)|(\r\n?))/", 
						htmlspecialchars($revisions[$this_revision_key+1]->wiki_page_revision_content));
			} else {
				$bf_rev_lines = array('');
			}
		} else {
			// selected revision is the latest
			$this_rev_lines = preg_split("/((\r?\n)|(\r\n?))/",
					htmlspecialchars($latest->wiki_page_content));
			
			// get all lines of the revision before, which is keyed 0
			if (isset($revisions[0]))
			{
				$bf_rev_lines = preg_split("/((\r?\n)|(\r\n?))/",
						htmlspecialchars($revisions[0]->wiki_page_revision_content));
			} else {
				$bf_rev_lines = array('');
			}
		}
		
		// compare with revision before
		require_once 'DiffEngine.php';
		$diff_bf = new Diff($bf_rev_lines, $this_rev_lines);
		$diffFormatter = new LinxDiffFormatter();
		$diff_bf_formatted = $diffFormatter->format($diff_bf);
		
		// comfpare with revision after
		
		$data = array(
				'latest' => $latest,
				'model'=> $model,
				'revisions' => $revisions,
				'diff_with_bf' => '',//$diff_bf_formatted,
		);
		
		Utilities::render($this, 'view', $data);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new WikiPageRevision;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WikiPageRevision']))
		{
			$model->attributes=$_POST['WikiPageRevision'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->wiki_page_revision_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionRestore()
	{
		$wiki_revision_id = $_GET['id'];
		$model = $this->loadModel($wiki_revision_id);
		$model->restore();
		
		$this->redirect(array('wikiPage/view','id'=>$model->wiki_page_id));
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

		if(isset($_POST['WikiPageRevision']))
		{
			$model->attributes=$_POST['WikiPageRevision'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->wiki_page_revision_id));
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
		$dataProvider=new CActiveDataProvider('WikiPageRevision');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new WikiPageRevision('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['WikiPageRevision']))
			$model->attributes=$_GET['WikiPageRevision'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return WikiPageRevision the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=WikiPageRevision::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param WikiPageRevision $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='wiki-page-revision-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
