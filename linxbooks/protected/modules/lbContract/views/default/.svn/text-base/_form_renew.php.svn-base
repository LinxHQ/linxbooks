<?php
/* @var $this LbContractsController */
/* @var $model LbContracts */
/* @var $documentModel lbContractDocument */
/* @var $form CActiveForm */
?>
<!--<div style="overflow: hidden;">
    <div style="float: left;width: 300px;"><h3 style="line-height:10px;">Contract: <?php //echo $model->lb_contract_no; ?></h3></div>
   <div style="text-align: right;"><h3 style="line-height:10px;"><?php //echo $model->customer->lb_customer_name; ?></h3></div>
</div>
<br>

<h4>Renew Contract</h4>
<div class="form">
        <div class="control-group">
            <div class="control-label required">Customer:</div>
            <div class="controls text"><?php //echo $model->customer->lb_customer_name; ?></div>
        </div>
        <div class="control-group">
            <div class="control-label required">Contract Type:</div>
            <div class="controls text"><?php //echo $model->lb_contract_type; ?></div>
        </div>
        <?php // echo $form->textAreaRow($model,'lb_contract_notes',array('rows'=>'4','cols'=>'40','style'=>'width:350px;')); ?>
        <?php // echo $form->textFieldRow($model, 'lb_contract_no'); ?>
        <div class="control-group">
            <?php // echo CHtml::label('Date start', 'LbContracts_lb_contract_date_start', array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php
//                    $this->widget('ext.rezvan.RDatePicker',array(
//                        'name'=>'LbContracts[lb_contract_date_start]',
//                        'value'=>date('Y-m-d'),
//                        'options' => array(
//                            'format' => 'yyyy-mm-dd',
//                            'viewformat' => 'yyyy-mm-dd',
//                            'placement' => 'right',
//                            'todayBtn'=>true,
//                        )
//                    ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php // echo CHtml::label('Date end', 'LbContracts_lb_contract_date_end',array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php
//                    $data_renew_end = LbContracts::model()->getTimeOutContract($model->lb_record_primary_key);
//                    $this->widget('ext.rezvan.RDatePicker',array(
//                        'name'=>'LbContracts[lb_contract_date_end]',
//                        'value'=>($model->lb_contract_date_end) ? date('Y-m-d',  strtotime($data_renew_end)) : date('Y-m-d'),
//                        'options' => array(
//                            'format'=>'yyyy-mm-dd',
//                            'viewformat' => 'yyyy-mm-dd',
//                            'placement' => 'right',
//                            'todayBtn' =>true,
//                        )
//                    ));
                ?>
            </div>
        </div>

</div> form -->

<?php
/* @var $this LbContractsController */
/* @var $model LbContracts */
/* @var $documentModel lbContractDocument */
/* @var $form CActiveForm */
?>
<div style="overflow: hidden;">
    <div style="float: left;width: 300px;"><h3 style="line-height:10px;">Contract: <?php echo $model->lb_contract_no; ?></h3></div>
   <div style="text-align: right;"><h3 style="line-height:10px;"><?php echo $model->customer->lb_customer_name; ?></h3></div>
