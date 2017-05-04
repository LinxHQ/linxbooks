<?php
/* @var $this TaskProgressController */
/* @var $model TaskProgress */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'task-progress-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
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
		<?php echo $form->labelEx($model,'tp_percent_completed'); ?>
		<?php echo $form->textField($model,'tp_percent_completed',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'tp_percent_completed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tp_days_completed'); ?>
		<?php echo $form->textField($model,'tp_days_completed',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'tp_days_completed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tp_last_update'); ?>
		<?php echo $form->textField($model,'tp_last_update'); ?>
		<?php echo $form->error($model,'tp_last_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tp_last_update_by'); ?>
		<?php echo $form->textField($model,'tp_last_update_by'); ?>
		<?php echo $form->error($model,'tp_last_update_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->