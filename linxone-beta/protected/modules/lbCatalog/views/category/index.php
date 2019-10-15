<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lb Catalog Categories',
);

$this->menu=array(
	array('label'=>'Create LbCatalogCategories', 'url'=>array('create')),
	array('label'=>'Manage LbCatalogCategories', 'url'=>array('admin')),
);
?>

<h1>Lb Catalog Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
