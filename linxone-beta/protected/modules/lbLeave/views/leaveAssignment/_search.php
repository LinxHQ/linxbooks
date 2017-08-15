<?php
/* @var $this LeaveAssignmentController */
/* @var $model LeaveAssignment */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'assignment_id'); ?>
		<?php echo $form->textField($model,'assignment_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'assignment_leave_name'); ?>
		<?php echo $form->textField($model,'assignment_leave_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'assignment_leave_type_id'); ?>
		<?php echo $form->textField($model,'assignment_leave_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'assignment_account_id'); ?>
		<?php echo $form->textField($model,'assignment_account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'assignment_year'); ?>
		<?php echo $form->textField($model,'assignment_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'assignment_total_days'); ?>
		<?php echo $form->textField($model,'assignment_total_days'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->