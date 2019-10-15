<?php
/* @var $this PastoralcareController */
/* @var $model LbPastoralCare */

$this->breadcrumbs=array(
	'Lb Pastoral Cares'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LbPastoralCare', 'url'=>array('index')),
	array('label'=>'Manage LbPastoralCare', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>