<?php
/* @var $this ResourceAssignedListController */
/* @var $model ResourceAssignedList */

$this->breadcrumbs=array(
	'Resource Assigned Lists'=>array('index'),
	$model->resource_assigned_list_id=>array('view','id'=>$model->resource_assigned_list_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ResourceAssignedList', 'url'=>array('index')),
	array('label'=>'Create ResourceAssignedList', 'url'=>array('create')),
	array('label'=>'View ResourceAssignedList', 'url'=>array('view', 'id'=>$model->resource_assigned_list_id)),
	array('label'=>'Manage ResourceAssignedList', 'url'=>array('admin')),
);
?>

<h1>Update ResourceAssignedList <?php echo $model->resource_assigned_list_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>