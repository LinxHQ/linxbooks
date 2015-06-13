<?php
/* @var $this AccountInvitationController */
/* @var $model AccountInvitation */
/* @var $form CActiveForm */

$form = $this->beginWidget('CActiveForm', array(
		'id'=>'issue-form',
		'htmlOptions' => array('class'=>'well'),
		'enableAjaxValidation'=>false,
));

// list of projects user created
// can only invite to own project
$active_projects = array(0 => '') + Project::model()->getProjectsCreatedBy(Yii::app()->user->id, 'datasourceArray');

echo $form->errorSummary($model);

echo $form->label($model, 'account_invitation_to_email');
echo $form->textField($model,'account_invitation_to_email');

echo $form->label($model, 'account_invitation_message');
echo $form->textArea($model, "account_invitation_message"); 

echo $form->label($model, 'account_invitation_project');
echo $form->dropDownList($model, 'account_invitation_project', $active_projects);

echo $form->label($model, 'account_invitation_type');
echo $form->checkbox($model, 'account_invitation_type'); 
	
echo CHtml::submitButton($model->isNewRecord ? 'Invite' : 'Save', array('data-theme'=>'b')); 
$this->endWidget(); 