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

if(isset($_POST['search_data_from_saleReport']) && $_POST['search_data_from_saleReport']!="")
    $date_from = date('Y-m-d',  strtotime ($_POST['search_data_from_saleReport']));
if(isset($_POST['search_data_to_saleReport']) && $_POST['search_data_to_saleReport']!="")
    $date_to = date('Y-m-d',  strtotime ($_POST['search_data_to_saleReport']));
$customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
$customer_option = LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
$customer_option=array(0=>'All')+$customer_option;
$contact_option = array(0=>'All');
$address_option = array(0=>'All');
$invoice_option = array(0=>'All','Oustanding','Paid');
$status=false;

//if($_POST['invoice_option'] == 1)
//    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.  LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")';
//if($_POST['invoice_option'] == 2)
//    $status = '("'.LbInvoice::LB_INVOICE_STATUS_CODE_PAID.'")';

//$contactModel = LbCustomerContact::model()->getContacts(4,LbCustomerContact::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
//$a=  LbInvoice::model()->getInvoiceStatement(5,0,2,$status,'2014-07-01','2015-06-01');
//echo '<pre>';
//print_r($a[0]['lb_invoice_no']);

?>

<table>
    <tr>
        <td><span style="font-size: 16px;"><?php echo Yii::t('lang','Customer name');?>:</span> </td>
        <td><?php echo CHtml::dropDownList('customer_statement','', $customer_option,array('class'=>'span4','onchange'=>'changeCustomer();')); ?></td>
    </tr>
    <tr>
        <td><span style="font-size: 16px;"><?php echo Yii::t('lang','Attention:');?>:</span> </td>
        <td><?php echo CHtml::dropDownList('attention_statement','', $contact_option,array('class'=>'span4')); ?></td>
    </tr>
    <tr>
        <td><span style="font-size: 16px;"><?php echo Yii::t('lang','Address:');?>:</span> </td>
        <td><?php echo CHtml::dropDownList('address_option','', $address_option,array('class'=>'span4')); ?></td>
    </tr>
    <tr>
        <td><span style="font-size: 16px;"><?php echo Yii::t('lang','Load Invoice:');?>:</span> </td>
        <td><?php echo CHtml::dropDownList('invoice_option','', $invoice_option,array('class'=>'span4')); ?></td>
        <td>
            <?php echo CHtml::label(Yii::t('lang','From'), "search_data_from_statements",array('style'=>'display:inline;margin-left: 15px;'));?>
            <?php $this->widget('ext.rezvan.RDatePicker',array(
                        'name'=>'search_data_from_statements',
                        'value'=>  $current_data_cash,
                        'options' => array(
                            'format' => 'dd-mm-yyyy',
                            'viewformat' => 'dd-mm-yyyy',
                            'placement' => 'right',
                            'todayBtn'=>true,
                        ),
                        'htmlOptions'=>array('class'=>'span2','placeholder'=>'Date from','style'=>'margin-top: 8px;margin-right: 15px;'),
                    ));
                ?>
        </td>
        <td>
            <?php echo CHtml::label(Yii::t('lang','To'), "search_data_to_statements",array('style'=>'display:inline'));?>
            <?php $this->widget('ext.rezvan.RDatePicker',array(
                        'name'=>'search_data_to_statements',
                        'value'=>  $lastMonth_data,
                        'options' => array(
                            'format' => 'dd-mm-yyyy',
                            'viewformat' => 'dd-mm-yyyy',
                            'placement' => 'right',
                            'todayBtn'=>true,
                        ),
                        'htmlOptions'=>array('class'=>'span2','placeholder'=>'Date from','style'=>'margin-top: 8px;margin-right: 15px;'),
                    ));
            ?>  
        </td><td>
            <?php echo CHtml::button(Yii::t('lang','Search'), array('onclick'=>'load_view_statements();return false;','class'=>'btn','style'=>'margin-top:-3px;')) ?>
        </td>
        
    </tr>
</table>
<div id ='form_view_statements'>
    
</div>

<script type="text/javascript">
    function changeCustomer()
    {
        var customer_id_statement = $('#customer_statement').val();
        $('#attention_statement').load('AttentionByCustomer',{customer_id_statement:customer_id_statement});
        $('#address_option').load('AjaxDropDownAddress',{customer_id_statement:customer_id_statement});
    }
    function printPDF_saleReport() {
        var customer_id=0;
        if($('#customer_id_sale').val() > 0)
                customer_id = $('#customer_id_sale').val();
        window.open('pdfSale?customer='+customer_id+'&search_date_from=<?php echo $date_from; ?>&search_date_to=<?php echo $date_to ?>', '_target');
        
    }
    function load_view_statements()
    {
        var customer_id_statements = $('#customer_statement').val();
        var search_data_from_statements = $('#search_data_from_statements').val();
        var search_data_to_statements = $('#search_data_to_statements').val();
        var attention_statement = $('#attention_statement').val();
        var address_option = $('#address_option').val();
        var invoice_option = $('#invoice_option').val();
        if(customer_id_statements == 0)
            alert("Please choose customer!");
        else
        {
            $('#form_view_statements').html('<img src="<?php echo YII::app()->baseUrl; ?>/images/loading.gif" /> Loading...');
            $('#form_view_statements').load('AjaxLoadFormViewStatement',{customer_id_statements:customer_id_statements,search_data_from_statements:search_data_from_statements,search_data_to_statements:search_data_to_statements
            ,attention_statement:attention_statement,address_option:address_option,invoice_option:invoice_option});
        }
    }
</script>