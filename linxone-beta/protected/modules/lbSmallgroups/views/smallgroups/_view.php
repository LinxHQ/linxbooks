<?php
/* @var $this SmallgroupsController */
/* @var $data LbSmallGroups */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_group_name')); ?>:</b>
	<?php echo CHtml::encode($data->lb_group_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_group_type')); ?>:</b>
	<?php echo CHtml::encode($data->lb_group_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_group_district')); ?>:</b>
	<?php echo CHtml::encode($data->lb_group_district); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_group_frequency')); ?>:</b>
	<?php echo CHtml::encode($data->lb_group_frequency); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_group_meeting_time')); ?>:</b>
	<?php echo CHtml::encode($data->lb_group_meeting_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_group_since')); ?>:</b>
	<?php echo CHtml::encode($data->lb_group_since); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_group_location')); ?>:</b>
	<?php echo CHtml::encode($data->lb_group_location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_group_active')); ?>:</b>
	<?php echo CHtml::encode($data->lb_group_active); ?>
	<br />

	*/ ?>

</div>