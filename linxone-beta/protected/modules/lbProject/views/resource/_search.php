<?php
/* @var $this ResourceController */
/* @var $model Resource */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'resource_id'); ?>
		<?php echo $form->textField($model,'resource_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_subscription_id'); ?>
		<?php echo $form->textField($model,'account_subscription_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resource_url'); ?>
		<?php echo $form->textField($model,'resource_url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resource_description'); ?>
		<?php echo $form->textField($model,'resource_description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resource_created_by'); ?>
		<?php echo $form->textField($model,'resource_created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resource_created_date'); ?>
		<?php echo $form->textField($model,'resource_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resource_space'); ?>
		<?php echo $form->textField($model,'resource_space',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->