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
                                'actions'=>array('cronInvoiceUpdateStatus'),
                                'users'=>array('*'),
                            ),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','ajaxGetTax','ajaxGetTotals',
                    'chooseItemTemplate',
                ),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','ajaxUpdateField',
                    'ajaxQuickCreateCustomer','ajaxgetAmount',
                    'ajaxQuickCreateAddress',
                    'ajaxQuickCreateContact',
					'ajaxUpdateCustomer','createBlankItem','createBlankDiscount','createBlankTax',
                    'ajaxUpdateLineItems','CreatePaymentPo',
                    'ajaxUpdateDiscounts',
                    'ajaxUpdateTaxes','ajaxgetNote','AjaxSavePaymentInvoice',
                    'createTax',
                    'ajaxConfirmInvoice',
                    'saveItemAsTemplate','ajaxDeletePayment',
                    'PDF',
                    'SenEmail',
                    'AjaxSendEmailInvoice',
                    'MoveInvoice',
                    'PublicPDF',
                    'AjaxSendEmailInvoiceSharePDF',
                    'ajaxUpdateStatus',
                    'dashboard',
                    'UploadLogo',
                    'admin',
                    'ajaxUpdateStatus',
                    'ajaxUpdateNexIDField',
                    'ajaxUpdateDefaultNoteField','ajaxgetMethod',
                    'ajaxUpdateFieldTax',
                    'ajaxUpdateFieldGenera',
                    'ajaxCopyInvoice','view_chart_expenditures','_form_oustanding_invoice'
                     ,'_form_oustanding_quotation','chart','_search_invoice','_search_quotation','ajaxgetDate'
                                    ),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				//'actions'=>array('admin','delete','ajaxDeleteItem'),
                                'actions'=>array('delete','ajaxDeleteItem'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
/*	public function actionView($id=false,$invoice_no=false)
	{
            if(isset($_REQUEST['invoice_no']))
            {
                $model=  LbInvoice::model()->find('lb_invoice_no="'.$invoice_no.'"');
                if(count($model) > 0)
                {
                    $id = $model->lb_record_primary_key;
                    
                    $url = ($model->customer) ?$model->getViewURL($model->customer->lb_customer_name)
                            :$model->getViewURL("No customer");
                    $this->redirect($url);
                }
                else
                    return;
            }
           
                if(isset($_REQUEST['id']) && $_REQUEST['id']>0)
                $id = $_REQUEST['id'];
            
            
            $model = $this->loadModel($id);
            $invoiceItemModel=new LbInvoiceItem('search');
            $invoiceItemModel->unsetAttributes();  // clear any default values
            $invoiceItemModel->lb_invoice_id = $model->lb_record_primary_key;

            // invoice discounts
            $invoiceDiscountModel = new LbInvoiceItem('search');
            $invoiceDiscountModel->unsetAttributes();  // clear any default values
            $invoiceDiscountModel->lb_invoice_id = $model->lb_record_primary_key;

            // invoice taxes
            $invoiceTaxModel = new LbInvoiceItem('search');
            $invoiceTaxModel->unsetAttributes();  // clear any default values
            $invoiceTaxModel->lb_invoice_id = $model->lb_record_primary_key;

        // invoiceTotal
        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($id);

		LBApplication::render($this,'view',array(
			'model'=>$model,
			'invoiceItemModel'=>$invoiceItemModel,
            'invoiceDiscountModel'=>$invoiceDiscountModel,
            'invoiceTaxModel'=>$invoiceTaxModel,
            'invoiceTotal'=>$invoiceTotal,
			//'ownCompany'=>$ownCompany,
			//'ownCompanyAddress'=>$ownCompanyAddress,
			//'customerCompany'=>$customerCompany,
		));
    
	}
        
      

        /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
/*	public function actionCreate()
	{
		// are we creating invoice or quotation?
		if (isset($_GET['group']) 
				&& $_GET['group'] == strtolower(LbInvoiceGeneric::LB_INVOICE_GROUP_INVOICE))
		{
			$model=new LbInvoice;
		} else {
			$model = new LbQuotation();
		}
		
		// get basic info to assign to this record
		$ownCompany = LbCustomer::model()->getOwnCompany();
		$ownCompanyAddress = null;
		$customerCompany = new LbCustomer;
		$customerCompany->lb_customer_name = 'Click to choose customer';
		
		// get own company address
		if ($ownCompany->lb_record_primary_key)
		{
			// auto assign owner company
			$model->lb_invoice_company_id = $ownCompany->lb_record_primary_key;
			
			$own_company_addresses = LbCustomerAddress::model()->getActiveAddresses($ownCompany->lb_record_primary_key,
					$ownCompany::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
			
			if (count($own_company_addresses))
			{
				$ownCompanyAddress= $own_company_addresses[0];
				// auto assign owner company's address
				$model->lb_invoice_company_address_id = $ownCompanyAddress->lb_record_primary_key;
			}
		}
		
		// add invoice to database right away.
		// other fields will be updated on the invoice page later on
		$model->saveUnconfirmed();
		
		//
		// == Prepare line items grid
		// add 1 line-item by default
		// 
		$blankItem = new LbInvoiceItem();
		$blankItem->addBlankItem($model->lb_record_primary_key);
		$blankTax = new LbInvoiceItem();
        $blankTax->addBlankTax($model->lb_record_primary_key);

		$invoiceItemModel=new LbInvoiceItem('search');
		$invoiceItemModel->unsetAttributes();  // clear any default values
		$invoiceItemModel->lb_invoice_id = $model->lb_record_primary_key;

        // totals - create a blank total record, set everything to zero: subtotal, after disc, after tax, paid, outstanding....
        $invoiceTotal = new LbInvoiceTotal;
        $invoiceTotal->createBlankTotal($model->lb_record_primary_key);

		// == end items grid data prep
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        $invoiceDiscountModel = new LbInvoiceItem();
        $invoiceDiscountModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_DISCOUNT;
        $invoiceTaxModel = new LbInvoiceItem();
        $invoiceTaxModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX;

		if(isset($_POST['LbInvoice']))
		{
			$model->attributes=$_POST['LbInvoice'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->lb_record_primary_key));
		}

        $this->redirect(array('view','id'=>$model->lb_record_primary_key));

        /**
		LBApplication::render($this,'create',array(
			//'save_unconfirmed'=>$save_unconfirmed,
			'model'=>$model,
			'invoiceItemModel'=>$invoiceItemModel,
            'invoiceDiscountModel'=>$invoiceDiscountModel,
            'invoiceTaxModel'=>$invoiceTaxModel,
            'invoiceTotal'=>$invoiceTotal,
		));**/

        /**
        LBApplication::render($this,'view',array(
            'model'=>$model,
            'invoiceItemModel'=>$invoiceItemModel,
            'invoiceDiscountModel'=>$invoiceDiscountModel,
            'invoiceTaxModel'=>$invoiceTaxModel,
            'invoiceTotal'=>$invoiceTotal,
        ));**/
	//}
	
        public function actionView($id=false,$invoice_no=false,$expenses_id=false)
	{
            $expenses_id = isset($_REQUEST['expenses_id']) ? ($_REQUEST['expenses_id']) :0;
            if(isset($_REQUEST['invoice_no']))
            {
                $model=  LbInvoice::model()->find('lb_invoice_no="'.$invoice_no.'"');
                if(count($model) > 0)
                {
                    $id = $model->lb_record_primary_key;
                    
                    $url = ($model->customer) ?$model->getViewURL($model->customer->lb_customer_name)
                            :$model->getViewURL("No customer");
                    $this->redirect($url);
                }
                else
                    return;
            }
           
                if(isset($_REQUEST['id']) && $_REQUEST['id']>0)
                $id = $_REQUEST['id'];
            
            
            $model = $this->loadModel($id);
            $invoiceItemModel=new LbInvoiceItem('search');
            $invoiceItemModel->unsetAttributes();  // clear any default values
            $invoiceItemModel->lb_invoice_id = $model->lb_record_primary_key;

            // invoice discounts
            $invoiceDiscountModel = new LbInvoiceItem('search');
            $invoiceDiscountModel->unsetAttributes();  // clear any default values
            $invoiceDiscountModel->lb_invoice_id = $model->lb_record_primary_key;

            // invoice taxes
            $invoiceTaxModel = new LbInvoiceItem('search');
            $invoiceTaxModel->unsetAttributes();  // clear any default values
            $invoiceTaxModel->lb_invoice_id = $model->lb_record_primary_key;

        // invoiceTotal
        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($id);

		LBApplication::render($this,'view',array(
			'model'=>$model,
			'invoiceItemModel'=>$invoiceItemModel,
            'invoiceDiscountModel'=>$invoiceDiscountModel,
            'invoiceTaxModel'=>$invoiceTaxModel,
            'invoiceTotal'=>$invoiceTotal,
            'expenses_id'=>$expenses_id,
			//'ownCompany'=>$ownCompany,
			//'ownCompanyAddress'=>$ownCompanyAddress,
			//'customerCompany'=>$customerCompany,
		));
    
	}
        
      

        /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                $expenses_id = isset($_GET['expenses_id']) ? $_GET['expenses_id'] :0;
            //     $expensesModel = LbExpenses::model()->findByPk($expenses_id);
		// are we creating invoice or quotation?
		if (isset($_GET['group']) && $_GET['group'] == strtolower(LbInvoiceGeneric::LB_INVOICE_GROUP_INVOICE))
		{
			$model=new LbInvoice;
		} else {
			$model = new LbQuotation();
		}
		
		// get basic info to assign to this record
		$ownCompany = LbCustomer::model()->getOwnCompany();
		$ownCompanyAddress = null;
		$customerCompany = new LbCustomer;
		$customerCompany->lb_customer_name = 'Click to choose customer';
		
		// get own company address
		if ($ownCompany->lb_record_primary_key)
		{
			// auto assign owner company
			$model->lb_invoice_company_id = $ownCompany->lb_record_primary_key;
			
			$own_company_addresses = LbCustomerAddress::model()->getActiveAddresses($ownCompany->lb_record_primary_key,
					$ownCompany::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
			
			if (count($own_company_addresses))
			{
				$ownCompanyAddress= $own_company_addresses[0];
				// auto assign owner company's address
				$model->lb_invoice_company_address_id = $ownCompanyAddress->lb_record_primary_key;
			}
		}
		
		// add invoice to database right away.
		// other fields will be updated on the invoice page later on
		$model->saveUnconfirmed();
		
		//
		// == Prepare line items grid
		// add 1 line-item by default
		// 
		$blankItem = new LbInvoiceItem();
		$blankItem->addBlankItem($model->lb_record_primary_key);
		$blankTax = new LbInvoiceItem();
        $blankTax->addBlankTax($model->lb_record_primary_key);

		$invoiceItemModel=new LbInvoiceItem('search');
		$invoiceItemModel->unsetAttributes();  // clear any default values
		$invoiceItemModel->lb_invoice_id = $model->lb_record_primary_key;

        // totals - create a blank total record, set everything to zero: subtotal, after disc, after tax, paid, outstanding....
        $invoiceTotal = new LbInvoiceTotal;
        $invoiceTotal->createBlankTotal($model->lb_record_primary_key);

		// == end items grid data prep
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        $invoiceDiscountModel = new LbInvoiceItem();
        $invoiceDiscountModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_DISCOUNT;
        $invoiceTaxModel = new LbInvoiceItem();
        $invoiceTaxModel->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX;

		if(isset($_POST['LbInvoice']))
		{
			$model->attributes=$_POST['LbInvoice'];
			if($model->save()){
                            $this->redirect(array('view','id'=>$model->lb_record_primary_key));
                        }
				
		}
    if(isset($expenses_id) & $expenses_id > 0){
        $this->redirect(array('view','id'=>$model->lb_record_primary_key,'expenses_id'=>$expenses_id));
    }  else {
        $this->redirect(array('view','id'=>$model->lb_record_primary_key));
    }
        
    /*   LBApplication::render($this,'view',array(
            'model'=>$model,
            'invoiceItemModel'=>$invoiceItemModel,
            'invoiceDiscountModel'=>$invoiceDiscountModel,
            'invoiceTaxModel'=>$invoiceTaxModel,
            'invoiceTotal'=>$invoiceTotal,
            'id'=>$model->lb_record_primary_key,
            'expenses_id'=>$expenses_id,
        ));*/
        /**
		LBApplication::render($this,'create',array(
			//'save_unconfirmed'=>$save_unconfirmed,
			'model'=>$model,
			'invoiceItemModel'=>$invoiceItemModel,
            'invoiceDiscountModel'=>$invoiceDiscountModel,
            'invoiceTaxModel'=>$invoiceTaxModel,
            'invoiceTotal'=>$invoiceTotal,
		));**/
/*
        if (isset($expenses_id)){
            LBApplication::render($this,'view',array(
            'model'=>$model,
            'expenses_id'=>$expenses_id,
            'invoiceItemModel'=>$invoiceItemModel,
            'invoiceDiscountModel'=>$invoiceDiscountModel,
            'invoiceTaxModel'=>$invoiceTaxModel,
            'invoiceTotal'=>$invoiceTotal,
            ));
        }else{
        LBApplication::render($this,'view',array(
            'model'=>$model,
            'invoiceItemModel'=>$invoiceItemModel,
            'invoiceDiscountModel'=>$invoiceDiscountModel,
            'invoiceTaxModel'=>$invoiceTaxModel,
            'invoiceTotal'=>$invoiceTotal,
        ));
        }*/
        }
	/**
	 * Create a new blank item for this invoice
	 * Usually called when user add a new line on the GUI
	 * 
	 * @param unknown $id invoice id
	 */
	public function actionCreateBlankItem($id)
	{
		$invoiceItem = new LbInvoiceItem();
		$result = $invoiceItem->addBlankItem($id);
		if ($result)
		{
			$response = array();
			$response['success'] = YES;
			$response['invoice_item_id'] = $invoiceItem->lb_record_primary_key;
			
			LBApplication::renderPlain($this, array(
				'content'=>CJSON::encode($response)
			));
		}
	}
        

    /**
     * Create a new blank discount for this invoice
     * Usually called when user add a new line on the GUI
     * This will serve as a form
     *
     * @param unknown $id invoice id
     */
    public function actionCreateBlankDiscount($id)
    {
        $invoiceItem = new LbInvoiceItem();
        $result = $invoiceItem->addBlankDiscount($id);
        if ($result)
        {
            $response = array();
            $response['success'] = YES;
            $response['invoice_item_id'] = $invoiceItem->lb_record_primary_key;

            LBApplication::renderPlain($this, array(
                'content'=>CJSON::encode($response)
            ));
        }
    }

    /**
     * Create a new blank tax for this invoice
     * Usually called when user add a new line on the GUI
     * This will serve as a form
     *
     * @param unknown $id invoice id
     */
    public function actionCreateBlankTax($id)
    {
        $invoiceItem = new LbInvoiceItem();
        $result = $invoiceItem->addBlankTax($id);
        if ($result)
        {
            $response = array();
            $response['success'] = YES;
            $response['invoice_item_id'] = $invoiceItem->lb_record_primary_key;

            LBApplication::renderPlain($this, array(
                'content'=>CJSON::encode($response)
            ));
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

		if(isset($_POST['LbInvoice']))
		{
			$model->attributes=$_POST['LbInvoice'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->lb_record_primary_key));
		}

		LBApplication::render($this,'update',array(
			'model'=>$model,
		));
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
	 * , but also continue to auto assign address to this invoice.
	 */
	public function actionAjaxUpdateCustomer()
	{
		// call ajaxUpdateField to update customer id
		if($this->actionAjaxUpdateField())
		{
			// updated invoice_customer_id successfully
			// now find this customer address and auto assign
			// the first billing address we found
			// or if no billing address found, just assign first address
			$invoice_id = $_POST['pk'];
			$invoice = LbInvoice::model()->findByPk($invoice_id);
			
			if ($invoice)
			{
				// reset address just in case some address of previous customer is already there
				$invoice->lb_invoice_customer_address_id = 0;
                $invoice->lb_invoice_attention_contact_id = 0;
				$invoice->save();
                                $address_array['customer']=$invoice->lb_invoice_customer_id;
                                if($invoice->lb_invoice_customer_id > 0)
                                {

                                    $custoemr_name = str_replace( ' ', '-',$invoice->customer->lb_customer_name);
                                    $address_array['customer_name']=$custoemr_name;
                                }

                // auto assign one of the addresses of this customer to this invoice
				$addresses = LbCustomerAddress::model()->getAddresses($invoice->lb_invoice_customer_id,
						LbCustomerAddress::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
				$firstAddress = null;
				
				// only proceed if found any address
				if (count($addresses))
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
					}
						
					// assign address to invoice
					$invoice->lb_invoice_customer_address_id = $firstAddress->lb_record_primary_key;
					if ($invoice->save())
					{
						// return that address in json
						// we need to format it nicely.
						$address_array = $firstAddress->formatAddressLines();
						$address_array['customer']=$invoice->lb_invoice_customer_id;
                                                if($invoice->lb_invoice_customer_id > 0)
                                                {

                                                    $custoemr_name = str_replace( ' ', '-',$invoice->customer->lb_customer_name);
                                                    $address_array['customer_name']=$custoemr_name;
                                                }
						// print json
						
					} // end formatting address to return in json
				}// end if found addresses
			}
			LBApplication::renderPartial($this, '//layouts/plain_ajax_content', array(
							'content'=>CJSON::encode($address_array),
						));
						return true;
		}
	
		return false;
	}
	
	/**
	 * update line items
	 * 
	 * @param int $id invoice id
	 */
	public function actionAjaxUpdateLineItems($id)
	{
		// Get all invoice items
		$invoice_items = LbInvoiceItem::model()->getInvoiceItems($id, 
				LbInvoiceItem::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
		
		// foreach invoice item
		// get post values, then update it
		foreach ($invoice_items as $item)
		{
			$item_id = $item->lb_record_primary_key;
			
			// get POSTed values
            if (isset($_POST['lb_invoice_item_description_'.$item_id]))
            {
                $item_description = $_POST['lb_invoice_item_description_'.$item_id];
                $item->lb_invoice_item_description=$item_description;
            }
            if (isset($_POST['lb_invoice_item_quantity_'.$item_id]))
            {
                $item_quantity = $_POST['lb_invoice_item_quantity_'.$item_id];
                $item->lb_invoice_item_quantity = $item_quantity;
            }
            if (isset($_POST['lb_invoice_item_value_'.$item_id]))
            {
                $item_value = $_POST['lb_invoice_item_value_'.$item_id];
                $item->lb_invoice_item_value = $item_value;
            }
			
			// save
            $item->save();
		}

        // return totals
        $invoiceTotals = LbInvoiceTotal::model()->getInvoiceTotal($id);
        LBApplication::renderPlain($this, array('content'=>CJSON::encode($invoiceTotals)));
	}

    /**
     * update discounts
     *
     * @param int $id invoice id
     */
    public function actionAjaxUpdateDiscounts($id)
    {
        // Get all invoice discounts
        $invoice_discounts = LbInvoiceItem::model()->getInvoiceDiscounts($id,
            LbInvoiceItem::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

        // foreach invoice discount
        // get post description and total (not value), then update it
        foreach ($invoice_discounts as $discount)
        {
            $item_id = $discount->lb_record_primary_key;

            // get POSTed values
            if (isset($_POST['lb_invoice_item_description_'.$item_id]))
            {
                $discount_description = $_POST['lb_invoice_item_description_'.$item_id];
                $discount->lb_invoice_item_description=$discount_description;
            }
            if (isset($_POST['lb_invoice_item_total_'.$item_id]))
            {
                $discount_total = $_POST['lb_invoice_item_total_'.$item_id];
                $discount->lb_invoice_item_value = $discount_total; // total will be recalculated at model's save
            }

            // save
            $discount->lb_invoice_item_quantity = 1; // always 1

            $discount->save();
        }

        // return totals
        $invoiceTotals = LbInvoiceTotal::model()->getInvoiceTotal($id);
        LBApplication::renderPlain($this, array('content'=>CJSON::encode($invoiceTotals)));
    }

    /**
     * update taxes
     *
     * @param int $id invoice id
     */
    public function actionAjaxUpdateTaxes($id)
    {
        // Get all invoice discounts
        $invoice_taxes = LbInvoiceItem::model()->getInvoiceTaxes($id,
            LbInvoiceItem::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

        // foreach invoice tax
        // get post description and value, then update it
        foreach ($invoice_taxes as $tax)
        {
            $item_id = $tax->lb_record_primary_key;

            // get POSTed values
            if (isset($_POST['lb_invoice_item_description_'.$item_id]))
            {
                // IMPORTANT: for tax item, description is the tax record id from lb_taxes table
                $tax_description = $_POST['lb_invoice_item_description_'.$item_id];
                $tax->lb_invoice_item_description=$tax_description;
            }
            //echo $tax_description;

            if (isset($_POST['lb_invoice_item_value_'.$item_id]))
            {
                $tax_value_percent = $_POST['lb_invoice_item_value_'.$item_id];
                $tax->lb_invoice_item_value = $tax_value_percent;
            }

            // save
            $tax->lb_invoice_item_quantity = 1; // always 1
            $tax->save();
        }

        // return totals
        $invoiceTotals = LbInvoiceTotal::model()->getInvoiceTotal($id);
        LBApplication::renderPlain($this, array('content'=>CJSON::encode($invoiceTotals)));
    }

    /**
     * get value of a single tax item (e.g. return should be 7, 10, 8.5...)
     *
     * @param $id
     */
    public function actionAjaxGetTax($id)
    {
        // only proceed if tax id and line item primary key available
        if (isset($_POST['tax_id']))
        {
            if($_POST['tax_id']!=0)
            {
                // get tax record, so that we can determine the value
                $taxRecord = LbTax::model()->findByPk($_POST['tax_id']);
            }
            else
            {
                $taxRecord['lb_tax_value']=0;
            }
            if ($taxRecord)
            {
                LBApplication::renderPlain($this, array('content'=>CJSON::encode($taxRecord)));
            }
                
        }
    }

    /**
     * Add a new tax item to the list of all available taxes for this subscription
     */
    public function actionCreateTax()
    {
        $model = new LbTax();
        $submission_type = isset($_GET['form_type']) ? $_GET['form_type'] : 'default';
        $invoice_id = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : 0;

        $invoiceModel = LbInvoice::model()->findByPk($invoice_id);

        if (isset($_POST['LbTax']))
        {
            $model->attributes=$_POST['LbTax'];
            
            $lbtax_arr = $_POST['LbTax'];
            if(!LbTax::model()->IsNameTax($lbtax_arr['lb_tax_name']))
            {
                $error['error'] = "Tax Name Exist.";
                return LBApplication::renderPlain($this, array('content'=>CJSON::encode($error)));

            }
            if($model->save())
            {
                if ($submission_type == 'ajax')
                {
                    if (isset($_GET['invoice_id']) && $_GET['invoice_id'] > 0)
                    {
                        // auto add this tax item into this invoice
                        $invoiceItem = new LbInvoiceItem();
                        $invoiceItem->addTaxToInvoice($_GET['invoice_id'], $model);

                        // print json result of this invoice item
                        LBApplication::renderPlain($this, array('content'=>CJSON::encode($invoiceItem)));
                    }
                    return true;
                } else {
                    $this->redirect(array('viewTax','id'=>$model->lb_record_primary_key));
                }
            }
        }

        $submission_details = array();
        $submission_details["type"] = $submission_type;

        LBApplication::render($this, '_form_tax', array(
            'model'=>$model,
            'invoiceModel'=>$invoiceModel,
            'submission_details'=>$submission_details,
        ));
    }

    /**
     * Get all totals of invoice
     *
     * @param $id invoice id
     */
    public function actionAjaxGetTotals($id)
    {
        $invoiceTotals = LbInvoiceTotal::model()->getInvoiceTotal($id);
        if ($invoiceTotals)
        {
            LBApplication::renderPlain($this, array('content'=>CJSON::encode($invoiceTotals)));
        }
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
                if(isset($_GET['ajax']) && $_GET['ajax'] == 'lb-quotation-Outstanding-grid')
                {
                     $model = LbQuotation::model()->findByPk($id);
                     $error = array();
                    if($model->lb_quotation_status == LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT)
                    {   
                        $model->delete();

                        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                        if(!isset($_GET['ajax']))
                                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('dashboard'));
                    }
                    else
                    {
                        $error['error']="The quotation may be allowed to remove the I_DRAFT status";
                        LBApplication::renderPlain($this, array('content'=>CJSON::encode($error)));
                    }
                }
                else {
                    $model = LbInvoice::model()->findByPk($id);
                    $error = array();
                    if($model->lb_invoice_status_code == LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT)
                    {   
                        $this->loadModel($id)->delete();

                        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                        if(!isset($_GET['ajax']))
                                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('dashboard'));
                    }
                    else
                    {
                        $error['error']="The invoice may be allowed to remove the I_DRAFT status";
                        LBApplication::renderPlain($this, array('content'=>CJSON::encode($error)));
                    }
                }
	}

    /**
     * Delete item from invoice: line, discount, tax
     *
     * @param $id ITEM ID (NOT invoice id)
     */
    public function actionAjaxDeleteItem($id)
    {
        $invoiceItem = LbInvoiceItem::model()->findByPk($id);
        $invoiceItem->delete();
    }

    /**
     * Confirm an invoice
     * Assign a unique invoice number to it
     *
     * @param $id
     */
/*    public function actionAjaxConfirmInvoice($id)
    {
        $model = $this->loadModel($id);

        $model->confirm();
        $result = array();
        $result['lb_invoice_status_code']=  LbInvoice::model()->getDisplayInvoiceStatus($model->lb_invoice_status_code);
        $result['lb_invoice_no'] = $model->lb_invoice_no;
        $result['lb_record_primary_key']= $id;
        LBApplication::renderPlain($this, array('content'=>CJSON::encode($result)));
    }*/
    public function actionAjaxConfirmInvoice($id,$expenses_id=false)
    {

            $expenses_id = isset($_GET['expenses_id']) ? $_GET['expenses_id'] : 0; 
            $model = $this->loadModel($id);
            if($model->confirm()){
                if(isset($expenses_id) && $expenses_id > 0){
                    $expenses_invoice = new LbExpensesInvoice;
                    $expenses_invoice->lb_expenses_id = $expenses_id;
                    $expenses_invoice->lb_invoice_id = $id;
                    $expenses_invoice->save();
                }
            };
            $result = array();
            $result['lb_invoice_status_code']=  LbInvoice::model()->getDisplayInvoiceStatus($model->lb_invoice_status_code);
            $result['lb_invoice_no'] = $model->lb_invoice_no;
            $result['lb_record_primary_key']= $id;
            LBApplication::renderPlain($this, array('content'=>CJSON::encode($result)));
      //  }
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LbInvoice');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LbInvoice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LbInvoice']))
			$model->attributes=$_GET['LbInvoice'];
                if(isset($_GET['status_id']))
                    $model->lb_invoice_status_code = $_GET['status_id'];

		LBApplication::render($this, 'admin',array(
			'model'=>$model,
                        'status_id'=>$model->lb_invoice_status_code,
		));
	}
        
    /**
     * Quick create customer from a modal form
     * over invoice main page
     *
     * @param $id   invoice id
     * @return bool
     */
    public function actionAjaxQuickCreateCustomer($id)
    {
        $customerModel = new LbCustomer;
        $model = $this->loadModel($id);

        if (isset($_POST['LbCustomer']))
        {
            // save customer data
            $customerModel->attributes = $_POST['LbCustomer'];
            if ($customerModel->save())
            {
                // assign this customer to this invoice
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
     * @param string $id   invoice id
     * @return bool
     * @throws CHttpException if customer is not selected.
     */
    public function actionAjaxQuickCreateAddress($id)
    {
        $model = $this->loadModel($id);
        $customerModel = LbCustomer::model()->findByPk($model->lb_invoice_customer_id);
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
                // assign this address to this invoice
                $model->lb_invoice_customer_address_id = $customerAddress->lb_record_primary_key;
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

    /**
     * Quick create contact from a modal form
     * over invoice main page
     *
     * @param $id   invoice id
     * @return bool
     * @throws ChttpException if customer is not selected
     */
    public function actionAjaxQuickCreateContact($id)
    {
        $model = $this->loadModel($id);
        $customerModel = LbCustomer::model()->findByPk($model->lb_invoice_customer_id);
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
                // assign this contact to this invoice
                $model->lb_invoice_attention_contact_id = $customerContact->lb_record_primary_key;
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

    /**
     * Choose item template from list of templates
     *
     * @param $id invoice id
     */
    public function actionChooseItemTemplate($id)
    {
        $model = $this->loadModel($id);
        $invoiceItem = LbInvoiceItem::model()->findByPk($_GET['item_id']);

        $invoiceItemTemplate = new LbInvoiceItemTemplate('search');
        $invoiceItemTemplate->unsetAttributes();  // clear any default values
        if(isset($_GET['LbInvoiceItemTemplate']))
            $invoiceItemTemplate->attributes=$_GET['LbInvoiceItemTemplate'];

        LBApplication::render($this,'_item_templates',array(
            'model'=>$model,
            'invoiceItem'=>$invoiceItem,
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

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbInvoice the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LbInvoice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbInvoice $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-invoice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        public function actionPDF($id,$email=false)
        {
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
           
            $model = LbInvoice::model()->findByPk($id);
            //$html2pdf->AddFont(13);
            $html2pdf->WriteHTML($this->renderPartial('pdf', array('model'=>$model),true));
            $html2pdf->WriteHTML($this->renderPartial('_pdf_footer', array(), true));
//            $html2pdf->SetHtmlFooter(false);
            if($email)
                return $html2pdf->Output('',true);
            else {
                $html2pdf->Output($model->lb_invoice_no.'.pdf','I');
            }
        }
        public function actionSenEmail($id)
       {
            $model = LbInvoice::model()->findByPk($id);
            LBApplication::render($this, '_form_email', array(
                'model'=>$model
            ));
        }
        public function actionAjaxSendEmailInvoice($id)
        {
             $email_to = $_POST['email_to'];
             $email_to_arr = explode(",", $email_to);
             $model = LbInvoice::model()->findByPk($id);
             $message = new YiiMailMessage();
             $message->subject= $_POST['email_subject'];
             $message->setBody($_POST['email_content'], 'text/html');
             foreach ($email_to_arr as $value) {
                $message->addTo($value);
             }
             //$message->addTo('thongnv@lionsoftwaresolutions.com');
             $message->from = $_POST['email_from'];
             $swiftAttachment = Swift_Attachment::newInstance($this->actionPDF($id,true),$model->lb_invoice_no.'.pdf','application/pdf');
             $message->attach($swiftAttachment);
             //$message->AddAttachment(Yii::app()->createAbsoluteUrl('lbInvoice/default/pdf/',array('id'=>$id)));
             echo Yii::app()->mail->send($message);  
        }
        
        public function actionGetPublicPDF($p)
        {
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $model = LbInvoice::model()->find('lb_invoice_encode="'.$p.'"');
            $html2pdf->WriteHTML($this->renderPartial('pdf', array('model'=>$model),true));  
            
            $html2pdf->Output('invoice.pdf',false);
        }
        public function actionPublicPDF($p){
            //$this->render($this,'_form_public_pdf', array('p'=>$p));
            LBApplication::render($this, '_form_public_pdf', array('p'=>$p));
            //echo Yii::app()->createAbsoluteUrl("/index.php/p/");
        }
        
        function actionAjaxSendEmailInvoiceSharePDF($p){
             
             $email_body = $_POST['email_content']."<br><br><a href='".Yii::app()->createAbsoluteUrl("LbInvoice/p/".$p)."'>".Yii::app()->createAbsoluteUrl("/p/".$p)."</a>";
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
        
	/**
	 * Display info dasdboard.
	 */
	public function actionDashboard()
	{
		$model=new LbInvoice('search');
		$model->unsetAttributes();  // clear any default values
                $invoiceModel = new LbQuotation();
		if(isset($_GET['LbInvoice']))
                {
			$model->attributes=$_GET['LbInvoice'];
                }

		LBApplication::render($this, 'dashboard',array(
			'model'=>$model,
                        'quotationModel'=>$invoiceModel,
		));
	}
        
        public function actionAjaxUpdateStatus($id,$status)
        {
            $model = LbInvoice::model()->findByPk($id);
            $model->lb_invoice_status_code=$status;
            
  
            if($model->save())
            {
                $result = array();
                $result['lb_invoice_status_code']=  LbInvoice::model()->getDisplayInvoiceStatus($status);
                $result['lb_record_primary_key']=$id;
                LBApplication::renderPlain($this, array('content'=>  CJSON::encode($result)));
            }
        }
        
	public function actionAjaxUpdateNexIDField()
	{
		if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = LbNextId::model()->findByPk($id);
			// update
			$model->$attribute = $value;
			return $model->save();
		}
	
		return false;
	}
        
	public function actionAjaxUpdateDefaultNoteField()
	{
		if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = LbDefaultNote::model()->findByPk($id);
			// update
			$model->$attribute = $value;
			return $model->save();
		}
	
		return false;
	}
        
        public function actionAjaxUpdateFieldTax()
        {
		if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = LbTax::model()->findByPk($id);
			// update
			$model->$attribute = $value;
                        $model -> save();
			return true;
		}
	
		return false;
        }
        
        public function actionAjaxUpdateFieldGenera()
        {
		if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = LbGenera::model()->findByPk($id);
			// update
			$model->$attribute = $value;
                        $model -> save();
			return true;
		}
	
		return false;
        }
        
        public function actionAjaxCopyInvoice($id)
        {
            //Add thong tin quotation
            $inv_new = new LbInvoice();
            $invoice = LbInvoice::model()->findByPk($id);

            $inv_new->lb_invoice_no = LbInvoice::model()->formatInvoiceNextNumFormatted(0);
            $inv_new->lb_invoice_date = date('Y-m-d');
            $inv_new->lb_invoice_due_date = date('Y-m-d');
            $inv_new->lb_invoice_status_code = LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT;
            $inv_new->lb_invoice_company_id = $invoice->lb_invoice_company_id;
            $inv_new->lb_invoice_company_address_id = $invoice->lb_invoice_company_address_id;
            $inv_new->lb_invoice_customer_id = $invoice->lb_invoice_customer_id;
            $inv_new->lb_invoice_customer_address_id = $invoice->lb_invoice_customer_address_id;
            $inv_new->lb_invoice_attention_contact_id = $invoice->lb_invoice_attention_contact_id;
            $inv_new->lb_invoice_internal_note = $invoice->lb_invoice_internal_note;
            $inv_new->lb_invoice_subject = $invoice->lb_invoice_subject;
            $inv_new->lb_invoice_note = $invoice->lb_invoice_note;
            $inv_new->lb_invoice_encode = LbInvoice::model()->setBase64_decodeInvoice();
            if($inv_new->save())
            {
                // Add thong tin tax
                $invoice_tax_arr = LbInvoiceItem::model()->getInvoiceTaxes($invoice->lb_record_primary_key);
                foreach ($invoice_tax_arr->data as $tax_item) {
                    $inv_tax_new = new LbInvoiceItem();

                    $inv_tax_new->lb_invoice_id = $inv_new->lb_record_primary_key;
                    $inv_tax_new->lb_invoice_item_description = $tax_item->lb_invoice_item_description;
                    $inv_tax_new->lb_invoice_item_quantity = $tax_item->lb_invoice_item_quantity;
                    $inv_tax_new->lb_invoice_item_value = $tax_item->lb_invoice_item_value;
                    $inv_tax_new->lb_invoice_item_total = $tax_item->lb_invoice_item_total;
                    $inv_tax_new->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_TAX;
                    $inv_tax_new->save();
                }//END

                //Add thong tin discount
                $invoice_discount_arr = LbInvoiceItem::model()->getInvoiceDiscounts($invoice->lb_record_primary_key);
                foreach ($invoice_discount_arr->data as $discount_item) {
                    $inv_discount_new = new LbInvoiceItem();

                    $inv_discount_new->lb_invoice_id = $inv_new->lb_record_primary_key;
                    $inv_discount_new->lb_invoice_item_description = 'Discount';
                    $inv_discount_new->lb_invoice_item_quantity = $discount_item->lb_invoice_item_quantity;
                    $inv_discount_new->lb_invoice_item_value = $discount_item->lb_invoice_item_value;
                    $inv_discount_new->lb_invoice_item_total = $discount_item->lb_invoice_item_total;
                    $inv_discount_new->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_DISCOUNT;
                    $inv_discount_new->save();
                }//END

                //Add Thong tin total
                $invoice_total= LbInvoiceTotal::model()->getInvoiceTotal($invoice->lb_record_primary_key);
                $inv_total_new = new LbInvoiceTotal();

                $inv_total_new->lb_invoice_id = $inv_new->lb_record_primary_key;
                $inv_total_new->lb_invoice_revision_id= $invoice_total->lb_invoice_revision_id;
                $inv_total_new->lb_invoice_subtotal=$invoice_total->lb_invoice_subtotal;
                $inv_total_new->lb_invoice_total_after_discounts = $invoice_total->lb_invoice_total_after_discounts;
                $inv_total_new->lb_invoice_total_after_taxes = $invoice_total->lb_invoice_total_after_taxes;
                $inv_total_new->lb_invoice_total_outstanding = $invoice_total->lb_invoice_total_outstanding;
                $inv_total_new->lb_invoice_total_paid = $invoice_total->lb_invoice_total_paid;
                $inv_total_new->save();

                //Add thong tin item
                $invoice_item_arr = LbInvoiceItem::model()->getInvoiceItems($invoice->lb_record_primary_key);
                foreach ($invoice_item_arr->data as $item) {
                    $inv_item_new = new LbInvoiceItem();

                    $inv_item_new->lb_invoice_id = $inv_new->lb_record_primary_key;
                    $inv_item_new->lb_invoice_item_description = $item->lb_invoice_item_description;
                    $inv_item_new->lb_invoice_item_quantity = $item->lb_invoice_item_quantity;
                    $inv_item_new->lb_invoice_item_value = $item->lb_invoice_item_value;
                    $inv_item_new->lb_invoice_item_total = $item->lb_invoice_item_total;
                    $inv_item_new->lb_invoice_item_type = LbInvoiceItem::LB_INVOICE_ITEM_TYPE_LINE;
                    $inv_item_new->save();
                }//END
                
                $customer_name = ($inv_new->customer) ? $inv_new->customer->lb_customer_name : "No customer";
                $url = LbInvoice::model()->getViewURLByIdNormalized($inv_new->lb_record_primary_key, $customer_name);
                echo '{"status":"success","url":"'.$url.'"}';
            }        

        }
        public function actionview_chart_expenditures()
        {
            $year = $_POST['year'];
            LBApplication::renderPartial($this, 'view_chart_expenditures',array(
			'year'=>$year,
                       
		));
        }
        public function action_form_oustanding_invoice()
        {
            $model=new LbInvoice('search');
            $model->unsetAttributes();  // clear any default values
            $invoiceModel = new LbQuotation();
      
            LBApplication::renderPartial($this, '_form_oustanding_invoice',array(
			'model'=>$model,
                       
		));
        }
        
        public function action_form_oustanding_quotation()
        {
            $model=new LbInvoice('search');
            $model->unsetAttributes();  // clear any default values
            $invoiceModel = new LbQuotation();
      
            LBApplication::renderPartial($this, '_form_oustanding_quotation',array(
			'model'=>$model,'quotationModel'=>$invoiceModel,
                       
		));
        }
        public function actionChart()
        {
            $model=new LbInvoice('search');
            $model->unsetAttributes();  // clear any default values
            $invoiceModel = new LbQuotation();
      
            LBApplication::renderPartial($this, 'chart',array(
			'model'=>$model,'quotationModel'=>$invoiceModel,
                       
		));
        }
        
        public function action_search_invoice()
        {
            $name = $_GET['name'];
             LBApplication::renderPartial($this, '_search_invoice',array(
			'name'=>$name,
                       
		));
        }
        
        public function action_search_quotation()
        {
             $name = $_GET['name'];
             LBApplication::renderPartial($this, '_search_quotation',array(
			'name'=>$name,
                        
		));
        }
        
        //add payment invoice
        public function actionCreatePaymentPo($id)
	{
		$invoiceItem = new LbInvoiceItem();
		$result = $invoiceItem->addBlankItem($id);
		if ($result)
		{
			$response = array();
			$response['success'] = YES;
			$response['invoice_item_id'] = $invoiceItem->lb_record_primary_key;
			
			LBApplication::renderPlain($this, array(
				'content'=>CJSON::encode($response)
			));
		}
	}
        
        public function actionajaxgetMethod(){
         // only proceed if tax id and line item primary key available
            $model = LbPayment::model()->findByPk($_POST['line_item_pk']);
            if (isset($_POST['method_id']))
            {
                
                  $taxRecord['value']= $model->lb_payment_method = $_POST['method_id'];
                    if($model->save())
                        LBApplication::renderPlain($this, array('content'=>CJSON::encode($taxRecord)));
              
            }
        }
        
        public function actionajaxgetAmount()
        {
            $model = LbPaymentItem::model()->find('lb_payment_id = '.$_POST['line_item_pk']);
            
            $invoice_id=0;
            if($_POST['invoice_id']);{
                $invoice_id = $_POST['invoice_id'];
                $invoiceManage = LbInvoice::model()->findByPk($invoice_id);
            }
            
            if (isset($_POST['method_id']))
            {
                
                  $taxRecord['value']= $model->lb_payment_item_amount = $_POST['method_id'];
                  //tinh paid
                   
                    if($model->save())
                    {
                        $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($invoice_id);
                        $taxRecord['paid']=$invoiceTotal->calculateInvoicetotalPaid($invoice_id);
                        $taxRecord['outstanding']=$invoiceTotal->calculateInvoiceTotalOutstanding();
                        if($invoiceTotal->calculateInvoiceTotalOutstanding() <= 0)
                        {
                            //update status invoice
                            
                            $invoiceManage->lb_invoice_status_code=LbInvoice::LB_INVOICE_STATUS_CODE_PAID;
                            $invoiceManage->save();
                            $taxRecord['status']='I_PAID';
                        }
                        else
                        {
                            $invoiceManage->lb_invoice_status_code=LbInvoice::LB_INVOICE_STATUS_CODE_OPEN;
                            $invoiceManage->save();
                            $taxRecord['status']='Open';
                        }
                        LBApplication::renderPlain($this, array('content'=>CJSON::encode($taxRecord)));
                    }
              
            }
        }
        public function actionajaxgetNote()
        {
            $model = LbPaymentItem::model()->find('lb_payment_id = '.$_POST['line_item_pk']);
            if (isset($_POST['method_id']))
            {
                
                  $taxRecord['value']= $model->lb_payment_item_note = $_POST['method_id'];
                    if($model->save())
                        LBApplication::renderPlain($this, array('content'=>CJSON::encode($taxRecord)));
              
            }
        }
        public function actionajaxgetDate()
        {
            $model = LbPayment::model()->findByPk($_POST['line_item_pk']);
            if (isset($_POST['method_id']))
            {
                
                  $taxRecord['value']= $model->lb_payment_date = $_POST['method_id'];
                    if($model->save())
                        LBApplication::renderPlain($this, array('content'=>CJSON::encode($taxRecord)));
              
            }
        }
        
        function actionAjaxSavePaymentInvoice()
        {
            if(isset($_POST['id']))
            {
                $model_invoice = LbInvoice::model()->findByPk($_POST['id']);
                $customer = $model_invoice->lb_invoice_customer_id;
            }
            $model = new LbPayment();
           
            $model->lb_payment_no=LbPayment::model()->FormatPaymentNo(LbPayment::model()->getPaymentNextNum());
            $model->lb_payment_customer_id = $customer;
            $model->lb_payment_method=0;
            $model->lb_payment_date= date('Y-m-d');
            $model->lb_payment_total=0; 
            if($model->save())
            {
                    $paymentItemModel = new LbPaymentItem();
                    $paymentItemModel->lb_payment_id = $model->lb_record_primary_key;
                    $paymentItemModel->lb_invoice_id = $_POST['id'];
                   
                    $paymentItemModel->lb_payment_item_amount=0;
                    if($paymentItemModel->save()){
                                $response = array();
                                $response['success'] = YES;
                                $response['payment_no'] =  $model->lb_payment_no;
                                $response['lb_payment_id'] =  $model->lb_record_primary_key;

                                LBApplication::renderPlain($this, array(
                                        'content'=>CJSON::encode($response)
                                ));
                    }
                    else
                         echo '{"status":"fail"}';
                            
                        
                    
                }
                
            }
            
            function actionajaxDeletePayment(){
                if(isset($_GET['id']))
                    $payment_item_id = $_GET['id'];
                //delete payment item
                
                $payment = LbPaymentItem::model()->find('lb_payment_id = '.$payment_item_id);
                
                if($payment->delete())
                {
                    $invoice_id=$_GET['invoice_id'];
                    $invoiceManage = LbInvoice::model()->findByPk($invoice_id);
                    $invoiceTotal = LbInvoiceTotal::model()->getInvoiceTotal($invoice_id);
                    $taxRecord['paid']=$invoiceTotal->calculateInvoicetotalPaid($invoice_id);
                    $taxRecord['outstanding']=$invoiceTotal->calculateInvoiceTotalOutstanding();
                    if($invoiceTotal->calculateInvoiceTotalOutstanding() <= 0)
                    {
                        $taxRecord['status']='I_PAID';
                        
                        $invoiceManage->lb_invoice_status_code=LbInvoice::LB_INVOICE_STATUS_CODE_PAID;
                        $invoiceManage->save();
                    }
                    else
                    {
                        $taxRecord['status']='Open';
                        $invoiceManage->lb_invoice_status_code=LbInvoice::LB_INVOICE_STATUS_CODE_OPEN;
                        $invoiceManage->save();
                    }
                //update invoice total
                
//                if($payment->delete())
//                    echo 'success';
                LBApplication::renderPlain($this, array('content'=>CJSON::encode($taxRecord)));
                }
            }
        
}
