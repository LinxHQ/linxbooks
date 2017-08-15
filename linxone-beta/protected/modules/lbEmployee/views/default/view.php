<?php
/* @var $this DefaultControllersController */
/* @var $model LbEmployee */

$this->breadcrumbs=array(
	'Lb Employees'=>array('index'),
	$model->lb_record_primary_key,
);

$this->menu=array(
	array('label'=>'List LbEmployee', 'url'=>array('index')),
	array('label'=>'Create LbEmployee', 'url'=>array('create')),
	array('label'=>'Update LbEmployee', 'url'=>array('update', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Delete LbEmployee', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lb_record_primary_key),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LbEmployee', 'url'=>array('admin')),
);
?>

<h1>View LbEmployee #<?php echo $model->lb_record_primary_key; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lb_record_primary_key',
		'employee_name',
		'employee_address',
		'employee_birthday',
		'employee_phone_1',
		'employee_phone_2',
		'employee_email_1',
		'employee_email_2',
		'employee_code',
		'employee_tax',
		'employee_bank',
		'employee_note',
	),
)); ?>
