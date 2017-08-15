<?php
/* @var $this ProjectMemberController */
/* @var $data ProjectMember */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('project_member_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->project_member_id), array('view', 'id'=>$data->project_member_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project_id')); ?>:</b>
	<?php echo CHtml::encode($data->project_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_id); ?>
	<br />


</div>