<?php
/* @var $this SubscriptionPackageController */
/* @var $model SubscriptionPackage */

$this->breadcrumbs=array(
	'Subscription Packages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SubscriptionPackage', 'url'=>array('index')),
	array('label'=>'Manage SubscriptionPackage', 'url'=>array('admin')),
);
?>

<h1>Create SubscriptionPackage</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>