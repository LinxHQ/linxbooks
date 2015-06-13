<?php
/* @var $this VendorController */
/* @var $model LbVendor */
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
		<?php echo $form->label($model,'lb_vendor_supplier_id'); ?>
		<?php echo $form->textField($model,'lb_vendor_supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_vendor_supplier_address'); ?>
		<?php echo $form->textField($model,'lb_vendor_supplier_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_vendor_supplier_attention_id'); ?>
		<?php echo $form->textField($model,'lb_vendor_supplier_attention_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_vendor_no'); ?>
		<?php echo $form->textField($model,'lb_vendor_no',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_vendor_category'); ?>
		<?php echo $form->textField($model,'lb_vendor_category'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_vendor_date'); ?>
		<?php echo $form->textField($model,'lb_vendor_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_vendor_notes'); ?>
		<?php echo $form->textArea($model,'lb_vendor_notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_vendor_subject'); ?>
		<?php echo $form->textArea($model,'lb_vendor_subject',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_vendor_status'); ?>
		<?php echo $form->textField($model,'lb_vendor_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->