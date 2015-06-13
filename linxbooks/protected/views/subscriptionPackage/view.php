<?php
/* @var $this SubscriptionPackageController */
/* @var $model SubscriptionPackage */

$this->breadcrumbs=array(
	'Subscription Packages'=>array('index'),
	$model->subscription_package_id,
);

$this->menu=array(
	array('label'=>'List SubscriptionPackage', 'url'=>array('index')),
	array('label'=>'Create SubscriptionPackage', 'url'=>array('create')),
	array('label'=>'Update SubscriptionPackage', 'url'=>array('update', 'id'=>$model->subscription_package_id)),
	array('label'=>'Delete SubscriptionPackage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->subscription_package_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubscriptionPackage', 'url'=>array('admin')),
);
?>

<h1>View SubscriptionPackage #<?php echo $model->subscription_package_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'subscription_package_id',
		'subscription_package_name',
		'subscription_package_status',
	),
)); ?>
