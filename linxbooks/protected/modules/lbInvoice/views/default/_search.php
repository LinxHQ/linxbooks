<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'lb_record_primary_key'); ?>
		<?php echo $form->textField($model,'lb_record_primary_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_group'); ?>
		<?php echo $form->textField($model,'lb_invoice_group',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_generated_from_quotation_id'); ?>
		<?php echo $form->textField($model,'lb_generated_from_quotation_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_no'); ?>
		<?php echo $form->textField($model,'lb_invoice_no',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_date'); ?>
		<?php echo $form->textField($model,'lb_invoice_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_due_date'); ?>
		<?php echo $form->textField($model,'lb_invoice_due_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_company_id'); ?>
		<?php echo $form->textField($model,'lb_invoice_company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_company_address_id'); ?>
		<?php echo $form->textField($model,'lb_invoice_company_address_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_customer_id'); ?>
		<?php echo $form->textField($model,'lb_invoice_customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_customer_address_id'); ?>
		<?php echo $form->textField($model,'lb_invoice_customer_address_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_attention_contact_id'); ?>
		<?php echo $form->textField($model,'lb_invoice_attention_contact_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_subject'); ?>
		<?php echo $form->textField($model,'lb_invoice_subject',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_note'); ?>
		<?php echo $form->textArea($model,'lb_invoice_note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_invoice_status_code'); ?>
		<?php echo $form->textField($model,'lb_invoice_status_code',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->