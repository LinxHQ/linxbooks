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
             <span style="font-size:20px;font-weight:bold;">GST Report</span>
             
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
           <table border="0" width="100%" class="items table table-bordered">
           <thead>
                <tr>
                            <th width="100" class="lb-grid-header">'.Yii::t('lang','Number').'</th>
                            <th width="100" class="lb-grid-header">'.Yii::t('lang','Date').'</th>
                            <th width="250" class="lb-grid-header">'.Yii::t('lang','Customer').'</th>
                            <th width="150" class="lb-grid-header">'.Yii::t('lang','Invoice Value').'</th>
                            <th width="150" class="lb-grid-header">'.Yii::t('lang','GST Collected').'</th>             
                </tr>
                <tr></tr>
                </thead>';
                if($customer_id > 0)
                {
               $PDFGst .= '<tbody>';
                            $invoiceValue=0;
                            $gst = 0;
                            foreach ($a as $data)
                            {
                               $customer_id = false;
                                
                                $invoice_information = LbInvoiceTotal::model()->getInvoiceById($data->lb_record_primary_key);
                                $invoiceTax = LbInvoiceItem::model()->getInvoiceTaxById($data->lb_record_primary_key,"TAX");
                                                                $invoiceValue = $invoiceValue+$invoice_information->lb_invoice_total_after_discounts;

                                $PDFGst .= '<tr>';
                                $PDFGst .= '<td>'.$data->lb_invoice_no.'</td>';
                                $PDFGst .= '<td>'.$data->lb_invoice_date.'</td>';
                                $PDFGst .= '<td>';
                                
                                if($data->lb_invoice_customer_id)
                                {
                                    $customer_id = $data->lb_invoice_customer_id;
                                    $PDFGst .= LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];
                                }
                               
                                $PDFGst .= '</td>';
                                $PDFGst .= '<td>$'.$invoice_information->lb_invoice_total_after_discounts.'</td>';
                                $PDFGst .= '<td>';
                                $totalTax=0;
                                if($invoiceTax)
                                {
                                    $totaltax = $invoice_information->lb_invoice_total_after_taxes-$invoice_information->lb_invoice_total_after_discounts;
                                    
                                    $PDFGst .= '$'.$totaltax;
                                }else
                                    $PDFGst .= '$0.00';
                                $PDFGst .= '</td>';
                                
                                $PDFGst .= '</tr>';
                                $gst = $gst+($invoice_information->lb_invoice_total_after_taxes-$invoice_information->lb_invoice_total_after_discounts);
                            }
                            $PDFGst .='</tbody>';
                            $PDFGst .='<tfoot><tr>
                                <td colspan="3"><b>Total</b></td>
                                <td align="right" style="border-top:1px solid #000">
                                    <b>$'.$invoiceValue.'</b>
                                </td>
                                <td align="right" style="border-top:1px solid #000">
                                <b>$'.$gst.'</b>
                                </td>
                                </tr>
                        
                    </tfoot>';
                }
                else
                {
                    $customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
                        $invoiceValue=0;
                            $gst = 0;
                        foreach ($customer_arr as $customer)
                        { 
                            $PDFGst .= '<tbody>';
                           
                            $a = LbInvoice::model()->getInvoiceMonth($customer['lb_record_primary_key'],$date_from,$date_to);

                            
                            foreach ($a as $data)
                            {
                               $customer_id = false;
                                
                                $invoice_information = LbInvoiceTotal::model()->getInvoiceById($data->lb_record_primary_key);
                                $invoiceTax = LbInvoiceItem::model()->getInvoiceTaxById($data->lb_record_primary_key,"TAX");
                                                                $invoiceValue = $invoiceValue+$invoice_information->lb_invoice_total_after_discounts;

                                $PDFGst .= '<tr>';
                                $PDFGst .= '<td>'.$data->lb_invoice_no.'</td>';
                                $PDFGst .= '<td>'.$data->lb_invoice_date.'</td>';
                                $PDFGst .= '<td>';
                                
                                if($data->lb_invoice_customer_id)
                                {
                                    $customer_id = $data->lb_invoice_customer_id;
                                    $PDFGst .= LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];
                                }
                               
                                $PDFGst .= '</td>';
                                $PDFGst .= '<td>$'.$invoice_information->lb_invoice_total_after_discounts.'</td>';
                                $PDFGst .= '<td>';
                                $totalTax=0;
                                if($invoiceTax)
                                {
                                    $totaltax = $invoice_information->lb_invoice_total_after_taxes-$invoice_information->lb_invoice_total_after_discounts;
                                    
                                    $PDFGst .= '$'.$totaltax;
                                }else
                                    $PDFGst .= '$0.00';
                                $PDFGst .= '</td>';
                                
                                $PDFGst .= '</tr>';
                                $gst = $gst+($invoice_information->lb_invoice_total_after_taxes-$invoice_information->lb_invoice_total_after_discounts);
                            }
                            
                        
                    $PDFGst .= '</tbody>';
                }
                $PDFGst .='<tfoot><tr>
                                <td colspan="3"><b>Total</b></td>
                                <td align="right" style="border-top:1px solid #000">
                                    <b>$'.number_format($invoiceValue,2).'</b>
                                </td>
                                <td align="right" style="border-top:1px solid #000">
                                <b>$'.number_format($gst,2).'</b>
                                </td>
                                </tr>
                        
                    </tfoot>';
                }

$PDFGst .='
            </table>
            </td></tr>'
        
        . '</table>';
        
echo $PDFGst;

?>
