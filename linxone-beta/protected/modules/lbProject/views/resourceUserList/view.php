<?php
/* @var $this ResourceUserListController */
/* @var $model ResourceUserList */

$this->breadcrumbs=array(
	'Resource User Lists'=>array('index'),
	$model->resource_user_list_id,
);

$this->menu=array(
	array('label'=>'List ResourceUserList', 'url'=>array('index')),
	array('label'=>'Create ResourceUserList', 'url'=>array('create')),
	array('label'=>'Update ResourceUserList', 'url'=>array('update', 'id'=>$model->resource_user_list_id)),
	array('label'=>'Delete ResourceUserList', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->resource_user_list_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ResourceUserList', 'url'=>array('admin')),
);
?>

<h1>View ResourceUserList #<?php echo $model->resource_user_list_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'resource_user_list_id',
		'account_subscription_id',
		'resource_user_list_name',
		'resource_user_list_created_by',
		'resource_user_list_created_date',
	),
)); ?>
