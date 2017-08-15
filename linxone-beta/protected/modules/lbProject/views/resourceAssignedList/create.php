<?php
/* @var $this ResourceAssignedListController */
/* @var $model ResourceAssignedList */

$this->breadcrumbs=array(
	'Resource Assigned Lists'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ResourceAssignedList', 'url'=>array('index')),
	array('label'=>'Manage ResourceAssignedList', 'url'=>array('admin')),
);
?>

<h1>Create ResourceAssignedList</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>