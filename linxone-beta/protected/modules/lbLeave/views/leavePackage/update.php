<?php
/* @var $this LeavePackageController */
/* @var $model LeavePackage */

$this->breadcrumbs=array(
	'Leave Packages'=>array('index'),
	$model->leave_package_id=>array('view','id'=>$model->leave_package_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LeavePackage', 'url'=>array('index')),
	array('label'=>'Create LeavePackage', 'url'=>array('create')),
	array('label'=>'View LeavePackage', 'url'=>array('view', 'id'=>$model->leave_package_id)),
	array('label'=>'Manage LeavePackage', 'url'=>array('admin')),
);
?>

<h1>Update LeavePackage <?php echo $model->leave_package_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>