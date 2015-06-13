<?php

class DefaultController extends CLBController
{
        public $layout='//layouts/column1';
    
	public function actionIndex()
	{
		$this->render('index');
	}
        public function actionCreate()
        {
            $model = new LbPayment();
            $lbInvoiceModel = new LbInvoice();
            
            $customer_id=0;
            if(isset($_GET['id']) && $_GET['id']!="")
                $customer_id = $_GET['id'];
            
            
            LBApplication::render($this,'create',array('model'=>$model,'lbInvoiceModel'=>$lbInvoiceModel,'customer_id'=>$customer_id));
            
        }
        
        function actionAjaxSavePayment()
        {
            $model = new LbPayment();
            if(isset($_POST['LbPayment'])){
                $payment_arr = $_POST['LbPayment'];
                $payment_arr = $_POST['LbPayment'];
                
                $model->lb_payment_no=LbPayment::model()->FormatPaymentNo(LbPayment::model()->getPaymentNextNum());
                $model->lb_payment_customer_id = $_POST['customer_id'];
                $model->lb_payment_method=$payment_arr['lb_payment_method'];
                $model->lb_payment_date= $payment_arr['lb_payment_date'];
                //$model->lb_payment_notes=$payment_arr['lb_payment_notes'];
                $model->lb_payment_total=$_POST['total_payment'];
                //$model->lb_invoice_id = $_POST[]
                
                if($model->save())
                {
                    //LbPayment::model()->setPaymentNextNum();
                    
                    // save payment item
                    $count_payment = count($_POST['payment_check']);
                    $payment_invoice = $_POST['payment_check'];
                    $payment_note = $_POST['payment_note'];
                    $payment_item_amount = $_POST['payment'];
                    
                    for($i=0;$i<$count_payment;$i++){
                        if($payment_item_amount[$i]>0){
                            $paymentItemModel = new LbPaymentItem();
                            $paymentItemModel->lb_payment_id = $model->lb_record_primary_key;
                            $paymentItemModel->lb_invoice_id = $payment_invoice[$i];
                            $paymentItemModel->lb_payment_item_note=$payment_note[$i];
                            $paymentItemModel->lb_payment_item_amount=$payment_item_amount[$i];
                            if($paymentItemModel->save()){
                                $invoice_total = LbInvoiceTotal::model()->getInvoiceTotal($paymentItemModel->lb_invoice_id);
                                if($invoice_total){
                                    $invoice_total->calculateInvoicetotalPaid ($paymentItemModel->lb_invoice_id);
                                    $total_outstanding = $invoice_total->calculateInvoiceTotalOutstanding();
                                    if(isset($total_outstanding))
                                    {
                                        //Update Status
                                        LbInvoice::model()->InvoiceUpdateStatus($payment_invoice[$i]);
                                    }
                                    
                                }
                                echo '{"status":"success"}';
                            }
                            else
                                echo '{"status":"fail"}';
                            
                        }
                    }
                }
                
            }
        }
        
        function actionAjaxLoadInvoiceByCustomer()
        {
            $lbInvoiceModel = new LbInvoice();
            LBApplication::renderPartial($this,'_form_line_item', array('lbInvoiceModel'=>$lbInvoiceModel, 'customer_id'=>$_POST['customer_id']));
        }
        function actionAjaxLoadFormViewPayment()
        {
            //LBApplication::renderPartial($this, '_form_view_payment', array());
            $model = new LbPayment();
            $lbInvoiceModel = new LbInvoice();
            LBApplication::renderPartial($this,'_form_view_payment',  array('model'=>$model,'lbInvoiceModel'=>$lbInvoiceModel));
        }
        
        
        public function actionPdf($invoice, $search_date_from,$search_date_to)
        {
            //$customer_id = $_GET['customer_id'];
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            
            $model = new LbPayment();
            $lbInvoiceModel = LbInvoice::model()->findByPk($invoice);
            $html2pdf->WriteHTML($this->renderPartial('pdf', array('lbPaymentModel'=>$model,'model'=>$lbInvoiceModel,'invoice_id'=>$invoice,'search_date_from'=>$search_date_from,'search_date_to'=>$search_date_to),true));
            $html2pdf->WriteHTML($this->renderPartial('_pdf_footer', array(), true));
            $html2pdf->Output('invoice.pdf','I');
        }
        
        
        
      
        
}
