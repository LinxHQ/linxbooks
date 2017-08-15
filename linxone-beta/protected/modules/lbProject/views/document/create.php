<?php
/* @var $this DocumentController */
/* @var $model Documents */

$this->breadcrumbs=array(
	'Documents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Documents', 'url'=>array('index')),
	array('label'=>'Manage Documents', 'url'=>array('admin')),
);
?>

<h1>Create Documents</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>