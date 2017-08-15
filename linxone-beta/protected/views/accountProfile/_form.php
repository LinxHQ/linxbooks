<?php
/* @var $this AccountProfileController */
/* @var $model AccountProfile */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'account-profile-form',
	'enableAjaxValidation'=>false,
)); ?>

<fieldset>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

		<?php //echo $form->labelEx($model,'account_id'); ?>
		<?php //echo $form->textField($model,'account_id'); ?>
		<?php //echo $form->error($model,'account_id'); ?>

		<?php echo $form->textFieldRow($model,'account_profile_surname',
			array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'account_profile_surname'); ?>

		<?php echo $form->textFieldRow($model,'account_profile_given_name',
			array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'account_profile_given_name'); ?>

		<?php echo $form->textFieldRow($model,'account_profile_preferred_display_name',
			array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'account_profile_preferred_display_name'); ?>
		
		<?php echo $form->textFieldRow($model,'account_profile_company_name',
			array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'account_profile_company_name'); ?>
</fieldset>

		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->