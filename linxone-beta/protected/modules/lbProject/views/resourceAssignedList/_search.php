<?php
/* @var $this ResourceAssignedListController */
/* @var $model ResourceAssignedList */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'resource_assigned_list_id'); ?>
		<?php echo $form->textField($model,'resource_assigned_list_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resource_id'); ?>
		<?php echo $form->textField($model,'resource_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resource_user_list_id'); ?>
		<?php echo $form->textField($model,'resource_user_list_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->