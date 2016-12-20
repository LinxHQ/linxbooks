<?php 
    if(isset($_REQUEST['customer_id']))
        $customer_id = $_REQUEST['customer_id'];
    
    
    $invoice = LbVendorInvoice::model()->getInvoiceAmountByCustomer($customer_id);
    
    $this->widget('bootstrap.widgets.TbGridView', array(
		'id' => 'payment_invoice_grid',
            //     'htmlOptions'=>array('class'=>'items table table-bordered'),
        'type'=>'bordered',
		'dataProvider' => $invoice,
		'columns' => array(
				array(
                                        'header' => '#',
                                        'type' => 'raw',
                                        'value' => 'CHtml::checkBox("payment_check[]","",array(
                                                                "id"=>"check_payment_invoice_{$data->lb_record_primary_key}",
                                                                "onclick"=>"select_apply_invoice({$data->lb_record_primary_key})",
                                                                "value"=>"{$data->lb_record_primary_key}"))',
                                        'htmlOptions'=>array('style'=>'width: 10px; '),
                                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
				),
                                array(
                                        'header' => Yii::t('lang','Vendor Invoice No'),
                                        //'name'=>'lb_vd_invoice_no',
                                        'type' => 'raw',
                                        'value' =>'CHtml::encode($data->lb_vd_invoice_no)',
                                        'htmlOptions'=>array('style'=>'width: 150px; '),
                                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                                array(
                                        'header' =>  Yii::t('lang','Amount Due'),
                                        'type' => 'raw',
                                        'value' =>'CHtml::textField("amount_due_{$data->lb_record_primary_key}",LbVendorTotal::model()->getVendorTotal("{$data->lb_record_primary_key}",LbVendorTotal::LB_VENDOR_INVOICE_TOTAL)->lb_vendor_last_outstanding,array(
                                                                                                "style"=>"width: 110px;text-align: right; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"amount_due_{$data->lb_record_primary_key}",
                                            ))',
                                        'htmlOptions'=>array('style'=>'width: 80px;text-align:right;'),
                                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                                array(
                                        'header' =>  Yii::t('lang','Payment'),
                                        'type' => 'raw',
                                        'value' =>  'CHtml::textField("payment[]", "0.00",array("onkeyup"=>"TotalPaymentAmount()",
                                                                "style"=>"width: 110px;text-align: right; padding-right: 0px;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                                 "id"=>"payment_{$data->lb_record_primary_key}",
                                                                 "disabled"=>"disabled",
                                            ))',
                                        'htmlOptions'=>array('style'=>'width: 130px;text-align: right; '),
                                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                                array(
                                        'header' =>  Yii::t('lang','Notes'),
                                        'type' => 'raw',
                                        'value' =>'CHtml::textArea("payment_note[]","",array(
                                                                 "style"=>"width: 250px; border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                                 "id"=>"payment_note_{$data->lb_record_primary_key}",
                                        ))',
                                        'htmlOptions'=>array('style'=>'width: 100px; '),
                                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                )
                    ),
    ));

?>

<?php if(count($invoice->data)){ ?>
    <div style="width:100%;overflow:hidden;margin-bottom: 50px;text-align: right;font-weight: bold;">
        <div style="float:left;width:245px;">Total:</div>
        <div style="float:left;width:167px;" id="total_payment_amount"><?php echo LbVendorTotal::model()->getTotalVendorByCustomer($customer_id) ?></div>
        <div style="float:left;width:189px;" id="div_total_payment">
            <?php echo CHtml::textField('total_payment','0.00',array('id'=>'total_payment',
                                                                       "style"=>"width: 110px;text-align: right; padding-right: 0px; border-top: none;
                                                                                 border-left: none; border-right: none; box-shadow: none;font-weight: bold;",
                                                                       "disabled"=>"disabled")); ?>
        </div>
    </div>
<?php } ?>
<script>
    function TotalPaymentAmount(){
        var total_payment = 0;
        //var format_total_payment_amount =0;
        <?php foreach ($invoice->data as $data) { ?>
                total_payment += parseFloat($('#payment_'+<?php echo $data->lb_record_primary_key; ?>).val());
                var format_total_payment = total_payment.toFixed(2);
               
        <?php } ?>
        $('#total_payment').val(format_total_payment);
    }
    function select_apply_invoice(item){
        var amount_due = parseFloat($('#amount_due_'+item).val());
        var payment_amount = parseFloat($('#hdd_payment_amount').val());
        var payment = parseFloat($('#payment_'+item).val());
        if($('#check_payment_invoice_'+item).attr("checked"))
        {
            if(payment_amount>amount_due)
            {
                $('#payment_'+item).val(amount_due.toFixed(2));
                $('#hdd_payment_amount').val((payment_amount-amount_due).toFixed(2));
            }
            else{
                $('#payment_'+item).val(payment_amount.toFixed(2));
                $('#hdd_payment_amount').val(0);
            }
            $('#payment_'+item).attr("disabled",false);
        }else{
            $('#hdd_payment_amount').val((payment_amount+payment).toFixed(2));
            $('#payment_'+item).val("0.00");
            $('#payment_'+item).attr("disabled",true);
        }
        TotalPaymentAmount();
    }
    function save_payment(){
        var total_payment = parseFloat($('#total_payment').val());
        var payment_amount = parseFloat($('#payment_amount').val());
        if($('#customer_id').val()==0 || $('#customer_id').val()=="")
        {
            alert('Please choose custormer.');
            return false;
        }
        if(payment_amount=="" || payment_amount==0){
            alert('Please enter payment amount.');
            return false;
        }
        if(total_payment != payment_amount)
        {
            alert('Your total applied payment is not equal to payment amount. Please make sure you apply all the payment amount.');
            return false;
        }
        <?php foreach ($invoice->data as $data) { ?>
                var amount_due = parseFloat($('#amount_due_'+<?php echo $data->lb_record_primary_key; ?>));
                var payment = parseFloat($('payment_'+<?php echo $data->lb_record_primary_key; ?>));
                if(amount_due < payment)
                {
                    alert('The Payment Amount cannot exceed the Invoice Amount Due.');
                    return false;
                }
               
        <?php } ?>
       var data_form = $('#lb-payment-form').serialize();
       data_form += '&total_payment='+total_payment;
       
       $.ajax({
           type:'POST',
           url:'AjaxSavePayment',
           data:data_form,
           success:function(data){
               alert("Success payment");
               window.location.reload();
           }
       });
    }
</script>

