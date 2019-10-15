<?php
/* @var $this PeoplevolunteersController */
/* @var $model LbPeopleVolunteers */

$this->breadcrumbs=array(
	'Lb People Volunteers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LbPeopleVolunteers', 'url'=>array('index')),
	array('label'=>'Manage LbPeopleVolunteers', 'url'=>array('admin')),
);
?>

<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Volunteers - Create").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar">';
	        	echo '<a live="false" data-workspace="1" href="'.$this->createUrl('/lbVolunteers/peoplevolunteers/create').'"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	            echo ' <input type="text" placeholder="Enter name..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
	$picture = Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png";
 ?>
<div class="lb-empty-15"></div>
<div id="advanced_search" style="width: 100%;height: 30px; display: inline-flex; /*border: 1px solid red;*/">
  <div id="left" style="width: 50%; padding: 5px;">
    <i class="icon-search"></i> Advanced Search
  </div>
  <div id="right" style="width: 50%; padding: 5px;">
    <p style="float: right;"><i class="icon-download-alt"></i> Excel <i class="icon-download-alt"></i> PDF</p>
  </div>
</div>
<div class="lb-empty-15"></div>

<?php $this->renderPartial('_form', array('model_state' => $model_state, 'model' => $model)); ?>