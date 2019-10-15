<?php
/* @var $this ProjectMemberController */
/* @var $model ProjectMember */
/* @var $form CActiveForm */
/* @var $project_id integer */

$project = Project::model()->findByPk($project_id);

// // check permission
// if (!Permission::checkPermission($project, PERMISSION_PROJECT_UPDATE_MEMBER) && !AccountTeamMember::model()->isAcountAdmin())
// {
// 	return false;
// }

/**
 * account team members data source
 */

$project_master_account_id = $project->findProjectMasterAccount();

$team_members = AccountTeamMember::model()->getTeamMembers($project_master_account_id, true);
$team_member_dd_source = array();

foreach ($team_members as $member)
{
	//echo $member->member_account_id;
	$memberProfile = AccountProfile::model()->getProfile($member->member_account_id);
	if ($memberProfile)
	{
		$team_member_dd_source[$member->member_account_id] = $memberProfile->getShortFullName(); ;// $member->member_account->account_profile->account_profile_preferred_display_name;
	}
}
// add master account to the list, since getTeamMembers only get normal member
$team_member_dd_source[$project_master_account_id] = AccountProfile::model()->getShortFullName($project_master_account_id);

// end getting team members data source
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'project-member-form',
	'enableAjaxValidation'=>false,
	'action' => array("projectMember/createMultiple"),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'project_id', array('value' => isset($project_id) ? $project_id : 0)); ?>

	<?php echo $form->dropDownListRow($model, 'manager', array('') + $team_member_dd_source); ?>
	
	<?php echo $form->checkBoxListRow($model, 'members_array', $team_member_dd_source); ?>

	<div class="form-actions">
	
		<?php 
		$this->widget('bootstrap.widgets.TbButton',
				array('buttonType' => 'submit',
						'type' => null,
						'label' => YII::t('core','Submit'),
				));
		//echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); 
		?>
		<?php echo CHtml::link('Skip', Project::model()->getProjectURL($project_id)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->