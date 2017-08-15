<?php
/* @var $this AccountTeamMemberController */
/* @var $model AccountTeamMember */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'account_team_member_id'); ?>
		<?php echo $form->textField($model,'account_team_member_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'member_account_id'); ?>
		<?php echo $form->textField($model,'member_account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'master_account_id'); ?>
		<?php echo $form->textField($model,'master_account_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->