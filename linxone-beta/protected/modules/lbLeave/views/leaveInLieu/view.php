<?php
/* @var $this LeaveInLieuController */
/* @var $model LeaveInLieu */

$this->breadcrumbs=array(
	'Leave In Lieus'=>array('index'),
	$model->leave_in_lieu_id,
);

$this->menu=array(
	array('label'=>'List LeaveInLieu', 'url'=>array('index')),
	array('label'=>'Create LeaveInLieu', 'url'=>array('create')),
	array('label'=>'Update LeaveInLieu', 'url'=>array('update', 'id'=>$model->leave_in_lieu_id)),
	array('label'=>'Delete LeaveInLieu', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->leave_in_lieu_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LeaveInLieu', 'url'=>array('admin')),
);
?>

<h1>View LeaveInLieu #<?php echo $model->leave_in_lieu_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'leave_in_lieu_id',
		'leave_in_lieu_name',
		'leave_in_lieu_day',
		'leave_in_lieu_totaldays',
		'account_create_id',
	),
)); ?>
