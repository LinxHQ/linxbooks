<?php
/* @var $this SubscriptionPackageController */
/* @var $model SubscriptionPackage */

$this->breadcrumbs=array(
	'Subscription Packages'=>array('index'),
	$model->subscription_package_id=>array('view','id'=>$model->subscription_package_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SubscriptionPackage', 'url'=>array('index')),
	array('label'=>'Create SubscriptionPackage', 'url'=>array('create')),
	array('label'=>'View SubscriptionPackage', 'url'=>array('view', 'id'=>$model->subscription_package_id)),
	array('label'=>'Manage SubscriptionPackage', 'url'=>array('admin')),
);
?>

<h1>Update SubscriptionPackage <?php echo $model->subscription_package_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>