<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$current_data_cash = date('d-m-Y');
$lastMonth_data = date('d-m-Y',strtotime("+1 month -1 day"));
$customer_id = FALSE;
if(isset($_POST['customer_id_saleReport']))
    $customer_id = $_POST['customer_id_saleReport'];
$date_from = date('Y-m-d');
$date_to = date('Y-m-d',strtotime("+1 month -1 day"));

if(isset($_POST['search_data_from_statements']) && $_POST['search_data_from_statements']!="")
    $date_from = date('Y-m-d',  strtotime ($_POST['search_data_from_statements']));
if(isset($_POST['search_data_to_statements']) && $_POST['search_data_to_statements']!="")
    $date_to = date('Y-m-d',  strtotime ($_POST['search_data_to_statements']));
$customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
$customer_option = LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);

$statusNumber=false;
$status = false;
$attention_statement = false;
$customer_id_statements = false;
$address_option = false;


if(isset($_POST['invoice_option']))
    $statusNumber = $_POST['invoice_option'];
if($statusNumber == 1)
    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")';
if($_POST['attention_statement'])
    $attention_statement = $_POST['attention_statement'];
if($_POST['customer_id_statements'])
    $customer_id_statements = $_POST['customer_id_statements'];

if($statusNumber == 2)
    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_PAID.'")';

if($_POST['address_option'] && $_POST['address_option'] > 0)
    $address_option = $_POST['address_option'];

if($statusNumber == 0)
    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_PAID.'")';

//$contactModel = LbCustomerContact::model()->getContacts(4,LbCustomerContact::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
$a=  LbInvoice::model()->getInvoiceStatement($customer_id_statements,$_POST['attention_statement'],$address_option,$status,$date_from,$date_to);


?>
<button class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_statement(); return false;">Print PDF</button><br>
<form>
    <fieldset>
        

      
                        <?php
//                                <div style="width:80%;border: 1px solid #CCCCCC;padding:15px;">
                            $outstanding = 0;
                            $paid = 0;
                            $tax = 0;
                            if($address_option)
                            {
                                
                                tableSearch($customer_id_statements,$_POST['attention_statement'],$address_option,$status,$date_from,$date_to);
                            }
                            else
                            {
                                $valuePaid = 0;
                               $valueAmount =0;
                               $valueDue = 0;
                               global $valuePaid,$valueDue,$valueAmount;
                               $StatementSearch=  LbInvoice::model()->getInvoiceStatement($customer_id_statements,$_POST['attention_statement'],$address_option,$status,$date_from,$date_to);
                               $addressAll = LbCustomerAddress::model()->getAddressesByCustomer($customer_id_statements);
                               
                               foreach ($addressAll as $value)
                               {
                                   
                                   tableSearch($customer_id_statements,$_POST['attention_statement'],$value['lb_record_primary_key'],$status,$date_from,$date_to);
                               }
                               
                               foreach ($StatementSearch as $data)
                                {
                                   $addName = false;
                                   if($data['lb_invoice_customer_address_id'] != '')
                                        $addName = LbCustomerAddress::model()->find('lb_record_primary_key='.$data['lb_invoice_customer_address_id']); 
                                    if(count($addName) == 0)
                                    {
                                        
                                        echo '<b>Address: </b>
                                        <table border="0" width="100%" class="items table table-bordered">
                                        <thead>
                                        <tr>
                                            <th width="250" class="lb-grid-header">'.Yii::t('lang','Date').'</th>
                                            <th width="150" class="lb-grid-header">'. Yii::t('lang','Invoice Number').'</th>
                                            <th width="150" class="lb-grid-header">'. Yii::t('lang','Amount').'</th>
                                            <th width="150" class="lb-grid-header">'. Yii::t('lang','Payments').'</th>
                                            <th width="150" class="lb-grid-header">'. Yii::t('lang','Due').'</th>


                                        </tr>
                                    </thead>
                                     <tbody>';
                                    foreach ($StatementSearch as $data)
                                    {
                                        $getInvoiceById = LbInvoiceTotal::model()->getInvoiceById($data['lb_record_primary_key']);
                                        $addArr = LbInvoice::model()->findAll('lb_invoice_customer_address_id='.$data['lb_invoice_customer_address_id']);
                                        $addName = LbCustomerAddress::model()->find('lb_record_primary_key='.$data['lb_invoice_customer_address_id']);   
                                        if(count($addName) == 0)
                                        {
                                        echo '<tr>';
                                        echo '<td>'.$data['lb_invoice_date'].'</td>';
                                        echo '<td>'.$data['lb_invoice_no'].'</td>';
                                        echo '<td>'.$getInvoiceById['lb_invoice_total_after_taxes'].'</td>';
                                        echo '<td>'.$getInvoiceById['lb_invoice_total_paid'].'</td>';
                                        echo '<td>'.$getInvoiceById['lb_invoice_total_outstanding'].'</td>';
                                        $outstanding = $outstanding + $getInvoiceById['lb_invoice_total_outstanding'];
                                        $paid = $paid + $getInvoiceById['lb_invoice_total_paid'];
                                        $tax = $tax + $getInvoiceById['lb_invoice_total_after_taxes'];
                                        echo '</tr>';
                                        $valuePaid = $valuePaid + $getInvoiceById['lb_invoice_total_paid'];
                                        $valueAmount = $valueAmount + $getInvoiceById['lb_invoice_total_after_taxes'];
                                        $valueDue = $valueDue +$getInvoiceById['lb_invoice_total_outstanding'];
                                        }

                                    }
                                    echo '</tbody> '
                                   . '<tfoot>';
                                        echo '<tr>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td style="border-top:1px solid #000" ><b>$'.number_format($tax,2).'</b></td>';
                                    echo '<td style="border-top:1px solid #000"><b>$'.number_format($paid,2).'<b></td>';
                                    echo '<td style="border-top:1px solid #000"><b>$'.number_format($outstanding,2).'</b></td>';

                                    echo '</tr>'
                                        . '</tfoot>'
                                        
                                    . '</table>';
                                        }
                                        break;

                                }
                                echo '<table border="0" width="100%" class="items table table-bordered">
                                       
                                        <tr>
                                            <td width="250" style="border-top:1px solid #000; "><b>Total</b></td>
                                            <td width="150" style="border-top:1px solid #000; "></td>
                                            <td width="150" style="border-top:1px solid #000; "><b>$'.number_format($valueAmount,2).'</b></td>
                                            <td width="150" style="border-top:1px solid #000; "><b>$'.number_format($valuePaid,2).'</b></td>
                                            <td width="150" style="border-top:1px solid #000; "><b>$'.number_format($valueDue,2).'</b></td>


                                        </tr></table>
                                    ';
                            }
                            
                            
                        ?>
                
    </fieldset>
