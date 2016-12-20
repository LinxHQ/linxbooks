<?php
/* @var $this LbExpensesController */
/* @var $model LbExpenses */
/* @var $form CActiveForm */
$valuePv = false;

if(isset($_REQUEST['idPV']))
{
    $valuePv = $_REQUEST['idPV'];
}
echo '<input type="hidden" value="'.$valuePv.'"  id="idPv">';
echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;"><h3>Expenses</h3></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbExpenses::model()->getActionURLNormalized('expenses'));


            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> '.Yii::t('lang','New'), 'items'=>array(
                        array('label'=>Yii::t('lang','New Expenses'),'url'=>  LbExpenses::model()->getActionURLNormalized('create')),
                        array('label'=>Yii::t('lang','New Payment Voucher'),'url'=> LbExpenses::model()->getActionURLNormalized('createPaymentVoucher')),
                     )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div><br>';
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'lb-expenses-form',
        'enableAjaxValidation'=>true,

        'type'=>'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data','onsubmit'=>"validation();"), // ADD THIS
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	
     
        
        <?php echo $form->hiddenField($model,'lb_record_primary_key'); ?>
        
        <?php 
        
            $ExpensesNo = LbExpenses::model()->FormatExpensesNo(LbExpenses::model()->getExpensesNextNum());
            echo $form->textFieldRow($model, 'lb_expenses_no', array('class'=>'span3', 'value'=>$ExpensesNo));
            
            $recurring = UserList::model()->getItemsForListCode('recurring');
            $category_arr = UserList::model()->getItemsForListCode('expenses_category');
            echo $form->dropDownListRow($model, 'lb_category_id', CHtml::listData($category_arr, 'system_list_item_id', 'system_list_item_name'));
         
            
            echo $form->textFieldRow($model, 'lb_expenses_date', 
                    array('hint'=>'Format: dd-mm-yyyy, e.g. 31-12-2013', 'value'=>$model->lb_expenses_date ? date('d-m-Y', strtotime($model->lb_expenses_date)) : date('d-m-Y')));
     
            echo $form->textFieldRow($model, 'lb_expenses_amount',array('class'=>'span3', 'value'=>'0.00'));
            echo '<span id="vacation"></span>';
            echo '<hr/>';
            
            $customer_arr = LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC', LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
            $option_customer = $customer_arr;
            echo '<div class="control-group">';
            echo CHtml::label('Customer', 'LbExpenses_lb_customer_id',array('class'=>'control-label'));
            echo '<div class="controls">';
            echo CHtml::dropDownList('LbExpensesCustomer[lb_customer_id][]', '', $option_customer, array('multiple'=>true));
//            echo Chosen::activeMultiSelect($model,'lb_expenses_amount', $option_customer, array('class'=>'span6'));
            echo '</div>';
            echo '</div>';
//            echo $form->dropDownListRow($customerModel, 'lb_customer_id', $option_customer, array('multiple'=>true));
            
            $status='("'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")';
            $invoices = LbInvoice::model()->getInvoiceByStatus($status);
            $invoice_arr = array();
            if (count($invoices) > 0) {
                foreach ($invoices->data as $data) {
                    $invoice_arr[$data->lb_record_primary_key] = $data->lb_invoice_no;
                }
            }
            if (count($invoice_arr) <= 0)
                $option_invoice = array(''=>'Choose Invoice');
            else $option_invoice = $invoice_arr;
            echo '<div class="control-group">';
            echo CHtml::label('Invoices', 'LbExpenses_lb_invoice_id',array('class'=>'control-label'));
            echo '<div class="controls">';
            echo CHtml::dropDownList('LbExpensesInvoice[lb_invoice_id][]', '', $option_invoice, array('multiple'=>true));
//            echo Chosen::activeMultiSelect($model,'lb_expenses_amount', $option_customer, array('class'=>'span6'));
            echo '</div>';
            echo '</div>';
//            echo $form->dropDownListRow($invoiceModel, 'lb_invoice_id', $option_invoice, array('multiple'=>true));
            
            echo $form->textAreaRow($model,'lb_expenses_note',array('rows'=>'3','cols'=>'40','style'=>'width:210px;'));
            
            $recurring = UserList::model()->getItemsForListCode('recurring');
            $option_recurring = array(''=>'Choose Recurring')+$recurring;
            echo $form->dropDownListRow($model, 'lb_expenses_recurring_id', CHtml::listData($option_recurring, 'system_list_item_id', 'system_list_item_name'));

//            foreach ($recurring_arr as $data){
//                $recurring .='<option value="'.$data->lb_record_primary_key.'">'.$data['system_list_item_name'].'</option>';
//                $option_recurring = array(''=>'Choose Recurring')+$data;
//            }
//            echo $form->dropDownListRow($model, 'lb_expenses_recurring_id', $recurring);
//            
            $bank_accounts = LbBankAccount::model()->getBankAccount(Yii::app()->user->id);
            $bank_account_arr = array();
            if (count($bankaccounts) > 0) {
                foreach ($bankaccounts as $data_bank) {
                    $bank_account_arr[$data_bank->lb_record_primary_key] = $data_bank->lb_bank_account;
                }
            }
            $option_bank_acc=array(''=>'Choose Bank Account');
            if(UserList::model()->getItemsForListCode('BankAcount'))
                $option_bank_acc +=UserList::model()->getItemsForListCode('BankAcount');
            
            echo $form->dropDownListRow($model, 'lb_expenses_bank_account_id', CHtml::listData($option_bank_acc, 'system_list_item_id', 'system_list_item_name'));
            $arr_tax=LbTax::model()->getTaxes("",LbTax::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);
