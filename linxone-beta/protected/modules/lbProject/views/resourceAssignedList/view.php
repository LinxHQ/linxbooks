<?php
/* @var $this ResourceAssignedListController */
/* @var $model ResourceAssignedList */

$this->breadcrumbs=array(
	'Resource Assigned Lists'=>array('index'),
	$model->resource_assigned_list_id,
);

$this->menu=array(
	array('label'=>'List ResourceAssignedList', 'url'=>array('index')),
	array('label'=>'Create ResourceAssignedList', 'url'=>array('create')),
	array('label'=>'Update ResourceAssignedList', 'url'=>array('update', 'id'=>$model->resource_assigned_list_id)),
	array('label'=>'Delete ResourceAssignedList', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->resource_assigned_list_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ResourceAssignedList', 'url'=>array('admin')),
);
?>

<h1>View ResourceAssignedList #<?php echo $model->resource_assigned_list_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'resource_assigned_list_id',
		'resource_id',
		'resource_user_list_id',
	),
)); ?>
