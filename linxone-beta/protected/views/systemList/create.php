<?php
/* @var $this SystemListItemController */
/* @var $model SystemListItem */

$this->breadcrumbs=array(
	'System List Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SystemListItem', 'url'=>array('index')),
	array('label'=>'Manage SystemListItem', 'url'=>array('admin')),
);
?>

<h1>Create SystemListItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>