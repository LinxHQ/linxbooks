<?php
/* @var $this LeaveAssignmentController */
/* @var $model LeaveAssignment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'leave-assignment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'assignment_leave_name'); ?>
		<?php echo $form->textField($model,'assignment_leave_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'assignment_leave_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'assignment_leave_type_id'); ?>
		<?php echo $form->textField($model,'assignment_leave_type_id'); ?>
		<?php echo $form->error($model,'assignment_leave_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'assignment_account_id'); ?>
		<?php echo $form->textField($model,'assignment_account_id'); ?>
		<?php echo $form->error($model,'assignment_account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'assignment_year'); ?>
		<?php echo $form->textField($model,'assignment_year'); ?>
		<?php echo $form->error($model,'assignment_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'assignment_total_days'); ?>
		<?php echo $form->textField($model,'assignment_total_days'); ?>
		<?php echo $form->error($model,'assignment_total_days'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->