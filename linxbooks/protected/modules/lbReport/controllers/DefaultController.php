<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
            $taxModel = LbTax::model()->getTaxes();
                
                $list = UserList::model()->getList();
                
                $translate = Translate::model()->search();
                
		$translate=new Translate('search');
		$translate->unsetAttributes();  // clear any default values
		if(isset($_GET['Translate']))
			$translate->attributes=$_GET['Translate'];
                
		LBApplication::render($this,'index',array(
                    'taxModel'=>$taxModel,
                    'list'=>$list,
                    'translate'=>$translate,
                ));
//		$this->render('index');
	}
        
        function actionAjaxLoadViewAgingReport()
        {
            $model=new LbInvoice();
            
//            $lbInvoiceModel = new LbInvoice();
            LBApplication::renderPartial($this,'_form_view_aging_report',  array('model'=>$model));
        }
        public function actionAdmin()
	{
		$model=new LbInvoice();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Modules']))
			$model->attributes=$_GET['Modules'];

		LBApplication::renderPartial($this, '_form_view_aging_report',array(
			'model'=>$model,
		));
	}
        
        function actionformCashReport()
        {
            $model = new LbPayment();
            $lbInvoiceModel = new LbInvoice();
            LBApplication::renderPartial($this,'_form_view_cash_receipt',  array('model'=>$model,'lbInvoiceModel'=>$lbInvoiceModel));
        }
        
        function actionAjaxLoadFormViewCash()
        {
            $model = new LbPayment();
            $lbInvoiceModel = new LbInvoice();
            LBApplication::renderPartial($this,'_form_view_cash_receipt',  array('model'=>$model,'lbInvoiceModel'=>$lbInvoiceModel));
        }
        
        function actionAjaxLoadFormViewJournal()
        {
             $model = new LbPayment();
             $lbInvoiceModel = new LbInvoice();
             LBApplication::renderPartial($this,'_form_view_invoice_journal',  array('model'=>$model,'lbInvoiceModel'=>$lbInvoiceModel));
        }
        
        function actionAjaxLoadFormViewgstReport()
        {
            LBApplication::renderPartial($this,'_form_view_gstReport',  array());

        }
        
        function actionpdfGstReport($customer, $search_date_from,$search_date_to)
        {
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $lbInvoiceModel = new LbInvoice();
            $html2pdf->WriteHTML($this->renderPartial('pdf_gstReport', array('model'=>$lbInvoiceModel,'customer'=>$customer,'search_date_from'=>$search_date_from,'search_date_to'=>$search_date_to),true));
            $html2pdf->Output('GstReport.pdf','I');
        }
        
        function actionAjaxLoadFormViewsaleReport() {
            LBApplication::renderPartial($this,'_form_view_sale_report',  array());

        }
        
        function actionpdfSale($customer, $search_date_from,$search_date_to)
        {
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $lbInvoiceModel = new LbInvoice();
            $html2pdf->WriteHTML($this->renderPartial('pdf_saleReport', array('model'=>$lbInvoiceModel,'customer'=>$customer,'search_date_from'=>$search_date_from,'search_date_to'=>$search_date_to),true));
            $html2pdf->Output('SaleReport.pdf','I');
        }
        
        public function actionAttentionByCustomer()
        {
            $customer_id = $_POST['customer_id_statement'];
            $option_contact='<option value="0">All</option>';
            $contact_arr = LbCustomerContact::model()->getContacts($customer_id, LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
            foreach ($contact_arr as $key => $value) {
                $option_contact.='<option value="'.$key.'">'.$value.'</option>';
            }
            
            echo $option_contact; 
             
        }
        
         public function actionAjaxDropDownAddress() 
        {
            $customer_id = $_POST['customer_id_statement'];
            $option_address='<option value="0">All</option>';
            $address_arr = LbCustomerAddress::model()->getAddresses($customer_id, LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
            foreach ($address_arr as $key => $value) {
                $option_address.='<option value="'.$key.'">'.$value.'</option>';
            }

            echo $option_address;
        }
        
        public function actionAjaxLoadFormViewStatement()
        {
             LBApplication::renderPartial($this,'_form_view_customer_statement',  array());
        }
        public function actionpdfAgingReport($customer,$search_date_from)
        {
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $lbInvoiceModel = new LbInvoice();
            $html2pdf->WriteHTML($this->renderPartial('pdf_agingReport', array('model'=>$lbInvoiceModel,'customer'=>$customer,'search_date_from'=>$search_date_from),true));
            $html2pdf->Output('AgingReport.pdf','I');
        }
        
        
        public function actionPDFStatement($customer,$attention,$address,$statusNumber,$search_date_from,$search_date_to) {
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $lbInvoiceModel = new LbInvoice();
            $html2pdf->WriteHTML($this->renderPartial('pdf_statement', array('model'=>$lbInvoiceModel,'attention'=>$attention,'customer'=>$customer,'search_date_from'=>$search_date_from,'address'=>$address,'statusNumber'=>$statusNumber,'search_date_to'=>$search_date_to),true));
            $html2pdf->Output('StatementReport.pdf','I');
        }
        
        public function actionPDFInvoiceJournal($customer_id,$search_date_to,$search_date_from)
        {
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $lbInvoiceModel = new LbInvoice();
            
            $html2pdf->WriteHTML($this->renderPartial('PDFInvoiceJournal', array('model'=>$lbInvoiceModel,'customer_id'=>$customer_id,'search_date_from'=>$search_date_from,'search_date_to'=>$search_date_to),true));
            $html2pdf->Output('PDFInvoiceJournal.pdf','I');
        }
        
        public function actionpdfCash($customer,$search_date_from,$search_date_to)
        {
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $lbInvoiceModel = new LbInvoice();
            $html2pdf->WriteHTML($this->renderPartial('PDFCash', array('model'=>$lbInvoiceModel,'customer_id'=>$customer,'search_date_from'=>$search_date_from,'search_date_to'=>$search_date_to),true));
            $html2pdf->Output('PDFCash.pdf','I');
        }
          
}