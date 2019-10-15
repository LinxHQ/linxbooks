<?php
/* @var $this PeoplevolunteersController */
/* @var $data LbPeopleVolunteers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_people_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_people_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_volunteers_type')); ?>:</b>
	<?php echo CHtml::encode($data->lb_volunteers_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_volunteers_position')); ?>:</b>
	<?php echo CHtml::encode($data->lb_volunteers_position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_volunteers_active')); ?>:</b>
	<?php echo CHtml::encode($data->lb_volunteers_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_volunteers_start_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_volunteers_start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_volunteers_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_volunteers_end_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_entity_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_entity_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_entity_type')); ?>:</b>
	<?php echo CHtml::encode($data->lb_entity_type); ?>
	<br />

	*/ ?>

</div>