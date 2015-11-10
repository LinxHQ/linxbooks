<?php
/* @var $this ProcessChecklistDefaultController */
/* @var $model ProcessChecklistDefault */

$this->breadcrumbs=array(
	'Process Checklist Defaults'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProcessChecklistDefault', 'url'=>array('index')),
	array('label'=>'Manage ProcessChecklistDefault', 'url'=>array('admin')),
);
?>

<h1>Create ProcessChecklistDefault</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>