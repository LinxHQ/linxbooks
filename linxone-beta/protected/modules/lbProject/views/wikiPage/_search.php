<?php
/* @var $this WikiPageController */
/* @var $model WikiPage */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'wiki_page_id'); ?>
		<?php echo $form->textField($model,'wiki_page_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_subscription_id'); ?>
		<?php echo $form->textField($model,'account_subscription_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'project_id'); ?>
		<?php echo $form->textField($model,'project_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wiki_page_title'); ?>
		<?php echo $form->textField($model,'wiki_page_title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wiki_page_parent_id'); ?>
		<?php echo $form->textField($model,'wiki_page_parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wiki_page_content'); ?>
		<?php echo $form->textArea($model,'wiki_page_content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wiki_page_tags'); ?>
		<?php echo $form->textField($model,'wiki_page_tags',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wiki_page_date'); ?>
		<?php echo $form->textField($model,'wiki_page_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wiki_page_updated_by'); ?>
		<?php echo $form->textField($model,'wiki_page_updated_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->