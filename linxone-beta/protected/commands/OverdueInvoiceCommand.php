<?php
/**
 * Chuc nang: Chay cron update tat ca cac invoce co Status I_OPEN da het han thanh Invoice Co Status I_OVERDUE.
 */
class OverdueInvoiceCommand extends CConsoleCommand {
    public function run($args) {
        
        $current_date = date('Y-m-d');
        $sql = 'UPDATE `lb_invoices` SET `lb_invoice_status_code`="'.LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'"
                WHERE `lb_invoice_due_date` <"'.$current_date.'" AND `lb_invoice_status_code`="'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'"';
        
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        if($command->execute())
            echo "Success";
    }
}

?>

