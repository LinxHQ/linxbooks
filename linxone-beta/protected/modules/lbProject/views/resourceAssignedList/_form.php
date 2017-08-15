<?php
/* @var $this ResourceAssignedListController */
/* @var $model ResourceAssignedList */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'resource-assigned-list-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'resource_id'); ?>
		<?php echo $form->textField($model,'resource_id'); ?>
		<?php echo $form->error($model,'resource_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'resource_user_list_id'); ?>
		<?php echo $form->textField($model,'resource_user_list_id'); ?>
		<?php echo $form->error($model,'resource_user_list_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->