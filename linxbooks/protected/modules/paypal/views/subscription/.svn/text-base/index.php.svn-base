<?php
$this->breadcrumbs=array(
	'Subscriptions',
);

//$this->menu=array(
//	array('label'=>'Create Subscription', 'url'=>array('create')),
//	array('label'=>'Manage Subscription', 'url'=>array('admin')),
//);
?>

<h1>Subscriptions</h1>

<?php 
LBApplicationUI::newButton(Yii::t('lang','New Subcription'), array(
        'url'=>$this->createUrl('/paypal/subscription/create'),
));
    
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'paypal.views.subscription._view',
)); ?>
