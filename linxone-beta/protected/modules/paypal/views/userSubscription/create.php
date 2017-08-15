<?php
$this->breadcrumbs=array(
	'User Subscriptions'=>array('index'),
	'Create',
);

//$this->menu=array(
//	array('label'=>'List UserSubscription', 'url'=>array('index')),
//	array('label'=>'Manage UserSubscription', 'url'=>array('admin')),
//);
?>

<h1>Create UserSubscription</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>