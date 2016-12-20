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
                        array('allow',
                            'actions'=>array(
                                    'index',
                                     'create',
                                     'view',
                                     'ajaxUpdateCustomer',
                                     'createBlankItem',
                                     'deleteBlankItem',
                                     'ajaxCreateBlankDiscount',
                                     'ajaxDeleteBlankDiscount',
                                     'ajaxCreateBlankTax',
                                     'ajaxDeleteBlankTax',
                                     'ajaxUpdateLineItems',
                                     'ajaxUpdateTaxs',
                                     'ajaxUpdateDiscount',
                                     'ajaxUpdateTotal',
                                     'ajaxtConfirm',
                                     'update',
                                     'ajaxQuickCreateCustomer',
                                     'ajaxQuickCreateAddress',
                                     'ajaxQuickCreateContact',
                                     'ajaxSendEmailQuotation',
                                     'formSendEmail',
                                     'formSharePDFQuotation',
                                     'PDFQuotation',
                                     'ajaxUpdateStatus',
                                     'chooseItemTemplate',
                                     'saveItemAsTemplate',
                                     'ajaxQuickCreateTax',
                                     'ajaxCreateInvoice',
                                     'ajaxSendEmailQuotationSharePDF',
                                     'getPublicPDF',
                                     'ajaxUpdateField',
                                     'uploadLogo',
                                     'ajaxCopyQuotation',
                                     'Search_Quotation',
                                     'ajaxQuickCreateCurrency',
                                     'AjaxUpdateFieldDate'
                            ),
                            'users'=>array('@'),
                        ),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('allow',  // deny all users
				'users'=>array('*'),
                                'actions'=> array('GetPublicPDF'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
	public function actionIndex()
	{
		$this->render('index');
	}
        function actionAdmin()
        {
            $model=new LbQuotation('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['LbQuotation']))
                    $model->attributes=$_GET['LbQuotation'];
            if(isset($_GET['status_id']))
                    $model->lb_quotation_status = $_GET['status_id'];
            
            LBApplication::render($this, 'admin', array(
                            'model'=>$model,
                            'status_id'=>$model->lb_quotation_status,
                    ));
        }
        function actionCreate()
        {
            $model = new LbQuotation();
            
            // get default ownCompany and ownCompany address
            $ownCompany = LbCustomer::model()->getOwnCompany();
            $ownCompanyAddress = null;
            if($ownCompany->lb_record_primary_key)
            {
                $model->lb_company_id = $ownCompany->lb_record_primary_key;
                $own_company_addresses = LbCustomerAddress::model()->getActiveAddresses($ownCompany->lb_record_primary_key,
                                $ownCompany::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
                
                if (count($own_company_addresses))
                {
                        $ownCompanyAddress= $own_company_addresses[0];
                        // auto assign owner company's address
                        $model->lb_company_address_id = $ownCompanyAddress->lb_record_primary_key;
                }
            }

            // save quotation Unconfirmed
            $model->saveUnconfirmed();
            
            // add 1 line-item by default
            $blankItem = new LbQuotationItem();
            $blankItem->addBlankItem($model->lb_record_primary_key);
            
            //add 1 tax by default
            $blankTax = new LbQuotationTax();
            $blankTax->addBlankTax($model->lb_record_primary_key);
            
            //add 1 total by default
            $blankTotal = new LbQuotationTotal();
            $blankTotal->createBlankTotal($model->lb_record_primary_key);
            
            $model->save();
            $id = $model->lb_record_primary_key;
            $model = $this->loadModel($id);
            
            $quotationItemModel = new LbQuotationItem('search');
            $quotationItemModel->unsetAttributes();
            $quotationItemModel->lb_quotation_id = $model->lb_record_primary_key;
            
            $quotationTaxModel = new LbQuotationTax('search');
            $quotationTaxModel->unsetAttributes();
            $quotationTaxModel->lb_quotation_id = $model->lb_record_primary_key;
            
            $quotationDiscountModel = new LbQuotationDiscount('search');
            $quotationDiscountModel->unsetAttributes();
            $quotationDiscountModel->lb_quotation_id = $model->lb_record_primary_key;
            
            $quotationTotalModel = LbQuotationTotal::model()->getQuotationTotal($id);
            
            
            LBApplication::render($this, 'view', array(
                'model'=>$model,
                'quotationItemModel'=>$quotationItemModel,
                'quotaitonTaxModel'=>$quotationTaxModel,
                'quotationDiscountModel'=>$quotationDiscountModel,
                'quotationTotalModel'=>$quotationTotalModel));
            $this->redirect(array('view','id'=>$model->lb_record_primary_key));
        }
        function actionView($id)
        {
            $model = $this->loadModel($id);
            
            $quotationItemModel = new LbQuotationItem('search');
            $quotationItemModel->unsetAttributes();
            $quotationItemModel->lb_quotation_id = $model->lb_record_primary_key;
            
            $quotationTaxModel = new LbQuotationTax('search');
            $quotationTaxModel->unsetAttributes();
            $quotationTaxModel->lb_quotation_id = $model->lb_record_primary_key;
            
            $quotationDiscountModel = new LbQuotationDiscount('search');
            $quotationDiscountModel->unsetAttributes();
            $quotationDiscountModel->lb_quotation_id = $model->lb_record_primary_key;
            
            $quotationTotalModel = LbQuotationTotal::model()->getQuotationTotal($id);
            
            
            LBApplication::render($this, 'view', array(
                'model'=>$model,
                'quotationItemModel'=>$quotationItemModel,
                'quotaitonTaxModel'=>$quotationTaxModel,
                'quotationDiscountModel'=>$quotationDiscountModel,
                'quotationTotalModel'=>$quotationTotalModel));
        }
        function loadModel($id)
        {
            $model = LbQuotation::model()->findByPk($id);
            if($model===NULL)
                throw new CHttpException(404,'The requested page does not exist.');
            return $model;
        }
        
        
	/**
	 * Use for updating through inline editable
	 * such as jquery editable, bootstrap x-editable, etc.
	 *
	 * POST params
	 * pk	the primary key of this record
	 * name attribute name
	 * value value to be updated to
	 *
	 * This action actually call actionAjaxUpdateField in parent controller
	 * , but also continue to auto assign address to this quotation.
	 */
        function actionAjaxUpdateCustomer()
        {
            if($this->actionAjaxUpdateField())
            {
                $quotation_id = $_POST['pk'];
                $quotation = LbQuotation::model()->findByPk($quotation_id);
                
                if($quotation)
                {
                    // reset address just in case some address of previous customer is already there
                    $quotation->lb_quotation_customer_address_id = 0;
                    $quotation->lb_quotation_attention_id = 0;
                    $address_array['customer_name']="";
                    $quotation->save();
                    $address_array['customer']=$quotation->lb_quotation_customer_id;
                    if($quotation->lb_quotation_customer_id > 0)
                    {
                        
                        $custoemr_name = str_replace( ' ', '-',$quotation->customer->lb_customer_name);
                        $address_array['customer_name']=$custoemr_name;
                    }
                    // auto assign one of the addresses of this customer to this invoice
                    $addresses = LbCustomerAddress::model()->getAddresses($quotation->lb_quotation_customer_id,
                                    LbCustomerAddress::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
                    $firstAddress = null;
                    
                    if(count($addresses))
                    {
                        // get first billing address
                        // or just first address to auto assign to this invoice
                        $firstAddress = $addresses[0]; // be default, just use first address
                        foreach ($addresses as $addr)
                        {
                                // if billing address, use this instead
                                if ($addr->lb_customer_address_is_billing)
                                {
                                        $firstAddress = $addr;
                                        break; // no need to carry on
                                }
                                
                                // assign address to invoice
                                $quotation->lb_quotation_customer_address_id = $firstAddress->lb_record_primary_key;
                                if ($quotation->save())
                                {
                                        // return that address in json
                                        // we need to format it nicely.
                                        $address_array = $firstAddress->formatAddressLines();
                                        $address_array['customer_name']="";
                                        
                                        $address_array['customer']=$quotation->lb_quotation_customer_id;
                                        if($quotation->lb_quotation_customer_id > 0)
                                        {

                                            $custoemr_name = str_replace( ' ', '-',$quotation->customer->lb_customer_name);
                                            $address_array['customer_name']=$custoemr_name;
                                        }
                                        // print json
//                                        LBApplication::renderPartial($this, '//layouts/plain_ajax_content', array(
//                                                'content'=>CJSON::encode($address_array),
//                                        ));
                                        
                                } // end formatting address to return in json
                        }
                    }
                    LBApplication::renderPartial($this, '//layouts/plain_ajax_content', array(
                                                'content'=>CJSON::encode($address_array),
                                        ));
                                        return true;
                }   
            }
        }
        function actionCreateBlankItem($id)
        {
            $quotationItem = new LbQuotationItem();
            $result = $quotationItem->addBlankItem($id);
            if($result)
            {
                $response = array();
                $response['success'] = YES;
                $response['quotation_item_id'] = $quotationItem->lb_record_primary_key;
                LBApplication::renderPlain($this, array('content'=>  CJSON::encode($response)));
            }

        }
        function actionDeleteBlankItem($id)
        {
            $quotationItem = LbQuotationItem::model()->findByPk($id);
            $result=$quotationItem->delete();
            if($result)
            {
                //Update Total
                $this->actionAjaxUpdateTotal($quotationItem->lb_quotation_id);
                //Update Tax
                $this->actionAjaxUpdateTaxs($quotationItem->lb_quotation_id);
                
//                //Get Total
//                $quotationTotal = LbQuotationTotal::model()->getQuotationTotal($quotationItem->lb_quotation_id);
//                LBApplication::renderPlain($this,  array('content'=>CJSON::encode($quotationTotal)));
            }
            
        }
        function actionAjaxCreateBlankDiscount($id)
        {
            $quotationDiscount = new LbQuotationDiscount();
            $result = $quotationDiscount->addBlankDiscount($id);
            
            if($result)
            {
                $response = array();
                $response['success'] = YES;
                $response['quotation_discount_id'] = $quotationDiscount->lb_record_primary_key;
                
                LBApplication::renderPlain($this,array('content'=>CJSON::encode($response)));
            }
        }
        function actionAjaxDeleteBlankDiscount($id)
        {
            $quotationDiscount = LbQuotationDiscount::model()->findByPk($id);
            $result = $quotationDiscount->delete();
            if($result)
            {
                $quotation_id = $quotationDiscount->lb_quotation_id;
                //Update Total
               $this->actionAjaxUpdateTotal($quotation_id);

               //Update Tax
               $this->actionAjaxUpdateTaxs($quotation_id);
            }
        }
        
        function actionAjaxCreateBlankTax($id){
            $quotationTax = new LbQuotationTax();
            $result = $quotationTax->addBlankTax($id);
            if($result)
            {
                //Update Total
                $this->actionAjaxUpdateTotal($id);
                //Update Tax
                $this->actionAjaxUpdateTaxs($id);
            }
        }
        
        function actionAjaxDeleteBlankTax($id){
            $quotationTax = LbQuotationTax::model()->findByPk($id);
            if($quotationTax->delete())
            {
                $quotation_id = $quotationTax->lb_quotation_id;
                //Update Total
                $this->actionAjaxUpdateTotal($quotation_id);
                //Update Tax
                $this->actionAjaxUpdateTaxs($quotation_id);
            }
            
        }
        
        function actionAjaxUpdateLineItems($id){
            $quotationItem = LbQuotationItem::model()->getquotationItems($id, "ModelArray");
            
            foreach ($quotationItem as $item) {
                $item_id = $item->lb_record_primary_key;
                $item_quantity = $item->lb_quotation_item_quantity;
                $item_price = $item->lb_quotation_item_price;
                
                if(isset($_POST['lb_quotation_item_description_'.$item_id]))
                {
                    $item->lb_quotation_item_description = $_POST['lb_quotation_item_description_'.$item_id];
                }
                if(isset($_POST['lb_quotation_item_quantity_'.$item_id]))
                {
                    $item_quantity = $_POST['lb_quotation_item_quantity_'.$item_id];
                    $item->lb_quotation_item_quantity = $_POST['lb_quotation_item_quantity_'.$item_id];
                }
                if(isset($_POST['lb_quotation_item_price_'.$item_id]))
                {
                    $item_price = $_POST['lb_quotation_item_price_'.$item_id];
                    $item->lb_quotation_item_price = $_POST['lb_quotation_item_price_'.$item_id];
                }
                $item->lb_quotation_item_total = $item_quantity * $item_price;
                
                $item->save();
            }
            
            //Update Total
            $this->actionAjaxUpdateTotal($id);
            //Update Tax
            $this->actionAjaxUpdateTaxs($id);
            
        }
        function actionAjaxUpdateTaxs($id)
        {
            $quotationTax = LbQuotationTax::model()->getTaxQuotation($id);
            
            //get total
            $quotationTotal = LbQuotationTotal::model()->getQuotationTotal($id);
            $subtotal = $quotationTotal->lb_quotation_subtotal;
            $totalDiscount = $quotationTotal->lb_quotation_total_after_discount;
            $subtotal_and_discount = $subtotal - $totalDiscount;
            
            $taxTotal =0;
            if(count($quotationTotal)>0)
            {
                foreach ($quotationTax->data as $tax) 
                {
                    $tax_id = $tax->lb_record_primary_key;
                    $quotationtax_tax_id = $tax->lb_quotation_tax_id;

                    if(isset($_POST['lb_quotation_tax_id_'.$tax_id]))
                    {
                        $quotationtax_tax_id = $_POST['lb_quotation_tax_id_'.$tax_id];
                        $tax->lb_quotation_tax_id = $quotationtax_tax_id;
                    }

                    $LbTax = LbTax::model()->findByPk($quotationtax_tax_id);

                    $tax->lb_quotation_tax_value = (isset($LbTax->lb_tax_value) ? $LbTax->lb_tax_value : 0 );


                    $taxTotal = ($subtotal_and_discount*$tax->lb_quotation_tax_value)/100;
                    $tax->lb_quotation_tax_total = $taxTotal;

                    $tax->save();
                }
            }
            $this->actionAjaxUpdateTotal($id);
            
            $quotationTotal = LbQuotationTotal::model()->getQuotationTotal($id);
            LBApplication::renderPlain($this,  array('content'=>CJSON::encode($quotationTotal)));
        }
        
        function actionAjaxUpdateDiscount($id)
        {
            $quotationDiscount = LbQuotationDiscount::model()->getQuotationDiscounts($id);          
            
            foreach ($quotationDiscount->data as $discount)
            {
               $discount_item = $discount->lb_record_primary_key;

                if(isset($_POST['lb_quotation_item_description_'.$discount_item]))
                {
                    $discount->lb_quotation_discount_description = $_POST['lb_quotation_item_description_'.$discount_item];
                }

                $discount->lb_quotation_discount_total = $_POST['lb_quotation_item_total_'.$discount_item];
                
                $discount->save();
            }
            //Update Total
            $this->actionAjaxUpdateTotal($id);
            
            //Update Tax
            $this->actionAjaxUpdateTaxs($id);
        }
        
        function actionAjaxUpdateTotal($id)
        {
            LbQuotationTotal::model()->calculateQuotationSubtotal($id);
            LbQuotationTotal::model()->calculateQuotationTotalDiscount($id);
            LbQuotationTotal::model()->calculateQuotationAfterTotalTax($id);
            LbQuotationTotal::model()->calculateQuotationAfterTotal($id);
        }
        
        function actionAjaxtConfirm($id)
        {
            $quotation = LbQuotation::model()->findByPk($id);
            $quotation->confirm();
            $result = array();
            $result['lb_record_primary_key'] = $id;
            $result['lb_quotation_status'] = $quotation->lb_quotation_status;
            $result['lb_quotation_no'] = $quotation->lb_quotation_no;
            $result['lb_quotation_status_display'] = LbQuotation::model()->getDisplayQuotationStatus($quotation->lb_quotation_status);
            
            LBApplication::renderPlain($this, array('content'=>  CJSON::encode($result)));
        }
        function actionDelete($id){
            $quotation = LbQuotation::model()->findByPk($id);
            if($quotation->lb_quotation_status==LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT)
                $quotation->delete();
            
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        function ActionUpdate($id){
            $this->actionView($id);
        }
        function actionAjaxQuickCreateCustomer($id)
        {
            $customerModel = new LbCustomer;
            $model = $this->loadModel($id);

            if (isset($_POST['LbCustomer']))
            {
                // save customer data
                $customerModel->attributes = $_POST['LbCustomer'];
                if ($customerModel->save())
                {
                    // assign this customer to this quotation
                    $model->setCustomer($customerModel->lb_record_primary_key);
                }
                //return JSON record of customer
                LBApplication::renderPlain($this, array('content'=>CJSON::encode($customerModel)));
                return true;
            }

            // show quick create form
            LBApplication::render($this,'_form_customer', array(
                'model'=>$model,
                'customerModel'=>$customerModel,
            ));
        }
        
    /**
     * Quick create customer address from a modal form
     * over invoice main page
     *
     * @param string $id   quotation id
     * @return bool
     * @throws CHttpException if customer is not selected.
     */
    public function actionAjaxQuickCreateAddress($id)
    {
        $model = $this->loadModel($id);
        $customerModel = LbCustomer::model()->findByPk($model->lb_quotation_customer_id);
        $customerAddress = new LbCustomerAddress();

        // a customer must have been assigned first
        if ($customerModel === null)
        {
            throw new CHttpException(404,'Please select a customer first.');
        }

        if (isset($_POST['LbCustomerAddress']))
        {
            // save customer data
            $customerAddress->attributes = $_POST['LbCustomerAddress'];
            $customerAddress->lb_customer_id = $customerModel->lb_record_primary_key;
            if ($customerAddress->save())
            {
                // assign this address to this quotation
                $model->lb_quotation_customer_address_id = $customerAddress->lb_record_primary_key;
                $model->save();
            }
            //return JSON record of customer address
            LBApplication::renderPlain($this,
                array('content'=>CJSON::encode($customerAddress->formatAddressLines())));
            return true;
        }

        // show quick create form
        LBApplication::render($this,'_form_address', array(
            'model'=>$model,
            'customerModel'=>$customerModel,
            'customerAddressModel'=>$customerAddress
        ));
    }
    
    public function actionAjaxQuickCreateContact($id)
    {
        $model = $this->loadModel($id);
        $customerModel = LbCustomer::model()->findByPk($model->lb_quotation_customer_id);
        $customerContact = new LbCustomerContact();

        // a customer must have been assigned first
        if ($customerModel === null)
        {
            throw new CHttpException(404,'Please select a customer first.');
        }

        if (isset($_POST['LbCustomerContact']))
        {
            // save customer data
            $customerContact->attributes = $_POST['LbCustomerContact'];
            $customerContact->lb_customer_id = $customerModel->lb_record_primary_key;
            if ($customerContact->save())
            {
                // assign this contact to this quotation
                $model->lb_quotation_attention_id = $customerContact->lb_record_primary_key;
                $model->save();
            }
            //return JSON record of customer address
            LBApplication::renderPlain($this,
                array('content'=>CJSON::encode($customerContact))
            );
            return true;
        }
        
        // show quick create form
        LBApplication::render($this,'_form_contact', array(
            'model'=>$model,
            'customerModel'=>$customerModel,
            'customerContactModel'=>$customerContact
        ));
    }
    
    function actionAjaxSendEmailQuotation($id)
    {
         $email_to = $_POST['email_to_quotation'];
         $email_to_arr = explode(",", $email_to);
         $model = LbQuotation::model()->findByPk($id);
         $message = new YiiMailMessage();
         $message->subject= $_POST['email_subject_quotation'];
         $message->setBody($_POST['email_content_quotation'], 'text/html');
         foreach ($email_to_arr as $value) {
            $message->addTo($value);
         }
         //$message->addTo('thongnv@lionsoftwaresolutions.com');
         $message->from = $_POST['email_from_quotaiton'];
         $swiftAttachment = Swift_Attachment::newInstance($this->actionPDFQuotation($id,true),$model->lb_quotation_no.'.pdf','application/pdf');
         $message->attach($swiftAttachment);
         //$message->AddAttachment(Yii::app()->createAbsoluteUrl('lbInvoice/default/pdf/',array('id'=>$id)));
         if(Yii::app()->mail->send($message))
         {
             $status = $this->actionAjaxUpdateStatus($id,LbQuotation::LB_QUOTATION_STATUS_CODE_SENT);
             $response['lb_quotation_status'] = $status;
             LBApplication::renderPlain($this, array('content'=>  CJSON::encode($response)));
         }
         
    }
    
    function actionFormSendEmail($id)
    {
        $model = LbQuotation::model()->findByPk($id);
        LBApplication::renderPartial($this, '_form_email', array('model'=>$model));
    }
    
    function actionFormSharePDFQuotation($id)
    {
        $model = LbQuotation::model()->findByPk($id);
        $p = $model->lb_quotation_encode;
        LBApplication::renderPartial($this, '_form_public_pdf', array('model'=>$model,'p'=>$p));
    }
    
    function actionPDFQuotation($id,$email=false)
    {
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $model = LbQuotation::model()->findByPk($id);
        //$html2pdf->AddFont(13);
        $html2pdf->WriteHTML($this->renderPartial('_form_pdf', array('model'=>$model),true));
         $html2pdf->WriteHTML($this->renderPartial('_pdf_footer', array(), true));
        if($email)
            return $html2pdf->Output('',true);
        else {
            $html2pdf->Output($model->lb_quotation_no.'.pdf','I');
        }
    }
    
    function actionAjaxUpdateStatus($id,$status_value)
    {
        $model = LbQuotation::model()->findByPk($id);
        $model->lb_quotation_status=$status_value;
        if($model->save())
        {
            return $model->lb_quotation_status;
        }
    }
    
    function actionChooseItemTemplate($id)
    {
        $model = $this->loadModel($id);
        $quotationItem = LbQuotationItem::model()->findByPk($_GET['item_id']);

        $invoiceItemTemplate = new LbInvoiceItemTemplate('search');
        $invoiceItemTemplate->unsetAttributes();  // clear any default values
        if(isset($_GET['LbInvoiceItemTemplate']))
            $invoiceItemTemplate->attributes=$_GET['LbInvoiceItemTemplate'];

        LBApplication::render($this,'_form_template',array(
            'model'=>$model,
            'quotationItem'=>$quotationItem,
            'invoiceItemTemplate'=>$invoiceItemTemplate,
        ));
    }
    
    /**
     * Save a current invoice item as a template item
     *
     * @param $id invoice id
     */
    public function actionSaveItemAsTemplate($id)
    {
        $model = $this->loadModel($id);

        // only proceed if params are present
        if ($model && isset($_POST['item_description']) && isset($_POST['item_unit_price']))
        {
            $invoiceItemTemplate = new LbInvoiceItemTemplate();
            $invoiceItemTemplate->lb_item_unit_price = $_POST['item_unit_price'];

            // split the posted description into title and description
            $split_description = explode("\n",$_POST['item_description']);
            if (count($split_description) > 1)
            {
                $invoiceItemTemplate->lb_item_title = $split_description[0];
                for ($i = 1; $i < count($split_description); $i++)
                {
                    $invoiceItemTemplate->lb_item_description .= $split_description[$i];
                    if ($i+1 < count($split_description))
                        $invoiceItemTemplate->lb_item_description .= "\n";
                }
            } else {
                $invoiceItemTemplate->lb_item_title = "";
                $invoiceItemTemplate->lb_item_description = $_POST['item_description'];
            }

            if ($invoiceItemTemplate->save())
            {
                LBApplication::renderPlain($this, array('content'=>SUCCESS));
            } else {
                LBApplication::renderPlain($this, array('content'=>FAILURE));
            }
        }
    }
    
    public function actionAjaxQuickCreateTax($id)
    {
        $model = new LbTax();
        $submission_type = isset($_GET['form_type']) ? $_GET['form_type'] : 'default';

        $quotationModel = LbQuotation::model()->findByPk($id);

        if (isset($_POST['LbTax']))
        {
            $model->attributes=$_POST['LbTax'];
            $lbtax_arr = $_POST['LbTax'];
            
            if(!LbTax::model()->IsNameTax($lbtax_arr['lb_tax_name']))
            {
                $error['error'] = "Tax Name Exist.";
                LBApplication::renderPlain($this, array('content'=>CJSON::encode($error)));
                return false;
            }
            
            if($model->save())
            {
                $result['yes']=true;
                if ($submission_type == 'ajax')
                {
                        // auto add this tax item into this invoice
                        $quotaitonTax = new LbQuotationTax();
                        if($quotaitonTax->addTaxToQuotation($id,$model))
                            $this->actionAjaxUpdateTaxs($id);
                        // print json result of this quotation item
                        //LBApplication::renderPlain($this, array('content'=>CJSON::encode($result)));
                       return true;
                } 
            }
        }

        $submission_details = array();
        $submission_details["type"] = $submission_type;

        LBApplication::render($this, '_form_tax', array(
            'model'=>$model,
            'quotationModel'=>$quotationModel,
            'submission_details'=>$submission_details,
        ));
    }
    
    function actionAjaxCreateInvoice($id)
    {
        $model = $this->loadModel($id);
        $quotationItem = LbQuotationItem::model()->getquotationItems($id,'ModelArray');
        $quotationDiscount = LbQuotationDiscount::model()->getQuotationDiscounts($id);
        $quotationTax = LbQuotationTax::model()->getTaxQuotation($id);
        $quotationTotal = LbQuotationTotal::model()->getQuotationTotal($id);
        
        
        $invoiceModel = new LbInvoice;
        $invoiceTotal = new LbInvoiceTotal;
        
        $invoice_number_int = LbInvoice::model()->getInvoiceNextNum();
        $invoiceModel->lb_invoice_no = LbInvoice::model()->formatInvoiceNextNumFormatted($invoice_number_int);
        $invoiceModel->lb_invoice_status_code = LbInvoice::LB_INVOICE_STATUS_CODE_OPEN;
        // invoice date
        $invoiceModel->lb_invoice_date = date('Y-m-d');
        $invoiceModel->lb_invoice_due_date = date('Y-m-d');
        // invoice group
        $invoiceModel->lb_invoice_group = LbInvoice::LB_INVOICE_GROUP_INVOICE;
        // invoice base64_decode
        $invoiceModel->lb_invoice_encode = LbInvoice::model()->setBase64_decodeInvoice();
        // invoice note
        $invoiceModel->lb_invoice_note = $model->lb_quotation_note;
        $invoiceModel->lb_invoice_company_id = $model->lb_company_id;
        $invoiceModel->lb_invoice_company_address_id = $model->lb_company_address_id;
        $invoiceModel->lb_invoice_customer_id = $model->lb_quotation_customer_id;
        $invoiceModel->lb_invoice_customer_address_id = $model->lb_quotation_customer_address_id;
        $invoiceModel->lb_invoice_attention_contact_id = $model->lb_quotation_attention_id;
        $invoiceModel->lb_quotation_id = $model->lb_record_primary_key;
        $invoiceModel->lb_invoice_subject = $model->lb_quotation_subject;
        
        // invoice internal note
        $invoiceModel->lb_invoice_internal_note = $model->lb_quotation_internal_note;
        
        if($invoiceModel->save())
        {
            // copy line item
            foreach ($quotationItem as $q_item)
            {
                $invoiceItemModel = new LbInvoiceItem;
                $invoiceItemModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                $invoiceItemModel->lb_invoice_item_description = $q_item->lb_quotation_item_description;
                $invoiceItemModel->lb_invoice_item_quantity = $q_item->lb_quotation_item_quantity;
                $invoiceItemModel->lb_invoice_item_value = $q_item->lb_quotation_item_price;
                $invoiceItemModel->lb_invoice_item_total = $q_item->lb_quotation_item_total;
                $invoiceItemModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_LINE;
                
                $invoiceItemModel->save();
            }
            
            // copy tax item
            foreach($quotationTax->data as $q_tax)
            {
                $invoiceTaxModel = new LbInvoiceItem;
                $invoiceTaxModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                $invoiceTaxModel->lb_invoice_item_description = $q_tax->lb_quotation_tax_id;
                $invoiceTaxModel->lb_invoice_item_quantity = 1;
                $invoiceTaxModel->lb_invoice_item_value = $q_tax->lb_quotation_tax_value;
                $invoiceTaxModel->lb_invoice_item_total = $q_tax->lb_quotation_tax_total;
                $invoiceTaxModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX;
                
                $invoiceTaxModel->save();
            }
            
            // copy discount item
            foreach($quotationDiscount->data as $q_discount)
            {
                $invoiceDiscountModel = new LbInvoiceItem;
                $invoiceDiscountModel->lb_invoice_id = $invoiceModel->lb_record_primary_key;
                $invoiceDiscountModel->lb_invoice_item_description = $q_discount->lb_quotation_discount_description;
                $invoiceDiscountModel->lb_invoice_item_quantity = 1;
                $invoiceDiscountModel->lb_invoice_item_value = $q_discount->lb_quotation_discount_total;
                $invoiceDiscountModel->lb_invoice_item_total = $q_discount->lb_quotation_discount_total;
                $invoiceDiscountModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_DISCOUNT;
                
                $invoiceDiscountModel->save();
            }
            
            // Copy Total
            $invoiceTotal->lb_invoice_id = $invoiceModel->lb_record_primary_key;
            $invoiceTotal->lb_invoice_subtotal = $quotationTotal->lb_quotation_subtotal;
            $invoiceTotal->lb_invoice_total_after_discounts = $quotationTotal->lb_quotation_total_after_discount;
            $invoiceTotal->lb_invoice_total_after_taxes = $quotationTotal->lb_quotation_total_after_total;
            $invoiceTotal->lb_invoice_total_outstanding = $quotationTotal->lb_quotation_total_after_total;
            $invoiceTotal->lb_invoice_revision_id=0;

            $invoiceTotal->save();
            // redirect Invoice
//            $url_invoice = $model->customer ? LbInvoice::model()->getViewURL($model->customer->lb_customer_name,null,$invoiceModel->lb_record_primary_key) : LbInvoice::model()->getViewURL("No customer",null,$invoiceModel->lb_record_primary_key);
//            $this->redirect($url_invoice);
        }
        
    }
    
    function actionAjaxSendEmailQuotationSharePDF($p){

         $email_body = $_POST['email_content']."<br><br><a href='".Yii::app()->createAbsoluteUrl("lbQuotation/p/".$p)."'>".Yii::app()->createAbsoluteUrl("lbQuotation/p/".$p)."</a>";
         $email_to = $_POST['email_to'];
         $email_to_arr = explode(",", $email_to);
         $message = new YiiMailMessage();
         $message->subject= "Share PDF";
         $message->setBody($email_body, 'text/html');
         foreach ($email_to_arr as $value) {
            $message->addTo($value);
         }
         $message->from = 'thongnv@lionsoftwaresolutions.com';
         echo Yii::app()->mail->send($message);  
    }
    
    public function actionGetPublicPDF($p)
    {
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $model = LbQuotation::model()->find('lb_quotation_encode="'.$p.'"');
        $html2pdf->WriteHTML($this->renderPartial('_form_pdf', array('model'=>$model),true));  

        $html2pdf->Output('quotation.pdf',false);
    }
    
    public function actionAjaxCopyQuotation($id)
    {
        //Add thong tin quotation
        $quo_new = new LbQuotation();
        $quotation = LbQuotation::model()->findByPk($id);
        
        $quo_new->lb_quotation_no = LbQuotation::model()->formatQuotationNextNumFormatted(0);
        $quo_new->lb_quotation_date = date('Y-m-d');
        $quo_new->lb_quotation_due_date = date('Y-m-d');
        $quo_new->lb_quotation_status = LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT;
        $quo_new->lb_company_id = $quotation->lb_company_id;
        $quo_new->lb_company_address_id = $quotation->lb_company_address_id;
        $quo_new->lb_quotation_customer_id = $quotation->lb_quotation_customer_id;
        $quo_new->lb_quotation_customer_address_id = $quotation->lb_quotation_customer_address_id;
        $quo_new->lb_quotation_attention_id = $quotation->lb_quotation_attention_id;
        $quo_new->lb_quotation_internal_note = $quotation->lb_quotation_internal_note;
        $quo_new->lb_quotation_subject = $quotation->lb_quotation_subject;
        $quo_new->lb_quotation_note = $quotation->lb_quotation_note;
        $quo_new->lb_quotation_encode = LbQuotation::model()->setBase64_decodeQuotation();
        if($quo_new->save())
        {
            // Add thong tin tax
            $quotation_tax_arr = LbQuotationTax::model()->getTaxQuotation($quotation->lb_record_primary_key);
            foreach ($quotation_tax_arr->data as $tax_item) {
                $quo_tax_new = new LbQuotationTax();
                
                $quo_tax_new->lb_quotation_id = $quo_new->lb_record_primary_key;
                $quo_tax_new->lb_quotation_tax_id = $tax_item->lb_quotation_tax_id;
                $quo_tax_new->lb_quotation_tax_value = $tax_item->lb_quotation_tax_value;
                $quo_tax_new->lb_quotation_tax_total = $tax_item->lb_quotation_tax_total;
                $quo_tax_new->save();
            }//END
            
            //Add thong tin discount
            $quotation_discount_arr = LbQuotationDiscount::model()->getQuotationDiscounts($quotation->lb_record_primary_key);
            foreach ($quotation_discount_arr->data as $discount_item) {
                $quo_discount_new = new LbQuotationDiscount();
                
                $quo_discount_new->lb_quotation_id = $quo_new->lb_record_primary_key;
                $quo_discount_new->lb_quotation_discount_description = $discount_item->lb_quotation_discount_description;
                $quo_discount_new->lb_quotation_discount_total = $discount_item->lb_quotation_discount_total;
                $quo_discount_new->lb_quotation_discount_value = $discount_item->lb_quotation_discount_value;
                $quo_discount_new->save();
            }//END
            
            //Add Thong tin total
            $quotation_total= LbQuotationTotal::model()->getQuotationTotal($quotation->lb_record_primary_key);
            $quo_total_new = new LbQuotationTotal();
            
            $quo_total_new->lb_quotation_id = $quo_new->lb_record_primary_key;
            $quo_total_new->lb_quotation_subtotal= $quotation_total->lb_quotation_subtotal;
            $quo_total_new->lb_quotation_total_after_discount = $quotation_total->lb_quotation_total_after_discount;
            $quo_total_new->lb_quotation_total_after_tax = $quotation_total->lb_quotation_total_after_tax;
            $quo_total_new->lb_quotation_total_after_total = $quotation_total->lb_quotation_total_after_total;
            $quo_total_new->save();
            
            //Add thong tin item
            $quotation_item_arr = LbQuotationItem::model()->getquotationItems($quo_new->lb_record_primary_key);
            foreach ($quotation_item_arr->data as $item) {
                $quo_item_new = new LbQuotationItem();
                
                $quo_item_new->lb_quotation_id = $quo_new->lb_record_primary_key;
                $quo_item_new->lb_quotation_item_price = $item->lb_quotation_item_price;
                $quo_item_new->lb_quotation_item_description = $item->lb_quotation_item_description;
                $quo_item_new->lb_quotation_item_quantity = $item->lb_quotation_item_quantity;
                $quo_item_new->lb_quotation_item_total = $item->lb_quotation_item_total;
                $quo_item_new->save();
            }//END

        }        
        
    }
    public function actionSearch_Quotation(){
        $search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
        LBApplication::renderPartial($this, 'search_view_quotation', array(
            'search_name'=>$search_name,
        ));
    }
     public function actionajaxQuickCreateCurrency(){
        $quotation_id = isset($_REQUEST['quotation_id']) ? $_REQUEST['quotation_id'] : '';        
       // $model = LbInvoice::model()->findByPk($invoice_id);
        $model = $this->loadModel($quotation_id);
        $GeneraModel = new LbGenera();
        if(isset($_POST['LbGenera'])){
            $GeneraModel->attributes = $_POST['LbGenera'];
            if($GeneraModel->save()){
                $model->lb_quotation_currency = $GeneraModel->lb_record_primary_key;
                 $model->save();
            }
            LBApplication::renderPlain($this,
                array('content'=>CJSON::encode($GeneraModel))
            );
            return true;
        }
        LBApplication::renderPartial($this, '_form_currency', array(
            'model'=>$model,
            'GeneraModel'=>$GeneraModel,
        ));
    }
    public function actionAjaxUpdateFieldDate()
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
			//$model->save();
                        if($model->save()){
                           // if($model->lb_invoice_status_code != LbInvoice::LB_INVOICE_STATUS_CODE_PAID){
//                                $status = LbInvoice::model()->UpdateStatusInvoice($model->lb_record_primary_key);
//                                $model->lb_invoice_status_code = $status;
                                $model->lb_quotation_due_date = LbQuotation::model()->UpdateDueDate($model->lb_record_primary_key);
                                $model->save();
                           // }
                        }
                        return true;
		}
	
		return false;
	}
}
