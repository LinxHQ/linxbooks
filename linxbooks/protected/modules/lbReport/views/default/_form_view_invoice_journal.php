<?php
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');

$method = LBPayment::model()->method;
$customer_id =false;
if(isset($_POST['customer_id_journal']) && $_POST['customer_id_journal'] > 0)
    $customer_id=$_POST['customer_id_journal'];
//echo $customer_id;
$date_from = date('Y-m-d');
$date_to = date('Y-m-d',strtotime("+1 month -1 day"));

if(isset($_POST['search_data_from_journal']) && $_POST['search_data_from_journal']!="")
    $date_from = date('Y-m-d',  strtotime ($_POST['search_data_from_journal']));
if(isset($_POST['search_data_to_journal']) && $_POST['search_data_to_journal']!="")
    $date_to = date('Y-m-d',  strtotime ($_POST['search_data_to_journal']));

$timestamp    = strtotime('2014-04');
$first_second = date('m-01-Y 00:00:00', $timestamp);
$last_second  = date('Y-m-t', $timestamp);


$customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);


$startDate = $date_from;
$endDate = $date_to;
//$Ydate = date('Y',$date_from);
$arrDate = dateMY($date_from);
$arrDateEnd = dateMY($date_to);
$Yfrom = $arrDate[0];
$Mfrom = $arrDate[1];
$YEnd = $arrDateEnd[0];
$MStart = $arrDateEnd[1];

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
$totalAll = 0;
            $subtotalAll = 0;
            $taxAll = 0;

?>
<input hidden="true" id="customer_id_journal" value ='<?php echo $customer_id; ?>'/>

<div style="width:100%;margin-top:10px;margin-bottom:3px;">
   
    <button class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_invoice_Journal(); return false;">Print PDF</button></div>
