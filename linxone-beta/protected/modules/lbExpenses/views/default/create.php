<?php
/* @var $this LbExpensesController */
/* @var $model LbExpenses */

$this->breadcrumbs=array(
	'Lb Expenses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LbExpenses', 'url'=>array('index')),
	array('label'=>'Manage LbExpenses', 'url'=>array('admin')),
);
?>



<?php $this->renderPartial('_form', array(
                                        'model'=>$model,
                                        'customerModel'=>$customerModel,
                                        'invoiceModel'=>$invoiceModel,
                                        'bankaccounts'=>$bankaccounts,
                                    )); ?>
