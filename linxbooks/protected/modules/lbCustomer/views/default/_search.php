<?php
/* @var $this LbCustomerController */
/* @var $model LbCustomer */
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
		<?php echo $form->label($model,'lb_customer_name'); ?>
		<?php echo $form->textField($model,'lb_customer_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_customer_registration'); ?>
		<?php echo $form->textField($model,'lb_customer_registration',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_customer_tax_id'); ?>
		<?php echo $form->textField($model,'lb_customer_tax_id',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_customer_website_url'); ?>
		<?php echo $form->textField($model,'lb_customer_website_url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_customer_is_own_company'); ?>
		<?php echo $form->textField($model,'lb_customer_is_own_company'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->