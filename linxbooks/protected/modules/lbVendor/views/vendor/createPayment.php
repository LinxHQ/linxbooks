<?php
$canAdd = BasicPermission::model()->checkModules('lbPayment', 'add');
    $customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
				LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
    $option_customer=array(0=>'Choose Supplier')+$customer_arr;
   
?>

<style>
    .accordion-heading{
        background: rgb(91,183,91);
    }
</style>
<?php // echo $model->lb_record_primary_key; 
echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;"><h3>Bills</h3></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbVendor::model()->getActionURLNormalized('dashboard'));
            echo '&nbsp;';
            echo '</div>';
echo '</div><br>';
?>

<!--<div style="font-size:16px;padding-top:0px;margin-bottom:18px;" text-size="30px"><b>Payment</b></div>-->
<div style="overflow: hidden;">
    <div class="accordion" id="accordion2">
        <?php if($canAdd) { ?>
        <div class="accordion-group">
            <div class="accordion-heading" id="new_payment">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#form_new_payment">
                    <i></i>
                    <span style="color: #fff;font-size: 20px; font-weight: bold"><?php echo Yii::t('lang','New Payment'); ?></span>
                </a>
            </div>
            <div id="form_new_payment" class="accordion-body collapse in">
                <div class="accordion-inner">
                    <p class="note"><?php echo Yii::t('lang','Fields with * are required'); ?>.</p>
                    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                                'id'=>'lb-payment-form',
                                'enableAjaxValidation'=>false,
                                'type'=>'horizontal',
                                'htmlOptions'=>array('onsubmit'=>'return is_save_payment();'),
                            ));
                    ?>
                    <div class="control-group">
                        <div class="control-label"><?php echo Yii::t('lang','Receipt No'); ?></div>
                        <div class="controls" style="padding-top:5px;font-weight: bold;font-size: 18px;color: #6E8900"><?php echo LbPaymentVendor::model()->FormatPaymentVendorNo(LbPaymentVendor::model()->getPaymentVendorNextNum()); ?></div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label(Yii::t('lang','Supplier').' * ', 'customer_id',array('class'=>'control-label'));?>
                        <div class="controls">
                            <?php echo CHtml::dropDownList('customer_id',$customer_id, $option_customer,array('class'=>'span4','onchange'=>'load_invoice_by_customer(this.value);')); ?>
                        </div>

                    </div>

                    <?php //echo $form->textFieldRow($model,'lb_payment_no',array('class'=>'span3','maxlength'=>255)); ?>
                    <?php echo $form->dropDownListRow($model,'lb_payment_vendor_method', LbPaymentVendor::model()->method); ?>
                    <div class="control-group" >
                        <?php echo CHtml::label(Yii::t('lang','Payment Date'), 'message_messageDate', array('class'=>'control-label'));?>
                        <div class="controls">
                            <?php $this->widget('ext.rezvan.RDatePicker',array(
                                        'name'=>'LbPaymentVendor[lb_payment_date]',
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
                        <div class="control-label" >
                            <?php echo CHtml::label(Yii::t('lang','Payment Amount').' *', 'payment_amount') ?>
                        </div>
                        <div class="controls">
                            <?php echo CHtml::textField('payment_amount','0.00',array('id'=>'payment_amount','onkeyup'=>'load_payment_hidden()')) ?>
                            <?php echo CHtml::hiddenField('hdd_payment_amount','', array('id'=>'hdd_payment_amount')) ?>
                        </div>
                    </div>
                    <div id="payment_invoice">
                        <?php LBApplication::renderPartial($this,'_form_line_item', array('customer_id'=>$customer_id)); ?>
                    </div>
                    </br>
                    <div class="control-group" style="text-align: center">
                        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'buttom','htmlOptions'=>array('class'=>'btn btn-success','onclick'=>'save_payment();return false;'), 'label'=>'<i class="icon-ok icon-white"></i> &nbsp; Save','encodeLabel'=>false)); ?>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div> 
        <?php } ?>
        <div class="accordion-group">
            <div class="accordion-heading" id="view_payment">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#form_view_payment">
                    <i></i>
                    <span style="color: #fff;font-size: 20px; font-weight: bold"><?php echo Yii::t('lang','View Payment'); ?></span>
                </a>
            </div>
            <div id="form_view_payment" class="accordion-body collapse">
                <div class="accordion-inner">
                    <?php LBApplication::renderPartial($this,'_view_payment',array('customer_id'=>$customer_id)) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Style accodtion icon
    //$('a:active i').addClass("icon-minus-sign");
    //$('.accordion-body.in.collapse i').addClass("icon-plus-sign");
    $('#new_payment i').addClass('icon-minus-sign');
    $('#view_payment i').addClass('icon-plus-sign');
    $('#form_new_payment').on('show', function () {
        $('#new_payment i').removeClass();
        $('#new_payment i').addClass('icon-minus-sign');
    });
    $('#form_new_payment').on('hidden', function () {
        $('#new_payment i').removeClass();
        $('#new_payment i').addClass('icon-plus-sign');
    });
    $('#form_view_payment').on('show', function () {
        $('#view_payment i').removeClass();
        $('#view_payment i').addClass('icon-minus-sign');
        $('#form_view_payment').css('min-height','300px');
    });
    $('#form_view_payment').on('hidden', function () {
        $('#view_payment i').removeClass();
        $('#view_payment i').addClass('icon-plus-sign');
        $('#form_view_payment').css('min-height','0px');
    });

    function load_invoice_by_customer(customer_id){
        $('#payment_invoice').load('AjaxLoadInvoiceByCustomer',{customer_id:customer_id});
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
        $('#payment_invoice').load('AjaxLoadInvoiceByCustomer',{customer_id:customer_id});
    }


</script>
    
