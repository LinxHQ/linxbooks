<?php
/* @var $this DefaultControllersController */
/* @var $model LbEmployee */

$this->breadcrumbs=array(
	'Lb Employees'=>array('index'),
	$model->lb_record_primary_key=>array('view','id'=>$model->lb_record_primary_key),
	'Update',
);

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right"><h3>'.Yii::t('lang','Employee').'</h3></div>';
            echo '<div class="lb-header-left lb-header-left-update-employee">';
                LBApplicationUI::backButton($model->getActionModuleURL('default', 'Dashboard'));
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