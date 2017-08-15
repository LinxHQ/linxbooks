<?php
/* @var $this DefaultController */

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canview = BasicPermission::model()->checkModules($m, 'view');
$canEdit = BasicPermission::model()->checkModules($m, 'update');
$canviewOwn = BasicPermission::model()->checkModules($m, 'view',Yii::app()->user->id);
$canViewPacPerIn = DefinePermission::model()->checkFunction($m, 'Leave Management');
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<?php 
	$account = array();
	$drop_user = '';
	if($canviewOwn){
		$account=array(Yii::app()->user->id=>AccountProfile::model() -> getFullName(Yii::app()->user->id));
		$drop_user = CHtml::dropDownList('assignment_account_id1',"", $account ,array('class'=>'span3','onchange'=>'loadReport();'));
	}
	if($canview){
		$account=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true);
		$drop_user = CHtml::dropDownList('assignment_account_id1',"", $account ,array('prompt'=>Yii::t('lang','Select Employee'),'class'=>'span3','onchange'=>'loadReport();')); 
	}
	if($canViewPacPerIn==1){
		$account=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true);
		$drop_user = CHtml::dropDownList('assignment_account_id1',"", $account ,array('prompt'=>'Select Employee','class'=>'span3','onchange'=>'loadReport();')); 
	}

	$account=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true);
	$years=UserList::model()->getItemsListCodeById('leave_year',true);
?>

<div class="select-employee" style="display: inline-flex;">
	<div class="control-group" style="display: inline-flex;">
	    <?php echo CHtml::label(Yii::t('lang','Employee :'), '',array('class'=>'control-label style-application'));?>
	    <div class="controls">
	        <?php echo $drop_user; ?>
	    </div>

	</div>

	<div class="control-group" style="display: inline-flex;">
	    <?php echo CHtml::label(Yii::t('lang','Year :'), '',array('class'=>'control-label style-application'));?>
	    <div class="controls">
	        <?php 
	        	echo CHtml::dropDownList('assignment_year_id1',"", $years ,array('class'=>'span2','onchange'=>'loadReport();')); 
	        ?>
	    </div>

	</div>
</div>
<p style="color: rgb(91, 183, 91);"><i><?php echo Yii::t('lang','Current Date') ?> : <?php echo Date('d M Y'); ?></i></p>
<div class="form-new-report">
	
</div>


<script type="text/javascript">
	function loadReport(){
		var emp_id = $('#assignment_account_id1').val();
		var year_id = $('#assignment_year_id1').val();
		$.ajax({
	        url : "<?php echo Yii::app()->baseUrl; ?>/lbLeave/default/LoadReport",
	        type : "post",
	        data: {emp_id:emp_id,year_id:year_id},
	        success : function (result){
	            $('.form-new-report').html(result);
	        }
	    });
	}
</script>