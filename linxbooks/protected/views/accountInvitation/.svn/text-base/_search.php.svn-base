<?php
/* @var $this AccountInvitationController */
/* @var $model AccountInvitation */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'account_invitation_id'); ?>
		<?php echo $form->textField($model,'account_invitation_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_invitation_master_id'); ?>
		<?php echo $form->textField($model,'account_invitation_master_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_invitation_to_email'); ?>
		<?php echo $form->textField($model,'account_invitation_to_email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_invitation_date'); ?>
		<?php echo $form->textField($model,'account_invitation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_invitation_status'); ?>
		<?php echo $form->textField($model,'account_invitation_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_invitation_rand_key'); ?>
		<?php echo $form->textField($model,'account_invitation_rand_key',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->