<?php
/* @var $this ProcessChecklistController */
/* @var $model ProcessChecklist */

//$this->breadcrumbs=array(
//	'Process Checklists'=>array('index'),
//	$model->pc_id=>array('view','id'=>$model->pc_id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List ProcessChecklist', 'url'=>array('index')),
//	array('label'=>'Create ProcessChecklist', 'url'=>array('create')),
//	array('label'=>'View ProcessChecklist', 'url'=>array('view', 'id'=>$model->pc_id)),
//	array('label'=>'Manage ProcessChecklist', 'url'=>array('admin')),
//);
?>

<h1>Update Process Check List: <?php echo $model->pc_name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>