<?php
/* @var $this DefaultControllersController */
/* @var $model LbEmployee */
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
		<?php echo $form->label($model,'employee_name'); ?>
		<?php echo $form->textField($model,'employee_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_address'); ?>
		<?php echo $form->textArea($model,'employee_address',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_birthday'); ?>
		<?php echo $form->textField($model,'employee_birthday'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_phone_1'); ?>
		<?php echo $form->textField($model,'employee_phone_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_phone_2'); ?>
		<?php echo $form->textField($model,'employee_phone_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_email_1'); ?>
		<?php echo $form->textField($model,'employee_email_1',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_email_2'); ?>
		<?php echo $form->textField($model,'employee_email_2',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_code'); ?>
		<?php echo $form->textField($model,'employee_code',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_tax'); ?>
		<?php echo $form->textField($model,'employee_tax',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_bank'); ?>
		<?php echo $form->textArea($model,'employee_bank',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_note'); ?>
		<?php echo $form->textArea($model,'employee_note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->