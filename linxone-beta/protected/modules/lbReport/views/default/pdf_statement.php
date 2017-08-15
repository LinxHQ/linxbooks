<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$current_data_cash = date('d-m-Y');
$lastMonth_data = date('d-m-Y',strtotime("+1 month -1 day"));
$customer_id = FALSE;
if(isset($_GET['customer_id_saleReport']))
    $customer_id = $_GET['customer_id_saleReport'];
$date_from = date('Y-m-d');
$date_to = date('Y-m-d',strtotime("+1 month -1 day"));

if(isset($_GET['search_date_from']) && $_GET['search_date_from']!="")
    $date_from = date('Y-m-d',  strtotime ($_GET['search_date_from']));
if(isset($_GET['search_data_to_statements']) && $_GET['search_data_to_statements']!="")
    $date_to = date('Y-m-d',  strtotime ($_GET['search_date_from']));
$customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
$customer_option = LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);

$statusNumber=false;
$status = false;
$attention_statement = false;
$customer_id_statements = false;
$address_option = false;


if(isset($_GET['statusNumber']))
    $statusNumber = $_GET['statusNumber'];
if($statusNumber == 1)
    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")';
if(isset($_GET['attention']) && $_GET['attention'] > 0)
    $attention_statement = $_GET['attention'];
if(isset($_GET['customer']))
    $customer_id_statements = $_GET['customer'];

if($statusNumber == 2)
    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_PAID.'")';

if($_GET['address'] && $_GET['address'] > 0)
    $address_option = $_GET['address'];

if($statusNumber == 0)
    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_PAID.'")';

//$contactModel = LbCustomerContact::model()->getContacts(4,LbCustomerContact::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
$a=  LbInvoice::model()->getInvoiceStatement($customer_id_statements,$_GET['attention'],$address_option,$status,$date_from,$date_to);

 $company = (isset($model->owner) ? $model->lb_invoice_company_id : '');
                        $folder ='images/logo/';
            $path = YII::app()->baseUrl."/images/logo/";
            
            $filename = '';
            $file_arr = array_diff(scandir($folder),array('.','..'));
            $subcription = LBApplication::getCurrentlySelectedSubscription();
            foreach ($file_arr as $key => $file) {
                 $file_name = explode('.', $file); 
                 $file_name_arr = explode('_', $file_name[0]);
//                 print_r($file_name_arr);
                 if($file_name_arr[0] == $subcription && $file_name_arr[1] == $company)
                    echo "<img src='".$path.$file."' style='max-height:120px' />";
            }
?>

      
                        <?php
                        $customer_name = LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];
                        
                        echo  '
                            <table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
                            <tr><td><table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
                            <tr><td >
                             <span style="font-size:20px;font-weight:bold;">Statement</span>

                            </td></tr>
                            </table>
                            </td></tr>
                            <tr><td >
                            <table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
                            <tr><td >
                             <span style="margin:10px;padding:10px">From: '.$date_from.'</span>
                             <span style="margin:10px;">To: '.$date_to.'</span>
                                 
                            </td></tr></table>
                            
                         </td></tr>
                            
                            </table>';
                        echo '<table border="0" style="width:100%;" cellpadding="0" cellspacing="0">
                            <tr><td >
                             <span style="fload:left"><b>Bill To: </b>'.$customer_name.'</span></td></tr>';
                        if($_GET['attention'] > 0)
                        {
                         $attention_name = LbCustomerContact::model()->find('lb_record_primary_key='.$_GET['attention']);
                         echo'   <tr><td> <span style="fload:left"><b>Attention: </b>'.$attention_name['lb_customer_contact_first_name'].' '.$attention_name['lb_customer_contact_last_name'].'</span>
                                 
                            </td></tr>
                            ';
                        }
                        echo '</table>';
