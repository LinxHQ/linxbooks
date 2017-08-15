<?php
/* @var $this LeavePackageController */
/* @var $model LeavePackage */

$this->breadcrumbs=array(
	'Leave Packages'=>array('index'),
	$model->leave_package_id,
);

$this->menu=array(
	array('label'=>'List LeavePackage', 'url'=>array('index')),
	array('label'=>'Create LeavePackage', 'url'=>array('create')),
	array('label'=>'Update LeavePackage', 'url'=>array('update', 'id'=>$model->leave_package_id)),
	array('label'=>'Delete LeavePackage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->leave_package_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LeavePackage', 'url'=>array('admin')),
);
?>

<h1>View LeavePackage #<?php echo $model->leave_package_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'leave_package_id',
		'leave_package_name',
	),
)); ?>
