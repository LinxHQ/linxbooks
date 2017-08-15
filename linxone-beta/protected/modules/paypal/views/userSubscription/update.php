<?php
$this->breadcrumbs=array(
	'User Subscriptions'=>array('index'),
	$model->user_subscription_id=>array('view','id'=>$model->user_subscription_id),
	'Update',
);

//$this->menu=array(
//	array('label'=>'List UserSubscription', 'url'=>array('index')),
//	array('label'=>'Create UserSubscription', 'url'=>array('create')),
//	array('label'=>'View UserSubscription', 'url'=>array('view', 'id'=>$model->user_subscription_id)),
//	array('label'=>'Manage UserSubscription', 'url'=>array('admin')),
//);
?>

<h1>Update UserSubscription <?php echo $model->user_subscription_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>