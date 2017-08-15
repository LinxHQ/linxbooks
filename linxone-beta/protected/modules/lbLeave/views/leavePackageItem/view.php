<?php
/* @var $this LeavePackageItemController */
/* @var $model LeavePackageItem */

$this->breadcrumbs=array(
	'Leave Package Items'=>array('index'),
	$model->item_id,
);

$this->menu=array(
	array('label'=>'List LeavePackageItem', 'url'=>array('index')),
	array('label'=>'Create LeavePackageItem', 'url'=>array('create')),
	array('label'=>'Update LeavePackageItem', 'url'=>array('update', 'id'=>$model->item_id)),
	array('label'=>'Delete LeavePackageItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->item_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LeavePackageItem', 'url'=>array('admin')),
);
?>

<h1>View LeavePackageItem #<?php echo $model->item_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'item_id',
		'item_leave_package_id',
		'item_leave_type_id',
		'item_total_days',
	),
)); ?>
