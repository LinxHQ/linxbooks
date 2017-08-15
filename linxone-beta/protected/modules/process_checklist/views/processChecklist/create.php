<?php
/* @var $this ProcessChecklistController */
/* @var $model ProcessChecklist */

//$this->breadcrumbs=array(
//	'Process Checklists'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List ProcessChecklist', 'url'=>array('index')),
//	array('label'=>'Manage ProcessChecklist', 'url'=>array('admin')),
//);
?>

<h1>Create Process Check List</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>