<?php

/* @var $this LbContractsController */
/* @var $paymentModel LbPayment */
?>
  <fieldset>
    <legend>Payment detail</legend>
        <div id="form_new_payment" class="accordion-body collapse in">
            <div class="accordion-inner">
                <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                            'id'=>'lb-payment-form',
                            'enableAjaxValidation'=>false,
                            'type'=>'horizontal',
                            'htmlOptions'=>array('onsubmit'=>'return is_save_payment();'),
                        ));
                ?>
                <div class="control-group">
                    <div class="control-label">Receipt No</div>
                    <div class="controls" style="padding-top:5px;font-weight: bold;font-size: 18px;color: #6E8900"><?php echo LbPayment::model()->FormatPaymentNo(); ?></div>
                </div>
                <?php //echo $form->textFieldRow($model,'lb_payment_no',array('class'=>'span3','maxlength'=>255)); ?>
                <?php echo $form->dropDownListRow($paymentModel,'lb_payment_method',  LbPayment::model()->method); ?>
                <div class="control-group" >
                    <?php echo CHtml::label('Payment Date', 'message_messageDate', array('class'=>'control-label'));?>
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
<!--                <div class="control-group" >
                    <?php //echo CHtml::label('Payment Notes', 'LbPayment_lb_payment_notes', array('class'=>'control-label'));?>
                    <div class="controls">
                    <?php //echo $form->textArea($paymentModel, 'lb_payment_notes',array('class'=>'span7','rows'=>'3')); ?>
                    </div>
                </div>-->
                <?php $this->endWidget(); ?>
            </div>
        </div>
</fieldset>
