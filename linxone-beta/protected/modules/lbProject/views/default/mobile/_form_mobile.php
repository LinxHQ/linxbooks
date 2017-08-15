<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $form CActiveForm */

if (!Permission::checkPermission($model, PERMISSION_PROJECT_CREATE))
{
	return false;
}

 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
	'enableAjaxValidation'=>false,
)); 
 ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php 
	// if this account is linked to more than 2 subscriptions
	// must choose which subscription to create this project in
	$accountSubscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id,true);//Yii::app()->user->account_subscriptions;
	
	if ($accountSubscriptions) 
	{		
		if (count($accountSubscriptions) > 1)
		{
			// show choices
			echo $form->dropDownList($model,'account_subscription_id', $accountSubscriptions);
		} else if (count($accountSubscriptions) == 1) {
			// else hide it by default since there's nothing to select
			// TODO: back end needs to validate that user has right.
			reset($accountSubscriptions);
			$first_key = key($accountSubscriptions);
			echo $form->hiddenField($model,'account_subscription_id', array('value' => $first_key));
		}
	}
	// END choosing account subscriptions
	
	echo $form->labelEx($model,'project_name');
	echo $form->textField($model,'project_name'); 
	
	echo $form->labelEx($model,'project_start_date');
	echo '<input type="date" data-role="datebox" name="Project[project_start_date]"
    	id="Project_project_start_date" data-options=\'{"mode": "datebox"}\' />';
	
	echo $form->labelEx($model,'project_description');
	echo $form->textArea($model,'project_description'); 
	
	echo $form->labelEx($model,'project_simple_view');
	echo '<input type="checkbox" name="Project[project_simple_view]" id="Project_project_simple_view" value="1"/>';
	echo '<p style="font-size:12px">Simple View is suitable for non-IT development projects. You will still be able to change this later on.</p>'; 
	
	echo CHtml::submitButton($model->isNewRecord ? 'Create Project' : 'Save'); ?>

<?php $this->endWidget(); ?>