//            echo '<pre>';
//            print_r($arr_tax);
            $option_tax ='<option value="0">---</option>';
            foreach ($arr_tax as $data)
            {
                $option_tax .='<option value="'.$data['lb_record_primary_key'].'">'.$data['lb_tax_value'].'</option>';
            }
            
            echo '<div class="control-group" id="tax_0">';
            echo CHtml::label('Taxes', 'LbExpenses_lb_tax_id',array('class'=>'control-label'));
            echo '<div class="controls">';
           // echo '<a href="#"  onClick="delete_tax(0); return false;" rel="tooltip" class="delete" data-original-title="Delete"><i class="icon-trash"></i></a>';
            echo '<select name="LbExpensesTax[lb_tax_id][]" id="LbExpenses_lb_tax_id_0" onchange="changeTax(0);">'.$option_tax.'</select>';echo '&nbsp;&nbsp;&nbsp;';
//            echo CHtml::dropDownList('LbExpenses_lb_tax_id', '', $option_tax, array('style'=>'width:50px;'));echo '&nbsp;&nbsp;&nbsp;';
            echo CHtml::textField('LbExpenses_lb_expenses_tax_total', '', array('class'=>'span2','id'=>'LbExpenses_lb_expenses_tax_total_0'));echo '&nbsp;&nbsp;&nbsp;';
            echo CHtml::link('More tax', '#', array('onclick'=>'addTaxClick(); return false;','id'=>'tax_0'));
            echo '</div>';
            echo '</div>';
            
        ?>
        
        <div class="control-group">
            <?php echo CHtml::label('Attachments', 'LbExpenses_lb_expenses_document',array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php
                    $this->widget('CMultiFileUpload', array(
                                    'name' => 'documents',
                                    'accept' => 'jpeg|jpg|gif|png|pdf|odt|docx|doc|dia', // useful for verifying files
                                    'duplicate' => 'Duplicate file!', // useful, i think
                                    'denied' => 'Invalid file type', // useful, i think
                                    'htmlOptions'=>array('class'=>'multi'),
                                ));
                ?>
            </div>
        </div>

	<div style="padding-left: 200px;">
		<?php  
            LBApplicationUI::submitButton('Save', array(
                        'htmlOptions'=>array(
                            'onclick'=>'return validation()',
                            'style'=>'margin-left: auto; margin-right: auto; background:#fff,',
                         //   'id'=>'btn-invoice-save-all-'.$model->lb_record_primary_key,
                        ),
                    ));
                    echo '&nbsp;&nbsp;&nbsp&nbsp;';
                    LBApplicationUI::backButton(LbExpenses::model()->getActionURLNormalized('expenses'));
        //echo CHtml::SubmitButton('Save',array('onclick'=>'return validation();'));
         ?>
            
                <?php 
         //       $this->widget('bootstrap.widgets.TbButton', array(
          //          'label'=>'Back',
          //          'url'=>LbExpenses::model()->getActionURLNormalized('expenses'),
          //      ));
                ?>
                <?php // LBApplicationUI::backButton('admin'); ?>
	</div>
     

<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="javascript">
    
    
    $(document).ready(function(){
        var from_date = $("#LbExpenses_lb_expenses_date").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            from_date.hide();
        }).data('datepicker');	
        
        $('#LbExpenses_lb_expenses_amount').change(function(){
        changeAmount();
        
        });
        
    });
    var tax_id=0;
    
    
    function addTaxClick()
    {
       
        tax_id++;
        var html ='<div style="margin-left:178px;" id="tax_'+tax_id+'"><a id="tax_'+tax_id+'" href="#" onClick="delete_tax('+tax_id+');return false;" rel="tooltip" class="delete" data-original-title="Delete"><i class="icon-trash"></i></a>';
        html +='<select onchange = "changeTax('+tax_id+')" style="margin-top:9px;" name="LbExpensesTax[lb_tax_id][]" id="LbExpenses_lb_tax_id_'+tax_id+'"><?php echo $option_tax?></select>&nbsp;&nbsp;&nbsp;'
        html +='<input type="text" name="LbExpenses_lb_expenses_tax_total" value="" id="LbExpenses_lb_expenses_tax_total_'+tax_id+'" class="span2">&nbsp;&nbsp;&nbsp;</div>';
        $(html).insertAfter("#tax_"+(tax_id-1));
        
        
        
    }
    
    function changeAmount()
    {
        var amount = $('#LbExpenses_lb_expenses_amount').val();
        for(var i = 0; i<=tax_id;i++)
            changeTax(i);
    }
    function delete_tax(id)
    {
        $('#tax_'+id).remove();
//        $('#LbExpenses_lb_tax_id_'+id).remove();
//        $('#LbExpenses_lb_expenses_tax_total_'+id).remove();
        tax_id--;
    }
    function changeTax(id)
    {
        
        var amount = $('#LbExpenses_lb_expenses_amount').val();
        var tax = $('#LbExpenses_lb_tax_id_'+id+' option:selected').text();
        var tax_value=0;
        tax_value=(amount*tax)/100;
        if(tax == '---')
            tax_value=0;
        $('#LbExpenses_lb_expenses_tax_total_'+id).val(tax_value);
    }
    

    function validation(){
        var lb_expenses_amount =jQuery("#LbExpenses_lb_expenses_amount").val();
        var success=true;
        var idPv = $('#idPv').val();
        
        if(lb_expenses_amount=='0.00'){
            //alert("Amount cannot be blank");
            jQuery('#vacation').html('Amount  cannot be blank.').show();
            success=false;

        }
        
        return success;
    }
</script>
