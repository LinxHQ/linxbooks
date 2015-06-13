<?php
/* @var $this VendorController */
/* @var $data LbVendor */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_vendor_supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_vendor_supplier_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_vendor_supplier_address')); ?>:</b>
	<?php echo CHtml::encode($data->lb_vendor_supplier_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_vendor_supplier_attention_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_vendor_supplier_attention_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_vendor_no')); ?>:</b>
	<?php echo CHtml::encode($data->lb_vendor_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_vendor_category')); ?>:</b>
	<?php echo CHtml::encode($data->lb_vendor_category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_vendor_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_vendor_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_vendor_notes')); ?>:</b>
	<?php echo CHtml::encode($data->lb_vendor_notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_vendor_subject')); ?>:</b>
	<?php echo CHtml::encode($data->lb_vendor_subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_vendor_status')); ?>:</b>
	<?php echo CHtml::encode($data->lb_vendor_status); ?>
	<br />

	*/ ?>

</div>