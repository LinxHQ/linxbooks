<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $form CActiveForm */

if (isset($_GET['ajax']))
{
	Yii::app()->bootstrap->register();
	$iframe_input_style = array('style' => "height: 30px;");
	echo '<style>body{background-color: #FFFFFF}</style>';
}
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'account-form',
	'enableAjaxValidation'=>false,
)); ?>

<fieldset>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
	if (isset ($accountSubscriptionModel))
	{
	echo $form->dropDownListRow($accountSubscriptionModel, 'account_subscription_package_id', 
			$active_subscription_packages); 
	}
	?>
	<?php echo $form->textFieldRow($model,'account_email',
			array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); ?>
			
			
	<?php 
	// add new account fields
	if ($model->isNewRecord)
	{
		echo $form->textFieldRow($accountProfileModel,'account_profile_company_name',
				array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); 
		echo $form->textFieldRow($accountProfileModel,'account_profile_given_name',
				array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); 
		echo $form->textFieldRow($accountProfileModel,'account_profile_surname',
				array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); 
		echo $form->passwordFieldRow($model,'account_password',
				array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); 
		echo $form->hiddenField($model, 'account_timezone');
	} // end showing fields for adding new account
	else {
		// showing fields for updating account
		/**echo $form->textFieldRow($model,'account_timezone',
			array('size'=>60,'maxlength'=>255));**/
		echo $form->dropDownListRow($model, 'account_timezone', 
				LBApplication::getTimeZoneListSource());
		echo $form->textFieldRow($model,'account_language',
			array('size'=>60,'maxlength'=>255));
	}
	?>
	

	<!--  div class="row">
		<?php //echo $form->labelEx($model,'account_timezone'); ?>
		<?php //echo $form->textField($model,'account_timezone',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo $form->error($model,'account_timezone'); ?>
	</div-->

	<!-- div class="row">
		<?php //echo $form->labelEx($model,'account_language'); ?>
		<?php //echo $form->textField($model,'account_language',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo $form->error($model,'account_language'); ?>
	</div-->

</fieldset>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save'); ?>

<?php $this->endWidget(); ?>
</div>
<script language="javascript">
$(document).ready(function(){
	if ($("#Account_account_timezone").val() == '')
	{
		var tz = jstz.determine(); // Determines the time zone of the browser client
		$("#Account_account_timezone").val(tz.name());
	}
});
</script>