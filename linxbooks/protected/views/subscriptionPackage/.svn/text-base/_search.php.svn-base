<?php
/* @var $this SubscriptionPackageController */
/* @var $model SubscriptionPackage */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'subscription_package_id'); ?>
		<?php echo $form->textField($model,'subscription_package_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subscription_package_name'); ?>
		<?php echo $form->textField($model,'subscription_package_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subscription_package_status'); ?>
		<?php echo $form->textField($model,'subscription_package_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->