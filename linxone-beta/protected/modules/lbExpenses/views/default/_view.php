<?php
/* @var $this LbExpensesController */
/* @var $data LbExpenses */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_expenses_amount')); ?>:</b>
	<?php echo CHtml::encode($data->lb_expenses_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_expenses_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_expenses_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_expenses_recurring_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_expenses_recurring_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_expenses_bank_account_id')); ?>:</b>
	<?php echo CHtml::encode($data->lb_expenses_bank_account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_expenses_note')); ?>:</b>
	<?php echo CHtml::encode($data->lb_expenses_note); ?>
	<br />


</div>
