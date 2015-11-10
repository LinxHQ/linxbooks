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
        	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
        
	public function accessRules()
	{
		return array(
                        array('allow',
                            'actions'=>array(
                                    'index','PrintPdfPV','deletePVExpenses',
                                     'admin','create','view','delete','update',
                                     'ajaxSearchExpenses','error','createPaymentVoucher','ListEx','viewPaymentVoucher','ExpensesNewCustomer',
//                                     'ajaxDropDownContact',
//                                     'upload',
//                                     'dashboard',
//                                     'renew',
//                                     'ajaxFormPayment',
                                     'AssignCustomer','AssignInvoice',
                                'createExPv','createBlankTax',
                                     'deleteDocument','deletePaymentVoucher',
                                     'uploadDocument',
                                'savePaymentVoucher','AjaxLoadViewPV',
//                                     'ajaxUpdateStatusContract',
//                                     'createInvoice',
                                'ViewPV','createNewExPv',
                                     'ajaxUpdateField',
                                     'deleteCustomerExpenses',
                                     'deleteInvoiceExpenses',
                                     'loadAjaxTabInvoice',
                                     'loadAjaxTabCustomer','expenses','paymentVoucher','SearchExpenses'
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
		$customerExpenses = LbExpensesCustomer::model()->getCustomerExpenses($id);
                $invoiceExpenses = LbExpensesInvoice::model()->getExpensesInvoice($id);
            
		LBApplication::render($this,'view',array(
			'model'=>$this->loadModel($id),
                        'customerExpenses'=>$customerExpenses,
                        'invoiceExpenses'=>$invoiceExpenses,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new LbExpenses;
                $model->attributes;
                $idPV = false;
                if(isset($_REQUEST['idPV']))
                    $idPV = $_REQUEST['idPV'];
//                $documentModel = new LbDocument();
                $customerModel = new LbExpensesCustomer();
                $invoiceModel = new LbExpensesInvoice();
                $bankaccountModel = new LbBankAccount();
                $bankaccounts = $bankaccountModel->getBankAccount(Yii::app()->user->id);
                
                if (isset($_POST['LbExpenses']) && floatval($_POST['LbExpenses']['lb_expenses_amount']) != 0)
                {
                        $LbExpenses = $_POST['LbExpenses'];
                       
                        $model->attributes = $LbExpenses;
                        $model->lb_expenses_date = date('Y-m-d', strtotime($_POST['LbExpenses']['lb_expenses_date']));
                        if ($model->save())
                        {
                            LbExpenses::model()->setExpensesNextNum(LbExpenses::model()->getExpensesNextNum());
                            //********** Upload document *************//
                            $documents = CUploadedFile::getInstancesByName('documents');
                            // proceed if the images have been set
                            $i=0;
                            if (isset($documents) && count($documents) > 0) {
                                // go through each uploaded image
                                foreach ($documents as $document => $doc) {
                                    $i++;
                                    // tach filename va duoi
                                    $temp = explode('.', $doc->name);
                                    $duoi='.'.$temp[count($temp)-1];
                                    $lendduoi = strlen($temp[count($temp)-1])+1;
                                    $filename = substr( $doc->name,0,strlen($doc->name)-$lendduoi);
                                    $encoded_filename = str_replace(' ', '_', $filename).'_expenses'.$model->lb_record_primary_key.'_'.$i.$duoi;

                                    if ($doc->saveAs(Yii::getPathOfAlias('webroot').'/uploads/'.$encoded_filename)) {
                                        // add it to the main model now
                                        $documentModel = new LbDocument;
                                        $documentModel->lb_document_parent_type = LbDocument::LB_DOCUMENT_PARENT_TYPE_EXPENSES;
                                        $documentModel->lb_document_parent_id = $model->lb_record_primary_key;
                                        $documentModel->lb_document_url = "/uploads/".$encoded_filename; //it might be $img_add->name for you, filename is just what I chose to call it in my model
                                        $documentModel->lb_document_name = $doc->name; // this links your picture model to the main model (like your user, or profile model)
                                        $documentModel->lb_document_encoded_name = $encoded_filename;
                                        $documentModel->save(); // DONE
                                    }
                                }
                            }
                            // *** End upload document *** //
                            
                            // ********* Add cusotmer **********//
                            if(isset($_POST["LbExpensesCustomer"]) )
{ 
                            $LbExpensesCustomer = $_POST['LbExpensesCustomer'];
                            if (isset($LbExpensesCustomer['lb_customer_id']) && is_array($LbExpensesCustomer['lb_customer_id']) && count($LbExpensesCustomer['lb_customer_id']) > 0)
                            {
                                foreach ($LbExpensesCustomer['lb_customer_id'] as $customer) {
                                    if ($customer > 0) {
                                        $expensesCustomer = new LbExpensesCustomer();
                                        $expensesCustomer->lb_expenses_id = $model->lb_record_primary_key;
                                        $expensesCustomer->lb_customer_id = $customer;
                                        $expensesCustomer->save();
                                    }
                                }
                            }
}
                            // *** End add customer *** //
                            
                            // ********* Choose invoice **********//
                           if(isset($_POST["LbExpensesInvoice"]) )
                            { 
                            $LbExpensesInvoice = $_POST['LbExpensesInvoice'];
                            if (isset($LbExpensesInvoice['lb_invoice_id']) && is_array($LbExpensesInvoice['lb_invoice_id']) && count($LbExpensesInvoice['lb_invoice_id']) > 0)
                            {
                                foreach ($LbExpensesInvoice['lb_invoice_id'] as $invoice) {
                                    if ($invoice > 0) {
                                        $expensesInvoice = new LbExpensesInvoice();
                                        $expensesInvoice->lb_expenses_id = $model->lb_record_primary_key;
                                        $expensesInvoice->lb_invoice_id = $invoice;
                                        $expensesInvoice->save();
                                    }
                                }
                            }
                            }
                          
                            //Insert Tax
                         
                            if(isset($_POST["LbExpensesTax"]) ){
                                $LbExpensesTax= $_POST['LbExpensesTax'];
                                  
                                if (isset($LbExpensesTax['lb_tax_id']) && is_array($LbExpensesTax['lb_tax_id']) && count($LbExpensesTax['lb_tax_id']) > 0)
                                {
                                    foreach ($LbExpensesTax['lb_tax_id'] as $tax) {
                                        if ($tax > 0) {
                                            $expensesTax = new LbExpensesTax();
                                            $expensesTax->lb_expenses_id = $model->lb_record_primary_key;
                                            $expensesTax->lb_tax_id = $tax;
                                            $amount =$_POST['LbExpenses']['lb_expenses_amount'];
                                            
                                            $information_tax = LbTax::model()->findByPk($tax);
                                            $tax_value=$information_tax['lb_tax_value'];
                                            $expensesTax->lb_expenses_tax_total = ($amount*$tax_value)/100;
                                            
                                            $expensesTax->save();
                                            
                                           
                                        }
                                    }
                                }
                            }
                          

                            // *** End add invoice *** //
                            
                            //add ex in payment voucher
                            if($idPV)
                            {
                                $PvExpenses = new LbPvExpenses();
                                $PvExpenses->lb_expenses_id = $model->lb_record_primary_key;
                                $PvExpenses->lb_payment_voucher_id=$idPV;


                                $PvExpenses->insert();
                            }
//                            echo '<pre>';
//                            print_r($_POST["LbExpensesTax"]);
                          
                            $this->redirect(array('view','id'=>$model->lb_record_primary_key));
                          return;
                        }
                }
//                if(isset($_REQUEST['type']))
//                {
//                    $this->render('create',array(
//			'model'=>$model,
//                        'customerModel'=>$customerModel,
//                        'invoiceModel'=>$invoiceModel,
//                        'bankaccounts'=>$bankaccounts,
//                    ));
//                    return;
//                }
		$this->render('create',array(
			'model'=>$model,
                        'customerModel'=>$customerModel,
                        'invoiceModel'=>$invoiceModel,
                        'bankaccounts'=>$bankaccounts,
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

//		if(isset($_POST['LbExpenses']))
//		{
//			$model->attributes=$_POST['LbExpenses'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->lb_record_primary_key));
//		}

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
                $modelPV = new LbPaymentVoucher();
                 $model=$this->loadModel($id);
		if($this->loadModel($id)->delete())
                {
                    $document = LbDocument::model()->getDocumentParentType(LbDocument::LB_DOCUMENT_PARENT_TYPE_EXPENSES, $id);
                    if (count($document) > 0) {
                        foreach ($document as $dataDocument) {
                            $itemDocument = LbDocument::model()->findByPk($dataDocument->lb_record_primary_key);
                            $itemDocument->delete();
                        }
                    }
                    $expenses_customer = LbExpensesCustomer::model()->getCustomerExpenses($id);
                    if (count($expenses_customer) > 0) {
                        foreach ($expenses_customer as $dataExpensesCustomer) {
                            $itemExpensesCustomer = LbExpensesCustomer::model()->findByPk($dataExpensesCustomer->lb_record_primary_key);
                            $itemExpensesCustomer->delete();
                        }
                    }
                    $expenses_invoice = LbExpensesInvoice::model()->getExpensesInvoice($id);
                    if (count($expenses_invoice) > 0) {
                        foreach ($expenses_invoice as $dataExpensesInvoice) {
                            $itemExpensesInvoice = LbExpensesInvoice::model()->findByPk($dataExpensesInvoice->lb_record_primary_key);
                            $itemExpensesInvoice->delete();
                        }
                    }
                    
                    
                    $expense_tax = LbExpensesTax::model()->getExpensesTax($id);
                    if (count($expense_tax) > 0) {
                        foreach ($expense_tax as $dataExpenseTax) {
                            $itemExpensesTax = LbExpensesTax::model()->findByPk($dataExpenseTax->lb_record_primary_key);
                            $itemExpensesTax->delete();
                        }
                    }
                }
                return false;
         
//            LBApplication::render($this,'admin',array(
//                                    'model'=>$model,
//                                    'modelPv'=>$modelPV
//                            ));
//               
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LbExpenses');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LbExpenses;
		$model->unsetAttributes();  // clear any default values
                $modelPV = new LbPaymentVoucher();
                if (isset($_GET['LbExpenses'])) {
                    $expensesFrm = $_GET['LbExpenses'];
                    $model->attributes = $expensesFrm;
                    if (isset($expensesFrm['lb_category_id']) && $expensesFrm['lb_category_id'] != '')
                        $model->lb_category_id = $expensesFrm['lb_category_id'];
                    if (isset($expensesFrm['from_date']) && $expensesFrm['from_date'] != '')
                        $model->from_date = date('Y-m-d', strtotime($expensesFrm['from_date']));
                    if (isset($expensesFrm['to_date']) && $expensesFrm['to_date'] != '')
                        $model->to_date = date('Y-m-d', strtotime($expensesFrm['to_date']));
                }

		LBApplication::render($this,'admin',array(
			'model'=>$model,
                        'modelPv'=>$modelPV
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbExpenses the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model= LbExpenses::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbExpenses $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-expenses-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        public function actionAjaxSearchExpenses()
        {
                $category = $_POST['lb_category_id'];
                $from_date = $_POST['from_date'];
                $to_date = $_POST['to_date'];
                
                $expenses = LbExpenses::model()->getExpenses($category);


		LBApplication::render($this,'admin',array(
			'model'=>$expenses,
		));
            
        }
        
        public function actionSearchExpenses()
        {
            $date_from = false;
            $date_to = false;
            $category_id=0;
            if(isset ($_POST['category_id']))
                    $category_id = $_POST['category_id'];
            if(isset($_POST['date_from']))
                $date_from = $_POST['date_from'];
            if(isset ($_POST['date_to']))
                $date_to = $_POST['date_to'];
            $model = new LbExpenses();
          
            LBApplication::renderPartial($this,'view_expenses',  array('model'=>$model,'category_id'=>$category_id,'date_from'=>$date_from,'date_to'=>$date_to));  
        }
        
        public function actionDeleteDocument($id)
        {
            $documentModel = LbDocument::model()->findByPk($id);
            $documentModel->delete();
        }
        
        public function actionUploadDocument($id)
        {
                Yii::import("ext.EAjaxUpload.qqFileUploader");

                $folder='uploads/';// folder for uploaded files
                $allowedExtensions = array("jpeg","jpg","gif","png","pdf","odt","docx","doc","dia");//array("jpg","jpeg","gif","exe","mov" and etc...
                $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
                $result = $uploader->handleUpload($folder, false);
                $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

                $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
                $fileName=$result['filename'];//GETTING FILE NAME
                
                 //tach filename va duoi
//                $temp = explode('.', $fileName);
//                $encoded_filename = str_replace(' ', '_', $filename);
//                $duoi='.'.$temp[count($temp)-1];
//                $lendduoi = strlen($temp[count($temp)-1])+1;
//                $filename = substr( $pic->name,0,strlen($pic->name)-$lendduoi);
                
                $documentModel = new LbDocument;
                $documentModel->lb_document_parent_type = LbDocument::LB_DOCUMENT_PARENT_TYPE_EXPENSES;
                $documentModel->lb_document_parent_id = $id;
                $documentModel->lb_document_url = "/uploads/".$fileName; 
                $documentModel->lb_document_name = $fileName; // this links your picture model to the main model (like your user, or profile model)
                $documentModel->lb_document_encoded_name = $fileName;
                $documentModel->save(); // DONE
                return $return;// it's array
        }
        
        public function ActionAjaxUpdateStatusContract($id,$status_update)
        {
            $model = LbContracts::model()->findByPk($id);
            $model->lb_contract_status = $status_update;
            $model->save();
        }
        
        public function actionDeleteCustomerExpenses()
        {
            $error = array();
            $customer_id = $_POST['customer_id'];
            $expenses_id = $_POST['expenses_id'];
            
            if (isset($_POST['customer_id']) && isset($_POST['expenses_id'])) {
                $customerExpenses = LbExpensesCustomer::model()->getCustomerExpenses($expenses_id, $customer_id);
                if (count($customerExpenses) > 0) {
                    foreach ($customerExpenses as $cus) {
                        $customerEx = LbExpensesCustomer::model()->findByPk($cus->lb_record_primary_key);
                        $customerEx->delete();
                    } 
                }
            }
        }
        
        public function actionDeleteInvoiceExpenses()
        {
            $error = array();
            $invoice_id = $_POST['invoice_id'];
            $expenses_id = $_POST['expenses_id'];
            
            if (isset($_POST['invoice_id']) && isset($_POST['expenses_id'])) {
                $invoiceExpenses = LbExpensesInvoice::model()->getExpensesInvoice($expenses_id, $invoice_id);
                if (count($invoiceExpenses) > 0) {
                    foreach ($invoiceExpenses as $inv) {
                        $invoiceEx = LbExpensesInvoice::model()->findByPk($inv->lb_record_primary_key);
                        $invoiceEx->delete();
                    } 
                }
            }
        }
        
        function ActionLoadAjaxTabCustomer($id)
        {
                $customerExpenses = LbExpensesCustomer::model()->getCustomerExpenses($id);
            
                LBApplication::renderPartial($this, '_expenses_customer', array(
                                'expenses_customer'=>$customerExpenses,
                                'expenses_id'=>$id,
                            ));
        }
        
        function ActionLoadAjaxTabInvoice($id)
        {
                $invoiceExpenses = LbExpensesInvoice::model()->getExpensesInvoice($id);
            
                LBApplication::renderPartial($this, '_expenses_invoice', array(
                                'expenses_invoice'=>$invoiceExpenses,
                                'expenses_id'=>$id,
                            ));
        }
        
        //Payment Voucher
        function actionCreatePaymentVoucher()
        {
           $model = new LbExpenses();
           $modelPV = new LbPaymentVoucher();
           $id = 0;
           
           if(isset($_REQUEST['id']))
           {
//               $model = new LbExpenses();
               $id=$_REQUEST['id'];
//               $modelPV = LbPaymentVoucher::model()->findByPk($_REQUEST['id']);
           }
            LBApplication::render($this,'create_payment_voucher',array(
			'model'=>$model,
                        'modelPv'=>$modelPV,
                        'id'=>$id
		));
        }
        
        function actionListEx()
        {
            $model = new LbExpenses();
            LBApplication::render($this,'listExpenses.php',array(
			'model'=>$model,
                      
		));
        }
        public function actionsavePaymentVoucher()
        {
            $model = new LbPaymentVoucher();
            $pv_no=false;
            $pv_title=false;
            $pv_date=false;
            $pv_description=false;
            if($_POST['pv_no'])
                $pv_no = $_POST['pv_no'];
            $issetPv = LbPaymentVoucher::model()->find('lb_payment_voucher_no = "'.$pv_no.'"');
//            if(count($issetPv) > 0)
//            {
//                $response = array();
//                $response['success'] = NO;
//                
//                
//                LBApplication::renderPlain($this, array('content'=>  CJSON::encode($response)));
//                return;
//            }
            if($_POST['pv_title'])
                $pv_title = $_POST['pv_title'];
            if($_POST['pv_date'])
            {
               $pv_date = $_POST['pv_date'];
            }
            if($_POST['pv_description'])
                $pv_description = $_POST['pv_description'];
            $idPv = false;
            if(isset($_REQUEST['idPv']))
                $idPv = $_REQUEST['idPv'];
            
            //company
            
            $id = $model->savePaymentVoucher($pv_no,$pv_title,$pv_date,$pv_description,$idPv);
            
            $count = count($_POST['iem_ex_arr']);
            
            $expenses_item = $_POST['iem_ex_arr'];
            for($i = 0;$i<$count ; $i++)
            {
                if($expenses_item[$i] > 0)
                {
                    $PvExpenses = new LbPvExpenses();
                    
                    $PvExpenses->lb_expenses_id = $expenses_item[$i];
                    $PvExpenses->lb_payment_voucher_id=$id;
                    if(LbPvExpenses::model()->getExpensesPV($expenses_item[$i],$id) == false)        
                        $PvExpenses->insert();
                }
                    
            }
            if($id)
                
            {
                $response = array();
                $response['success'] = YES;
                $response['id'] = $id;
                LBApplication::renderPlain($this, array('content'=>  CJSON::encode($response)));
            }
            
        }
        function actionViewPV()
        {
            $model=new LbExpenses;
		$model->unsetAttributes();  // clear any default values
                $modelPV = new LbPaymentVoucher();
                if (isset($_GET['LbExpenses'])) {
                    $expensesFrm = $_GET['LbExpenses'];
                    $model->attributes = $expensesFrm;
                    if (isset($expensesFrm['lb_category_id']) && $expensesFrm['lb_category_id'] != '')
                        $model->lb_category_id = $expensesFrm['lb_category_id'];
                    if (isset($expensesFrm['from_date']) && $expensesFrm['from_date'] != '')
                        $model->from_date = date('Y-m-d', strtotime($expensesFrm['from_date']));
                    if (isset($expensesFrm['to_date']) && $expensesFrm['to_date'] != '')
                        $model->to_date = date('Y-m-d', strtotime($expensesFrm['to_date']));
                }

		$this->render($this,'admin',array(
			'model'=>$model,
                        'modelPv'=>$modelPV
		));
           
        }
        
        
        public function actionAjaxLoadViewPV()
        {
            $date_from = false;
            $date_to = false;
            if(isset($_POST['date_from']))
                $date_from = $_POST['date_from'];
            if(isset ($_POST['date_to']))
                    $date_to = $_POST['date_to'];
            $model = new LbPaymentVoucher();
          
            LBApplication::renderPartial($this,'_form_view_payment_voucher',  array('model'=>$model,'date_from'=>$date_from,'date_to'=>$date_to));
        }
          
        public function actiondeletePaymentVoucher($id)
        {
            LbPaymentVoucher::model()->deleteByPk($id);
        }
        
   
        
        //print PDF
        public function actionPrintPdfPV()
        {
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            
            $model = new LbPayment();
            
            $html2pdf->WriteHTML($this->renderPartial('pdf', array(),true));
//            $html2pdf->WriteHTML($this->renderPartial('_pdf_footer', array(), true));
            $html2pdf->Output('invoice.pdf','I');
            
        }
        
        //delete payment voucher expenses
        function actiondeletePVExpenses($id)
        {
            
            return LbPvExpenses::model()->deleteByPk($id);
        }
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
        
        public function actionexpenses()
        {
            $model=new LbExpenses();
            $modelPV=new LbPaymentVoucher();
            LBApplication::render($this,'view_expenses',array(
                                    'model'=>$model,
                                    'modelPv'=>$modelPV
                            ));
        }
        public function actionpaymentVoucher()
        {
            $model=new LbExpenses();
            $modelPV=new LbPaymentVoucher();
            LBApplication::render($this,'view_payment_voucher',array(
                                    'model'=>$model,
                                    'modelPv'=>$modelPV
                            ));
        }
         public function actionExpensesNewCustomer(){ 
         //   $model = $this->loadModel($id);
            $expenses_id = isset($_REQUEST['expenses_id']) ? $_REQUEST['expenses_id'] : 0;
        //    $submission_type = isset($_GET['form_type']) ? $_GET['form_type'] : 'default';
            $expensesModel = LbExpenses::model()->findByPk($expenses_id);
            $customerModel = new LbCustomer();
            $addressModel = new LbCustomerAddress();
            $contactModel = new LbCustomerContact();
            $own = false;
            if(isset($_POST['LbCustomer'])){
                $customerModel->attributes = $_POST['LbCustomer'];
            //    $customerModel->lb_customer_is_own_company = 0;
                if($customerModel->save()){
                 //   if($submission_type == 'ajax'){
                        if(isset($expenses_id) && $expenses_id >0){
                             $expenses_customer = new LbExpensesCustomer();
                            $expenses_customer->lb_expenses_id = $expenses_id;
                            $expenses_customer->lb_customer_id = $customerModel->lb_record_primary_key;
                            $expenses_customer->save();
                            
                            LBApplication::renderPlain($this, array('content'=>CJSON::encode($expenses_customer)));
                        }
                        if(isset($_POST['LbCustomerAddress']))
				{
					$addressModel->attributes=$_POST['LbCustomerAddress'];
					$addressModel->lb_customer_id = $customerModel->lb_record_primary_key;
					$addressModel->save();
				}
				
				// save contact if any
				if(isset($_POST['LbCustomerContact']))
				{
					$contactModel->attributes=$_POST['LbCustomerContact'];
					$contactModel->lb_customer_id = $customerModel->lb_record_primary_key;
					if ($contactModel->save())
					{
						// automatically assign this contact to submitted address
						$contactAddressModel = new LbCustomerAddressContact();
						$contactAddressModel->lb_customer_address_id = $addressModel->lb_record_primary_key;
						$contactAddressModel->lb_customer_contact_id = $contactModel->lb_record_primary_key;
						$contactAddressModel->save();
					}
				}
                        
                }
            }
       
            LBApplication::render($this, 'addCustomer', array(
                'expensesModel'=>$expensesModel,
                'own'=>$own,
                'customerModel'=>$customerModel,
                'addressModel'=>$addressModel,
                'contactModel'=>$contactModel,
            ));
        }
        public function actionAssignCustomer(){
            $expenses_id = isset($_REQUEST['expenses_id']) ? $_REQUEST['expenses_id'] : 0;
             $expensesModel = LbExpenses::model()->findByPk($expenses_id); 
            $customerModel = new LbCustomer('search');  
            $customerModel->unsetAttributes();
            if(isset($_GET['LbCustomer'])){
                $customerModel->attributes = $_GET['LbCustomer'];
            }           
                $customer_id = Yii::app()->request->getParam('customer_id');
                if(isset($customer_id) && is_array($customer_id) && count($customer_id) > 0){
                    foreach($customer_id as  $customer){
                        if($customer > 0){
                            if(isset($expenses_id) && $expenses_id > 0){
                            $expensesCustomer = new LbExpensesCustomer();
                            $expensesCustomer->lb_expenses_id = $expenses_id;
                            $expensesCustomer->lb_customer_id = $customer;
                            $expensesCustomer->save();
                            }
                        }
                    }
                }

                LBApplication::render($this, '_assign_customer', array(
                    'customerModel'=>$customerModel,
                    'expensesModel'=>$expensesModel,
                ));
            
        }
        public function actionAssignInvoice(){
            $expenses_id = isset($_REQUEST['expenses_id']) ? $_REQUEST['expenses_id'] : 0;
            $expensesModel = LbExpenses::model()->findByPk($expenses_id);
            $invoiceModel = new LbInvoice('search');
            $invoiceModel->unsetAttributes();
            if(isset($_GET['LbInvoice'])){
                $invoiceModel->attributes = $_GET['LbInvoice'];
            }
            $invoice_id = Yii::app()->request->getParam('invoice_id');
            if(isset($invoice_id) && is_array($invoice_id) && count($invoice_id) > 0){
                foreach ($invoice_id as $invoice) {
                    if($invoice > 0){
                        if(isset($expenses_id) && $expenses_id > 0){
                            $expensesInvoice = new LbExpensesInvoice();
                            $expensesInvoice->lb_expenses_id = $expenses_id;
                            $expensesInvoice->lb_invoice_id = $invoice;
                            $expensesInvoice->save();
                        }
                    }
                }
            }
            LBApplication::render($this, '_assign_invoice', array(
                'invoiceModel'=>$invoiceModel,
                'expensesModel'=>$expensesModel,
            ));
        }
}


