<?php
/* @var $this WikiPageRevisionController */
/* @var $data WikiPageRevision */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('wiki_page_revision_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->wiki_page_revision_id), array('view', 'id'=>$data->wiki_page_revision_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wiki_page_id')); ?>:</b>
	<?php echo CHtml::encode($data->wiki_page_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wiki_page_revision_content')); ?>:</b>
	<?php echo CHtml::encode($data->wiki_page_revision_content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wiki_page_revision_date')); ?>:</b>
	<?php echo CHtml::encode($data->wiki_page_revision_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wiki_page_revision_updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->wiki_page_revision_updated_by); ?>
	<br />


</div>