<?php
$this->breadcrumbs=array(
	'User Subscriptions'=>array('index'),
	$model->user_subscription_id,
);

//$this->menu=array(
//	array('label'=>'List UserSubscription', 'url'=>array('index')),
//	array('label'=>'Create UserSubscription', 'url'=>array('create')),
//	array('label'=>'Update UserSubscription', 'url'=>array('update', 'id'=>$model->user_subscription_id)),
//	array('label'=>'Delete UserSubscription', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_subscription_id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage UserSubscription', 'url'=>array('admin')),
//);
?>

<h1>View UserSubscription #<?php echo $model->user_subscription_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_subscription_id',
		'user_id',
		'subscription_id',
		'date_from',
	),
)); ?>
