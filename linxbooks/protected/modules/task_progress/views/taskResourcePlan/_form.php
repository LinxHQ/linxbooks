<?php
/* @var $this TaskResourcePlanController */
/* @var $model TaskResourcePlan */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'task-resource-plan-form',
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
		<?php echo $form->labelEx($model,'trp_start'); ?>
		<?php echo $form->textField($model,'trp_start'); ?>
		<?php echo $form->error($model,'trp_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trp_end'); ?>
		<?php echo $form->textField($model,'trp_end'); ?>
		<?php echo $form->error($model,'trp_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trp_work_load'); ?>
		<?php echo $form->textField($model,'trp_work_load'); ?>
		<?php echo $form->error($model,'trp_work_load'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trp_effort'); ?>
		<?php echo $form->textField($model,'trp_effort',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'trp_effort'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->