<?php
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');

$method = LBPayment::model()->method;
$customer_id =false;
if(isset($_GET['customer']) && $_GET['customer']!="")
    $customer_id=$_GET['customer'];
//echo $customer_id;
$date_from = date('Y-m-d');
$date_to = date('Y-m-d',strtotime("+1 month -1 day"));

if(isset($_GET['search_date_from']) && $_GET['search_date_from']!="")
    $date_from = date('Y-m-d',  strtotime ($_GET['search_date_from']));
if(isset($_GET['search_date_to']) && $_GET['search_date_to']!="")
    $date_to = date('Y-m-d',  strtotime ($_GET['search_date_to']));

//$customer_arr= LbCustomer::model()->getCompaniesByPayment('lb_customer_name ASC', LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY,$customer_id,$date_from,$date_to);
$customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
$a = LbInvoice::model()->getInvoicePaidByCustomerDate(3,398);

function dateMY($date)
{
    $arr = explode('-',$date);
    return $arr;
}

function numberDate($year,$t)
{
    $t; $year; $d;
    switch ( $t ) {
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            $d    = 31;
            break;
        case 4:
        case 6:
        case 9:
        case 11:
            $d    = 30;
            break;
        case 2:
            if( $year % 100 != 0 && $year % 4 == 0 ) {
                $d    = 29;
            } else {
                $d    = 28;
            }
            break;
        default: $d    = 0;
    }
    return $d;
}

$FromDate = $date_from;
$Todate = $date_to;

$PaymentAll = LbPayment::model()->getAllPayment(false,false,$customer_id,'05','2014','30');



$PDFCash = '<table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">'
        . '<tr><td>
                <table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
                <tr><td >
                 <span style="font-size:20px;font-weight:bold;">Cash Receipt</span>

                </td></tr>
                </table>
            </td></tr>'
        . '<tr><td>
            <table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
                <tr><td >
                 <span style="margin-top:10px;">From: '.$date_from.'</span>
                 <span style="margin-top:20px;"> </span>

                </td></tr>
            </table>
         </td></tr>'
        
        . '</table>
           <table border="0" width="100%" class="items table table-bordered">';
           $PDFCash .='<thead>
                    <tr>
                        <th  width="80" class="lb-grid-header">'.Yii::t('lang','Date').'</th>
                        <th width="100" class="lb-grid-header">'. Yii::t('lang','Customer').'</th>
                        <th width="100"  class="lb-grid-header">'.Yii::t('lang','Note').'</th>
                        <th width="200"  class="lb-grid-header">'.Yii::t('lang','Invoice Paid').'</th>
                        <th class="lb-grid-header" style="float:left;">'.Yii::t('lang','Payment Amount').'</th>
                     </tr>
                </thead>';

           
                 $customer_name='';
                 while(strtotime($FromDate) < strtotime($Todate))
                 {
                    $arrDate = dateMY($FromDate);
                    $subtotal = 0;
                    $tax = 0;
                    $total = 0;
                    $YStart = $arrDate[0];
                    $MStart = $arrDate[1];

                    $numberDate = $YStart.'-'.$MStart.'-'.numberDate($YStart, $MStart);
                     $MEnd = dateMY($Todate)[1];
                    $YEnd = dateMY($Todate)[0];
                    $date_To = date('Y-m-d',  strtotime ($numberDate));
                   
                    $day = dateMY($FromDate)[2];
                    $dayTo = dateMY($Todate)[2];
                    $month =  dateMY($FromDate)[1];
                    $year =  dateMY($FromDate)[0];
                    $AmountMonth = 0;
                    
                    for($i=0;$i<5;$i++)
                    {
                        if($YStart == $YEnd && $MStart == $MEnd)
                        {
                            $PaymentAll = LbPayment::model()->getAllPayment($FromDate,$Todate,$customer_id,false,false,$i);
                        }else
                            $PaymentAll = LbPayment::model()->getAllPayment($FromDate,$numberDate,$customer_id,false,false,$i);
                        
                            
                        if(count($PaymentAll) > 0)
                        {
                            $paymentAmount=0;
                            foreach ($PaymentAll as $data)
                            {
                                if(LbCustomer::model()->isCustomer($data->attributes['lb_payment_customer_id']) != null)
                                {
                                    $customer_information = LbCustomer::model()->find('lb_record_primary_key='.  intval($data->attributes['lb_payment_customer_id']));
                                    $customer_name = $customer_information->lb_customer_name;
                                    $PDFCash .= '<tr>';
                                    $PDFCash .= '<td>'.$data->attributes['lb_payment_date'].'</td>';
                                    $PDFCash .= '<td>'.$customer_name.'</td>';
                                    $PDFCash .= '<td>'.$data->attributes['lb_payment_notes'].'</td>';
                                   $payment_item = LbPaymentItem::model()->getAllPaymentInvoice($data->lb_record_primary_key);
                                    $PDFCash .= '<td>';

                                    foreach ($payment_item as $payment)
                                    {

                                        $invoiceNo = LbInvoice::model()->find('lb_record_primary_key='.  intval($payment->lb_invoice_id));
                                        if(isset($invoiceNo->lb_record_primary_key))
                                        {
                                        $PDFCash .= $invoiceNo->lb_invoice_no.':$'.$payment->lb_payment_item_amount.' <br/>';
                                        $paymentAmount = $paymentAmount+$payment->lb_payment_item_amount;
                                        $AmountMonth = $AmountMonth+$payment->lb_payment_item_amount;;

                                    
                                        }
                                    }
                                    $PDFCash .= '</td>';
                                    $total = $total+$data->attributes['lb_payment_total'];
                                    $PDFCash .= '<td>'.$data->attributes['lb_payment_total'].'</td>';

                                    $PDFCash .= '</tr>';



                                }
                            }
                            if($paymentAmount > 0)
                            {
                                $PDFCash .= '<tr ><td height="30" colspan="4"><b>Method: '.$method[$i].'</b></td>';
                                $PDFCash .= '<td style="border-top:1px solid #000"><b>$'.$paymentAmount.'</b></td>';
                            
                            $PDFCash .= '</tr>';
                            }
                            
                        
                        }
                            
                      }   
                        
                        
                      if($AmountMonth > 0)
                        {
                        $PDFCash .= '<tr>';
                        $PDFCash .= '<td  height="35" style="background:#EEE;" colspan="4"><b>'.$YStart.'-'.$MStart.'</b></td>';
                        $PDFCash .= '<td style="background:#EEE;margin-bottom:20px;"><b>$'.$AmountMonth.'</b></td>';
                        $PDFCash .= '</tr>';
                        $PDFCash .= '<tr>
                            <td> </td>
                            </tr>';
                        }   
          
                    $total = 0;
               

                    if($MStart < 12)
                        {
                            $MStart++;
                            $dateNext = $YStart.'-'.$MStart.'-01';
                        }
                        else
                        {
                            $YStart++;
                            $MStart = 1;
                            $dateNext = $YStart.'-'.$MStart.'-01';
                        }
                        
                        $FromDate = date('Y-m-d',  strtotime ($dateNext));
            
            }
           

             $PDFCash .='
            
        
        </table>';
           
echo $PDFCash;
                

          
            ?>
           