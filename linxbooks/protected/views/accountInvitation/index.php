<?php
/* @var $this AccountInvitationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Invitations',
);

$this->menu = array(
	array('label'=>'New Invitation', 'url'=>array('create')),
	array('label'=>'Invitations', 'url'=>array('admin')),
);
?>

<h1>Account Invitations</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'invitation-grid',
	'dataProvider'=>$dataProvider,
	//'itemView'=>'_view',
	'columns' => array(
		'account_invitation_to_email',
		'account_invitation_date',
		'account_invitation_status'		
	),
)); ?>
