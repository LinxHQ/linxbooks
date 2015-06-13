<?php
/* @var $this LbCustomerAddressController */
/* @var $model LbCustomerAddress */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'lb-customer-address-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
        'type'=>'horizontal',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_line_1',array('class'=>'span6')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_line_2',array('size'=>60,'maxlength'=>255,'class'=>'span6')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_city',array('size'=>60,'maxlength'=>100,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_state',array('size'=>60,'maxlength'=>100,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_country',array('size'=>60,'maxlength'=>100,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_postal_code',array('size'=>20,'maxlength'=>20,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_website_url',array('size'=>60,'maxlength'=>255,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_phone_1',array('size'=>50,'maxlength'=>50,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_phone_2',array('size'=>50,'maxlength'=>50,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_fax',array('size'=>50,'maxlength'=>50,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_address_email',array('size'=>60,'maxlength'=>100,'class'=>'span4')); ?>
		<?php echo $form->textAreaRow($model,'lb_customer_address_note',array('size'=>60,'maxlength'=>255,'class'=>'span6','rows'=>'4')); ?>
		<?php echo $form->dropDownListRow($model,'lb_customer_address_is_active', LbCustomerAddress::$dropdownActive); ?>

        <div class="form-actions">
                        <?php
                        LBApplicationUI::submitButton('Save');
                        ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
