<?php
/* @var $this LeaveApplicationController */
/* @var $model LeaveApplication */

$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	$model->leave_id,
);

// $this->menu=array(
// 	array('label'=>'List LeaveApplication', 'url'=>array('index')),
// 	array('label'=>'Create LeaveApplication', 'url'=>array('create')),
// 	array('label'=>'Update LeaveApplication', 'url'=>array('update', 'id'=>$model->leave_id)),
// 	array('label'=>'Delete LeaveApplication', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->leave_id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage LeaveApplication', 'url'=>array('admin')),
// );
?>

<h1><?php echo Yii::t('lang', 'View Application'); ?> : <?php echo AccountProfile::model() -> getFullName($model->account_id); ?></h1>
<a class="back-application" href="<?php echo Yii::app()->baseUrl; ?>/lbLeave/default/index">Back</a>
<?php $this->widget('editable.EditableDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'leave_id',
		array(
			'name'=>Yii::t('lang','Employee'),
			'value'=>function($data){
		        return AccountProfile::model() -> getFullName($data->account_id);
		     },
		),

		array(
			'name'=>Yii::t('lang','Start'),
           	'value'=>function($data){
				return $data->leave_startdate;
			},
		),
		array(
			'name'=>Yii::t('lang','End'),
           	'value'=>function($data){
				return $data->leave_enddate;
			},
		),
		array(
			'name'=>Yii::t('lang','Reason'),
           	'value'=>function($data){
				return $data->leave_reason;
			},
		),
		array(
			'name'=>Yii::t('lang','Approver'),
			'value'=>function($data){
				return AccountProfile::model() -> getFullName($data->leave_approver);
			},
		),
		array(
			'name'=>Yii::t('lang','CC-Receiver'),
			'value'=>function($data){
				$account_id = explode(',', $data->leave_ccreceiver);
				$account = '';
				foreach ($account_id as $value) {
					$account = AccountProfile::model() -> getFullName($value);
					
				}
				return $account .= $account;

			},

		),
		array(
			'name'=>Yii::t('lang','Status'),
           	'value'=>function($data){
				$status=UserList::model()->getItemsListCodeById('status_list',true);
				return $status[$data->leave_status];
			},
		),
		array(
			'name'=>Yii::t('lang','Type Leave'),
           	'value'=>function($data){
				return $data->leave_type_name;
			},
		),
		array(
			'name'=>Yii::t('lang','List Day Leave'),
           	'value'=>function($data){
				return $data->leave_list_day;
			},
		),
		array(
			'name'=>Yii::t('lang','Sum day leave'),
           	'value'=>function($data){
				return $data->leave_sum_day.' Day';
			},
		),
		array(
			'name'=>Yii::t('lang','Date submit'),
           	'value'=>function($data){
				return $data->leave_date_submit;
			},
		)
	
		// 'leave_name_approvers_by',
	),
)); ?>
<style type="text/css" media="screen">
[class*="span"] {
    float: none;
    min-height: 1px;
    margin-left: 21px;
}
.back-application {
	border: 1px solid rgb(91, 183, 91)!important;
    padding: 6px 20px;
    position: relative;
    bottom: 50px;
    float: right;
    border-radius: 3px;
}
</style>
