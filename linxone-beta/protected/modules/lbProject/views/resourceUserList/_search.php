<?php
/* @var $this ResourceUserListController */
/* @var $model ResourceUserList */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'resource_user_list_id'); ?>
		<?php echo $form->textField($model,'resource_user_list_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_subscription_id'); ?>
		<?php echo $form->textField($model,'account_subscription_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resource_user_list_name'); ?>
		<?php echo $form->textField($model,'resource_user_list_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resource_user_list_created_by'); ?>
		<?php echo $form->textField($model,'resource_user_list_created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resource_user_list_created_date'); ?>
		<?php echo $form->textField($model,'resource_user_list_created_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->