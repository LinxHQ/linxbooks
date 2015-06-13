<?php
/* @var $this AccountInvitationController */
/* @var $model AccountInvitation */

/**$this->breadcrumbs=array(
	'Account Invitations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AccountInvitation', 'url'=>array('index')),
	array('label'=>'Manage AccountInvitation', 'url'=>array('admin')),
);**/
?>

<h5>New Invitation</h5>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>