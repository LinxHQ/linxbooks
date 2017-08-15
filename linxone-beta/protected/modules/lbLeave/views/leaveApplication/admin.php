<?php
/* @var $this LeaveApplicationController */
/* @var $model LeaveApplication */
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canview = BasicPermission::model()->checkModules($m, 'view');
$canEdit = BasicPermission::model()->checkModules($m, 'update');
$canviewOwn = BasicPermission::model()->checkModules($m, 'view',Yii::app()->user->id);

$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LeaveApplication', 'url'=>array('index')),
	array('label'=>'Create LeaveApplication', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#leave-application-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$account = array();
$drop_user = '';
if($canviewOwn){
	$account=array(Yii::app()->user->id=>AccountProfile::model() -> getFullName(Yii::app()->user->id));
	$drop_user = CHtml::dropDownList('employee_id',"", $account ,array('class'=>'span3','onchange'=>'searchLeaveAplication();'));
}
if($canview){
	$account=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true);
	$drop_user = CHtml::dropDownList('employee_id',"", $account ,array('prompt'=>Yii::t('lang','Select Employee'),'class'=>'span3','onchange'=>'searchLeaveAplication();')); 
}


$status=UserList::model()->getItemsListCodeById('status_list',true);
$years=UserList::model()->getItemsForListCodeByName('leave_year',true);

?>


<?php
 // $this->renderPartial('_search',array(
	// 'model'=>$model,
 //));
?>

<div style="display: inline-flex;">
	<div class="control-group" style="display: inline-flex;">
	    <?php echo CHtml::label(Yii::t('lang','Employee :'), '',array('class'=>'control-label style-application'));?>
	    <div class="controls">
	        <?php echo $drop_user; ?>
	    </div>

	</div>

	<div class="control-group" style="display: inline-flex;">
	    <?php echo CHtml::label(Yii::t('lang','Status :'), '',array('class'=>'control-label style-application'));?>
	    <div class="controls">
	        <?php 
	        	echo CHtml::dropDownList('status_id',"", $status ,array('prompt'=>Yii::t('lang','Select status'),'class'=>'span2','onchange'=>'searchLeaveAplication();')); 
	        ?>
	    </div>

	</div>

	<div class="control-group" style="display: inline-flex;">
	    <?php echo CHtml::label(Yii::t('lang','Year :'), '',array('class'=>'control-label style-application'));?>
	    <div class="controls">
	        <?php 
	        	echo CHtml::dropDownList('year_id',"", $years ,array('prompt'=>Yii::t('lang','Year'),'class'=>'span2','onchange'=>'searchLeaveAplication();')); 
	        ?>
	    </div>

	</div>
</div>
<div id="griview_leave_application">
	<?php $this->renderPartial('lbLeave.views.leaveApplication._griview_leave_application',array(
				'model'=>$model,)); 
	?>
</div>
<div style="padding-top: 15px;">
<a href="#" data-toggle="modal" data-target="" onclick="submitStatus();"><?php echo Yii::t('lang','Submit'); ?></a>
<?php if($canEdit){ ?>
<span> | </span>
<a href="#" data-toggle="modal" data-target="" onclick="approver();"><?php echo Yii::t('lang','Approver'); ?></a>
<?php } ?>
<?php if($canEdit){ ?>
<span> | </span>

<a href="#" id="reject-v" onclick="load_view_reject()"><?php echo Yii::t('lang','Reject'); ?></a>
<?php } ?>

<span> | </span>
<a href="#" data-toggle="modal" data-target="#myModal" onclick="load_ajax();"><?php echo Yii::t('lang','New'); ?></a>
</div>

 <!-- Modal -->
<div class="modal fade" id="myModal" style="position: absolute; left: 20%; width: 60%; margin-left: 0px;     overflow: hidden;" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">

             <h2 style="background: rgb(91, 183, 91); color: #fff; text-align: left; padding: 8px 20px; margin-top: 0; border-radius: 5px 5px 0px 0px;"><?php echo Yii::t('lang','Add new leave application');?></h2>
             <button style="float: right;position: relative;bottom: 55px;right: 10px;background: rgb(91, 183, 91);border: none;" type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-remove"></i></button>
             <div class="form-new-application" style="width: 90%;margin: auto;">
                
             </div>
      		
        </div>
          
    </div>
</div>

