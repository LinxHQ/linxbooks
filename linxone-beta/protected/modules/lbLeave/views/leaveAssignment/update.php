<?php
/* @var $this LeaveAssignmentController */
/* @var $model LeaveAssignment */

$this->breadcrumbs=array(
	'Leave Assignments'=>array('index'),
	$model->assignment_id=>array('view','id'=>$model->assignment_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LeaveAssignment', 'url'=>array('index')),
	array('label'=>'Create LeaveAssignment', 'url'=>array('create')),
	array('label'=>'View LeaveAssignment', 'url'=>array('view', 'id'=>$model->assignment_id)),
	array('label'=>'Manage LeaveAssignment', 'url'=>array('admin')),
);
?>

<h1>Update LeaveAssignment <?php echo $model->assignment_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>