<?php
/* @var $this DefaultControllersController */
/* @var $model LbEmployee */

$this->breadcrumbs=array(
	'Lb Employees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LbEmployee', 'url'=>array('index')),
	array('label'=>'Manage LbEmployee', 'url'=>array('admin')),
);
echo '<div id="lb-view-header" style="margin: -20px -20px 17px; padding: 4px 20px;">';
echo '<div class="lb-header-right" style="margin-left:-10px"><h3><a style="color:#777;margin-left:9px;margin-top:2px;" href="'.LbInvoice::model()->getActionURLNormalized("dashboard").'">New Employee</a></h3></div>';
echo '</div>';
?>

<?php $this->renderPartial('_form', array('model'=>$model,'salaryModel'=>$salaryModel,'benefitModel'=>$benefitModel)); ?>