<?php
/* @var $this AccountTeamMemberController */
/* @var $model AccountTeamMember */

$this->breadcrumbs=array(
	'Account Team Members'=>array('index'),
	$model->account_team_member_id,
);

$this->menu=array(
	array('label'=>'List AccountTeamMember', 'url'=>array('index')),
	array('label'=>'Create AccountTeamMember', 'url'=>array('create')),
	array('label'=>'Update AccountTeamMember', 'url'=>array('update', 'id'=>$model->account_team_member_id)),
	array('label'=>'Delete AccountTeamMember', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->account_team_member_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AccountTeamMember', 'url'=>array('admin')),
);
?>

<h1>View AccountTeamMember #<?php echo $model->account_team_member_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'account_team_member_id',
		'member_account_id',
		'master_account_id',
	),
)); ?>