//                                <div style="width:80%;border: 1px solid #CCCCCC;padding:15px;">
                        echo '<br /><br />';
                            if($address_option)
                            {
                                
                                tableSearch($customer_id_statements,$_GET['attention'],$address_option,$status,$date_from,$date_to);
                            }
                            else
                            {
                                $outstanding = 0;
                                $paid = 0;
                                $tax = 0;
                               
                               $StatementSearch=  LbInvoice::model()->getInvoiceStatement($customer_id_statements,$_GET['attention'],$address_option,$status,$date_from,$date_to);
                               $addressAll = LbCustomerAddress::model()->getAddressesByCustomer($customer_id_statements);
                               $valuePaid = 0;
                               $valueAmount =0;
                               $valueDue = 0;
                               global $valuePaid,$valueDue,$valueAmount;
                               foreach ($addressAll as $value)
                               {
                                   
                                   tableSearch($customer_id_statements,$_GET['attention'],$value['lb_record_primary_key'],$status,$date_from,$date_to);
                                   
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
                                            <th width="100" class="lb-grid-header">'. Yii::t('lang','Payments').'</th>
                                            <th width="150" class="lb-grid-header">'. Yii::t('lang','Due').'</th>


                                        </tr>
                                    </thead>';
                                    
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
                                            $valuePaid =$valuePaid +  $getInvoiceById['lb_invoice_total_paid'];
                                            $valuePaid = $valuePaid + $getInvoiceById['lb_invoice_total_paid'];
                                            $valueAmount = $valueAmount + $getInvoiceById['lb_invoice_total_after_taxes'];
                                            $valueDue = $valueDue +$getInvoiceById['lb_invoice_total_outstanding'];
                                            echo '</tr>';
                                        }

                                    }
                                    
                                    
                                        echo '<tr>';
                                    echo '<td colspan="2"></td>';
                                    
                                    echo '<td style="border-top:1px solid #000; " ><b>$'.number_format($tax,2).'</b></td>';
                                    echo '<td style="border-top:1px solid #000"><b>$'.number_format($paid,2).'</b></td>';
                                    echo '<td style="border-top:1px solid #000">$<b>'.number_format($outstanding,2).'</b></td>';

                                    echo '</tr>'
                                    
                                        
                                    . '</table>';
                                        }
                                        break;

                                }
                                echo '<table border="0" width="100%" class="items table table-bordered">
                                       
                                        <tr>
                                            <td width="250" style="border-top:1px solid #000; "><b>Total</b></td>
                                            <td width="150" style="border-top:1px solid #000; "></td>
                                            <td width="150" style="border-top:1px solid #000; "><b>$'.number_format($valueAmount,2).'</b></td>
                                            <td width="100" style="border-top:1px solid #000; "><b>$'.number_format($valuePaid,2).'</b></td>
                                            <td width="150" style="border-top:1px solid #000; "><b>$'.number_format($valueDue,2).'</b></td>


                                        </tr></table>
                                    ';
                                
                            }
                            
                            
                        ?>
                
   
<?php
function tableSearch($customer_id_statements=false,$attention_statement = false,$address_option=false,$status=false,$date_from=false,$date_to=false)
{
    global $valuePaid;
    global $valueAmount;
     global $valueDue ;
    $StatementSearch=  LbInvoice::model()->getInvoiceStatement($customer_id_statements,$_GET['attention'],$address_option,$status,$date_from,$date_to);
$outstanding = 0;
    $paid = 0;
    $tax = 0;
                              if(count($StatementSearch) > 0)
                              {
                                  if($address_option)
                                        $addName = LbCustomerAddress::model()->find('lb_record_primary_key='.$address_option);
                                  echo '<span style="font-size: 16px;"><b>Address: </b>'.$addName->lb_customer_address_line_1.'</span><br />';
                                  echo '
                                    <table border="0" width="100%" class="items table table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="250" class="lb-grid-header">'.Yii::t('lang','Date').'</th>
                                        <th width="150" class="lb-grid-header">'. Yii::t('lang','Invoice Number').'</th>
                                        <th width="150" class="lb-grid-header">'. Yii::t('lang','Amount').'</th>
                                        <th width="100" class="lb-grid-header">'. Yii::t('lang','Payments').'</th>
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
                                    $valuePaid = $valuePaid + $getInvoiceById['lb_invoice_total_paid'];
                                    $valueAmount = $valueAmount + $getInvoiceById['lb_invoice_total_after_taxes'];
                                    $valueDue = $valueDue +$getInvoiceById['lb_invoice_total_outstanding'];
                                    echo '<tr>';
                                    echo '<td>'.$data['lb_invoice_date'].'</td>';
                                    echo '<td>'.$data['lb_invoice_no'].'</td>';
                                    echo '<td>'.$getInvoiceById['lb_invoice_total_after_taxes'].'</td>';
                                    echo '<td>'.$getInvoiceById['lb_invoice_total_paid'].'</td>';
                                    echo '<td>'.$getInvoiceById['lb_invoice_total_outstanding'].'</td>';

                                    echo '</tr>';

                                }
                                 echo '</tbody>'
                                . '<tfoot>';
                                        echo '<tr>';
                                    echo '<td colspan="2"></td>';
                                    
                                    echo '<td style="border-top:1px solid #000; " ><b>$'.number_format($tax,2).'</b></td>';
                                    echo '<td style="border-top:1px solid #000"><b>$'.number_format($paid,2).'</b></td>';
                                    echo '<td style="border-top:1px solid #000">$<b>'.number_format($outstanding,2).'</b></td>';

                                    echo '</tr>'
                                        . '</tfoot>'
                                        
                                . '</table>';
                              }
}
?>