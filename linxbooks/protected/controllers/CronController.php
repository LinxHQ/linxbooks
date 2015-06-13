<?php

class CronController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
        /*
         * Ham nay co chuc nang tu dong Update nhung Invoice co status I_OPEN da het han thanh I_OVERDUE
         * 
         */
        public function actionCronInvoiceUpdateStatus() {
            $current_date = date('Y-m-d');
            $modelAll = LbInvoice::model()->findAll();
            foreach ($modelAll as $data) {
                if(strtotime($current_date) > strtotime($data->lb_invoice_due_date) && $data->lb_invoice_status_code == LbInvoice::LB_INVOICE_STATUS_CODE_OPEN)
                {
                    $model=  LbInvoice::model()->findByPk($data->lb_record_primary_key);
                    $model->lb_invoice_status_code= LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE;
                    $model->save();
                }
            }
            
        }
}