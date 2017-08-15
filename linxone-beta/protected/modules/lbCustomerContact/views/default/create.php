<?php
/* @var $this LbCustomerContactController */
/* @var $model LbCustomerContact */

$this->breadcrumbs=array(
	'Lb Customer Contacts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LbCustomerContact', 'url'=>array('index')),
	array('label'=>'Manage LbCustomerContact', 'url'=>array('admin')),
);
?>

<h1>New Contract</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
