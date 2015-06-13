<?php
/* @var $this SystemListItemController */
/* @var $model SystemListItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-list-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'system_list_name'); ?>
		<?php echo $form->textField($model,'system_list_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'system_list_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_list_item_name'); ?>
		<?php echo $form->textField($model,'system_list_item_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'system_list_item_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_list_parent_item_id'); ?>
		<?php echo $form->textField($model,'system_list_parent_item_id'); ?>
		<?php echo $form->error($model,'system_list_parent_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_list_item_order'); ?>
		<?php echo $form->textField($model,'system_list_item_order'); ?>
		<?php echo $form->error($model,'system_list_item_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_list_item_active'); ?>
		<?php echo $form->textField($model,'system_list_item_active'); ?>
		<?php echo $form->error($model,'system_list_item_active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->