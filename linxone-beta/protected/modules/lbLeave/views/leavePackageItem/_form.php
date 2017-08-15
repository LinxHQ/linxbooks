<?php
/* @var $this LeavePackageItemController */
/* @var $model LeavePackageItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'leave-package-item-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'item_leave_package_id'); ?>
		<?php echo $form->textField($model,'item_leave_package_id'); ?>
		<?php echo $form->error($model,'item_leave_package_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item_leave_type_id'); ?>
		<?php echo $form->textField($model,'item_leave_type_id'); ?>
		<?php echo $form->error($model,'item_leave_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item_total_days'); ?>
		<?php echo $form->textField($model,'item_total_days'); ?>
		<?php echo $form->error($model,'item_total_days'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->