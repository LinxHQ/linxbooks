<?php
/* @var $this DefaultControllersController */
/* @var $model LbEmployee */

$this->breadcrumbs=array(
	'Lb Employees'=>array('index'),
	$model->lb_record_primary_key=>array('view','id'=>$model->lb_record_primary_key),
	'Update',
);

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;"><h4>'.Yii::t('lang','Customers').'</h4></div>';
            echo '<div class="lb-header-left">';
                LBApplicationUI::backButton($model->getHomeURLNormalized());
                echo '&nbsp;';
                // new
                
                
            echo '</div>';
echo '</div>';
$this->menu=array(
	array('label'=>'List LbEmployee', 'url'=>array('index')),
	array('label'=>'Create LbEmployee', 'url'=>array('create')),
	array('label'=>'View LbEmployee', 'url'=>array('view', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Manage LbEmployee', 'url'=>array('admin')),
);
?>
<div style="width:30%;margin-top:19px;margin-bottom:11px;"><span style="font-size: 16px;"><b><?php echo $model->employee_name; ?></b></span></div>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>