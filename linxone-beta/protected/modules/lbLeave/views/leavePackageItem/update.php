<?php
/* @var $this LeavePackageItemController */
/* @var $model LeavePackageItem */

$this->breadcrumbs=array(
	'Leave Package Items'=>array('index'),
	$model->item_id=>array('view','id'=>$model->item_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LeavePackageItem', 'url'=>array('index')),
	array('label'=>'Create LeavePackageItem', 'url'=>array('create')),
	array('label'=>'View LeavePackageItem', 'url'=>array('view', 'id'=>$model->item_id)),
	array('label'=>'Manage LeavePackageItem', 'url'=>array('admin')),
);
?>

<h1>Update LeavePackageItem <?php echo $model->item_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>