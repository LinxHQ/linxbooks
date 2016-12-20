<?php
/* @var $this LbCustomerContactController */
/* @var $model LbCustomerContact */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'lb-customer-contact-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
                <?php echo $form->textFieldRow($model,'lb_customer_contact_first_name',array('size'=>50,'maxlength'=>50,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_contact_last_name',array('size'=>50,'maxlength'=>50,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_contact_office_phone',array('size'=>50,'maxlength'=>50,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_contact_office_fax',array('size'=>50,'maxlength'=>50,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_contact_mobile',array('size'=>50,'maxlength'=>50,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_contact_email_1',array('size'=>60,'maxlength'=>100,'class'=>'span4')); ?>
		<?php echo $form->textFieldRow($model,'lb_customer_contact_email_2',array('size'=>60,'maxlength'=>100,'class'=>'span4')); ?>
		<?php echo $form->textAreaRow($model,'lb_customer_contact_note',array('size'=>60,'maxlength'=>255,'class'=>'span6','rows'=>'5')); ?>
		<?php echo $form->dropDownListRow($model,'lb_customer_contact_is_active', LbCustomerContact::$dropdownActiveContact); ?>

        <div style="padding-left: 200px;">
                        <?php
                            LBApplicationUI::submitButton('Save');
                        ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
