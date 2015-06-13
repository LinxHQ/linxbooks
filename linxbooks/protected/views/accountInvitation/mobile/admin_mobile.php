<?php
/* @var $this AccountInvitationController */
/* @var $model AccountInvitation */

$this->redirect(array('accountInvitation/create'));

?>

<h4>Invitations</h4>
<div id="account-invitation-new-form"></div>

<h5>Sent Invitations</h5>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'account-invitation-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'account_invitation_to_email',
	),
)); ?>
