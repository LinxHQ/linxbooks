<?php
/* @var $this CategoryController */
/* @var $data LbCatalogCategories */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_category_name')); ?>:</b>
	<?php echo CHtml::encode($data->lb_category_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_category_description')); ?>:</b>
	<?php echo CHtml::encode($data->lb_category_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_category_status')); ?>:</b>
	<?php echo CHtml::encode($data->lb_category_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_category_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_category_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_category_created_by')); ?>:</b>
	<?php echo CHtml::encode($data->lb_category_created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_category_parent')); ?>:</b>
	<?php echo CHtml::encode($data->lb_category_parent); ?>
	<br />


</div>