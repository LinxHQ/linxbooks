<?php
/* @var $this SubscriptionPackageController */
/* @var $model SubscriptionPackage */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subscription-package-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'subscription_package_name'); ?>
		<?php echo $form->textField($model,'subscription_package_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subscription_package_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subscription_package_status'); ?>
		<?php echo $form->textField($model,'subscription_package_status'); ?>
		<?php echo $form->error($model,'subscription_package_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->