<?php
/* @var $this LeavePackageItemController */
/* @var $model LeavePackageItem */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'item_id'); ?>
		<?php echo $form->textField($model,'item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item_leave_package_id'); ?>
		<?php echo $form->textField($model,'item_leave_package_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item_leave_type_id'); ?>
		<?php echo $form->textField($model,'item_leave_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item_total_days'); ?>
		<?php echo $form->textField($model,'item_total_days'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->