<form>
    <fieldset>
        <table border="0" width="100%" class="items table table-bordered">
                    <thead>
                        <tr>
                            <th width="250" class="lb-grid-header"><?php echo Yii::t('lang','Number'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Date'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Customer'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Sub Total'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Tax'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Total'); ?></th>
                            
                        </tr>
                    </thead>
<?php if($customer_id > 0)
        {
        
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

           if($YStart == $YEnd && $MStart == $MEnd)
           {
                $a = LbInvoice::model()->getInvoiceMonth($customer_id,$FromDate,$Todate,false,false);
            }else            
                $a = LbInvoice::model()->getInvoiceMonth($customer_id,$FromDate,$numberDate,false,false);

           
            ?>

                    
                  
                            <?php
                            foreach ($a as $data)
                            {
                                $customer_id = false;
                                
                                $invoice_information = LbInvoiceTotal::model()->getInvoiceById($data->lb_record_primary_key);
                                $invoiceTax = LbInvoiceItem::model()->getInvoiceTaxById($data->lb_record_primary_key,"TAX");
                                echo '<tr>';
                                echo '<td>'.$data->lb_invoice_no.'</td>';
                                echo '<td>'.$data->lb_invoice_date.'</td>';
                                echo '<td>';
                                
                                if($data->lb_invoice_customer_id)
                                {
                                    $customer_id = $data->lb_invoice_customer_id;
                                    echo LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];
                                }
                               
                                echo '</td>';
                                echo '<td>$'.number_format($invoice_information->lb_invoice_total_after_discounts,2).'</td>';
                                echo '<td>';
                                $totalTax=0;
                                if($invoiceTax)
                                {
                                    $totaltax = $invoice_information->lb_invoice_total_after_taxes-$invoice_information->lb_invoice_total_after_discounts;
                                    echo '$'.number_format($totaltax,2);
                                }else
                                    echo '$0.00';
                                echo '</td>';
                                echo '<td>$'.number_format($invoice_information->lb_invoice_total_after_taxes,2).'</td>';
                                echo '</tr>';
                                $subtotal = $subtotal+$invoice_information->lb_invoice_total_after_discounts;
                                $tax = $tax+$totaltax;
                                $total = $total+$invoice_information->lb_invoice_total_after_taxes;
                                $totalAll = $totalAll + $invoice_information->lb_invoice_total_after_taxes;
                                $subtotalAll = $subtotalAll+$invoice_information->lb_invoice_total_after_discounts;
                                $taxAll = $taxAll+$totaltax;
                            }
                            ?>
                    
                    <?php if(count($a) > 0 && $total > 0)
                    {?>
                        <tr>
                            <td colspan="3" ><b><?php echo $YStart.'-'.$MStart?></b></td>
                            <td style="border-top:1px solid #000"><b><?php echo '$'.$subtotal;?></b></td>
                            <td style="border-top:1px solid #000"><b><?php echo '$'.$tax;?></b></td>
                            <td style="border-top:1px solid #000"><b><?php echo '$'.$total;?></b></td>
                            
                        </tr>
                    <?php } ?>
                    
        <?php 
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
         }
        else
        {
            
            $customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
            
            while(strtotime($FromDate) < strtotime($Todate))
            {
            $arrDate = dateMY($FromDate);
            $subtotal = 0;
            $tax = 0;
            $total = 0;
            $YStart = $arrDate[0];
            $MStart = $arrDate[1];
            
            $numberDate = $YStart.'-'.$MStart.'-'.numberDate($YStart, $MStart);
            $date_To = date('Y-m-d',  strtotime ($numberDate));
            
            $MEnd = dateMY($Todate)[1];
            $YEnd = dateMY($Todate)[0];
            if($YStart == $YEnd && $MStart == $MEnd)
           {
                $a = LbInvoice::model()->getInvoiceMonth(false,$FromDate,$Todate,false,false);
            }else            
                $a = LbInvoice::model()->getInvoiceMonth(false,$FromDate,$numberDate,false,false);

           
            
            ?>

                    
                  
                            <?php
                            foreach ($a as $data)
                            {
                                $customer_id = false;
                                if(LbCustomer::model()->isCustomer($data->lb_invoice_customer_id) != null)
                                {
                                $invoice_information = LbInvoiceTotal::model()->getInvoiceById($data->lb_record_primary_key);
                                $invoiceTax = LbInvoiceItem::model()->getInvoiceTaxById($data->lb_record_primary_key,"TAX");
                                echo '<tr>';
                                echo '<td>'.$data->lb_invoice_no.'</td>';
                                echo '<td>'.$data->lb_invoice_date.'</td>';
                                echo '<td>';
                                
                                if($data->lb_invoice_customer_id)
                                {
                                    $customer_id = $data->lb_invoice_customer_id;
//                                   
                                        echo LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];
                                }
                               
                                echo '</td>';
                                echo '<td>$'.number_format($invoice_information->lb_invoice_total_after_discounts,2).'</td>';
                                echo '<td>';
                                $totalTax=0;
                                if($invoiceTax)
                                {
                                    $totaltax = $invoice_information->lb_invoice_total_after_taxes-$invoice_information->lb_invoice_total_after_discounts;
                                    echo '$'.number_format($totaltax,2);
                                }else
                                    echo '$0.00';
                                echo '</td>';
                                echo '<td>$'.number_format($invoice_information->lb_invoice_total_after_taxes,2).'</td>';
                                echo '</tr>';
                                $subtotal = $subtotal+$invoice_information->lb_invoice_total_after_discounts;
                                $tax = $tax+$totaltax;
                                $total = $total+$invoice_information->lb_invoice_total_after_taxes;
                                $totalAll = $totalAll + $invoice_information->lb_invoice_total_after_taxes;
                                $subtotalAll = $subtotalAll+$invoice_information->lb_invoice_total_after_discounts;
                                $taxAll = $taxAll+$totaltax;
                                }
                            }
                            ?>
                    
                    <?php if(count($a) > 0 && $total>0)
                    {?>
                        <tr>
                            <td colspan="3" ><b><?php echo $YStart.'-'.$MStart?></b></td>
                            <td style="border-top:1px solid #000"><b><?php echo '$'.number_format($subtotal,2);?></b></td>
                            <td style="border-top:1px solid #000"><b><?php echo '$'.number_format($tax,2);?></b></td>
                            <td style="border-top:1px solid #000"><b><?php echo '$'.number_format($total,2);?></b></td>
                            
                        </tr>
                    <?php } ?>
                    
        <?php 
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
           
           }
           
        ?>
                        <tfoot>
                            <?php
                                echo '<tr >';
                                echo '<td colspan="3" style="border-top:1px solid #000" ><b>TOTAL</b></td>';
                                echo '<td style="border-top:1px solid #000"><b>'.number_format($subtotalAll,2).'</b></td>';
                                echo '<td style="border-top:1px solid #000"><b>'.number_format($taxAll,2).'</b></td>';
                                echo '<td style="border-top:1px solid #000"><b>'.number_format($totalAll,2).'</b></td>';
                                echo '</tr>';
                            ?>
                        </tfoot>
     </table>   
  </fieldset>

</form>
         





<script type="text/javascript">
    function printPDF_invoice_Journal() {
        var customer_id_journal = 0;
        if($('#customer_id_journal').val() > 0)
            customer_id_journal = $('#customer_id_journal').val();
//        alert(customer_id_journal);
      window.open('PDFInvoiceJournal?customer_id='+customer_id_journal+'&search_date_from=<?php echo $date_from; ?>&search_date_to=<?php echo $date_to ?>', '_target');
     
    }
</script>
