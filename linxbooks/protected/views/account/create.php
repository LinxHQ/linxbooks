<?php
/* @var $this AccountController */
/* @var $model Account */

/**
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Account', 'url'=>array('index')),
	array('label'=>'Manage Account', 'url'=>array('admin')),
);**/
?>

<h1>Signup</h1>

<?php echo $this->renderPartial('_form', 
		array('model'=>$model, 
				//'companyModel' => $companyModel,
				//'companyContactModel' => $companyContactModel,
				'accountProfileModel' => $accountProfileModel,
				'accountSubscriptionModel' => $accountSubscriptionModel,
				'active_subscription_packages' => $active_subscription_packages)); ?>