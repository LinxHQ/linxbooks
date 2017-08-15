<?php
/* @var $this LeaveAssignmentController */
/* @var $model LeaveAssignment */

$this->breadcrumbs=array(
	'Leave Assignments'=>array('index'),
	$model->assignment_id,
);

$this->menu=array(
	array('label'=>'List LeaveAssignment', 'url'=>array('index')),
	array('label'=>'Create LeaveAssignment', 'url'=>array('create')),
	array('label'=>'Update LeaveAssignment', 'url'=>array('update', 'id'=>$model->assignment_id)),
	array('label'=>'Delete LeaveAssignment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->assignment_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LeaveAssignment', 'url'=>array('admin')),
);
?>

<h1>View LeaveAssignment #<?php echo $model->assignment_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'assignment_id',
		'assignment_leave_name',
		'assignment_leave_type_id',
		'assignment_account_id',
		'assignment_year',
		'assignment_total_days',
	),
)); ?>