<!-- modal reject -->
<div class="modal fade" id="myModalReject" style="position: absolute; left: 20%; width: 60%; margin-left: 0px;     overflow: hidden;" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">

             <h2 style="background: rgb(91, 183, 91); color: #fff; text-align: left; padding: 8px 20px; margin-top: 0; border-radius: 5px 5px 0px 0px;"><?php echo Yii::t('lang','Reject'); ?></h2>
             <div class="form-new-reject" style="width: 90%;margin: auto;">
                
             </div>
      
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" onclick="sen_email_reject()" data-dismiss="">Send</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>


<style type="text/css" media="screen">
	.caret {
		display: none;
	}	
	.button-column a {
		padding-left: 10px;
	}
</style>

<script type="text/javascript">
	function load_ajax(){
	    $.ajax({
	        url : "<?php echo Yii::app()->baseUrl; ?>/lbLeave/leaveApplication/FormCreate",
	        type : "post",
	        success : function (result){
	            $('.form-new-application').html(result);
	        }
	    });

	}
	searchLeaveAplication();

	function load_view_reject(){
            var inputs = document.getElementsByName('checkboxApplication[]');
            var id = '';var count=0;
            for (var i = 0; i < inputs.length; i++) {

                if (inputs[i].type == 'checkbox' && inputs[i].checked == true) {
                	count++;
                	if(count>1) {
                		alert("Loi");
                		return false;
                	}
                	else{
                    	id = inputs[i].value;
                	}
                }
            }
	    $.ajax({
	        url : "<?php echo Yii::app()->baseUrl; ?>/lbLeave/leaveApplication/FormViewReject",
	        type : "post",
	        data:{leave_id:id},
	        success : function (result){
	            $('.form-new-reject').html(result);
	            $('#myModalReject').modal('show');

	        }
	    });

	}

	function approver(){
			var leave_id = get_ID_checked();
	    $.ajax({
	        url : "<?php echo Yii::app()->baseUrl; ?>/lbLeave/leaveApplication/appStatusApprover",
	        type : "post",
	        data: {leave_id:leave_id,status:'45',send:'send'},
	        success : function (result){
	            location.reload();
	        }
	    });
	}


	function submitStatus(){
			var leave_id = get_ID_checked();
	    $.ajax({
	        url : "<?php echo Yii::app()->baseUrl; ?>/lbLeave/leaveApplication/appStatus",
	        type : "post",
	        data: {leave_id:leave_id,status:'44',send:'send'},
	        success : function (result){
	            location.reload();
	        }
	    });
	}



	function sen_email_reject(){
            var inputs = document.getElementsByName('checkboxApplication[]');
            var id = '';var count=0;
            for (var i = 0; i < inputs.length; i++) {

                if (inputs[i].type == 'checkbox' && inputs[i].checked == true) {
                	count++;
                	if(count>1) {
                		alert("Loi");
                		return false;
                	}
                	else{
                    	id = inputs[i].value;
                	}
                }
            }
			var confirm_reject = $('#confirm-reject').val();
	    $.ajax({
	        url : "<?php echo Yii::app()->baseUrl; ?>/lbLeave/leaveApplication/FormViewReject",
	        type : "post",
	        data: {leave_id:id,confirm_reject:confirm_reject,status:'46',send:'send'},
	        success : function (result){
	            location.reload();
	        }
	    });
	}


	 function get_ID_checked() {
            var inputs = document.getElementsByName('checkboxApplication[]');
            var id = '0';
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == 'checkbox' && inputs[i].checked == true) {
                    id += ','+inputs[i].value;
                }
            }
            return id;
        }
    function searchLeaveAplication(){
    	var employee_id = $('#employee_id').val();
    	var status_id = $('#status_id').val();
    	var year_id = $('#year_id').val();
    	$('#griview_leave_application').load('<?php echo Yii::app()->baseUrl; ?>/lbLeave/leaveApplication/searchLeaveAplication',{
    				employee_id: employee_id,status_id: status_id,year_id: year_id});
    	
    }
    setTimeout(function(){ 
		$('td.44 a').contents().unwrap();
		$('td.441 .icon-pencil').css('display', 'none');
		$('td.45 a').contents().unwrap();
		$('td.451 .icon-pencil').css('display', 'none');
		$('td.46 a').contents().unwrap();
		$('td.461 .icon-pencil').css('display', 'none');
		$('td.471 .icon-pencil').css('display', 'inline-flex');
    }, 1000);
    
</script>