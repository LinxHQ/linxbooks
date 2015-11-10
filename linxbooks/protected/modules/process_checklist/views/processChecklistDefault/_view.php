<?php
/* @var $this ProcessChecklistDefaultController */
/* @var $data ProcessChecklistDefault */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pcdi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pcdi_id), array('view', 'id'=>$data->pcdi_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pc_id')); ?>:</b>
	<?php echo CHtml::encode($data->pc_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pcdi_name')); ?>:</b>
	<?php echo CHtml::encode($data->pcdi_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pcdi_order')); ?>:</b>
	<?php echo CHtml::encode($data->pcdi_order); ?>
	<br />


</div>