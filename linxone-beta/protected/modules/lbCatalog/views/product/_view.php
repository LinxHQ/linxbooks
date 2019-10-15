<?php
/* @var $this ProductsController */
/* @var $data LbCatalogProducts */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_record_primary_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lb_record_primary_key), array('view', 'id'=>$data->lb_record_primary_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_name')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_sku')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_status')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_description')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_price')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_special_price')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_special_price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_special_price_from_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_special_price_from_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_special_price_to_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_special_price_to_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_tax')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_tax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_qty')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_qty_out_of_stock')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_qty_out_of_stock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_qty_min_order')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_qty_min_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_qty_max_order')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_qty_max_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_qty_notify')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_qty_notify); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_stock_availability')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_stock_availability); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_updated_date')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_updated_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lb_product_create_by')); ?>:</b>
	<?php echo CHtml::encode($data->lb_product_create_by); ?>
	<br />

	*/ ?>

</div>