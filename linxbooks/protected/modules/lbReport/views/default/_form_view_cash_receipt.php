<?php
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');

$method = LBPayment::model()->method;
$customer_id =false;
if(isset($_POST['customer_id']) && $_POST['customer_id']!="")
    $customer_id=$_POST['customer_id'];
//echo $customer_id;
$date_from = date('Y-m-d');
$date_to = date('Y-m-d',strtotime("+1 month -1 day"));

if(isset($_POST['search_date_from']) && $_POST['search_date_from']!="")
    $date_from = date('Y-m-d',  strtotime ($_POST['search_date_from']));
if(isset($_POST['search_date_to']) && $_POST['search_date_to']!="")
    $date_to = date('Y-m-d',  strtotime ($_POST['search_date_to']));

//$customer_arr= LbCustomer::model()->getCompaniesByPayment('lb_customer_name ASC', LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY,$customer_id,$date_from,$date_to);
$customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
//$a = LbInvoice::model()->getInvoicePaidByCustomerDate(3,398);

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
//$PaymentAll = LbPayment::model()->getAllPayment($FromDate,$numberDate,$customer_id,$MStart,$YStart,$i);

//$PaymentAll = LbPayment::model()->getAllPayment(false,false,$customer_id,'05','2014','30');
//echo '<pre>';
//print_r($PaymentAll);

?>


<input hidden="true" id="customer_id" value ='<?php echo $customer_id; ?>'/>
<div style="width:100%;margin-top:10px;margin-bottom:3px;">
   
<button class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_cash(); return false;">Print PDF</button>
<form>
    <fieldset>
<table border="0" width="100%" class="items table table-bordered">
            <thead>
                <tr>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Date'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Customer'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Note'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Invoice Paid'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Payment Amount'); ?></th>

                </tr>
            </thead>
            <tbody>
                
            <?php

                

            $customer_name='';
            
                 while(strtotime($FromDate) < strtotime($Todate))
                 {
                    $arrDate = dateMY($FromDate);
                    $subtotal = 0;
                    $tax = 0;
                    $total = 0;
                    $YStart = $arrDate[0];
                    $MStart = $arrDate[1];
                    $MEnd = dateMY($Todate)[1];
                    $YEnd = dateMY($Todate)[0];
                    
                    $numberDate = $YStart.'-'.$MStart.'-'.numberDate($YStart, $MStart);
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
                                    echo '<tr>';
                                    echo '<td>'.$data->attributes['lb_payment_date'].'</td>';
                                    echo '<td>'.$customer_name.'</td>';
                                    echo '<td>'.$data->attributes['lb_payment_notes'].'</td>';
                                   $payment_item = LbPaymentItem::model()->getAllPaymentInvoice($data->lb_record_primary_key);
                                    echo '<td>';

                                    foreach ($payment_item as $payment)
                                    {
//                                        echo $payment->lb_invoice_id;
                                        $invoiceNo = LbInvoice::model()->find('lb_record_primary_key='.  intval($payment->lb_invoice_id));
                                        if(isset($invoiceNo->lb_record_primary_key))
                                        {
                                        
                                          echo $invoiceNo->lb_invoice_no.':$'.$payment->lb_payment_item_amount.'; ';
                                        $paymentAmount = $paymentAmount+$payment->lb_payment_item_amount;
                                        $AmountMonth = $AmountMonth+$payment->lb_payment_item_amount;;
                                        }

                                    }
                                    echo '</td>';
                                    $total = $total+$data->attributes['lb_payment_total'];
                                    echo '<td>'.$data->attributes['lb_payment_total'].'</td>';

                                    echo '</tr>';



                                }
                            }
                            if($paymentAmount > 0)
                            {
                            echo '<tr><td colspan="4"><b>Method: '.$method[$i].'</b></td>';
                            echo '<td style="border-top:1px solid #000"><b>$'.$paymentAmount.'</b></td>';
                            }
                            
                        }
                            
                      }   
                        
                        
                      if($AmountMonth > 0)
                        {
                        echo '<tr height="35">';
                        echo '<td style="background:#EEE;" colspan="4"><b>'.$YStart.'-'.$MStart.'</b></td>';
                        echo '<td style="background:#EEE;margin-bottom:20px;"><b>$'.$AmountMonth.'</b></td>';
                        echo '</tr>';
                        echo '<tr>
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
           
 

            ?>
            </tbody>
</table></fieldset></form>


<script type="text/javascript">
    function printPDF_cash() {
            window.open('pdfCash?customer=<?php echo $customer_id;?>&search_date_from=<?php echo $date_from; ?>&search_date_to=<?php echo $date_to ?>', '_target');
    }
</script>
