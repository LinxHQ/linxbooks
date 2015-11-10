<?php
/* @var $this TaskProgressController */
/* @var $model TaskProgress */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'tp_id'); ?>
		<?php echo $form->textField($model,'tp_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_id'); ?>
		<?php echo $form->textField($model,'task_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_id'); ?>
		<?php echo $form->textField($model,'account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tp_percent_completed'); ?>
		<?php echo $form->textField($model,'tp_percent_completed',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tp_days_completed'); ?>
		<?php echo $form->textField($model,'tp_days_completed',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tp_last_update'); ?>
		<?php echo $form->textField($model,'tp_last_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tp_last_update_by'); ?>
		<?php echo $form->textField($model,'tp_last_update_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->