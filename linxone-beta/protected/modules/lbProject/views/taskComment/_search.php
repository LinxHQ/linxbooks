<?php
/* @var $this TaskCommentController */
/* @var $model TaskComment */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'task_comment_id'); ?>
		<?php echo $form->textField($model,'task_comment_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_id'); ?>
		<?php echo $form->textField($model,'task_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_comment_owner_id'); ?>
		<?php echo $form->textField($model,'task_comment_owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_comment_last_update'); ?>
		<?php echo $form->textField($model,'task_comment_last_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_comment_created_date'); ?>
		<?php echo $form->textField($model,'task_comment_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_comment_content'); ?>
		<?php echo $form->textArea($model,'task_comment_content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_comment_internal'); ?>
		<?php echo $form->textField($model,'task_comment_internal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->