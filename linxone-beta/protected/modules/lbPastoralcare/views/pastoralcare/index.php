<?php
/* @var $this PastoralcareController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lb Pastoral Cares',
);

$this->menu=array(
	array('label'=>'Create LbPastoralCare', 'url'=>array('create')),
	array('label'=>'Manage LbPastoralCare', 'url'=>array('admin')),
);
?>

<h1>Lb Pastoral Cares</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
