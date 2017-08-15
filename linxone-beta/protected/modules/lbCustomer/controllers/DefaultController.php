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
				'actions'=>array('index','view','dropdownJSON'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','ajaxUpdateField','createAddress','deleteAddress','loadAjaxTabAddress','loadAjaxTabContract','deleteContact','_search_customer'),
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
            if($id=="")
            {
                $this->redirect('create?own=1');
            }
		$model = $this->loadModel($id);
		$customer_addresses = LbCustomerAddress::model()->getAddresses($id, 
				LbCustomerAddress::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
		$customer_contacts = LbCustomerContact::model()->getContacts($id,
				LbCustomerContact::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
		
		LBApplication::render($this, 'view',array(
			'model'=>$model,
			'customer_addresses'=>$customer_addresses,
			'customer_contacts'=>$customer_contacts,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($own=false)
	{
		$model=new LbCustomer;
		$addressModel = new LbCustomerAddress();
		$contactModel = new LbCustomerContact();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LbCustomer']))
		{
			$model->attributes=$_POST['LbCustomer'];
			if($model->save())
			{
				// save address if any
				if(isset($_POST['LbCustomerAddress']))
				{
					$addressModel->attributes=$_POST['LbCustomerAddress'];
					$addressModel->lb_customer_id = $model->lb_record_primary_key;
					$addressModel->save();
				}
				
				// save contact if any
				if(isset($_POST['LbCustomerContact']))
				{
					$contactModel->attributes=$_POST['LbCustomerContact'];
					$contactModel->lb_customer_id = $model->lb_record_primary_key;
					if ($contactModel->save())
					{
						// automatically assign this contact to submitted address
						$contactAddressModel = new LbCustomerAddressContact();
						$contactAddressModel->lb_customer_address_id = $addressModel->lb_record_primary_key;
						$contactAddressModel->lb_customer_contact_id = $contactModel->lb_record_primary_key;
						$contactAddressModel->save();
					}
				}
				
				//$this->redirect(array('view','id'=>$model->lb_record_primary_key));
				$this->redirect($model->getViewURL($model->lb_customer_name));
			}
		}
                if($own)
                {
                    $this->renderPartial('create',array(
			'model'=>$model,
			'addressModel'=>$addressModel,
			'contactModel'=>$contactModel,
                        'own'=>$own,
                    ));
                }
                else
                {
                    LBApplication::render($this, 'create',array(
                            'model'=>$model,
                            'addressModel'=>$addressModel,
                            'contactModel'=>$contactModel,
                            'own'=>$own,
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
                $own=false;
		$model=$this->loadModel($id);
                $addressModel = new LbCustomerAddress();
		$contactModel = new LbCustomerContact();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LbCustomer']))
		{
			$model->attributes=$_POST['LbCustomer'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->lb_record_primary_key));
		}

		$this->render('update',array(
			'model'=>$model,
                    'addressModel'=>$addressModel,
			'contactModel'=>$contactModel,
                     'own'=>$own,
		));
                	
	}

//	/**
//	 * Deletes a particular model.
//	 * If deletion is successful, the browser will be redirected to the 'admin' page.
//	 * @param integer $id the ID of the model to be deleted
//	 */
	public function actionDelete($id)
	{
            $error = array();
		
                       
                    $constrac =   LbContracts::model()->countContractByCustomer($id) ;
                   
                    if(count($constrac) > 0)
                     {
                        throw new CHttpException(404,'This customer has other records in the system, therefore, cannot be deleted. Please contact the Administrator.');
                   
                    }  else {
                        $this->loadModel($id)->delete();
                    }
//                        
//              
//                
//		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
/**
 * 
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
//	public function actionDelete($id)
//	{
//            $error = array();
//		
//                      
//                    $constrac =   LbContracts::model()->getContractCustomer($id) ;
//                       $Expense = LbExpensesCustomer::model()->getExpensesCustomer($id) ;
//                  $Invoice = LbInvoice::model()-> getInvoiceCustomer($id) ;
//                  $Payment = LbPayment::model()-> getPaymentCustomer($id);
//                        if($constrac > 0 ||  $Expense>0 || $Invoice >0 || $Payment > 0)
//                        {
//      
//
//                    throw new CHttpException(404,'This customer has other records in the system, therefore, cannot be deleted. Please contact the Administrator.');
//                   
//                    }  else {
//                        $this->loadModel($id)->delete();
//                    }
//                        
//              
//                
//		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LbCustomer');
		LBApplication::render($this,'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LbCustomer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LbCustomer']))
			$model->attributes=$_GET['LbCustomer'];

		LBApplication::render($this,'admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * json data source for x-editable dropdown
	 */
	public function actionDropdownJSON()
	{
		$allow_add = isset($_GET['allow_add']) ? $_GET['allow_add'] : NO;
		
		// get results;
		$results = LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
				LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
		// prepend new customer link if allow add new
		if ($allow_add)
		{
			$results = array('-1'=>'Choose Customer', '0'=>'-- Add new customer --')+$results;
		}
		
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LbCustomer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LbCustomer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LbCustomer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lb-customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function ActionCreateAddress($id)
        {
            $addressModel = LbCustomerAddress();
            
            LBApplication::render($this, '_form_new_address', array(
                        'addressModel'=>$addressModel,
            ));
        }
        
	public function actionDeleteAddress()
	{
                $error = array();
                $address_id = $_POST['id'];
                $customer_id = $_POST['customer_id'];
                $invoiceAddress = LbInvoice::model()->getInvoiceByAddress($address_id);
                

                if(count($invoiceAddress->data)>0)
                {
                    $error['exist']='Address cannot be deleted. This address is already in use by an invoice or quotation.';
                    $model = LbCustomer::model()->findByPk($customer_id);
                    $customer_addresses = LbCustomerAddress::model()->getAddresses($customer_id, 
                                    LbCustomerAddress::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
                    $customer_contacts = LbCustomerContact::model()->getContacts($customer_id,
                                    LbCustomerContact::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
                    LBApplication::renderPartial($this, '//layouts/plain_ajax_content', array(
                            'content'=>CJSON::encode($error),		
                    ));
                }
                else
                {
                    $address = LbCustomerAddress::model()->findByPk($address_id);
                    $address->delete();
                }
	}
        
	public function actionDeleteContact()
	{
                $error = array();
                $contact_id = $_POST['id'];
                $customer_id = $_POST['customer_id'];
                $invoiceContact = LbInvoice::model()->getInvoiceByContact($contact_id);
                

                if(count($invoiceContact->data)>0)
                {
                    $error['exist']='Contact cannot be deleted. This contact is already in use by an invoice or quotation.';
                    $model = LbCustomer::model()->findByPk($customer_id);
                    $customer_addresses = LbCustomerAddress::model()->getAddresses($customer_id, 
                                    LbCustomerAddress::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
                    $customer_contacts = LbCustomerContact::model()->getContacts($customer_id,
                                    LbCustomerContact::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
                    LBApplication::renderPartial($this, '//layouts/plain_ajax_content', array(
                            'content'=>CJSON::encode($error),		
                    ));
                }
                else
                {
                    $contact = LbCustomerContact::model()->findByPk($contact_id);
                    $contact->delete();
                }
	}
        
        function ActionLoadAjaxTabAddress($id)
        {
            $customer_addresses = LbCustomerAddress::model()->getAddresses($id, 
                LbCustomerAddress::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
            
            LBApplication::renderPartial($this, '_customer_addresses', array(
                            'customer_addresses'=>$customer_addresses,
                            'customer_id'=>$id,
                          ));
        }
        
        function ActionLoadAjaxTabContract($id)
        {
            $customer_contacts = LbCustomerContact::model()->getContacts($id,
                            LbCustomerContact::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
            
            LBApplication::renderPartial($this, '_customer_contacts', array(
                            'customer_contacts'=>$customer_contacts,
                            'customer_id'=>$id,
                          ));
        }
        function action_search_customer(){
            $name = isset($_GET['name']) ? $_GET['name'] : '';
            LBApplication::renderPartial($this, '_search_customer', array(
                'name'=>$name,
            ));
        }
}
