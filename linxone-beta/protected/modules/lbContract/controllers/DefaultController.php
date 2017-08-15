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
                        array('allow',
                            'actions'=>array(
                                    'index',
                                     'admin','create','view','delete','update',
                                     'ajaxDropDownAddress',
                                     'ajaxDropDownContact',
                                     'upload',
                                     'dashboard',
                                     'renew',
                                     'ajaxFormPayment',
                                     'DeleteDocument',
                                     'uploadDocument',
                                     'ajaxUpdateStatusContract',
                                     'createInvoice',
                                     'ajaxUpdateField',
                            ),
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
		LBApplication::render($this,'view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LbContracts;
                $documentModel = new LbContractDocument();
                $paymentModel = new LbPayment();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LbContracts']))
		{
                        $LbContracts = $_POST['LbContracts'];
			$model->attributes=$LbContracts;
                        $model->lb_contract_status =  LbContracts::LB_CONTRACT_STATUS_ACTIVE;
			if($model->save())
                        {
                            LbContracts::model()->setContractNextNum(LbContracts::model()->getContractNextNum());
                            //********* Upload document *****************//
                                // THIS is how you capture those uploaded images: remember that in your CMultiFile widget, you set 'name' => 'images'
                                $images = CUploadedFile::getInstancesByName('images');
                                // proceed if the images have been set
                                $i=0;
                                if (isset($images) && count($images) > 0) {
                                    // go through each uploaded image
                                    foreach ($images as $image => $pic) {
                                        $i++;
                                        // tach filename va duoi
                                        $temp = explode('.', $pic->name);
                                        $duoi='.'.$temp[count($temp)-1];
                                        $lendduoi = strlen($temp[count($temp)-1])+1;
                                        $filename = substr( $pic->name,0,strlen($pic->name)-$lendduoi);
                                        
                                        if ($pic->saveAs(Yii::getPathOfAlias('webroot').'/uploads/'.$filename.'_'.$model->lb_record_primary_key.$i.$duoi)) {
                                            // add it to the main model now
                                            $documentModel = new LbContractDocument;
                                            $documentModel->lb_contract_id = $model->lb_record_primary_key;
                                            $documentModel->lb_document_url = "/uploads/".$filename.'_'.$model->lb_record_primary_key.$i.$duoi; //it might be $img_add->name for you, filename is just what I chose to call it in my model
                                            $documentModel->lb_document_name = $pic->name; // this links your picture model to the main model (like your user, or profile model)
                                            $documentModel->lb_document_url_icon = "/images/fileicons/32px/".$temp[count($temp)-1].".png";
                                            $documentModel->save(); // DONE
                                        }
                                    }
                                }
                            //**** End upload doxument ****//
                            
///////////////////////////////////////////////////////////////////////////////
                            //********* add new invoice *************/
                            if(isset($LbContracts['check_invoice']))
                            {
                                $invoiceModel = new LbInvoice();
                                // get basic info to assign to this record
                                $ownCompany = LbCustomer::model()->getOwnCompany();
                                $ownCompanyAddress = null;
                                $customerCompany = new LbCustomer;
                                $customerCompany->lb_customer_name = 'Click to choose customer';
                                

                                // get own company address
                                if ($ownCompany->lb_record_primary_key)
                                {
                                        // auto assign owner company
                                        $invoiceModel->lb_invoice_company_id = $ownCompany->lb_record_primary_key;

                                        $own_company_addresses = LbCustomerAddress::model()->getActiveAddresses($ownCompany->lb_record_primary_key,
                                                        $ownCompany::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

                                        if (count($own_company_addresses))
                                        {
                                                $ownCompanyAddress= $own_company_addresses[0];
                                                // auto assign owner company's address
                                                $invoiceModel->lb_invoice_company_address_id = $ownCompanyAddress->lb_record_primary_key;
                                        }
                                }
                                // add infor customer in invoice
                                $invoiceModel->lb_invoice_customer_id = $LbContracts['lb_customer_id'];
                                $invoiceModel->lb_invoice_customer_address_id = $LbContracts['lb_address_id'];
                                $invoiceModel->lb_invoice_attention_contact_id = $LbContracts['lb_contact_id'];
                                if($invoiceModel->save())
                                {
                                        // Save Lien ket contract va invoice
                                        $contrctInvoiceModel = new LbContractInvoice();
                                        $contrctInvoiceModel->lb_contract_id = $model->lb_record_primary_key;
                                        $contrctInvoiceModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                                        $contrctInvoiceModel->save();
                                        
                                        //Update invoice no vaf status I-OPEN
                                        $invoiceModel->confirm(); 
                                
                                        // add invoice to database right away.
                                        // other fields will be updated on the invoice page later on
                                        $invoiceModel->saveUnconfirmed();

                                        //
                                        // == Prepare line items grid
                                        // add 1 line-item by default
                                        // 
                                        $blankItem = new LbInvoiceItem();
                                        $blankItem->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                                        $blankItem->lb_invoice_item_description = "Contract payment for contract ".$model->lb_contract_no.", ".$model->lb_contract_type.", for period ".$model->lb_contract_date_start." to ".$model->lb_contract_date_end;
                                        $blankItem->lb_invoice_item_quantity = 1;
                                        $blankItem->lb_invoice_item_value = $model->lb_contract_amount;
                                        $blankItem->lb_invoice_item_total = $model->lb_contract_amount;
                                        $blankItem->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_LINE;
                                        $blankItem->save();
                                        
                                        // add tax
                                        $blankTax = new LbInvoiceItem();
                                        $default_tax = LbTax::model()->getDefaultTax();
                                        //$value_tax = ($default_tax->lb_tax_value/100) * $model->lb_contract_amount;
                                        $blankTax->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                                        $blankTax->lb_invoice_item_description = ($default_tax !== null ? $default_tax->lb_record_primary_key : 'Tax');
                                        $blankTax->lb_invoice_item_quantity = 1;
                                        $blankTax->lb_invoice_item_value =  ($default_tax !== null ? $default_tax->lb_tax_value : '0');
                                        $blankTax->lb_invoice_item_total = 0;
                                        $blankTax->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX;
                                        $blankTax->save();

                                        $invoiceItemModel=new LbInvoiceItem('search');
                                        $invoiceItemModel->unsetAttributes();  // clear any default values
                                        $invoiceItemModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;

                                        // totals - create a blank total record, set everything to zero: subtotal, after disc, after tax, paid, outstanding....
                                        $invoiceTotal = new LbInvoiceTotal;
                                        $invoiceTotal->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                                        $invoiceTotal->lb_invoice_revision_id = 0; // latest version
                                        $invoiceTotal->lb_invoice_subtotal = $model->lb_contract_amount;;
                                        $invoiceTotal->lb_invoice_total_after_discounts = $model->lb_contract_amount;
                                        $invoiceTotal->lb_invoice_total_after_taxes = $model->lb_contract_amount ;
                                        $invoiceTotal->lb_invoice_total_outstanding = $model->lb_contract_amount ;
                                        $invoiceTotal->lb_invoice_total_paid = 0;
                                        $invoiceTotal->save();

                                        // == end items grid data prep

                                        // Uncomment the following line if AJAX validation is needed
                                        // $this->performAjaxValidation($model);

                                        $invoiceDiscountModel = new LbInvoiceItem();
                                        $invoiceDiscountModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_DISCOUNT;
                                        $invoiceTaxModel = new LbInvoiceItem();
                                        $invoiceTaxModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX;
                                        //*** End add invoice **/
                                        
///////////////////////////////////////////////////////////////////////////////////////////////                                        
                                        //************** Add payment *************//
                                        if(isset($LbContracts['payment_amount']) && $LbContracts['payment_amount']!=0)
                                        {
                                            $paymentModel = new LbPayment();
                                            $paymentModel->attributes=$_POST['LbPayment'];
                                            $paymentModel->lb_payment_customer_id = $LbContracts['lb_customer_id'];
                                            $paymentModel->lb_payment_no = LbPayment::model()->FormatPaymentNo(LbPayment::model()->getPaymentNextNum());
                                            $paymentModel->lb_payment_total = $LbContracts['payment_amount'];
                                            if($paymentModel->save())
                                            {
                                                LbPayment::model()->setPaymentNextNum(LbPayment::model()->getPaymentNextNum());
                                                
                                                $paymentItemModel = new LbPaymentItem();
                                                $paymentItemModel->lb_payment_id = $paymentModel->lb_record_primary_key;
                                                $paymentItemModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                                                $paymentItemModel->lb_payment_item_note="";
                                                $paymentItemModel->lb_payment_item_amount=$LbContracts['payment_amount'];
                                                if($paymentItemModel->save()){
                                                    $invoice_total = LbInvoiceTotal::model()->getInvoiceTotal($paymentItemModel->lb_invoice_id);
                                                    if($invoice_total){
                                                        $invoice_total->calculateInvoicetotalPaid ($paymentItemModel->lb_invoice_id);
                                                        $total_outstanding = $invoice_total->calculateInvoiceTotalOutstanding();
                                                        if($total_outstanding)
                                                        {
                                                            //Update Status
                                                            LbInvoice::model()->InvoiceUpdateStatus($invoiceModel->lb_record_primary_key);
                                                        }

                                                    }
                                                }
                                            }
                                        }
                                }
                                
                            }
                            $this->redirect(array('view','id'=>$model->lb_record_primary_key));
                        }
				
		}
                $customer_id = "";
                if(isset($_POST['customer_id']))
                {
                    $customer_id = $_POST['customer_id'];
                }

		$this->render('create',array(
			'model'=>$model,
                        'documentModel'=>$documentModel,
                        'customer_id'=>$customer_id,
                        'paymentModel'=>$paymentModel,
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

		if(isset($_POST['LbContracts']))
		{
			$model->attributes=$_POST['LbContracts'];
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
		if($this->loadModel($id)->delete())
                {
                    $document = LbContractDocument::model()->getContractDocument($id);
                    foreach ($document->data as $dataDocumnet) {
                        $itemDocument = LbContractDocument::model()->findByPk($dataDocumnet->lb_record_primary_key);
                        $itemDocument->delete();
                    }
                    $contract_invoice = LbContractInvoice::model()->getContractInvoice($id);
                    foreach ($contract_invoice->data as $dataContractInvoice) {
                        $itemContractInvoice = LbContractInvoice::model()->findByPk($dataContractInvoice->lb_record_primary_key);
                        $itemContractInvoice->delete();
                    }
                }
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LbContracts');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($status=LbContracts::LB_CONTRACT_STATUS_ACTIVE)
	{
		$model=new LbContracts('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LbContracts']))
			$model->attributes=$_GET['LbContracts'];

		LBApplication::render($this,'admin',array(
			'model'=>$model,
                        'status'=>$status,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbContracts the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LbContracts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbContracts $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-contracts-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionAjaxDropDownAddress() 
        {
            $customer_id = $_POST['customer_id'];
            $option_address='<option value="0">Choose Address</option>';
            $address_arr = LbCustomerAddress::model()->getAddresses($customer_id, LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
            foreach ($address_arr as $key => $value) {
                $option_address.='<option value="'.$key.'">'.$value.'</option>';
            }

            echo $option_address;
        }
        
        public function actionAjaxDropDownContact()
        {
            $customer_id = $_POST['customer_id'];
            $option_contact='<option value="0">Choose Contact</option>';
            $contact_arr = LbCustomerContact::model()->getContacts($customer_id, LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
            foreach ($contact_arr as $key => $value) {
                $option_contact.='<option value="'.$key.'">'.$value.'</option>';
            }
            
            echo $option_contact; 
        }
        
        public function actionDashboard()
        {
            $model = new LbContracts();
            LBApplication::render($this,'dashboard',array(
                    'model'=>$model,
            ));
            
        }
        
        public function actionRenew($id)
        {
		$contractModel=LbContracts::model()->findByPk($id);
                
                $documentModel = new LbContractDocument();
                $paymentModel = new LbPayment();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LbContracts']))
		{
                    $LbContracts = $_POST['LbContracts'];
                    $model=new LbContracts;
                    $model->attributes=$_POST['LbContracts'];
                    $model->lb_customer_id = $contractModel->lb_customer_id;
                    $model->lb_address_id = $contractModel->lb_address_id;
                    $model->lb_contact_id = $contractModel->lb_contact_id;
                    $model->lb_contract_type = $contractModel->lb_contract_type;
                    $model->lb_contract_status =  LbContracts::LB_CONTRACT_STATUS_ACTIVE;
                    $model->lb_contract_parent = $contractModel->lb_record_primary_key;
			if($model->save())
                        {
                            //********* Upload document *****************//
                             $document = LbContractDocument::model()->getContractDocument($id);
                             foreach ($document->data as $dataDocument) {      
                                    $documentModel = new LbContractDocument;
                                    $documentModel->lb_contract_id = $model->lb_record_primary_key;
                                    $documentModel->lb_document_url = $dataDocument->lb_document_url;
                                    $documentModel->lb_document_name = $dataDocument->lb_document_name;
                                    $documentModel->lb_document_url_icon = $dataDocument->lb_document_url_icon;
                                    $documentModel->save(); // DONE
                                }
                            //**** End upload doxument ****//
                            
///////////////////////////////////////////////////////////////////////////////
                            //********* add new invoice *************/
                            if(isset($LbContracts['check_invoice']))
                            {
                                $invoiceModel = new LbInvoice();
                                // get basic info to assign to this record
                                $ownCompany = LbCustomer::model()->getOwnCompany();
                                $ownCompanyAddress = null;
                                $customerCompany = new LbCustomer;
                                $customerCompany->lb_customer_name = 'Click to choose customer';
                                

                                // get own company address
                                if ($ownCompany->lb_record_primary_key)
                                {
                                        // auto assign owner company
                                        $invoiceModel->lb_invoice_company_id = $ownCompany->lb_record_primary_key;

                                        $own_company_addresses = LbCustomerAddress::model()->getActiveAddresses($ownCompany->lb_record_primary_key,
                                                        $ownCompany::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

                                        if (count($own_company_addresses))
                                        {
                                                $ownCompanyAddress= $own_company_addresses[0];
                                                // auto assign owner company's address
                                                $invoiceModel->lb_invoice_company_address_id = $ownCompanyAddress->lb_record_primary_key;
                                        }
                                }
                                // add infor customer in invoice
                                $invoiceModel->lb_invoice_customer_id = $contractModel->lb_customer_id;
                                $invoiceModel->lb_invoice_customer_address_id = $contractModel->lb_address_id;
                                $invoiceModel->lb_invoice_attention_contact_id = $contractModel->lb_contact_id;
                                if($invoiceModel->save())
                                {
                                        // Save Lien ket contract va invoice
                                        $contrctInvoiceModel = new LbContractInvoice();
                                        $contrctInvoiceModel->lb_contract_id = $model->lb_record_primary_key;
                                        $contrctInvoiceModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                                        $contrctInvoiceModel->save();
                                        
                                        //Update invoice no vaf status I-OPEN
                                        $invoiceModel->confirm(); 
                                
                                        // add invoice to database right away.
                                        // other fields will be updated on the invoice page later on
                                        $invoiceModel->saveUnconfirmed();

                                        //
                                        // == Prepare line items grid
                                        // add 1 line-item by default
                                        // 
                                        $blankItem = new LbInvoiceItem();
                                        $blankItem->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                                        $blankItem->lb_invoice_item_description = "Contract payment for contract ".$model->lb_contract_no.", ".$model->lb_contract_type.", for period ".$model->lb_contract_date_start." to ".$model->lb_contract_date_end;
                                        $blankItem->lb_invoice_item_quantity = 1;
                                        $blankItem->lb_invoice_item_value = $model->lb_contract_amount;
                                        $blankItem->lb_invoice_item_total = $model->lb_contract_amount;
                                        $blankItem->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_LINE;
                                        $blankItem->save();
                                        
                                        // add tax
                                        $blankTax = new LbInvoiceItem();
                                        $default_tax = LbTax::model()->getDefaultTax();
                                        //$value_tax = ($default_tax->lb_tax_value/100) * $model->lb_contract_amount;
                                        $blankTax->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                                        $blankTax->lb_invoice_item_description = ($default_tax !== null ? $default_tax->lb_record_primary_key : 'Tax');
                                        $blankTax->lb_invoice_item_quantity = 1;
                                        $blankTax->lb_invoice_item_value =  ($default_tax !== null ? $default_tax->lb_tax_value : '0');
                                        $blankTax->lb_invoice_item_total = 0;
                                        $blankTax->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX;
                                        $blankTax->save();

                                        $invoiceItemModel=new LbInvoiceItem('search');
                                        $invoiceItemModel->unsetAttributes();  // clear any default values
                                        $invoiceItemModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;

                                        // totals - create a blank total record, set everything to zero: subtotal, after disc, after tax, paid, outstanding....
                                        $invoiceTotal = new LbInvoiceTotal;
                                        $invoiceTotal->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                                        $invoiceTotal->lb_invoice_revision_id = 0; // latest version
                                        $invoiceTotal->lb_invoice_subtotal = $model->lb_contract_amount;;
                                        $invoiceTotal->lb_invoice_total_after_discounts = $model->lb_contract_amount;
                                        $invoiceTotal->lb_invoice_total_after_taxes = $model->lb_contract_amount ;
                                        $invoiceTotal->lb_invoice_total_outstanding = $model->lb_contract_amount ;
                                        $invoiceTotal->lb_invoice_total_paid = 0;
                                        $invoiceTotal->save();

                                        // == end items grid data prep

                                        // Uncomment the following line if AJAX validation is needed
                                        // $this->performAjaxValidation($model);

                                        $invoiceDiscountModel = new LbInvoiceItem();
                                        $invoiceDiscountModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_DISCOUNT;
                                        $invoiceTaxModel = new LbInvoiceItem();
                                        $invoiceTaxModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX;
                                        //*** End add invoice **/
                                        
///////////////////////////////////////////////////////////////////////////////////////////////                                        
                                        //************** Add payment *************//
                                        if(isset($LbContracts['payment_amount']) && $LbContracts['payment_amount']!=0)
                                        {
                                            $paymentModel = new LbPayment();
                                            $paymentModel->attributes=$_POST['LbPayment'];
                                            $paymentModel->lb_payment_customer_id = $contractModel->lb_customer_id;
                                            $paymentModel->lb_payment_no = LbPayment::model()->FormatPaymentNo();
                                            $paymentModel->lb_payment_total = $LbContracts['payment_amount'];
                                            if($paymentModel->save())
                                            {
                                                LbPayment::model()->setPaymentNextNum(LbPayment::model()->getPaymentNextNum());
                                                
                                                $paymentItemModel = new LbPaymentItem();
                                                $paymentItemModel->lb_payment_id = $paymentModel->lb_record_primary_key;
                                                $paymentItemModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                                                $paymentItemModel->lb_payment_item_note="";
                                                $paymentItemModel->lb_payment_item_amount=$LbContracts['payment_amount'];
                                                if($paymentItemModel->save()){
                                                    $invoice_total = LbInvoiceTotal::model()->getInvoiceTotal($paymentItemModel->lb_invoice_id);
                                                    if($invoice_total){
                                                        $invoice_total->calculateInvoicetotalPaid ($paymentItemModel->lb_invoice_id);
                                                        $total_outstanding = $invoice_total->calculateInvoiceTotalOutstanding();
                                                        if($total_outstanding)
                                                        {
                                                            //Update Status
                                                            LbInvoice::model()->InvoiceUpdateStatus($invoiceModel->lb_record_primary_key);
                                                        }

                                                    }
                                                    echo "{succes}";
                                                }
                                            }
                                        }
                                }
                                
                            }
                            $contractModel->lb_contract_status = LbContracts::LB_CONTRACT_STATUS_HAS_RENEWED;
                            $contractModel->save();
                            $this->redirect(array('view','id'=>$model->lb_record_primary_key));
                        }	
		}
                $customer_id = "";
                if(isset($_POST['customer_id']))
                {
                    $customer_id = $_POST['customer_id'];
                }

            $this->render('_form_renew',array(
                    'model'=>$contractModel,
                    'paymentModel'=>$paymentModel,
                    //'documentModel'=>$documentModel,
            ));
        }
        
        public function actionAjaxFormPayment()
        {
            $paymentModel = new LbPayment;
            LBApplication::renderPartial($this, '_form_payment',array(
                            'paymentModel'=>$paymentModel,
                    ));
            
        }
        
        public function actionDeleteDocument($id)
        {
            $documentModel = LbContractDocument::model()->findByPk($id);
            $documentModel->delete();
        }
        
        public function actionUploadDocument($id)
        {
                Yii::import("ext.EAjaxUpload.qqFileUploader");

                $folder='uploads/';// folder for uploaded files
                $allowedExtensions = array("jpeg","jpg","gif","png","pdf","odt","docx","doc","dia");//array("jpg","jpeg","gif","exe","mov" and etc...
                $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
                $result = $uploader->handleUpload($folder);
                $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

                $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
                $fileName=$result['filename'];//GETTING FILE NAME
                
                 //tach filename va duoi
                $temp = explode('.', $fileName);
//                $duoi='.'.$temp[count($temp)-1];
//                $lendduoi = strlen($temp[count($temp)-1])+1;
//                $filename = substr( $pic->name,0,strlen($pic->name)-$lendduoi);
                
                $documentModel = new LbContractDocument;
                $documentModel->lb_contract_id = $id;
                $documentModel->lb_document_url = "/uploads/".$fileName; 
                $documentModel->lb_document_name = $fileName;
                $documentModel->lb_document_url_icon = "/images/fileicons/32px/".$temp[count($temp)-1].".png";
                $documentModel->save(); // DONE
                return $return;// it's array
        }
        
        public function ActionAjaxUpdateStatusContract($id,$status_update)
        {
            $model = LbContracts::model()->findByPk($id);
            $model->lb_contract_status = $status_update;
            $model->save();
        }
        
        public function actionCreateInvoice($id){
            $model = LbContracts::model()->findByPk($id);
        //********* add new invoice *************/
                $invoiceModel = new LbInvoice();
                // get basic info to assign to this record
                $ownCompany = LbCustomer::model()->getOwnCompany();
                $ownCompanyAddress = null;
                $customerCompany = new LbCustomer;
                $customerCompany->lb_customer_name = 'Click to choose customer';


                // get own company address
                if ($ownCompany->lb_record_primary_key)
                {
                        // auto assign owner company
                        $invoiceModel->lb_invoice_company_id = $ownCompany->lb_record_primary_key;

                        $own_company_addresses = LbCustomerAddress::model()->getActiveAddresses($ownCompany->lb_record_primary_key,
                                        $ownCompany::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

                        if (count($own_company_addresses))
                        {
                                $ownCompanyAddress= $own_company_addresses[0];
                                // auto assign owner company's address
                                $invoiceModel->lb_invoice_company_address_id = $ownCompanyAddress->lb_record_primary_key;
                        }
                }
                // add infor customer in invoice
                $invoiceModel->lb_invoice_customer_id = $model->lb_customer_id;
                $invoiceModel->lb_invoice_customer_address_id = $model->lb_address_id;
                $invoiceModel->lb_invoice_attention_contact_id = $model->lb_contact_id;
                if($invoiceModel->save())
                {
                        // Save Lien ket contract va invoice
                        $contrctInvoiceModel = new LbContractInvoice();
                        $contrctInvoiceModel->lb_contract_id = $model->lb_record_primary_key;
                        $contrctInvoiceModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                        $contrctInvoiceModel->save();

                        //Update invoice no vaf status I-OPEN
                        $invoiceModel->confirm(); 

                        // add invoice to database right away.
                        // other fields will be updated on the invoice page later on
                        $invoiceModel->saveUnconfirmed();

                        //
                        // == Prepare line items grid
                        // add 1 line-item by default
                        // 
                        $blankItem = new LbInvoiceItem();
                        $blankItem->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                        $blankItem->lb_invoice_item_description = "Contract payment for contract ".$model->lb_contract_no.", ".$model->lb_contract_type.", for period ".$model->lb_contract_date_start." to ".$model->lb_contract_date_end;
                        $blankItem->lb_invoice_item_quantity = 1;
                        $blankItem->lb_invoice_item_value = 0;
                        $blankItem->lb_invoice_item_total = 0;
                        $blankItem->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_LINE;
                        $blankItem->save();

                        // add tax
                        $blankTax = new LbInvoiceItem();
                        $default_tax = LbTax::model()->getDefaultTax();
                        //$value_tax = ($default_tax->lb_tax_value/100) * $model->lb_contract_amount;
                        $blankTax->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                        $blankTax->lb_invoice_item_description = ($default_tax !== null ? $default_tax->lb_record_primary_key : 'Tax');
                        $blankTax->lb_invoice_item_quantity = 1;
                        $blankTax->lb_invoice_item_value =  ($default_tax !== null ? $default_tax->lb_tax_value : '0');
                        $blankTax->lb_invoice_item_total = 0;
                        $blankTax->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX;
                        $blankTax->save();

                        $invoiceItemModel=new LbInvoiceItem('search');
                        $invoiceItemModel->unsetAttributes();  // clear any default values
                        $invoiceItemModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;

                        // totals - create a blank total record, set everything to zero: subtotal, after disc, after tax, paid, outstanding....
                        $invoiceTotal = new LbInvoiceTotal;
                        $invoiceTotal->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                        $invoiceTotal->lb_invoice_revision_id = 0; // latest version
                        $invoiceTotal->lb_invoice_subtotal = 0;;
                        $invoiceTotal->lb_invoice_total_after_discounts = 0;
                        $invoiceTotal->lb_invoice_total_after_taxes = 0 ;
                        $invoiceTotal->lb_invoice_total_outstanding = 0 ;
                        $invoiceTotal->lb_invoice_total_paid = 0;
                        $invoiceTotal->save();

                        // == end items grid data prep

                        // Uncomment the following line if AJAX validation is needed
                        // $this->performAjaxValidation($model);

                        $invoiceDiscountModel = new LbInvoiceItem();
                        $invoiceDiscountModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_DISCOUNT;
                        $invoiceTaxModel = new LbInvoiceItem();
                        $invoiceTaxModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX;
                        //*** End add invoice **/
                        //LBApplication::redire(array('lbInvoice/default/view','id'=>$invoiceModel->lb_record_primary_key));
                         $this->redirect(array('view','id'=>$model->lb_record_primary_key));
                }
        }
          
}