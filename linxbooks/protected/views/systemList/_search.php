<?php
/* @var $this SystemListItemController */
/* @var $model SystemListItem */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'system_list_item_id'); ?>
		<?php echo $form->textField($model,'system_list_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_list_name'); ?>
		<?php echo $form->textField($model,'system_list_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_list_item_name'); ?>
		<?php echo $form->textField($model,'system_list_item_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_list_parent_item_id'); ?>
		<?php echo $form->textField($model,'system_list_parent_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_list_item_order'); ?>
		<?php echo $form->textField($model,'system_list_item_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_list_item_active'); ?>
		<?php echo $form->textField($model,'system_list_item_active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->