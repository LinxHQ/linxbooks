<?php
/* @var $this AccountInvitationController */
/* @var $model AccountInvitation */

$this->breadcrumbs=array(
	'Account Invitations'=>array('index'),
	$model->account_invitation_id,
);

$this->menu=array(
	array('label'=>'List AccountInvitation', 'url'=>array('index')),
	array('label'=>'Create AccountInvitation', 'url'=>array('create')),
	array('label'=>'Update AccountInvitation', 'url'=>array('update', 'id'=>$model->account_invitation_id)),
	array('label'=>'Delete AccountInvitation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->account_invitation_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AccountInvitation', 'url'=>array('admin')),
);
?>

<h1>View AccountInvitation #<?php echo $model->account_invitation_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'account_invitation_id',
		'account_invitation_master_id',
		'account_invitation_to_email',
		'account_invitation_date',
		'account_invitation_status',
		'account_invitation_rand_key',
	),
)); ?>
