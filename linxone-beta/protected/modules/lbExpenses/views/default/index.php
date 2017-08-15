<?php
/* @var $this LbExpensesController */
/* @var $dataProvider CActiveDataProvider */

//$this->breadcrumbs=array(
//	'Lb Expenses',
//);
//
//$this->menu=array(
//	array('label'=>'Create LbExpenses', 'url'=>array('create')),
//	array('label'=>'Manage LbExpenses', 'url'=>array('admin')),
//);
?>

<!--<h1>Lb Expenses</h1>-->

<?php 
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
)); 
?>
