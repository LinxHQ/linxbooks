<?php
/* @var $this AccountSubscriptionController */
/* @var $model AccountSubscription */

$this->breadcrumbs=array(
	'Account Subscriptions'=>array('index'),
	'Create',
);

//$this->menu=array(
//	array('label'=>'List AccountSubscription', 'url'=>array('index')),
//	array('label'=>'Manage AccountSubscription', 'url'=>array('admin')),
//);
?>
<?php // echo $model->lb_record_primary_key; 
echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;"><h4>Subscription</h4></div>';
            echo '<div class="lb-header-left">';
            echo '&nbsp;';
            echo '</div>';
echo '</div><br>';
?>
<span style="font-size: 16px;"><b>Create Subscription</b></span>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>