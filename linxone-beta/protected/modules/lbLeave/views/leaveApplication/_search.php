<?php
/* @var $this LeaveApplicationController */
/* @var $model LeaveApplication */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'leave_id'); ?>
		<?php echo $form->textField($model,'leave_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_startdate'); ?>
		<?php echo $form->textField($model,'leave_startdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_enddate'); ?>
		<?php echo $form->textField($model,'leave_enddate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_reason'); ?>
		<?php echo $form->textArea($model,'leave_reason',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_approver'); ?>
		<?php echo $form->textField($model,'leave_approver',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_ccreceiver'); ?>
		<?php echo $form->textField($model,'leave_ccreceiver',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_name'); ?>
		<?php echo $form->textField($model,'leave_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_status'); ?>
		<?php echo $form->textField($model,'leave_status',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_type_name'); ?>
		<?php echo $form->textField($model,'leave_type_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_date_submit'); ?>
		<?php echo $form->textField($model,'leave_date_submit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_id'); ?>
		<?php echo $form->textField($model,'account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_name_approvers_by'); ?>
		<?php echo $form->textField($model,'leave_name_approvers_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->