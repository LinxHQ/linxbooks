<?php
$this->breadcrumbs=array(
	'Subscriptions'=>array('index'),
	$model->subscription_id=>array('view','id'=>$model->subscription_id),
	'Update',
);

//$this->menu=array(
//	array('label'=>'List Subscription', 'url'=>array('index')),
//	array('label'=>'Create Subscription', 'url'=>array('create')),
//	array('label'=>'View Subscription', 'url'=>array('view', 'id'=>$model->subscription_id)),
//	array('label'=>'Manage Subscription', 'url'=>array('admin')),
//);
?>

<h1>Update Subscription <?php echo $model->subscription_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>