<?php
/* @var $this LeavePackageController */
/* @var $model LeavePackage */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'leave-package-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('onsubmit' => 'return checkdata()',),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'leave_package_name'); ?>
		<?php echo $form->textField($model,'leave_package_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'leave_package_name'); ?>
	</div>

	<div class="row buttons create-application">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('lang','Create') : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<style type="text/css" media="screen">
	.create-application input {
		color: rgb(91, 183, 91);
	    background: #fff;
	    border: 1px solid rgb(91, 183, 91);
	    padding: 4px 10px;
	    border-radius: 3px;
	}
	.color-erros-leave-package {
		bottom: 10px;
		position: relative;
		right: 0px;
		color: red;
	}
</style>
<script type="text/javascript">
	function checkdata(){
		var LeavePackage_leave_package_name = $('#LeavePackage_leave_package_name').val();

		var check = true;

		// require leavetype
		if(LeavePackage_leave_package_name==''){
			$('#LeavePackage_leave_package_name_em_').css('display', 'block');
			$('#LeavePackage_leave_package_name_em_').html('<p class="color-erros-leave-package"><i>Package cannot be blank !</i></p>');
			
			check = false;
		}
		else{
			$('#LeavePackage_leave_package_name_em_').css('display', 'none');
			check = true;
		}

		return check;
	}
</script>