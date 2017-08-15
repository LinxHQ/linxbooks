<?php  
    $canAdd = BasicPermission::model()->checkModules('lbPayment', 'add');
    $customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
    $option_customer=array(0=>'Choose Customer')+$customer_arr;
?>
<p class="note"><?php echo Yii::t('lang','<i>Fields with * are required</i>'); ?>.</p>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'lb-payment-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onsubmit'=>'return is_save_payment();'),
        ));
?>
<div class="control-group">
    <div class="control-label"><?php echo Yii::t('lang','Receipt No'); ?></div>
    <div class="controls" style="padding-top:5px;font-weight: bold;font-size: 18px;color: #6E8900"><?php echo LbPayment::model()->FormatPaymentNo(LbPayment::model()->getPaymentNextNum()); ?></div>
</div>
<div class="control-group">
    <?php echo CHtml::label(Yii::t('lang','Customer').' * ', 'customer_id',array('class'=>'control-label'));?>
    <div class="controls">
        <?php echo CHtml::dropDownList('customer_id',$customer_id, $option_customer,array('class'=>'span4','onchange'=>'load_invoice_by_customer(this.value);')); ?>
    </div>

</div>

<?php //echo $form->textFieldRow($model,'lb_payment_no',array('class'=>'span3','maxlength'=>255)); ?>
<?php echo $form->dropDownListRow($model,'lb_payment_method',  LbPayment::model()->method); ?>
<div class="control-group" >
    <?php echo CHtml::label(Yii::t('lang','Payment Date'), 'message_messageDate', array('class'=>'control-label'));?>
    <div class="controls">
        <?php $this->widget('ext.rezvan.RDatePicker',array(
                    'name'=>'LbPayment[lb_payment_date]',
                    'value'=>  date('Y/m/d'),
                    'options' => array(
                        'format' => 'yyyy/mm/dd',
                        'viewformat' => 'yyyy-mm-dd',
                        'placement' => 'right',
                        'todayBtn'=>true,
                    )
                ));
        ?>
   </div>
</div>
<!--                    <div class="control-group" >
    <?php //echo CHtml::label('Payment Notes', 'LbPayment_lb_payment_notes', array('class'=>'control-label'));?>
    <div class="controls">
    <?php //echo $form->textArea($model, 'lb_payment_notes',array('class'=>'span7','rows'=>'3')); ?>
    </div>
</div>-->
<!--<div style="width: 100%;overflow: hidden; margin: 40px 0px 8px 5px;">
    <div style="float: left;width: 125px;padding-top: 6px;" >
        <?php echo CHtml::label(Yii::t('lang','Payment Amount').': ', 'payment_amount') ?>
    </div>
    <div style="float: left;width: 200px;">
        <?php echo CHtml::textField(Yii::t('lang','payment_amount'),'',array('id'=>'payment_amount','style'=>'width:150px;')) ?>
    </div>
</div>-->
<div class="control-group">
    <?php echo CHtml::label(Yii::t('lang','Payment Amount').' * ', 'payment_amount',array('class'=>'control-label'));?>
    <div class="controls">
        <?php echo CHtml::textField('payment_amount','0.00',array('id'=>'payment_amount','onkeyup'=>'load_payment_hidden()')) ?>
        <?php echo CHtml::hiddenField('hdd_payment_amount','', array('id'=>'hdd_payment_amount')) ?>
    </div>
</div>
<div id="payment_invoice">
    <?php LBApplication::renderPartial($this,'_form_line_item', array('lbInvoiceModel'=>$lbInvoiceModel,'customer_id'=>$customer_id)); ?>
</div>
</br>
<div class="control-group controls-button" style="text-align: center">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'buttom','htmlOptions'=>array('class'=>'btn btn-success','onclick'=>'save_payment();return false;'), 'label'=>'<i class="icon-ok icon-white"></i> &nbsp; Save','encodeLabel'=>false)); ?>
    <button type="button" class="btn btn-default hidden-cancel";" data-dismiss="modal">Cancel</button>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">


    function load_invoice_by_customer(customer_id){
        $('#payment_invoice').load('<?php echo yii::app()->createUrl('lbPayment/default/AjaxLoadInvoiceByCustomer')?>',{customer_id:customer_id});
        $('#hdd_payment_amount').val($('#payment_amount').val());
    }
    function load_payment_hidden(){
        var payment_amount = $('#payment_amount').val();
        if($.isNumeric(payment_amount)==false){
            alert("Please enter numeric characters.");
            $('#hdd_payment_amount').val("");
            $('#payment_amount').val("");
            return false;
        }
        $('#hdd_payment_amount').val(payment_amount);
        var customer_id = $('#customer_id').val();
        $('#payment_invoice').load('<?php echo yii::app()->createUrl('lbPayment/default/AjaxLoadInvoiceByCustomer')?>',{customer_id:customer_id});
    }


</script>
    