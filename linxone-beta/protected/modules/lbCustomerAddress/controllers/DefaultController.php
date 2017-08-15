<?php

class DefaultController extends CLBController
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
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','ajaxUpdateField','dropdownJSON','addressLinesJSON'),
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
		$model=new LbCustomerAddress;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $customer_id = $_REQUEST['customer_id'];
		if(isset($_POST['LbCustomerAddress']))
		{
			$model->attributes=$_POST['LbCustomerAddress'];
                        $model->lb_customer_id = $customer_id;
			if($model->save())
                        {
                           Yii::app()->request->redirect(Yii::app()->createUrl('lbCustomer/default/view',array('id'=>$customer_id)));
                        }
 
		}
		LBApplication::render($this,'create',array(
			'model'=>$model,
                        'customer_id'=>$customer_id,
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

		if(isset($_POST['LbCustomerAddress']))
		{
			$model->attributes=$_POST['LbCustomerAddress'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->lb_customer_address_id));
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
                $error = array();
                $invoiceAddress = LbInvoice::model()->getInvoiceByAddress($id);
                if(count($invoiceAddress)>0)
                {
                    $error[]='Address cannot be deleted. This address is already in use by an invoice/quotation.';
                    LBApplication::renderPartial($this, 'view', array(
                        'content'=>CJSON::encode($error),
                    ));
                }
                else
                {
                    $this->loadModel($id)->delete();

                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                    if(!isset($_GET['ajax']))
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LbCustomerAddress');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LbCustomerAddress('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LbCustomerAddress']))
			$model->attributes=$_GET['LbCustomerAddress'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    /**
     * json data source for x-editable dropdown to get ADDRESSES
     */
    public function actionDropdownJSON()
    {
        $allow_add = isset($_GET['allow_add']) ? $_GET['allow_add'] : NO;
        $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : 0;
        $invoice_id = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : 0;
        $quotation_id = isset($_GET['quotation_id']) ? $_GET['quotation_id'] :0;
        $vendor_id = isset($_GET['vendor_id']) ? $_GET['vendor_id'] :0;
        $lb_vendor_invoice_id = isset($_GET['lb_vendor_invoice_id']) ? $_GET['lb_vendor_invoice_id'] :0;
        // override customer id if invoice id is provided
        if ($invoice_id)
        {
            $invoice = LbInvoice::model()->findByPk($invoice_id);
            $customer_id = $invoice->lb_invoice_customer_id;
        }
         if($vendor_id)
        {
            $vendor= LbVendor::model()->findByPk($vendor_id);
            $customer_id = $vendor->lb_vendor_supplier_id;
        }
         if($lb_vendor_invoice_id)
        {
            $vendor_invoice= LbVendorInvoice::model()->findByPk($lb_vendor_invoice_id);
            $customer_id = $vendor_invoice->lb_vd_invoice_supplier_id;
        }
        
        // override customer id if quotation id is provided
        if ($quotation_id)
        {
            $quotation = LbQuotation::model()->findByPk($quotation_id);
            $customer_id = $quotation->lb_quotation_customer_id;
        }

        // get results;
        $results = LbCustomerAddress::model()->getAddresses($customer_id,
            LbCustomerAddress::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
        // prepend new address link if allow add new
        if ($allow_add && $allow_add != 2)
        {
            $results = array('0'=>'Choose address', '-1'=>'-- Add new address --')+$results;
        }
        if($vendor_id || $lb_vendor_invoice_id)
            $results = array('0'=>'Choose address')+$results;
        // we want to preserve order
        $ordered_results = array();
        foreach ($results as $key=>$text)
        {
            $ordered_results[] = array('value'=>$key,'text'=>$text);
        }

        LBApplication::renderPartial($this, '//layouts/plain_ajax_content', array(
            'content'=>CJSON::encode($ordered_results),
        ));
    }
	
	/**
	 * return the address lines in json format
	 * 
	 * @param unknown $id
	 */
	public function actionAddressLinesJSON($id)
	{
		$model = $this->loadModel($id);
		$address_lines = $model->formatAddressLines();
		
		LBApplication::renderPartial($this,'//layouts/plain_ajax_content',array(
			'content'=>CJSON::encode($address_lines),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbCustomerAddress the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LbCustomerAddress::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbCustomerAddress $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-customer-address-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
