<?php
/* @var $this LbExpensesController */
/* @var $model LbExpenses */

$this->breadcrumbs=array(
	'Lb Expenses'=>array('index'),
	$model->lb_record_primary_key=>array('view','id'=>$model->lb_record_primary_key),
	'Update',
);

$this->menu=array(
	array('label'=>'List LbExpenses', 'url'=>array('index')),
	array('label'=>'Create LbExpenses', 'url'=>array('create')),
	array('label'=>'View LbExpenses', 'url'=>array('view', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Manage LbExpenses', 'url'=>array('admin')),
);
?>

<h1>Update LbExpenses <?php echo $model->lb_record_primary_key; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
