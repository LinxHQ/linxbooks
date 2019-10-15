<?php
/* @var $this SmallgroupsController */
/* @var $model LbSmallGroups */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'lb_record_primary_key'); ?>
		<?php echo $form->textField($model,'lb_record_primary_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_group_name'); ?>
		<?php echo $form->textField($model,'lb_group_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_group_type'); ?>
		<?php echo $form->textField($model,'lb_group_type',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_group_district'); ?>
		<?php echo $form->textField($model,'lb_group_district',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_group_frequency'); ?>
		<?php echo $form->textField($model,'lb_group_frequency'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_group_meeting_time'); ?>
		<?php echo $form->textField($model,'lb_group_meeting_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_group_since'); ?>
		<?php echo $form->textField($model,'lb_group_since'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_group_location'); ?>
		<?php echo $form->textField($model,'lb_group_location',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_group_active'); ?>
		<?php echo $form->textField($model,'lb_group_active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->