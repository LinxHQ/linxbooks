<?php
/* @var $this PeoplevolunteersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lb People Volunteers',
);

$this->menu=array(
	array('label'=>'Create LbPeopleVolunteers', 'url'=>array('create')),
	array('label'=>'Manage LbPeopleVolunteers', 'url'=>array('admin')),
);
?>

<h1>Lb People Volunteers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