</div>
<br>
<h4>Renew Contract</h4>
<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'lb-contracts_renew-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data'), // ADD THIS
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <div class="control-group">
            <div class="control-label required">Customer:</div>
            <div class="controls text"><?php echo $model->customer->lb_customer_name; ?></div>
        </div>
        <?php echo $form->textFieldRow($model, 'lb_contract_no',array('calss'=>'span4'));?>

        <?php echo $form->textFieldRow($model, 'lb_contract_type', array()); ?>
        <div class="control-group">
            <?php echo CHtml::label('Date start', 'LbContracts_lb_contract_date_start', array('class'=>'control-label required')); ?>
            
            <div class="controls">
                <?php
                    $this->widget('ext.rezvan.RDatePicker',array(
                        'name'=>'LbContracts[lb_contract_date_start]',
                        'value'=>date('Y-m-d'),
                        'options' => array(
                            'format' => 'yyyy-mm-dd',
                            'viewformat' => 'yyyy-mm-dd',
                            'placement' => 'right',
                            'todayBtn'=>true,
                        )
                    ));
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label('Date end', 'LbContracts_lb_contract_date_end',array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php
                    $data_renew_end = LbContracts::model()->getTimeOutContract($model->lb_record_primary_key);
                    $this->widget('ext.rezvan.RDatePicker',array(
                        'name'=>'LbContracts[lb_contract_date_end]',
                        'value'=>($model->lb_contract_date_end) ? date('Y-m-d',  strtotime($data_renew_end)) : date('Y-m-d'),
                        'options' => array(
                            'format'=>'yyyy-mm-dd',
                            'viewformat' => 'yyyy-mm-dd',
                            'placement' => 'right',
                            'todayBtn' =>true,
                        )
                    ));
                ?>
            </div>
        </div>
        
        <?php echo $form->textAreaRow($model,'lb_contract_notes',array('rows'=>'4','cols'=>'40','style'=>'width:350px;')); ?>
        
        <?php echo $form->textFieldRow($model,'lb_contract_amount',array('value'=>$model->lb_contract_amount)); ?>
<!--        <div class="control-group">
            <?php // echo CHtml::label('Attachments', 'LbContacts_lb_contract_date_end',array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php
//                    $this->widget('CMultiFileUpload', array(
//                                    'name' => 'images',
//                                    'accept' => 'jpeg|jpg|gif|png|pdf|odt|docx|doc|dia', // useful for verifying files
//                                    'duplicate' => 'Duplicate file!', // useful, i think
//                                    'denied' => 'Invalid file type', // useful, i think
//                                    'htmlOptions'=>array('class'=>'multi'),
//                                ));
                ?>
            </div>
        </div>-->
        <div class="control-group">
            <div class="controls">
                <?php echo CHtml::checkBox('LbContracts[check_invoice]', '', array('onclick'=>'changeNewInvoice()')) ?>
                <span style="position: relative; top: 2px;">Create new invoice, with paid amount</span>
                <?php echo CHtml::textField('LbContracts[payment_amount]', '0.00', array('class'=>"span2","readonly"=>'true','onblur'=>'changePaidAmount();')) ?>
            </div>
        </div>
        <div class="control-group" id="form_contract_payment" style="display: none;">
                <fieldset >
                  <legend>Payment detail</legend>
                              <div class="control-group">
                                  <div class="control-label">Receipt No</div>
                                  <div class="controls" style="padding-top:5px;font-weight: bold;font-size: 18px;color: #6E8900"><?php echo LbPayment::model()->FormatPaymentNo(LbPayment::model()->getPaymentNextNum()); ?></div>
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
                              <div class="control-group" >
                                  <?php echo CHtml::label('Payment Notes', 'LbPayment_lb_payment_notes', array('class'=>'control-label'));?>
                                  <div class="controls">
                                  <?php echo $form->textArea($paymentModel, 'lb_payment_notes',array('class'=>'span7','rows'=>'3')); ?>
                                  </div>
                              </div>
              </fieldset>
        </div>
        <div class="form-actions">
                        <?php
                        LBApplicationUI::submitButton('Save');
                        ?>
        </div>


<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
 
    function changeNewInvoice()
    {
        if($('#LbContracts_check_invoice').attr('checked'))
        {
            var paid_amount = $('#LbContracts_payment_amount').val();
            $('#LbContracts_payment_amount').attr('readonly',false);
            if(parseFloat(paid_amount)>0)
            {
                $('#form_contract_payment').css("display","block");
            }
        }
        else
        {
            $('#LbContracts_payment_amount').attr('readonly',true);
            $('#form_contract_payment').css("display","none");
        }
    }
    function changePaidAmount()
    {
        var paid_amount = $('#LbContracts_payment_amount').val();
        if(parseFloat(paid_amount)>0)
            $('#form_contract_payment').css("display","block");
        else
            $('#form_contract_payment').css("display","none");
            
    }
</script>