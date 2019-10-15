<?php
/* @var $this PastoralcareController */
/* @var $model LbPastoralCare */

$this->breadcrumbs=array(
	'Lb Pastoral Cares'=>array('index'),
	$model->lb_record_primary_key=>array('view','id'=>$model->lb_record_primary_key),
	'Update',
);

$this->menu=array(
	array('label'=>'List LbPastoralCare', 'url'=>array('index')),
	array('label'=>'Create LbPastoralCare', 'url'=>array('create')),
	array('label'=>'View LbPastoralCare', 'url'=>array('view', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Manage LbPastoralCare', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>