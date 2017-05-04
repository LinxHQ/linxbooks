<?php
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');

//$method = LBPayment::model()->method;
$customer_id =false;
if(isset($_POST['customer_id_gstReport']) && $_POST['customer_id_gstReport'] > 0)
    $customer_id=$_POST['customer_id_gstReport'];
//echo $customer_id;
$date_from = date('Y-m-d');
$date_to = date('Y-m-d',strtotime("+1 month -1 day"));

if(isset($_POST['search_data_from_gstReport']) && $_POST['search_data_from_gstReport']!="")
    $date_from = date('Y-m-d',  strtotime ($_POST['search_data_from_gstReport']));
if(isset($_POST['search_data_to_gstReport']) && $_POST['search_data_to_gstReport']!="")
    $date_to = date('Y-m-d',  strtotime ($_POST['search_data_to_gstReport']));

$timestamp    = strtotime('2014-04');
$first_second = date('m-01-Y 00:00:00', $timestamp);
$last_second  = date('Y-m-t', $timestamp);


$customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
$a = LbInvoice::model()->getInvoiceMonth($customer_id,$date_from,$date_to);



?>
<input hidden="true" id="customer_id" value ='<?php echo $customer_id; ?>'/>
<div style="width:100%;margin-top:10px;margin-bottom:3px;">
   
<button class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_gstReport(); return false;">Print PDF</button>
</div>
<form>
    <fieldset>
        <table border="0" width="100%" class="items table table-bordered">
                    <thead>
                        <tr>
                            <th width="250" class="lb-grid-header"><?php echo Yii::t('lang','Number'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Date'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Customer'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Invoice Value'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','GST Collected'); ?></th>

                            
                        </tr>
                    </thead>
                    <?php if($customer_id > 0)
                    {?>
                    <tbody>
                            <?php
                            $invoiceValue=0;
                            $gst = 0;
                            foreach ($a as $data)
                            {
                               $customer_id = false;
                                
                                $invoice_information = LbInvoiceTotal::model()->getInvoiceById($data->lb_record_primary_key);
                                $invoiceTax = LbInvoiceItem::model()->getInvoiceTaxById($data->lb_record_primary_key,"TAX");
                                                                $invoiceValue = $invoiceValue+$invoice_information->lb_invoice_total_after_discounts;

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
                                echo '<td>$'.$invoice_information->lb_invoice_total_after_discounts.'</td>';
                                echo '<td>';
                                $totalTax=0;
                                if($invoiceTax)
                                {
                                    $totaltax = $invoice_information->lb_invoice_total_after_taxes-$invoice_information->lb_invoice_total_after_discounts;
                                    
                                    echo '$'.$totaltax;
                                }else
                                    echo '$0.00';
                                echo '</td>';
                                
                                echo '</tr>';
                                $gst = $gst+($invoice_information->lb_invoice_total_after_taxes-$invoice_information->lb_invoice_total_after_discounts);
                            }
                            ?>
                        
                    </tbody>
           
                    <tfoot>
                        <td colspan="3"><b>Total</b></td>
                        <td align="right" style="border-top:1px solid #000">
                        <b><?php echo '$'.$invoiceValue;?></b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b><?php echo '$'.$gst;?></b>
                        </td>
                        
                    </tfoot>
  
                    <?php } 
                    else
                    {
                        $customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
                        $invoiceValue=0;
                            $gst = 0;
                        foreach ($customer_arr as $customer)
                        { ?>
                            <tbody>
                            <?php
                            $a = LbInvoice::model()->getInvoiceMonth($customer['lb_record_primary_key'],$date_from,$date_to);

                            
                            foreach ($a as $data)
                            {
                               $customer_id = false;
                                
                                $invoice_information = LbInvoiceTotal::model()->getInvoiceById($data->lb_record_primary_key);
                                $invoiceTax = LbInvoiceItem::model()->getInvoiceTaxById($data->lb_record_primary_key,"TAX");
                                                                $invoiceValue = $invoiceValue+$invoice_information->lb_invoice_total_after_discounts;

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
                                echo '<td>$'.$invoice_information->lb_invoice_total_after_discounts.'</td>';
                                echo '<td>';
                                $totalTax=0;
                                if($invoiceTax)
                                {
                                    $totaltax = $invoice_information->lb_invoice_total_after_taxes-$invoice_information->lb_invoice_total_after_discounts;
                                    
                                    echo '$'.$totaltax;
                                }else
                                    echo '$0.00';
                                echo '</td>';
                                
                                echo '</tr>';
                                $gst = $gst+($invoice_information->lb_invoice_total_after_taxes-$invoice_information->lb_invoice_total_after_discounts);
                            }
                            ?>
                        
                    </tbody>
           
                    
                       
                        
                    <?php 
                        }
                        ?>
                    <tfoot>
                        <td colspan="3"><b>Total</b></td>
                        <td align="right" style="border-top:1px solid #000">
                            <b><?php echo '$'.number_format($invoiceValue,2);?></b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                            <b><?php echo '$'.number_format($gst,2);?></b>
                        </td>
                        
                    </tfoot>
                       
                    <?php
                                } ?>

                    
        </table>
       
  </fieldset>

</form>
         





<script type="text/javascript">
    function printPDF_gstReport() {
        
            var customer_id=0;
            if($('#customer_id').val() > 0)
                customer_id = $('#customer_id').val();
            window.open('pdfGstReport?customer='+customer_id+'&search_date_from=<?php echo $date_from; ?>&search_date_to=<?php echo $date_to ?>', '_target');
        
    }
</script>
<style>
.ui-state-default {
    /*background: url("images/ui-bg_glass_85_dfeffc_1x400.png") repeat-x scroll 50% 50% #bfdc7a;*/
    border: 1px solid #c5dbec;
  
    font-weight: normal;
    outline: medium none;
}
</style>
