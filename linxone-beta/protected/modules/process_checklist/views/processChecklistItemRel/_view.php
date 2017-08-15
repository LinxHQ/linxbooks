<?php
/* @var $this ProcessChecklistItemRelController */
/* @var $data ProcessChecklistItemRel */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pcir_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pcir_id), array('view', 'id'=>$data->pcir_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_id')); ?>:</b>
	<?php echo CHtml::encode($data->pc_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pcir_name')); ?>:</b>
	<?php echo CHtml::encode($data->pcir_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pcir_order')); ?>:</b>
	<?php echo CHtml::encode($data->pcir_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pcir_entity_type')); ?>:</b>
	<?php echo CHtml::encode($data->pcir_entity_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pcir_entity_id')); ?>:</b>
	<?php echo CHtml::encode($data->pcir_entity_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pcir_status')); ?>:</b>
	<?php echo CHtml::encode($data->pcir_status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pcir_status_update_by')); ?>:</b>
	<?php echo CHtml::encode($data->pcir_status_update_by); ?>
	<br />

	*/ ?>

</div>