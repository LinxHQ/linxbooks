<?php

class VendorController extends Controller
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
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','AjaxLoadFormViewPayment','AjaxSavePayment','AjaxLoadInvoiceByCustomer','addPayment','AjaxCreateVendorInvoice','createPo','ViewSupplier','InsertLineItem','createSupplier','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
                $modelItemVendor = new LbVendorItem();
                $modelDiscountVendor = new LbVendorDiscount();
                $modelTax = new LbVendorTax();
                $modelTotal = LbVendorTotal::model()->getVendorTotal($id,  LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
                        'modelItemVendor'=>$modelItemVendor,
                        'modelDiscountVendor'=>$modelDiscountVendor,
                        'modelTax'=>$modelTax,
                        'modelTotal'=>$modelTotal,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LbVendor;

		// get basic info to assign to this record
		$ownCompany = LbCustomer::model()->getOwnCompany();
		$ownCompanyAddress = null;
		$customerCompany = new LbCustomer;
		$customerCompany->lb_customer_name = 'Click to choose customer';
		
		// get own company address
		if ($ownCompany->lb_record_primary_key)
		{
			// auto assign owner company
			$model->lb_vendor_company_id = $ownCompany->lb_record_primary_key;
			
			$own_company_addresses = LbCustomerAddress::model()->getActiveAddresses($ownCompany->lb_record_primary_key,
					$ownCompany::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
			
			if (count($own_company_addresses))
			{
				$ownCompanyAddress= $own_company_addresses[0];
				// auto assign owner company's address
				$model->lb_vendor_company_address_id = $ownCompanyAddress->lb_record_primary_key;
			}
		}
                
                if($model->save())
                {
                    //save total
                    LbVendorTotal::model()->addTotalVendor($model->lb_record_primary_key,  LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL);
                    
                    
                    //save tax
                    LbVendorTax::model()->addLineTaxVendor($model->lb_record_primary_key,LbVendorTax::LB_VENDOR_ITEM_TYPE_TAX);
                    
                    //save item
                    LbVendorItem::model()->addLineItemVendor($model->lb_record_primary_key,LbVendorItem::LB_VENDOR_ITEM_TYPE_LINE);
                    
                    //save discount
                    LbVendorDiscount::model()->addLineDiscountVendor($model->lb_record_primary_key,LbVendorDiscount::LB_VENDOR_ITEM_TYPE_DISCOUNT);
                    
                    $this->redirect(array('view','id'=>$model->lb_record_primary_key));
                }
                
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

		if(isset($_POST['LbVendor']))
		{
			$model->attributes=$_POST['LbVendor'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->lb_record_primary_key));
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
		$dataProvider=new CActiveDataProvider('LbVendor');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LbVendor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LbVendor']))
			$model->attributes=$_GET['LbVendor'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbVendor the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LbVendor::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbVendor $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-vendor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
      public function actioncreatePo()
      {
                
                       
           
                $model=new LbVendor;

		// get basic info to assign to this record
		$ownCompany = LbCustomer::model()->getOwnCompany();
		$ownCompanyAddress = null;
		$customerCompany = new LbCustomer;
		$customerCompany->lb_customer_name = 'Click to choose customer';
		
		// get own company address
		if ($ownCompany->lb_record_primary_key)
		{
			// auto assign owner company
			$model->lb_vendor_company_id = $ownCompany->lb_record_primary_key;
			
			$own_company_addresses = LbCustomerAddress::model()->getActiveAddresses($ownCompany->lb_record_primary_key,
					$ownCompany::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
			
			if (count($own_company_addresses))
			{
				$ownCompanyAddress= $own_company_addresses[0];
				// auto assign owner company's address
				$model->lb_vendor_company_address_id = $ownCompanyAddress->lb_record_primary_key;
			}
		}
                
                if($model->save())
                {
                    $id = $_GET['id'];
                    $invoiceVendor = LbVendorInvoice::model()->findByPk($id);
                    $invoiceVendor->lb_vendor_id = $model->lb_record_primary_key;
                    $invoiceVendor->save();
                    $this->redirect(array('view','id'=>$model->lb_record_primary_key));
                }
        }
         function actionAjaxCreateVendorInvoice($id)
        {
        $model = $this->loadModel($id);
        $quotationItem = LbVendorItem::model()->getVendorItems($id, LbVendorItem::LB_VENDOR_ITEM_TYPE_LINE,
				LbVendorItem::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
      
        $quotationDiscount = LbVendorDiscount::model()->getVendorDiscounts($id, LbVendorDiscount::LB_VENDOR_ITEM_TYPE_DISCOUNT,
				LbVendorDiscount::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
        $quotationTax  = LbVendorTax::model()->getTaxByVendor($id,  LbVendorTax::LB_VENDOR_ITEM_TYPE_TAX,LbVendorTax::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
        $quotationTotal = LbVendorTotal::model()->getVendorTotal($model->lb_record_primary_key,  LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL);
        
        
        $invoiceModel = new LbVendorInvoice;
        
        
        $invoice_number_int = LbVendorInvoice::model()->getVINextNum();
        $invoiceModel->lb_vd_invoice_no = LbVendorInvoice::model()->formatVINextNumFormatted($invoice_number_int);
        $invoiceModel->lb_vd_invoice_status = LbVendorInvoice::LB_VD_CODE_OPEN;
        // invoice date
        $invoiceModel->lb_vd_invoice_date = date('Y-m-d');
        $invoiceModel->lb_vd_invoice_due_date = date('Y-m-d');
        // invoice group
//        $invoiceModel->lb_invoice_group = LbInvoice::LB_INVOICE_GROUP_INVOICE;
        // invoice base64_decode
        $invoiceModel->lb_vd_invoice_encode = LbVendorInvoice::model()->setBase64_decodePO();
        // invoice note
        $invoiceModel->lb_vd_invoice_notes = $model->lb_vendor_notes;
        $invoiceModel->lb_vd_invoice_company_id = $model->lb_vendor_company_id;
        $invoiceModel->lb_vd_invoice_company_address_id = $model->lb_vendor_company_address_id;
        $invoiceModel->lb_vd_invoice_supplier_id = $model->lb_vendor_supplier_id;
        $invoiceModel->lb_vd_invoice_supplier_address_id = $model->lb_vendor_supplier_address;
        $invoiceModel->lb_vd_invoice_supplier_attention_id = $model->lb_vendor_supplier_attention_id;
        $invoiceModel->lb_vendor_id = $model->lb_record_primary_key;
        $invoiceModel->lb_vd_invoice_subject = $model->lb_vendor_subject;
        $invoiceModel->lb_vd_invoice_category = $model->lb_vendor_category;
        // invoice internal note
//        $invoiceModel->lb_invoice_internal_note = $model->lb_quotation_internal_note;
        
        if($invoiceModel->insert())
        {
            // copy line item
            foreach ($quotationItem as $q_item)
            {
                $vendorItem = new LbVendorItem();
               
                $vendorItem->lb_vendor_id = $id;
                $vendorItem->lb_vendor_invoice_id = $invoiceModel->lb_record_primary_key;
                $vendorItem->lb_vendor_type = LbVendorItem::LB_VENDOR_INVOICE_ITEM_TYPE_LINE;
                $vendorItem->lb_vendor_item_quantity = $q_item->lb_vendor_item_quantity;
                $vendorItem->lb_vendor_item_price = $q_item->lb_vendor_item_price;
                $vendorItem->lb_vendor_item_amount = $q_item->lb_vendor_item_amount;
                $vendorItem->lb_vendor_item_description = $q_item->lb_vendor_item_description;
                $vendorItem->insert();
            }
            
            // copy tax item
            foreach($quotationTax as $q_tax)
            {
                $taxInvoiceVendor = new LbVendorTax();
                $taxInvoiceVendor->lb_vendor_invoice_id = $invoiceModel->lb_record_primary_key;
                $taxInvoiceVendor->lb_vendor_id = $id;
                
                $taxInvoiceVendor->lb_vendor_type = LbVendorTax::LB_VENDOR_INVOICE_ITEM_TYPE_TAX;
                $taxInvoiceVendor->lb_vendor_tax_id = $q_tax->lb_vendor_tax_id;
                $taxInvoiceVendor->lb_tax_name = $q_tax->lb_tax_name;
                $taxInvoiceVendor->lb_vendor_tax_value=$q_tax->lb_vendor_tax_value;
                $taxInvoiceVendor->lb_vendor_tax_total=$q_tax->lb_vendor_tax_total;
            
                $taxInvoiceVendor->insert();
            }
//            
//            // copy discount item
            foreach($quotationDiscount as $q_discount)
            {
                $discountVendorInvoice = new LbVendorDiscount();
              
                $discountVendorInvoice->lb_vendor_id = $id;
                $discountVendorInvoice->lb_vendor_invoice_id = $invoiceModel->lb_record_primary_key;
               
               
               $discountVendorInvoice->lb_vendor_description = $q_discount->lb_vendor_description;
               $discountVendorInvoice->	lb_vendor_value = $q_discount->lb_vendor_value;
               $discountVendorInvoice->lb_vendor_type = LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT;

                $discountVendorInvoice->insert();
            }
//            
//            // Copy Total
           $vendorItem = new LbVendorTotal();
           
            $vendorItem->lb_vendor_invoice_id = $invoiceModel->lb_record_primary_key;
            $vendorItem->lb_vendor_id = $id;
            
            $vendorItem->lb_vendor_type = LbVendorTotal::LB_VENDOR_INVOICE_TOTAL;
            $vendorItem->lb_vendor_subtotal = $quotationTotal->lb_vendor_subtotal;
            $vendorItem->lb_vendor_total_last_discount = $quotationTotal->lb_vendor_total_last_discount;
            $vendorItem->lb_vendor_last_tax = $quotationTotal->lb_vendor_last_tax;
            $vendorItem->lb_vendor_last_paid = $quotationTotal->lb_vendor_last_paid;
            $vendorItem->lb_vendor_last_outstanding = $quotationTotal->lb_vendor_last_outstanding;
          
            $vendorItem->insert();
               
            
            
            
            // redirect Invoice
//            $url_invoice = $model->customer ? LbInvoice::model()->getViewURL($model->customer->lb_customer_name,null,$invoiceModel->lb_record_primary_key) : LbInvoice::model()->getViewURL("No customer",null,$invoiceModel->lb_record_primary_key);
//            $this->redirect($url_invoice);
        }
        
        }
	
         public function actionaddPayment()
        {
            $model = new LbPaymentVendor();
            $lbInvoiceModel = new LbInvoice();
            
            $customer_id=0;
            if(isset($_GET['id']) && $_GET['id']!="")
                $customer_id = $_GET['id'];
            
            $this->render('createPayment',array(
			'model'=>$model,                       
                'customer_id'=>$customer_id
		));
            
        }
        
        function actionAjaxLoadInvoiceByCustomer()
        {
           
            LBApplication::renderPartial($this,'_form_line_item', array('customer_id'=>$_POST['customer_id']));
        }
        
        function actionAjaxSavePayment()
        {
            $model = new LbPaymentVendor();
            if(isset($_POST['LbPaymentVendor'])){
                $payment_arr = $_POST['LbPaymentVendor'];
               
                
                $model->lb_payment_vendor_no=  LbPaymentVendor::model()->FormatPaymentVendorNo(LbPaymentVendor::model()->getPaymentVendorNextNum());
                $model->lb_payment_vendor_customer_id = $_POST['customer_id'];
                $model->lb_payment_vendor_method=$payment_arr['lb_payment_vendor_method'];
                
               
                $model->lb_payment_vendor_total=$_POST['total_payment'];
                $date1=date_create($payment_arr['lb_payment_date']);

                $model->lb_payment_vendor_date=  date_format($date1,'Y-m-d');
                //$model->lb_invoice_id = $_POST[]
                
                if($model->insert())
                {
                    //LbPayment::model()->setPaymentNextNum();
                    
                    // save payment item
                    $count_payment = count($_POST['payment_check']);
                    $payment_invoice = $_POST['payment_check'];
                    $payment_note = $_POST['payment_note'];
                    $payment_item_amount = $_POST['payment'];
                    
                    for($i=0;$i<$count_payment;$i++){
                        if($payment_item_amount[$i]>0){
                            $paymentItemModel = new LbPaymentVendorInvoice();
                            $paymentItemModel->lb_payment_id = $model->lb_record_primary_key;
                            $paymentItemModel->lb_vendor_invoice_id = $payment_invoice[$i];
                            $paymentItemModel->lb_payment_item_note=$payment_note[$i];
                            $paymentItemModel->lb_payment_item_amount=$payment_item_amount[$i];
                            if($paymentItemModel->save()){
                                
                                    $invoiceVendor = LbVendorTotal::model()->find('lb_vendor_invoice_id = '.$paymentItemModel->lb_vendor_invoice_id); 
                                    $total = LbPaymentVendorInvoice::model()->calculateInvoicetotalPaid($paymentItemModel->lb_vendor_invoice_id);
                                    $modelVI = LbVendorTotal::model()->findByPk($invoiceVendor['lb_record_primary_key']);
                                    $modelVI->lb_vendor_last_paid = $total;
                                    $modelVI->lb_vendor_last_outstanding = $modelVI->lb_vendor_last_tax - $total;

                                    $modelVI->update();
                                   
                                }
                                echo '{"status":"success"}';
                            }
                            else
                                echo '{"status":"fail"}';
                            
                        }
                    }
                }
                
           
        }
        
        function actionAjaxLoadFormViewPayment()
        {
            $model = new LbPaymentVendor();
            $lbInvoiceModel = new LbInvoice();
            LBApplication::renderPartial($this,'_form_view_payment',  array('model'=>$model,'lbInvoiceModel'=>$lbInvoiceModel));
        }
   
}
