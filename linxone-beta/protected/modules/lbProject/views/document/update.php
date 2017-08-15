<?php
/* @var $this DocumentController */
/* @var $model Documents */

$this->breadcrumbs=array(
	'Documents'=>array('index'),
	$model->document_id=>array('view','id'=>$model->document_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Documents', 'url'=>array('index')),
	array('label'=>'Create Documents', 'url'=>array('create')),
	array('label'=>'View Documents', 'url'=>array('view', 'id'=>$model->document_id)),
	array('label'=>'Manage Documents', 'url'=>array('admin')),
);
?>

<h1>Update Documents <?php echo $model->document_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>