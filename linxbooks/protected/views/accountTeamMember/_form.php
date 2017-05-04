<?php
/* @var $this AccountTeamMemberController */
/* @var $model AccountTeamMember */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'account-team-member-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->checkboxRow($model, 'is_customer'); ?>
	<?php echo $form->checkboxRow($model, 'is_active'); ?>
	
	<?php 
	$this->widget('bootstrap.widgets.TbButton',
			array('buttonType'=>'submit',
					'htmlOptions' => array('live' => false),
					'type' => 'primary',
					'label' => 'Submit',
			));
	
	//echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); 
	?>

<?php $this->endWidget(); ?>

</div><!-- form -->