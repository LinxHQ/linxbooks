<?php
/* @var $this AccountInvitationController */
/* @var $model AccountInvitation */

$this->breadcrumbs=array(
	'Account Invitations'=>array('index'),
	$model->account_invitation_id=>array('view','id'=>$model->account_invitation_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AccountInvitation', 'url'=>array('index')),
	array('label'=>'Create AccountInvitation', 'url'=>array('create')),
	array('label'=>'View AccountInvitation', 'url'=>array('view', 'id'=>$model->account_invitation_id)),
	array('label'=>'Manage AccountInvitation', 'url'=>array('admin')),
);
?>

<h1>Update AccountInvitation <?php echo $model->account_invitation_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>