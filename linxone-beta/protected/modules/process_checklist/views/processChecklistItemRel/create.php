<?php
/* @var $this ProcessChecklistItemRelController */
/* @var $model ProcessChecklistItemRel */

$this->breadcrumbs=array(
	'Process Checklist Item Rels'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProcessChecklistItemRel', 'url'=>array('index')),
	array('label'=>'Manage ProcessChecklistItemRel', 'url'=>array('admin')),
);
?>

<h1>Create ProcessChecklistItemRel</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>