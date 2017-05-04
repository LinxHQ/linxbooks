<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$financial = UserList::model()->getItemsList('financial_year');        
$financial_day = $financial[0]['system_list_item_day'];
$financial_month = $financial[0]['system_list_item_month'];
$now = getdate();       
$year_prev = $now["year"]-1;

$year_next = $now["year"]+1;
//$financial_year = $financial_day."-".$financial_month."-".$now["year"];
$financial_year = $now["year"]."-".$financial_month."-".$financial_day;
$date_now = date('Y-m-d');


 $financial_prev_year = $year_prev."-".$financial_month."-".$financial_day;
 $financial_next_year = $year_next."-".$financial_month."-".$financial_day;

//if(strtotime($financial_year) < strtotime($date_now)){
//    //$financial_old_year = $financial_day."-".$financial_month."-".$year_old;
//    $financial_prev_year = $year_prev."-".$financial_month."-".$financial_day;
//    $total_Payment = LbInvoice::CURRENCY_SYMBOL.number_format(LbPayment::model()->getTotalPayment($financial_year,$financial_prev_year),2);
//}else{
//    $financial_next_year = $year_next."-".$financial_month."-".$financial_day;
//    $total_Payment = LbInvoice::CURRENCY_SYMBOL.number_format(LbPayment::model()->getTotalPaymentFinancial($financial_year,$financial_next_year),2);
//}
?>

    
<div class="col-lg" >
    <div class="panel-header-summary"><h4 >Outstanding</h4></div>
        <div class="panel-body">
            <div class="info_content_summary">
                <h1>
                <?php
                    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")';
                    echo LbInvoice::CURRENCY_SYMBOL.number_format($model->calculateInvoiceTotalOutstanding($status),2);
                //    echo LbInvoice::CURRENCY_SYMBOL.  number_format($model->totalInvoiceYearToDateRevenue($status),2);
                    ?></h1>
            </div>
        </div>
</div>
<div class="col-lg" >
        <div class="panel-header-summary"><h4 >You have earned</h4></div>
        <div class="panel-body">
            <div class="info_content_summary">
                <h1>
                <?php
                echo $total_Payment = LbInvoice::CURRENCY_SYMBOL.number_format(LbPayment::model()->getTotalPaymentFinancial($financial_prev_year,$financial_year),2);
                    // if(strtotime($date_now) > strtotime($financial_year)){
                    //     echo $total_Payment = LbInvoice::CURRENCY_SYMBOL.number_format(LbPayment::model()->getTotalPaymentFinancial($financial_year,$financial_prev_year),2);                     
                    //     //echo $total_Payment = LbInvoice::CURRENCY_SYMBOL.number_format(LbPayment::model()->getTotalPayment($financial_year,$financial_prev_year),2);
                    // }else{                                                
                    //    // echo $total_Payment = LbInvoice::CURRENCY_SYMBOL.number_format(LbPayment::model()->getTotalPaymentFinancial($financial_year,$financial_next_year),2);
                    //     echo $total_Payment = LbInvoice::CURRENCY_SYMBOL.number_format(LbPayment::model()->getTotalPayment($financial_year,$financial_prev_year),2);
                    // }
                    ?></h1>
            </div>
        </div>
        <div class="panel-footer">financial year <?php echo date('d M Y',  strtotime($financial_year));?></div>
        <div>
            
        </div>
</div>

<div class="col-lg" >
        <div class="panel-header-summary"><h4 >You have spent</h4></div>
        <div class="panel-body">
            <div class="info_content_summary">
                <h1 style="color: #dd3d36">
                <?php
                    if(strtotime($date_now) > strtotime($financial_year)){
                         $total_Payment_bills = LbPaymentVendor::model()->getTotalPaymentNext($financial_year,$financial_next_year);
                            $total_Payment_expenses = LbExpenses::model()->getTotalExpensesNext($financial_year,$financial_next_year);
                            echo LbInvoice::CURRENCY_SYMBOL.number_format(($total_Payment_bills + $total_Payment_expenses),2); 
                    }else{
                         $total_Payment_bills = LbPaymentVendor::model()->getTotalPaymentPrev($financial_year,$financial_prev_year);
                            $total_Payment_expenses = LbExpenses::model()->getTotalExpensesPrev($financial_year,$financial_prev_year);
                            echo LbInvoice::CURRENCY_SYMBOL.number_format(($total_Payment_bills + $total_Payment_expenses),2);
                    }
                    ?></h1>
            </div>
        </div>
</div>
   