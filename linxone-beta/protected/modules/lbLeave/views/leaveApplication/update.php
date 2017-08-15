<?php
/* @var $this LeaveApplicationController */
/* @var $model LeaveApplication */

$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	$model->leave_id=>array('view','id'=>$model->leave_id),

	'Update',
);

// $this->menu=array(
	// array('label'=>'List LeaveApplication', 'url'=>array('index')),
	// array('label'=>'Create LeaveApplication', 'url'=>array('create')),
	// array('label'=>'View LeaveApplication', 'url'=>array('view', 'id'=>$model->leave_id)),
	// array('label'=>'Manage LeaveApplication', 'url'=>array('admin')),
// );
?>

<h1><?php echo Yii::t('lang', 'Update Application'); ?> :<?php echo AccountProfile::model() -> getFullName($model->account_id); ?></h1>
<a class="back-application" href="<?php echo Yii::app()->baseUrl; ?>/lbLeave/default/index">Back</a>

<?php $this->renderPartial('_form', array('model'=>$model, 'evenStatusDate'=>$evenStatusDate,'oddDate'=>$oddDate, 'leave_ccreceiver'=>$leave_ccreceiver,)); ?>

<style type="text/css" media="screen">
	li {
	    list-style: none;
	    margin-left: 0px;
	}
	#leave-application-form .row {
	    margin: auto;
	}
	[class*="span"] {
	    float: none;
	    min-height: 1px;
	    margin-left: 21px;
	}
	.back-application {
		border: 1px solid rgb(91, 183, 91)!important;
	    padding: 6px 20px;
	    position: relative;
	    bottom: 45px;
	    float: right;
	    border-radius: 3px;
	}
</style>