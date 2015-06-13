<?php
$this->breadcrumbs=array(
	'Subscriptions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Subscription', 'url'=>array('index')),
	array('label'=>'Manage Subscription', 'url'=>array('admin')),
);
?>

<h1>Create Subscription</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>