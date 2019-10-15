<?php

class ProductController extends Controller
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
//			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update','duplicate'),
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
		$model=new LbCatalogProducts;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LbCatalogProducts']))
		{
			$model->attributes=$_POST['LbCatalogProducts'];
                        $model->lb_product_created_date = date('Y-m-d H:i:s');
                        $model->lb_product_updated_date = date('Y-m-d H:i:s');
                        $model->lb_product_create_by = Yii::app()->user->id;
                        $model->lb_product_special_price_from_date = date('Y-m-d', strtotime($_POST['LbCatalogProducts']['lb_product_special_price_from_date']));
                        $model->lb_product_special_price_to_date = date('Y-m-d',strtotime($_POST['LbCatalogProducts']['lb_product_special_price_to_date']));
                        
			if($model->save()){
                                //Save category
                                if(isset($_POST['category'])){
                                    $category = $_POST['category'];
                                    if(count($category))
                                        foreach ($array as $value) {
                                            $categoryProduct = new LbCatalogCategoryProduct();
                                            $categoryProduct->lb_product_id = $model->lb_record_primary_key;
                                            $categoryProduct->lb_category_id = $value;
                                        }
                                }
                                
                                //SAVE IMAGE
                                $file_big = CUploadedFile::getInstancesByName("file_big");
                                foreach ($file_big as $item) {
                                    $document = new LbDocument();
                                    $path = 'uploads/' . $item->name;
                                    $item->saveAs($path); 
                                    $document->addDocument('lbCatalog', $model->lb_record_primary_key, $item->name, LbDocument::IMAGES_TYPE_BIG);
                                }
                                
                                $file_small = CUploadedFile::getInstancesByName("file_small");
                                foreach ($file_small as $item) {
                                    $document = new LbDocument();
                                    $path = 'uploads/' . $item->name;
                                    $item->saveAs($path); 
                                    $document->addDocument('lbCatalog', $model->lb_record_primary_key, $item->name,LbDocument::IMAGES_TYPE_SMALL);
                                }
                                
                                $file_thumbnail = CUploadedFile::getInstancesByName("file_thumbnail");
                                foreach ($file_thumbnail as $item) {
                                    $document = new LbDocument();
                                    $path = 'uploads/' . $item->name;
                                    $item->saveAs($path); 
                                    $document->addDocument('lbCatalog', $model->lb_record_primary_key, $item->name, LbDocument::IMAGES_TYPE_THUMBNAIL);
                                }
                                
				$this->redirect(array('update','id'=>$model->lb_record_primary_key));
                        }
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
                $images = LbDocument::model()->getDocumentParentType('lbCatalog', $id,true);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LbCatalogProducts']))
		{
			$model->attributes=$_POST['LbCatalogProducts'];
                        $model->lb_product_special_price_from_date = date('Y-m-d', strtotime($_POST['LbCatalogProducts']['lb_product_special_price_from_date']));
                        $model->lb_product_special_price_to_date = date('Y-m-d',strtotime($_POST['LbCatalogProducts']['lb_product_special_price_to_date']));
			if($model->save()){
                                //Save category
                                if(isset($_POST['category'])){
                                    $category = $_POST['category'];
                                    LbCatalogCategoryProduct::model()->deleteAll('lb_product_id='.intval($model->lb_record_primary_key));
                                    if(count($category))
                                        foreach ($category as $value) {
                                            $categoryProduct = new LbCatalogCategoryProduct();
                                            $categoryProduct->lb_product_id = $model->lb_record_primary_key;
                                            $categoryProduct->lb_category_id = $value;
                                            $categoryProduct->save();
                                        }
                                }
                                //SAVE IMAGE
                                $file_big = CUploadedFile::getInstancesByName("file_big");
                                foreach ($file_big as $item) {
                                    $document = new LbDocument();
                                    $path = 'uploads/' . $item->name;
                                    $item->saveAs($path); 
                                    $document->addDocument('lbCatalog', $model->lb_record_primary_key, $item->name, LbDocument::IMAGES_TYPE_BIG);
                                }
                                
                                $file_small = CUploadedFile::getInstancesByName("file_small");
                                foreach ($file_small as $item) {
                                    $document = new LbDocument();
                                    $path = 'uploads/' . $item->name;
                                    $item->saveAs($path); 
                                    $document->addDocument('lbCatalog', $model->lb_record_primary_key, $item->name,LbDocument::IMAGES_TYPE_SMALL);
                                }
                                
                                $file_thumbnail = CUploadedFile::getInstancesByName("file_thumbnail");
                                foreach ($file_thumbnail as $item) {
                                    $document = new LbDocument();
                                    $path = 'uploads/' . $item->name;
                                    $item->saveAs($path); 
                                    $document->addDocument('lbCatalog', $model->lb_record_primary_key, $item->name, LbDocument::IMAGES_TYPE_THUMBNAIL);
                                }
                                
				//$this->redirect(array('view','id'=>$model->lb_record_primary_key));
                        }
		}
                    $this->render('update',array(
                            'model'=>$model,
                            'images'=>$images
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
		$model=new LbCatalogProducts('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LbCatalogProducts']))
			$model->attributes=$_GET['LbCatalogProducts'];
                if(isset($_GET['search-category']))
                    $model->search_ids = $_GET['search-category'];

                    LBApplication::render($this,'index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LbCatalogProducts('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LbCatalogProducts']))
			$model->attributes=$_GET['LbCatalogProducts'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbCatalogProducts the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LbCatalogProducts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbCatalogProducts $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-catalog-products-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionDuplicate($id){
            $product = LbCatalogProducts::model()->findByPk($id);
            $model=new LbCatalogProducts;
            $model->attributes=$product->attributes;
            $model->lb_product_created_date = date('Y-m-d H:i:s');
            $model->lb_product_updated_date = date('Y-m-d H:i:s');
            $model->lb_product_create_by = Yii::app()->user->id;

            if($model->save()){
                //Save category
                if(isset($_POST['category'])){
                    $category = $_POST['category'];
                    if(count($category))
                        foreach ($array as $value) {
                            $categoryProduct = new LbCatalogCategoryProduct();
                            $categoryProduct->lb_product_id = $model->lb_record_primary_key;
                            $categoryProduct->lb_category_id = $value;
                        }
                }

                //SAVE IMAGE
                $file_big = CUploadedFile::getInstancesByName("file_big");
                foreach ($file_big as $item) {
                    $document = new LbDocument();
                    $path = 'uploads/' . $item->name;
                    $item->saveAs($path); 
                    $document->addDocument('lbCatalog', $model->lb_record_primary_key, $item->name, LbDocument::IMAGES_TYPE_BIG);
                }

                $this->redirect(array('update','id'=>$model->lb_record_primary_key));
            }
        }
}
