<?php

class DefaultController extends Controller
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
				'actions'=>array('index','ajaxUpdateFieldVD','dropdownJSONCategory','CreateTax','UpdateStatusVIWriteOff','ajaxUpdateField','AjaxConfirmVenDorInvoice','AjaxUpdateFieldInvoice','ajaxUpdateFieldSubject','ajaxUpdateNoteVI','deleteVDInvoice','ajaxUpdateCustomerVI','ajaxDeleteItemTaxs','AjaxUpdateTaxes','AddDiscountInvoice','InsertLineItem','Vendorpdf','UpdateStatusWriteOff','ajaxUpdateCustomer','deleteVendor','AjaxConfirmVenDor','ajaxDeleteItemDiscount','ajaxUpdateDiscounts','CreateBlankDiscount','AjaxDeleteTax','ajaxGetTotals','dashboard','AjaxGetTax','CreateBlankTax','AjaxDeleteItem','AjaxUpdateLineItems','InsertBlankItem'),
				'users'=>array('@'),
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
        
	public function actionDashboard()
	{
                LBApplication::render($this, 'dashboard',array());
	}
        
        public function actionajaxDeleteItemTaxs($id)
        {
            
            $vendorTax = LbVendorTax::model()->findByPk($id);
            
            $idVendorItemTotal = $vendorTax['lb_vendor_type'];
            if($idVendorItemTotal == LbVendorTax::LB_VENDOR_ITEM_TYPE_TAX)
            {
                $idVendor = $vendorTax['lb_vendor_id'];
                $type =LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL ;
                $type_discount = LbVendorDiscount::LB_VENDOR_ITEM_TYPE_DISCOUNT;
            }
            else
            {
                $idVendor = $vendorTax['lb_vendor_invoice_id'];
                $type=LbVendorTotal::LB_VENDOR_INVOICE_TOTAL;
                $type_discount = LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT;
            }
            $vendorTax->delete();
            LbVendorTotal::model()->totalAfterDiscount($idVendor,$type_discount,$type);
           
        }
        
        public function actionajaxDeleteItem($id)
        {
            $vendorTax = LbVendorItem::model()->findByPk($id);
            $idVendorItemTotal = $vendorTax['lb_vendor_type'];
            $totalItem = $vendorTax['lb_vendor_item_amount'];
            if($idVendorItemTotal == LbVendorItem::LB_VENDOR_ITEM_TYPE_LINE)
            {
                $idVendor = $vendorTax['lb_vendor_id'];
                $type =LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL ;
                $type_discount = LbVendorDiscount::LB_VENDOR_ITEM_TYPE_DISCOUNT;
            }
            else
            {
                $idVendor = $vendorTax['lb_vendor_invoice_id'];
                $type=LbVendorTotal::LB_VENDOR_INVOICE_TOTAL;
                $type_discount = LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT;
            }
            
               //update sub total
            
           $subtotal = LbVendorTotal::model()->getSubtotalById($type,$idVendor);
           $key = LbVendorTotal::model()->getIdVendorTotalByItem($idVendor,$type);
           $total = LbVendorTotal::model()->findByPk($key);
           $total->lb_vendor_subtotal = $total['lb_vendor_subtotal']-$totalItem;
           $total->update();
           LbVendorTotal::model()->totalAfterDiscount($idVendor,$type_discount,$type);
            $vendorTax->delete();
            
            
         
            
            
        }
        
        public function actionInsertBlankItem($id)
	{
         $vendorItem = new LbVendorItem();
	$result = $vendorItem->addLineItemVendor($id,LbVendorItem::LB_VENDOR_ITEM_TYPE_LINE);

		if ($result)
		{
                   
			$response = array();
			$response['success'] = YES;
			$response['vendor_item_id'] = $result;
			
			LBApplication::renderPlain($this, array(
				'content'=>CJSON::encode($response)
			));
		}
               
	}
        
        
        public function actionAjaxUpdateLineItems($id,$type)
	{
	
		$vendorItem = LbVendorItem::model()->getVendorItems($id, $type,
				LbVendorItem::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
                if($type == LbVendorItem::LB_VENDOR_INVOICE_ITEM_TYPE_LINE)
                {
                    $return_type = LbVendorTotal::LB_VENDOR_INVOICE_TOTAL;
                    $type_discount = LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT;
                }
                if($type == LbVendorItem::LB_VENDOR_ITEM_TYPE_LINE)
                {
                    $return_type = LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL;
                    $type_discount = LbVendorDiscount::LB_VENDOR_ITEM_TYPE_DISCOUNT;
                    
                }
                $subtotal = 0;
                
		
                foreach ($vendorItem as $item)
		{
                       
			$item_id = $item->lb_record_primary_key;
			$item_value = $item->lb_vendor_item_price;
                        $item_quantity = $item->lb_vendor_item_quantity;
                        $item_description = $item->lb_vendor_item_description;
			// get POSTed values
                       
                        
                        if (isset($_POST['lb_vendor_item_description'.$item_id]))
                        {
                            
                            $item_description = $_POST['lb_vendor_item_description'.$item_id];
                            $item->lb_vendor_item_description=$item_description;
                            
                           
                        }
                        if (isset($_POST['lb_vendor_item_quantity'.$item_id]))
                        {
                            $item_quantity = $_POST['lb_vendor_item_quantity'.$item_id];
                            $item->lb_vendor_item_quantity = $item_quantity;
                            
                        }
                        if (isset($_POST['lb_vendor_item_price'.$item_id]))
                        {
                            $item_value = $_POST['lb_vendor_item_price'.$item_id];
                            $item->lb_vendor_item_price = $item_value;
                            
                            
                        }
                        $item->lb_vendor_item_amount=$item_value*$item_quantity;
                        $subtotal = $subtotal + $item_value*$item_quantity;
                        
             
                                    // save
                        $item->update();
                       
		}
               
        $total = LbVendorTotal::model()->calculateInvoiceSubTotal($id,$type, $return_type);
        LbVendorTotal::model()->totalAfterDiscount($id,$type_discount,$return_type);
        $vendorTotal = LbVendorTotal::model()->getVendorTotal($id,$return_type);

        LBApplication::renderPlain($this, array('content'=>CJSON::encode($vendorTotal)));
	}
        
       
	
        public function actionCreateBlankTax($id,$type)
        {
            $vendorIax= new LbVendorTax();
            $result = $vendorIax->addLineTaxVendor($id,$type);
            
            if ($result)
            {
                
                $response = array();
                $response['success'] = YES;
                $response['invoice_item_id'] = $vendorIax->lb_record_primary_key;

                LBApplication::renderPlain($this, array(
                    'content'=>CJSON::encode($response)
                ));
            }
            
        }
        
      
        
        public function actionAjaxGetTax()
        {
            // only proceed if tax id and line item primary key available
            $type = false;
            if(isset($_GET['type']))
                $type = $_GET['type'];
            
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
                    LbVendorTax::model()->ajaxUpdateTaxes($taxRecord->lb_tax_name,$taxRecord->lb_tax_value,$_POST['line_item_pk'],$_POST['tax_id'],$_GET['id'],$type);
                    LBApplication::renderPlain($this, array('content'=>CJSON::encode($taxRecord)));
                }

            }
        }
        
        
        public function actionajaxGetTotals($id,$type = false)
        {
            if($type)
                    $invoiceTotals = LbVendorTotal::model()->getVendorTotal($id,  LbVendorTotal::LB_VENDOR_INVOICE_TOTAL);
            else
                    $invoiceTotals = LbVendorTotal::model()->getVendorTotal($id,  LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL);

            if ($invoiceTotals)
            {
                LBApplication::renderPlain($this, array('content'=>CJSON::encode($invoiceTotals)));
            }
        }
        
        public function actionCreateBlankDiscount($id,$type)
        {
            $vendorDiscount = new LbVendorDiscount();
            $result = $vendorDiscount->addBlankDiscount($id,$type);
            if ($result)
            {
                $response = array();
                $response['success'] = YES;
                $response['invoice_item_id'] = $vendorDiscount->lb_vendor_type;

                LBApplication::renderPlain($this, array(
                    'content'=>CJSON::encode($response)
                ));
            }
        }
        
        public function actionAjaxUpdateDiscounts($id,$type)
        {
            // Get all invoice discounts
            $vendor_discounts = LbVendorDiscount::model()->getVendorDiscounts($id,$type,
                LbVendorDiscount::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

            // foreach invoice discount
            // get post description and total (not value), then update it
            foreach ($vendor_discounts as $discount)
            {
                $item_id = $discount->lb_record_primary_key;

                // get POSTed values
                if (isset($_POST['lb_vendor_description'.$item_id]))
                {
                    $discount_description = $_POST['lb_vendor_description'.$item_id];
                    $discount->lb_vendor_description=$discount_description;
                }
                if (isset($_POST['lb_vendor_value'.$item_id]))
                {
                    $discount_total = $_POST['lb_vendor_value'.$item_id];
                    $discount->lb_vendor_value = $discount_total; // total will be recalculated at model's save
                }

                // save
//                $discount->lb_invoice_item_quantity = 1; // always 1

                $discount->update();
            }
           
            if($type == LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT)
                $return_type = LbVendorTotal::LB_VENDOR_INVOICE_TOTAL;
            if($type == LbVendorDiscount::LB_VENDOR_ITEM_TYPE_DISCOUNT)
                $return_type = LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL;
             LbVendorTotal::model()->totalAfterDiscount($id,$type,$return_type);
             
            // return totals
            $invoiceTotals = LbVendorTotal::model()->getVendorTotal($id,$return_type);
            LBApplication::renderPlain($this, array('content'=>CJSON::encode($invoiceTotals)));
        }
        
        
        public function actionajaxDeleteItemDiscount($id)
        {
            $vendorDiscount = LbVendorDiscount::model()->findByPk($id);
            $type = $vendorDiscount['lb_vendor_type'];
            
            if($type == LbVendorDiscount::LB_VENDOR_ITEM_TYPE_DISCOUNT)
            {
                $return_type = LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL;
                $record_id = $vendorDiscount['lb_vendor_id'];
            }
            else{
                $return_type = LbVendorTotal::LB_VENDOR_INVOICE_TOTAL;
                $record_id = $vendorDiscount['lb_vendor_invoice_id'];
            }
            
           $vendorDiscount->deleteByPk($id);
           LbVendorTotal::model()->totalAfterDiscount($record_id,$type,$return_type);
           
            
            
            
        }
        
        public function actionAjaxConfirmVenDor($id)
        {
            $model = $this->loadModel($id);

            $model->confirm();
            $result = array();
            $result['lb_vendor_status']= LbVendor::model()->getDisplayPOStatus($model->lb_vendor_status);
            $result['lb_vendor_no'] = $model->lb_vendor_no;
            $result['lb_record_primary_key']= $id;
            LBApplication::renderPlain($this, array('content'=>CJSON::encode($result)));
        }
        public function actionAjaxConfirmVenDorInvoice($id)
        {
            $model =  LbVendorInvoice::model()->findByPk($id);

            $model->confirm();
            $result = array();
            $result['lb_vd_invoice_status']= LbVendorInvoice::model()->getDisplayInvoiceStatus($model->lb_vd_invoice_status);
            $result['lb_vd_invoice_no'] = $model->lb_vd_invoice_no;
            $result['lb_record_primary_key']= $id;
            LBApplication::renderPlain($this, array('content'=>CJSON::encode($result)));
        }
        
        public function actionDeleteVendor($id)
	{
            $this->render('dashboard');
//             $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('dashboard'));
//            
//            $vendorDiscount = LbVendor::model()->findByPk($id);
//            
//            $vendorDiscount->delete();
//                $model = LbVendor::model()->findByPk($id);
//                $error = array();
//                if($model->lb_vendor_status == LbVendor::LB_PO_STATUS_CODE_DRAFT)
//                {   
//                    
//                    $this->loadModel($id)->delete();
//
//                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//                    if(!isset($_GET['ajax']))
//                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('Dashboard'));
//                    
//                }
//                else
//                {
//                    $error['error']="The invoice may be allowed to remove the I_DRAFT status";
//                    LBApplication::renderPlain($this, array('content'=>CJSON::encode($error)));
//                }
	}
        
        public function loadModel($id)
	{
		$model=LbVendor::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

        public function actionAjaxUpdateCustomer()
        {
            
		if($this->actionAjaxUpdateField())
		{
			
			$vendor_id = $_POST['pk'];
			$vendor = LbVendor::model()->findByPk($vendor_id);
			
			if ($vendor)
			{
				// reset address just in case some address of previous customer is already there
				$vendor->lb_vendor_supplier_address = 0;
                                $vendor->lb_vendor_supplier_attention_id = 0;
				$vendor->save();


                                // auto assign one of the addresses of this customer to this invoice
				$addresses = LbCustomerAddress::model()->getAddresses($vendor->lb_vendor_supplier_id,
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
					$vendor->lb_vendor_supplier_address = $firstAddress->lb_record_primary_key;
					if ($vendor->save())
					{
						// return that address in json
						// we need to format it nicely.
						$address_array = $firstAddress->formatAddressLines();
						
						// print json
						LBApplication::renderPartial($this, '//layouts/plain_ajax_content', array(
							'content'=>CJSON::encode($address_array),
						));
						return true;
					} // end formatting address to return in json
				}// end if found addresses
			}
			return true;
		}
	
		return false;
        }
        public function actionajaxUpdateCustomerVI()
        {
            
		if($this->actionAjaxUpdateFieldInvoice())
		{
			
			$vendor_id = $_POST['pk'];
			$vendor = LbVendorInvoice::model()->findByPk($vendor_id);
			
			if ($vendor)
			{
				// reset address just in case some address of previous customer is already there
				$vendor->lb_vd_invoice_supplier_id = $_POST['value'];
                                $vendor->lb_vd_invoice_supplier_attention_id = 0;
				$vendor->save();


                                // auto assign one of the addresses of this customer to this invoice
				$addresses = LbCustomerAddress::model()->getAddresses($vendor->lb_vd_invoice_supplier_id,
						LbCustomerAddress::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
				$firstAddress = null;
				
				// only proceed if found any address
				if (count($addresses))
				{
					// get first billing address
                                        // echo 
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
					$vendor->lb_vd_invoice_supplier_address_id = $firstAddress->lb_record_primary_key;
					if ($vendor->save())
					{
						// return that address in json
						// we need to format it nicely.
						$address_array = $firstAddress->formatAddressLines();
						
						// print json
						LBApplication::renderPartial($this, '//layouts/plain_ajax_content', array(
							'content'=>CJSON::encode($address_array),
						));
						return true;
					} // end formatting address to return in json
				}// end if found addresses
			}
			return true;
                }
                return false;
	
        }
        
        
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
        public function actionAjaxUpdateFieldInvoice()
	{
		if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = LbVendorInvoice::model()->findByPk($id);
			// update
			$model->$attribute = $value;
			return $model->save();
		}
	
		return false;
	}
        
        public function actionUpdateStatusWriteOff($id)
        {
            $model = $this->loadModel($id);
          
            $model->lb_vendor_status = LbVendor::LB_VENDOR_STATUS_CODE_WRITTEN_OFF;
            $model->save();
               
            $result = array();
            $result['lb_vendor_status']= LbVendor::model()->getDisplayPOStatus($model->lb_vendor_status);
            $result['lb_vendor_no'] = $model->lb_vendor_no;
            $result['lb_record_primary_key']= $id;
            LBApplication::renderPlain($this, array('content'=>CJSON::encode($result)));
        }
        public function actionUpdateStatusVIWriteOff($id)
        {
            $model=  LbVendorInvoice::model()->findByPk($id);
          
            $model->lb_vd_invoice_status = LbVendorInvoice::LB_VD_CODE_WRITTEN_OFF;
            $model->save();
               
            $result = array();
            $result['lb_vendor_status']= LbVendorInvoice::model()->getDisplayInvoiceStatus($model->lb_vd_invoice_status);
            $result['lb_vendor_no'] = $model->lb_vd_invoice_no;
            $result['lb_record_primary_key']= $id;
            LBApplication::renderPlain($this, array('content'=>CJSON::encode($result)));
        }
        
        public function actionVendorpdf($id)
        {
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $model = LbVendor::model()->findByPk($id);
            //$html2pdf->AddFont(13);
            $html2pdf->WriteHTML($this->renderPartial('vendor_pdf', array('model'=>$model),true));
            $html2pdf->WriteHTML($this->renderPartial('_pdf_footer', array(), true));
           
            $html2pdf->Output($model->lb_vendor_no.'.pdf','PO');
           
        }
        
         public function actionInsertLineItem($id)
       {
            $vendorItem = new LbVendorItem();
            $result = $vendorItem->addLineItemVendor($id,LbVendorItem::LB_VENDOR_INVOICE_ITEM_TYPE_LINE);

                    if ($result)
                    {

                            $response = array();
                            $response['success'] = YES;
                            $response['vendor_item_id'] = $result;

                            LBApplication::renderPlain($this, array(
                                    'content'=>CJSON::encode($response)
                            ));
                    }
               
       }
       
       public function actionAjaxUpdateTaxes($id,$type)
        {
        // Get all invoice discounts
        $invoice_taxes = LbVendorTax::model()->getTaxByVendor($id,$type,LbVendorTax::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);

        // foreach invoice tax
        // get post description and value, then update it
        foreach ($invoice_taxes as $tax)
        {
            $item_id = $tax->lb_record_primary_key;

            // get POSTed values
            if (isset($_POST['lb_tax_name'.$item_id]))
            {
                // IMPORTANT: for tax item, description is the tax record id from lb_taxes table
                $tax_description = $_POST['lb_tax_name'.$item_id];
                $tax->lb_tax_name=$tax_description;
            }
            //echo $tax_description;

            if (isset($_POST['lb_vendor_tax_value'.$item_id]))
            {
                $tax_value_percent = $_POST['lb_vendor_tax_value'.$item_id];
                $tax->lb_vendor_tax_value = $tax_value_percent;
            }

            // save
//            $tax->lb_invoice_item_quantity = 1; // always 1
            $tax->save();
        }

        // return totals
        if($type == LbVendorTax::LB_VENDOR_ITEM_TYPE_TAX)
            $invoiceTotals = LbVendorTotal::model()->getVendorTotal($id,  LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL);
        else
            $invoiceTotals = LbVendorTotal::model()->getVendorTotal($id,  LbVendorTotal::LB_VENDOR_INVOICE_TOTAL);
        
        LBApplication::renderPlain($this, array('content'=>CJSON::encode($invoiceTotals)));
    }
    
    public function actiondeleteVDInvoice($id)
    {
                $model = LbVendorInvoice::model()->findByPk($id);
                $error = array();
                
                if($model->lb_vd_invoice_status == LbVendorInvoice::LB_VD_STATUS_CODE_DRAFT)
                {   
                   
                    $model->deleteByPk($id);
                    $this->render('dashboard');

                }
                else
                {
                   
                    $error['error']="The invoice may be allowed to remove the I_DRAFT status";
                    LBApplication::renderPlain($this, array('content'=>CJSON::encode($error)));
                }
        
    }
    
    public function actionajaxUpdateNoteVI()
    {
        $id = $_POST['pk'];
        $model = LbVendorInvoice::model()->findByPk($id);
        $model->lb_vd_invoice_notes = $_POST['value'];
        return $model->save();
    }
    public function actionajaxUpdateFieldSubject()
    {
        $id = $_POST['pk'];
        $model = LbVendorInvoice::model()->findByPk($id);
        $model->lb_vd_invoice_subject = $_POST['value'];
        return $model->save();
    }
    
    public function actiondropdownJSONCategory($vendor_id=false,$vendor_invoice_id=false)
    {
        
        $vendor_id = isset($_GET['vendor_id']) ? $_GET['vendor_id'] : 0;
        $quotation_id = isset($_GET['vendor_invoice_id']) ? $_GET['vendor_invoice_id'] : 0;

        
        $category_arr = SystemList::model()->getItemsForListCode('expenses_category',  LbVendor::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);

        $category_arr = SystemList::model()->findAll('system_list_code = "expenses_category"');
        
        $ordered_results = array();
        $ordered_results[0] = array('value'=>'0','text'=>'Choose category')+$ordered_results;
        foreach ($category_arr as $value)
        {
           
            $ordered_results[] = array('value'=>$value['system_list_item_id'],'text'=>$value['system_list_item_name']);
        }

      

        LBApplication::renderPlain($this, array(
            'content'=>CJSON::encode($ordered_results),
        ));
    }
    public function actionAjaxUpdateFieldVD()
    {
        if($_POST['name'] = 'lb_vd_invoice_no')
        {
        $id = $_POST['pk'];
        $model = LbVendorInvoice::model()->findByPk($id);
        $model->lb_vd_invoice_no = $_POST['value'];
        }
        return $model->save();
    }
   
    
    
}