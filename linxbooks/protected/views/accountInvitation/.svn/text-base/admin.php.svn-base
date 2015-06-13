<?php
/* @var $this AccountInvitationController */
/* @var $model AccountInvitation */

/*
$this->menu=array(
	//array('label'=>'List AccountInvitation', 'url'=>array('index')),
	array('label'=>'Invite Team Member', 'url'=>array('create')),
);
*/

?>

<h3>Invitations</h3>
<div id="account-invitation-new-form"></div>

<h5>Sent Invitations</h5>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'account-invitation-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'account_invitation_id',
		//'account_invitation_master_id',
		'account_invitation_to_email',
		'account_invitation_date',
		'account_invitation_status',
		//'account_invitation_rand_key',
		/**
		array(
			'class'=>'CButtonColumn',
		),**/
	),
)); ?>

<script language="javascript">
$(document).ready(function(){
	$.get("<?php echo Yii::app()->createUrl("accountInvitation/create", array('workspace' => 1));?>", function(data){
		$("#account-invitation-new-form").html(data);
	});
});
</script>