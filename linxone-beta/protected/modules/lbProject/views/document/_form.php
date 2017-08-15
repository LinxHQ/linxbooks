<?php
/* @var $this DocumentController */
/* @var $model Documents */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'documents-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'document_real_name'); ?>
		<?php echo $form->textField($model,'document_real_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'document_real_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_encoded_name'); ?>
		<?php echo $form->textField($model,'document_encoded_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'document_encoded_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_description'); ?>
		<?php echo $form->textField($model,'document_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'document_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_date'); ?>
		<?php echo $form->textField($model,'document_date'); ?>
		<?php echo $form->error($model,'document_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_revision'); ?>
		<?php echo $form->textField($model,'document_revision'); ?>
		<?php echo $form->error($model,'document_revision'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_root_revision_id'); ?>
		<?php echo $form->textField($model,'document_root_revision_id'); ?>
		<?php echo $form->error($model,'document_root_revision_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_owner_id'); ?>
		<?php echo $form->textField($model,'document_owner_id'); ?>
		<?php echo $form->error($model,'document_owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_parent_id'); ?>
		<?php echo $form->textField($model,'document_parent_id'); ?>
		<?php echo $form->error($model,'document_parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_parent_type'); ?>
		<?php echo $form->textField($model,'document_parent_type',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'document_parent_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->