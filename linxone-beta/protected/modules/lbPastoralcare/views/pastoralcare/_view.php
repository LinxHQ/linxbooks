<?php
/* @var $this PastoralcareController */
/* @var $data LbPastoralCare */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_people_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_people_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_pastoral_care_type')); ?>:</b>
	<?php echo CHtml::encode($data->lb_pastoral_care_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_pastoral_care_pastor_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_pastoral_care_pastor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_pastoral_care_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_pastoral_care_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_pastoral_care_remark')); ?>:</b>
	<?php echo CHtml::encode($data->lb_pastoral_care_remark); ?>
	<br />


</div>