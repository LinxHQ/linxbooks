<?php
/* @var $this TaskAssigneeController */
/* @var $model TaskAssignee */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'task-assignee-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'task_id'); ?>
		<?php echo $form->textField($model,'task_id'); ?>
		<?php echo $form->error($model,'task_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account_id'); ?>
		<?php echo $form->textField($model,'account_id'); ?>
		<?php echo $form->error($model,'account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'task_assignee_start_date'); ?>
		<?php echo $form->textField($model,'task_assignee_start_date'); ?>
		<?php echo $form->error($model,'task_assignee_start_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->