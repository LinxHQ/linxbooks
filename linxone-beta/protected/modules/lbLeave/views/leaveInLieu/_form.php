<?php
/* @var $this LeaveInLieuController */
/* @var $model LeaveInLieu */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'leave-in-lieu-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

	<!-- <?php echo $form->errorSummary($model); ?> -->

	<div style="display: inline-flex;">
		<div style="margin-left: 95px;" class="">
			<?php echo $form->textField($model,'leave_in_lieu_name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'leave_in_lieu_name'); ?>
		</div>

		<div style="margin-left: 107px;" class="">
			<?php echo $form->dateField($model,'leave_in_lieu_day'); ?>
			<?php echo $form->error($model,'leave_in_lieu_day'); ?>
		</div>

		<div style="margin-left: 35px;" class="">
			<?php echo $form->textField($model,'leave_in_lieu_totaldays'); ?>
			<?php echo $form->error($model,'leave_in_lieu_totaldays'); ?>
		</div>
	</div>

	

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
<!-- 		<button>Cancel</button> -->
		<button style="display: none" class="button-inlieu-cancel"><?php echo Yii::t('lang','Cancel'); ?></button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->