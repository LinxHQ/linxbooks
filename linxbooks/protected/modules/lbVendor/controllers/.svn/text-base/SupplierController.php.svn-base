<?php

class SupplierController extends Controller
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
				'actions'=>array('create','createSupplier','InsertLineItem','ViewSupplier','update'),
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

	
	 public function actioncreateSupplier()
       {
           $model=new LbVendorInvoice;
           $id = $model->addSupplier();
		// get basic info to assign to this record
            
                
               
            $this->redirect(array('viewSupplier','id'=>$id));
                
                
       }

	  public function actionViewSupplier($id)
       {
                $modelVendorInvoice = LbVendorInvoice::model()->loadModel($id);
                $modelItemVendor = new LbVendorItem();
                $modelDiscountVendor = new LbVendorDiscount();
                $modelTax = new LbVendorTax();
                $modelTotal = LbVendorTotal::model()->getVendorTotal($id,LbVendorTotal::LB_VENDOR_INVOICE_TOTAL);
		$this->render('viewSupplier',array(
			'model'=>$modelVendorInvoice,
                        'modelItemVendor'=>$modelItemVendor,
                        'modelDiscountVendor'=>$modelDiscountVendor,
                        'modelTax'=>$modelTax,
                        'modelTotal'=>$modelTotal,
                       
		));
       }
       
       public function actionInsertLineItem()
       {
//           $vendorItem = new LbVendorItem();
//            $result = $vendorItem->addLineItemVendor($id,LbVendorItem::LB_VENDOR_ITEM_TYPE_LINE);
//
//                    if ($result)
//                    {
//
//                            $response = array();
//                            $response['success'] = YES;
//                            $response['vendor_item_id'] = $result;
//
//                            LBApplication::renderPlain($this, array(
//                                    'content'=>CJSON::encode($response)
//                            ));
//                    }
               
       }
        
       
       public function actionDelete($id)
	{
//                $model = LbVendorInvoice::model()->findByPk($id);
//                echo $model->lb_vd_invoice_status;
//                $error = array();
//                $idnext = $id+1;
                $this->redirect(array('test','id'=>$id));
//                if($model->lb_vd_invoice_status == LbInvoice::LB_VD_STATUS_CODE_DRAFT)
//                {   
//                    $this->loadModel($id)->delete();
//                    if($this->loadModel($id)->delete())
//                        $this->redirect(array('viewSupplier','id'=>$idnext));
//                        
//                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
////                    if(!isset($_GET['ajax']))
////                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//                }
//                else
//                {
//                    $this->redirect(array('viewSupplier','id'=>$idnext));
////                    $error['error']="The invoice may be allowed to remove the I_DRAFT status";
////                    LBApplication::renderPlain($this, array('content'=>CJSON::encode($error)));
//                }
	}
        
         public function loadModel($id)
	{
		$model=LbVendorInvoice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
       
        
}
