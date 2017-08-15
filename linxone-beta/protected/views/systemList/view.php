<?php
/* @var $this SystemListItemController */
/* @var $model SystemListItem */

$this->breadcrumbs=array(
	'System List Items'=>array('index'),
	$model->system_list_item_id,
);

$this->menu=array(
	array('label'=>'List SystemListItem', 'url'=>array('index')),
	array('label'=>'Create SystemListItem', 'url'=>array('create')),
	array('label'=>'Update SystemListItem', 'url'=>array('update', 'id'=>$model->system_list_item_id)),
	array('label'=>'Delete SystemListItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->system_list_item_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SystemListItem', 'url'=>array('admin')),
);
?>

<h1>View SystemListItem #<?php echo $model->system_list_item_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'system_list_item_id',
		'system_list_name',
		'system_list_item_name',
		'system_list_parent_item_id',
		'system_list_item_order',
		'system_list_item_active',
	),
)); ?>
