<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$customer_id = FALSE;
if(isset($_POST['customer_id_saleReport']))
    $customer_id = $_POST['customer_id_saleReport'];
$date_from = date('Y-m-d');
$date_to = date('Y-m-d',strtotime("+1 month -1 day"));

if(isset($_POST['search_data_from_saleReport']) && $_POST['search_data_from_saleReport']!="")
    $date_from = date('Y-m-d',  strtotime ($_POST['search_data_from_saleReport']));
if(isset($_POST['search_data_to_saleReport']) && $_POST['search_data_to_saleReport']!="")
    $date_to = date('Y-m-d',  strtotime ($_POST['search_data_to_saleReport']));
$customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
$a = LbInvoice::model()->getInvoiceMonth($customer_id,$date_from,$date_to);
?>
<input hidden="true" id="customer_id_sale" value ='<?php echo $customer_id; ?>'/>
<div style="width:100%;margin-top:10px;margin-bottom:3px;">
   
<button class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_saleReport(); return false;">Print PDF</button>
</div>
<form>
    <fieldset>
        <table border="0" width="100%" class="items table table-bordered">
                    <thead>
                        <tr>
                            <th width="100" class="lb-grid-header"><?php echo Yii::t('lang','Date'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Number'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Customer'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Total'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Paid'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Amount'); ?></th>
                            <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Due'); ?></th>

                            
                        </tr>
                    </thead>
                    <?php if($customer_id > 0)
                                { ?>
                    <tbody>
                            <?php
                            $invoiceValue = 0;
                            $AllPaid = 0;
                            $invoiceDue = 0;
                            
                            foreach ($a as $data)
                            {
                                $customer_id = false;
                                
                                $invoice_information = LbInvoiceTotal::model()->getInvoiceById($data->lb_record_primary_key);
                                $invoiceTax = LbInvoiceItem::model()->getInvoiceTaxById($data->lb_record_primary_key,"TAX");
                                echo '<tr>';
                                
                                echo '<td>'.$data->lb_invoice_date.'</td>';
                                echo '<td>'.$data->lb_invoice_no.'</td>';
                                echo '<td>';
                                
                                if($data->lb_invoice_customer_id)
                                {
                                    $customer_id = $data->lb_invoice_customer_id;
                                    echo LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];
                                }
                                
                                echo '</td>';
                                $invoiceValue = $invoiceValue+$invoice_information->lb_invoice_total_after_taxes;
                                echo '<td>$'.$invoice_information->lb_invoice_total_after_taxes.'</td>';
                                echo '<td>';
                                
                                $totalPaid = LbInvoiceTotal::model()->find('lb_invoice_id='.  intval($data->lb_record_primary_key));
                                $AllPaid = $AllPaid + $totalPaid->lb_invoice_total_paid;
                                echo $totalPaid->lb_invoice_total_paid;
                                echo '</td>';
                                echo '<td>';
                                echo $totalPaid->lb_invoice_total_paid;
                                echo '</td>';
                                $invoiceDue = $invoiceDue+$totalPaid->lb_invoice_total_outstanding;
                                echo '<td>$'.$totalPaid->lb_invoice_total_outstanding.'</td>';
                              
                                echo '</tr>';
                            }
                            ?>
                    </tbody>
           
                   <tfoot>
                        <td colspan="3"><b>Sub Total</b></td>
                        <td align="right" style="border-top:1px solid #000">
                        <b><?php echo '$'.number_format($invoiceValue,2);?></b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b><?php echo '$'.number_format($AllPaid,2);?></b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b><?php echo '$'.number_format($AllPaid,2);?></b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b><?php echo '$'.number_format($invoiceDue,2);?></b>
                        </td>
                        
                        
                    </tfoot>
                <?php } 
            else {
                ?>
                    <tbody>
                    <?php
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
                                echo '<tr>';
                                
                                echo '<td>'.$data->lb_invoice_date.'</td>';
                                echo '<td>'.$data->lb_invoice_no.'</td>';
                                echo '<td>';
                                
                                if($data->lb_invoice_customer_id)
                                {
                                    $customer_id = $data->lb_invoice_customer_id;
                                    echo LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];
                                }
                                
                                echo '</td>';
                                $invoiceValue = $invoiceValue+$invoice_information->lb_invoice_total_after_taxes;
                                echo '<td>$'.$invoice_information->lb_invoice_total_after_taxes.'</td>';
                                echo '<td>';
                                
                                $totalPaid = LbInvoiceTotal::model()->find('lb_invoice_id='.  intval($data->lb_record_primary_key));
                                $AllPaid = $AllPaid + $totalPaid->lb_invoice_total_paid;
                                echo $totalPaid->lb_invoice_total_paid;
                                echo '</td>';
                                echo '<td>';
                                echo $totalPaid->lb_invoice_total_paid;
                                echo '</td>';
                                $invoiceDue = $invoiceDue+$totalPaid->lb_invoice_total_outstanding;
                                echo '<td>$'.$totalPaid->lb_invoice_total_outstanding.'</td>';
                              
                                echo '</tr>';
                    }
                 }
                 ?>
                    </tbody>
                <tfoot>
                        <td colspan="3"><b>Sub Total</b></td>
                        <td align="right" style="border-top:1px solid #000">
                        <b><?php echo '$'.number_format($invoiceValue,2);?></b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b><?php echo '$'.number_format($AllPaid,2);?></b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b><?php echo '$'.number_format($AllPaid,2);?></b>
                        </td>
                        <td align="right" style="border-top:1px solid #000">
                        <b><?php echo '$'.number_format($invoiceDue,2);?></b>
                        </td>
                        
                        
                    </tfoot>  
            <?php } ?>

    
        </table>
       
  </fieldset>

</form>

<script type="text/javascript">
    function printPDF_saleReport() {
        var customer_id=0;
        if($('#customer_id_sale').val() > 0)
                customer_id = $('#customer_id_sale').val();
        window.open('pdfSale?customer='+customer_id+'&search_date_from=<?php echo $date_from; ?>&search_date_to=<?php echo $date_to ?>', '_target');
        
    }
</script>