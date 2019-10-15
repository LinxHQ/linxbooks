<?php
/* @var $this PastoralcareController */
/* @var $model LbPastoralCare */

$this->breadcrumbs=array(
	'Lb Pastoral Cares'=>array('index'),
	$model->lb_record_primary_key,
);

$this->menu=array(
	array('label'=>'List LbPastoralCare', 'url'=>array('index')),
	array('label'=>'Create LbPastoralCare', 'url'=>array('create')),
	array('label'=>'Update LbPastoralCare', 'url'=>array('update', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Delete LbPastoralCare', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lb_record_primary_key),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LbPastoralCare', 'url'=>array('admin')),
);
?>

<!-- <h1>View LbPastoralCare #<?php echo $model->lb_record_primary_key; ?></h1> -->

<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Pastoral Care").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar">';
	        	echo '<a live="false" data-workspace="1" href="'.$this->createUrl('/lbPastoralcare/default/create').'"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	        	echo '<a live="false" data-workspace="1" href=""><i style="margin-top: -12px;margin-right: 10px;" class="icon-calendar"></i> </a>';
	            echo ' <input type="text" placeholder="Enter name to search..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
	// $picture = Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png";
 ?>
<div class="lb-empty-15"></div>
<div class="form">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lb_record_primary_key',
		'lb_people_id',
		'lb_pastoral_care_type',
		'lb_pastoral_care_pastor_id',
		'lb_pastoral_care_date',
		'lb_pastoral_care_remark',
	),
)); ?>
