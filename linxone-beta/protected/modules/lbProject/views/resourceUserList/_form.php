<?php
/* @var $this ResourceUserListController */
/* @var $model ResourceUserList */
/* @var $form CActiveForm */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'resource-user-list-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'account_subscription_id', 
			array('value'=>Utilities::getCurrentlySelectedSubscription())); ?>
	
	<?php echo $form->textFieldRow($model,'resource_user_list_name',array('style'=>'width: 300px;')); ?>
	<?php 
	echo $form->error($model,'resource_user_list_name'); 
	echo '<br/>';
	?>

	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>

<?php $this->endWidget(); ?>

