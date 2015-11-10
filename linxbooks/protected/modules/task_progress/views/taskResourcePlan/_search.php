<?php
/* @var $this TaskResourcePlanController */
/* @var $model TaskResourcePlan */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'trp_id'); ?>
		<?php echo $form->textField($model,'trp_id'); ?>
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
		<?php echo $form->label($model,'trp_start'); ?>
		<?php echo $form->textField($model,'trp_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trp_end'); ?>
		<?php echo $form->textField($model,'trp_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trp_work_load'); ?>
		<?php echo $form->textField($model,'trp_work_load'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trp_effort'); ?>
		<?php echo $form->textField($model,'trp_effort',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->