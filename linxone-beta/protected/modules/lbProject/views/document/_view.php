<?php
/* @var $this DocumentController */
/* @var $data Documents */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->document_id), array('view', 'id'=>$data->document_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_real_name')); ?>:</b>
	<?php echo CHtml::encode($data->document_real_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_encoded_name')); ?>:</b>
	<?php echo CHtml::encode($data->document_encoded_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_description')); ?>:</b>
	<?php echo CHtml::encode($data->document_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_date')); ?>:</b>
	<?php echo CHtml::encode($data->document_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_revision')); ?>:</b>
	<?php echo CHtml::encode($data->document_revision); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_root_revision_id')); ?>:</b>
	<?php echo CHtml::encode($data->document_root_revision_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('document_owner_id')); ?>:</b>
	<?php echo CHtml::encode($data->document_owner_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->document_parent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_parent_type')); ?>:</b>
	<?php echo CHtml::encode($data->document_parent_type); ?>
	<br />

	*/ ?>

</div>