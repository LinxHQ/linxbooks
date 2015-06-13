<?php

$thousand =LbGenera::model()->getGeneraSubscription()->lb_thousand_separator;
$decimal= LbGenera::model()->getGeneraSubscription()->lb_decimal_symbol;
$strnum = new LbInvoiceTotal();
$method = LBPayment::model()->method;
$date_from = date('Y-m-d');
$date_to = date('Y-m-d', strtotime("+1 month -1 day"));
$customer_id = false;
if (isset($_REQUEST['search_date_from']) && $_REQUEST['search_date_from'] != "")
    $date_from = date('Y-m-d', strtotime($_REQUEST['search_date_from']));
if (isset($_REQUEST['search_date_to']) && $_REQUEST['search_date_to'] != "")
    $date_to = date('Y-m-d', strtotime($_REQUEST['search_date_to']));
if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != 0)
    $customer_id = $_REQUEST['customer'];

$a = LbInvoice::model()->getInvoiceMonth($customer_id,$date_from,$date_to);

$PDFGst = '<table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">'
        . '<tr><td>
            <table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
            <tr><td >
             <span style="font-size:20px;font-weight:bold;">Sales Report</span>
            </td></tr>
            </table>
            </td></tr>'
        . '<tr><td>
            <table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
            <tr><td >
             <span style="margin:10px;padding:10px">From: '.$date_from.'</span>
             <span style="margin:10px;">To: '.$date_to.'</span>
             
            </td></tr>
            </table>
            </td></tr>'
        
        . '<tr><td>
           <table  width="100%" class="items table table-bordered">
           <thead>
                <tr>
                            
                            <th width="80" class="lb-grid-header">'.Yii::t('lang','Date').'</th>
                            <th width="100" class="lb-grid-header">'.Yii::t('lang','Number').'</th>
                            <th width="100" class="lb-grid-header">'.Yii::t('lang','Customer').'</th>
                            <th width="100" class="lb-grid-header">'.Yii::t('lang','Total').'</th>
                            <th width="100" class="lb-grid-header">'.Yii::t('lang','Paid').'</th>             
                            <th width="100" class="lb-grid-header">'.Yii::t('lang','Amount').'</th>             
                            <th width="150" class="lb-grid-header">'.Yii::t('lang','Due').'</th>             
                </tr>
                <tr></tr>
                </thead>
                ';
                if($customer_id > 0){
                $PDFGst .='<tbody>';
                            
                            $invoiceValue = 0;
                            $AllPaid = 0;
                            $invoiceDue = 0;
                            foreach ($a as $data)
                            {
                                $customer_id = false;
                                
                                $invoice_information = LbInvoiceTotal::model()->getInvoiceById($data->lb_record_primary_key);
                                $invoiceTax = LbInvoiceItem::model()->getInvoiceTaxById($data->lb_record_primary_key,"TAX");
                                $PDFGst .= '<tr>';
                                
                                $PDFGst .= '<td>'.$data->lb_invoice_date.'</td>';
                                $PDFGst .= '<td>'.$data->lb_invoice_no.'</td>';
                                $PDFGst .= '<td>';
                                
                                if($data->lb_invoice_customer_id)
                                {
                                    $customer_id = $data->lb_invoice_customer_id;
                                    $PDFGst .= LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];
                                }
                                
                                $PDFGst .= '</td>';
                                $invoiceValue = $invoiceValue+$invoice_information->lb_invoice_total_after_taxes;
                                $PDFGst .= '<td>$'.$invoice_information->lb_invoice_total_after_taxes.'</td>';
                                $PDFGst .= '<td>';
                                
                                $totalPaid = LbInvoiceTotal::model()->find('lb_invoice_id='.  intval($data->lb_record_primary_key));
                                $AllPaid = $AllPaid + $totalPaid->lb_invoice_total_paid;
                                $PDFGst .= $totalPaid->lb_invoice_total_paid;
                                $PDFGst .= '</td>';
                                $PDFGst .= '<td>';
                                $PDFGst .= $totalPaid->lb_invoice_total_paid;
                                $PDFGst .= '</td>';
                                $invoiceDue = $invoiceDue+$totalPaid->lb_invoice_total_outstanding;
                                $PDFGst .= '<td>$'.$totalPaid->lb_invoice_total_outstanding.'</td>';
                              
                                $PDFGst .= '</tr>';
                            }
                            
                   $PDFGst .= '</tbody>';
                        $PDFGst .='<tfoot><tr>
                                <td colspan="3"><b>Sub Total</b></td>
                        <td align="right" style="border-top:1px solid #000">
                        <b>$'.number_format($invoiceValue,2).'</b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b>$'.number_format($AllPaid,2).'</b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b>$'.number_format($AllPaid,2).'</b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b> $'.number_format($invoiceDue,2).'</b>
                        </td></tr>
                        
                    </tfoot>';
                }
                else
                {
                    
                 $PDFGst .='<tbody>';
                    
                 $customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
                 $invoiceValue = 0;
                 $AllPaid = 0;
                 $invoiceDue = 0;
                 foreach ($customer_arr as $customer)
                 {
                            
                            
                            $a = LbInvoice::model()->getInvoiceMonth($customer['lb_record_primary_key'],$date_from,$date_to);

                            foreach ($a as $data)
                            {
                                $customer_id = false;
                                
                                $invoice_information = LbInvoiceTotal::model()->getInvoiceById($data->lb_record_primary_key);
                                $invoiceTax = LbInvoiceItem::model()->getInvoiceTaxById($data->lb_record_primary_key,"TAX");
                                $PDFGst .= '<tr>';
                                
                                $PDFGst .= '<td>'.$data->lb_invoice_date.'</td>';
                                $PDFGst .= '<td>'.$data->lb_invoice_no.'</td>';
                                $PDFGst .= '<td>';
                                
                                if($data->lb_invoice_customer_id)
                                {
                                    $customer_id = $data->lb_invoice_customer_id;
                                    $PDFGst .= LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];
                                }
                                
                                $PDFGst .= '</td>';
                                $invoiceValue = $invoiceValue+$invoice_information->lb_invoice_total_after_taxes;
                                $PDFGst .= '<td>$'.$invoice_information->lb_invoice_total_after_taxes.'</td>';
                                $PDFGst .= '<td>';
                                
                                $totalPaid = LbInvoiceTotal::model()->find('lb_invoice_id='.  intval($data->lb_record_primary_key));
                                $AllPaid = $AllPaid + $totalPaid->lb_invoice_total_paid;
                                $PDFGst .= $totalPaid->lb_invoice_total_paid;
                                $PDFGst .= '</td>';
                                $PDFGst .= '<td>';
                                $PDFGst .= $totalPaid->lb_invoice_total_paid;
                                $PDFGst .= '</td>';
                                $invoiceDue = $invoiceDue+$totalPaid->lb_invoice_total_outstanding;
                                $PDFGst .= '<td>$'.$totalPaid->lb_invoice_total_outstanding.'</td>';
                              
                                $PDFGst .= '</tr>';
                            }
                            
                    }
                 
                   $PDFGst .= '</tbody>';
                        $PDFGst .='<tfoot><tr>
                                <td colspan="3"><b>Sub Total</b></td>
                        <td align="right" style="border-top:1px solid #000">
                        <b>$'.number_format($invoiceValue,2).'</b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b>$'.number_format($AllPaid,2).'</b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b>$'.number_format($AllPaid,2).'</b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b> $'.number_format($invoiceDue,2).'</b>
                        </td></tr>
                        
                    </tfoot>';
                }
            

$PDFGst .='
            </table>
            </td></tr>'
        
        . '</table>';
        
echo $PDFGst;

?>
