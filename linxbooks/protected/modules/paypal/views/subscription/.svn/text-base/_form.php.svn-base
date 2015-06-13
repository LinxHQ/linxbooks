<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subscription-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group ">
		<?php echo $form->labelEx($model,'subscription_name'); ?>
		<?php echo $form->textField($model,'subscription_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subscription_name'); ?>
	</div>

	<div class="control-group ">
		<?php echo $form->labelEx($model,'subscription_cycle'); ?>
		<?php echo $form->textField($model,'subscription_cycle'); ?>
		<?php echo $form->error($model,'subscription_cycle'); ?>
	</div>

	<div class="control-group ">
		<?php echo $form->labelEx($model,'subscription_value'); ?>
		<?php echo $form->textField($model,'subscription_value',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subscription_value'); ?>
	</div>

	<div class="control-group  buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->