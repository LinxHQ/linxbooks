<?php
/* @var $this LeavePackageController */
/* @var $model LeavePackage */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'leave_package_id'); ?>
		<?php echo $form->textField($model,'leave_package_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_package_name'); ?>
		<?php echo $form->textField($model,'leave_package_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->