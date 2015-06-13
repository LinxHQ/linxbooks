<?php
/* @var $this LbContractsController */
/* @var $data LbContracts */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_address_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_address_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_contact_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_contact_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_contract_no')); ?>:</b>
	<?php echo CHtml::encode($data->lb_contract_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_contract_notes')); ?>:</b>
	<?php echo CHtml::encode($data->lb_contract_notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_contract_date_start')); ?>:</b>
	<?php echo CHtml::encode($data->lb_contract_date_start); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_contract_date_end')); ?>:</b>
	<?php echo CHtml::encode($data->lb_contract_date_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_contract_type')); ?>:</b>
	<?php echo CHtml::encode($data->lb_contract_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_contract_amount')); ?>:</b>
	<?php echo CHtml::encode($data->lb_contract_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_contract_parent')); ?>:</b>
	<?php echo CHtml::encode($data->lb_contract_parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_contract_status')); ?>:</b>
	<?php echo CHtml::encode($data->lb_contract_status); ?>
	<br />

	*/ ?>

</div>