</form>
<?php
function tableSearch($customer_id_statements=false,$attention_statement = false,$address_option=false,$status=false,$date_from=false,$date_to=false)
{
    $outstanding = 0;
    $paid = 0;
    $tax = 0;
    global $valuePaid;
    global $valueAmount;
     global $valueDue ;
    $StatementSearch=  LbInvoice::model()->getInvoiceStatement($customer_id_statements,$_POST['attention_statement'],$address_option,$status,$date_from,$date_to);
//    $addName = LbCustomerAddress::model()->find('lb_record_primary_key='.$address_option);
//    echo '<span style="font-size: 16px;"><b>Address: </b>'.$addName->lb_customer_address_line_1.'</span><br />';
                              if(count($StatementSearch) > 0)
                              {
                                  
                                  if(isset($address_option))
                                        $addName = LbCustomerAddress::model()->find('lb_record_primary_key='.$address_option);
                                echo '<span style="font-size: 16px;"><b>Address: </b>'.$addName->lb_customer_address_line_1.'</span><br />';
                                echo '
                                    <table border="0" width="100%" class="items table table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="250" class="lb-grid-header">'.Yii::t('lang','Date').'</th>
                                        <th width="150" class="lb-grid-header">'. Yii::t('lang','Invoice Number').'</th>
                                        <th width="150" class="lb-grid-header">'. Yii::t('lang','Amount').'</th>
                                        <th width="150" class="lb-grid-header">'. Yii::t('lang','Payments').'</th>
                                        <th width="150" class="lb-grid-header">'. Yii::t('lang','Due').'</th>


                                    </tr>
                                </thead>
                                 <tbody>';
                                foreach ($StatementSearch as $data)
                                {
                                    $getInvoiceById = LbInvoiceTotal::model()->getInvoiceById($data['lb_record_primary_key']);
                                    $addArr = LbInvoice::model()->findAll('lb_invoice_customer_address_id='.$data['lb_invoice_customer_address_id']);
                                    $outstanding = $outstanding + $getInvoiceById['lb_invoice_total_outstanding'];
                                    $paid = $paid + $getInvoiceById['lb_invoice_total_paid'];
                                    $tax = $tax + $getInvoiceById['lb_invoice_total_after_taxes'];
                                    echo '<tr>';
                                    echo '<td>'.$data['lb_invoice_date'].'</td>';
                                    echo '<td>'.$data['lb_invoice_no'].'</td>';
                                    echo '<td>'.$getInvoiceById['lb_invoice_total_after_taxes'].'</td>';
                                    echo '<td>'.$getInvoiceById['lb_invoice_total_paid'].'</td>';
                                    echo '<td>'.$getInvoiceById['lb_invoice_total_outstanding'].'</td>';

                                    echo '</tr>';
                                    $valuePaid = $valuePaid + $getInvoiceById['lb_invoice_total_paid'];
                                    $valueAmount = $valueAmount + $getInvoiceById['lb_invoice_total_after_taxes'];
                                    $valueDue = $valueDue +$getInvoiceById['lb_invoice_total_outstanding'];

                                }
                                echo '</tbody>'
                                 . '<tfoot>';
                                        echo '<tr>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td style="border-top:1px solid #000" ><b>$'.number_format($tax,2).'</b></td>';
                                    echo '<td style="border-top:1px solid #000"><b>$'.number_format($paid,2).'<b></td>';
                                    echo '<td style="border-top:1px solid #000"><b>$'.number_format($outstanding,2).'</b></td>';

                                    echo '</tr>'
                                        . '</tfoot>'
                                        
                                . '</table>';
                              }
}
?>

<script type="text/javascript">
    function printPDF_statement() {
        window.open('PDFStatement?customer=<?php echo $customer_id_statements;?>&attention=<?php echo $attention_statement;?>&address=<?php echo $address_option;?>&statusNumber=<?php echo $statusNumber;?>&search_date_from=<?php echo $date_from; ?>&search_date_to=<?php echo $date_to ?>', '_target');
    }
</script>