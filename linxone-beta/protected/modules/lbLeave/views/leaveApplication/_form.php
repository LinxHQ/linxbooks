<?php
/* @var $this LeaveApplicationController */
/* @var $model LeaveApplication */
/* @var $form CActiveForm */
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canview = BasicPermission::model()->checkModules($m, 'view');
$canEdit = BasicPermission::model()->checkModules($m, 'update');
$canviewOwn = BasicPermission::model()->checkModules($m, 'view',Yii::app()->user->id);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'leave-application-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false, // thisturns off AJAX validation 
    'enableClientValidation'=>true,
    'clientOptions'=>array( 
            'onSubmit'=>'return checkdata();',
            'validateOnChange'=>true, 
    ), 
    'htmlOptions' => array('onsubmit' => 'return checkdata()',),

)); ?>

	<p class="note"><i><?php echo Yii::t('lang','Fields with * are required.');?></i></p>

	<?php 
		// echo $form->errorSummary($model); 

	?>
	
	<div class="row">
		<?php 
		$leave_type_all=UserList::model()->getItemsListCodeByIdApp('leave_type',true);
		$leave_type_user=UserList::model()->getItemsForListCodeByName('leave_type',true);

		$LeaveAssignment = LeaveAssignment::model()->findAll('assignment_account_id='.Yii::app()->user->id);
 		$LeaveType = array();
		foreach ($LeaveAssignment as $value) {
			if($value->assignment_leave_name=='Package'){
				$itemParkage = LeavePackageItem::model()->findAll('item_leave_package_id='.$value->assignment_leave_type_id);
				foreach ($itemParkage as $value_package) {
					
					if(!array_key_exists($value_package->item_leave_type_id, $LeaveType))
						$LeaveType[$leave_type_all[$value_package->item_leave_type_id]] = Yii::t('lang',$leave_type_all[$value_package->item_leave_type_id]);
				}

			}

			if($value->assignment_leave_name=='Leave Type'){
				
					
					if(array_key_exists($value->assignment_leave_type_id, $LeaveType))
						$LeaveType[$leave_type_all[$value->assignment_leave_type_id]] = Yii::t('lang',$leave_type_all[$value->assignment_leave_type_id]);
					

			}
		}

		if($canviewOwn){
			$leave_type=$LeaveType;
		}
		if($canview){
			$leave_type=$leave_type_user;
		}

		?>
		<?php echo $form->labelEx($model,Yii::t('lang','Type Leave *')); ?>
		<div class="controls">
	        <?php echo $form->dropDownList($model,'leave_type_name',$leave_type, array('prompt'=>Yii::t('lang','Select Leave Type'))); ?>
	    </div>
		
		<?php echo $form->error($model,'leave_type_name'); ?>
	</div>

	<div class="row">

		<?php echo $form->labelEx($model,Yii::t('lang','Reason *')); ?>
		<?php echo $form->textArea($model,'leave_reason',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'leave_reason'); ?>
	</div>

	<p><?php echo Yii::t('lang','*Please choose 13:30 for half-day point, if your leave involves half-day.');?> </p>
	<div class="row">
		
		<?php echo $form->labelEx($model,Yii::t('lang','Start *')); ?>
		<?php echo $form->textField($model,'leave_startdate'); ?>

		<?php echo $form->labelEx($model,Yii::t('lang','End *')); ?>
		<?php echo $form->textField($model,'leave_enddate'); ?>


		<?php echo $form->error($model,'leave_startdate'); ?>
		<?php echo $form->error($model,'leave_enddate'); ?>
	</div>
	
	<div class="list-style-date-select">
		<?php 
			$styledate=UserList::model()->getItemsForListCodeByName('leave_application_style_date',true);
			echo CHtml::dropDownList('leave_application_style_date[]','',$styledate);
		?>	
	</div>
	<div class="row row-list-date-setup" style="display: none;">
		<label class="list-title-date" style="padding: 0px;"></label>
		<div class="list-date-leave">
	
		</div>
		<label class="show-select-style-date">

		</label>
	</div>

	<?php if ($model->leave_id !='') { ?>
	<label class="title-detail" style="padding-left: 20px;"><i>Detail :</i></label>
	<div class="row row-list-date-update">
		
		<div class="list-date-update">
			
			<?php foreach ($oddDate as $value) { ?>
			<input type="text" name="leave_list_day[]" value="<?php echo $value; ?>" readonly />
			<?php } ?>

		</div>
		<label class="show-select-style-update">
			<?php foreach ($evenStatusDate as $value) { ?>
				<div class="list-style-date-update">
					<label><?php 
						echo CHtml::dropDownList('leave_application_style_date[]',$value,$styledate); ?> 
					</label>
				</div>
			<?php } ?>
			
		</label>
	</div>
	<?php } ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,Yii::t('lang','Approver *')); ?>
		<?php
			$account_approver=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true); 
			echo $form->dropDownList($model,'leave_approver',$account_approver, array('prompt'=>Yii::t('lang','Select')));
		?>
		<?php echo $form->error($model,'leave_approver'); ?>
	</div>

	<div class="row">
		<?php echo Yii::t('lang','CC-Receiver'); ?>
		<?php if ($model->leave_id =='') { ?>
			<ul>
				<div id="additional-inputs">
				    <li>
				    	<div class="item-select">
					    	<?php
								$account=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true);
								echo CHtml::dropDownList('leave_ccreceiver[]','',$account, array('prompt'=>Yii::t('lang','Select')));
							?>
						</div>
				    </li>
				</div>
			</ul>
		<?php } ?>
		<?php if ($model->leave_id !='') { ?>
			<ul>
				<div id="additional-inputs">
					<?php foreach ($leave_ccreceiver as $value) { ?>
					    <li>
					    	<div class="item-select">
								<div>
								<?php 
									$account=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true);
									echo CHtml::dropDownList('leave_ccreceiver[]',$value,$account, array('prompt'=>Yii::t('lang','Select'))); 
								?>
								</div>
								
							</div>
					    </li>
					<?php } ?>
				</div>
			</ul>
		<?php } ?>
		<?php echo CHtml::link(Yii::t('lang','Add CC-Receiver'),'',array('id'=>'additional-link')); ?>
		<?php echo $form->error($model,'leave_ccreceiver'); ?>
	</div>
	

	<div class="row buttons create-application">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('lang','Create') : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<style type="text/css">
	#leave-application-form .row {
		display: inline-flex;
		width: 100%;
	}
	#leave-application-form .row label {
		padding: 5px 0px 5px 5px;
		width: 130px;
	}
	#leave-application-form .row textarea {
		width: 80%;
	}
	.create-application input {
		color: rgb(91, 183, 91);
	    background: #fff;
	    border: 1px solid rgb(91, 183, 91);
	    padding: 4px 10px;
	    border-radius: 3px;
	}
	.color-erros {
		color: red;
	} 
	.color-erros-leave-type {
		bottom: 22px;
		position: relative;
		right: 219px;
	}
	
	.color-erros-reason {
		width: 200px;
	    position: relative;
	    bottom: 20px;
	    right: 432px;
	}
	.color-erros-start {
		width: 200px;
		position: absolute;
		left: 110px;
		top: 330px;
	}
	.color-erros-end {
		width: 200px;
		position: absolute;
		left: 110px;
		top: 386px;
	}
	.color-erros-approver {
		position: relative;
		right: 220px;
		bottom: 20px;
	}
	.dropdown-menu{    
		z-index: 1060;
	}
	li {
		list-style: none;
		margin-left: 30px;
	}
	#additional-link {
		width: 130px;
	    height: 23px;
	    border: 1px solid;
	    text-align: center;
	    padding-top: 4px;
	    border-radius: 3px;
	    margin-left: 10px;
	    text-decoration: none;
	    cursor: pointer;
	}
	.row-list-date-setup {
		margin-left: 115px;
	    background: #f3f3d2;
	    padding: 20px 20px 0px 20px;
	    width: 65% !important;
	}
	.row-list-date-update {
		margin-left: 115px;
	    background: #f3f3d2;
	    padding: 20px 20px 0px 20px;
	    width: 65% !important;
	}
	.list-title-date label {
		padding: 0 0 15px 0 !important;
	}
	.list-date {
		padding-bottom: 10px;
	}
	.list-style-date-select select {
		display: none;
	}
	.show-select-style-date div {
		padding-left: 25px;
		position: relative;
		bottom: 10px;
	}
	.show-select-style-update div {
		padding-left: 25px;
		position: relative;
	}
	.list-date-leave input {
		width: 90px;
	}
	.list-date-leave {
		width: 90px;
		position: relative;
		bottom: 5px;
	}
	.list-date-update input {
		width: 90px;
	    position: relative;
	    top: 16px;
	    margin-bottom: 25px;
	}
	.list-date-update {
		width: 90px;
		position: relative;
		bottom: 5px;
	}
</style>
<script type="text/javascript">

	// set up cc-receiver application leave
	var i = $('#additional-inputs li').size() + 1;
	
	$("#additional-link").bind("click",function(){

    	var addInput = $('.item-select').html();
    
	    $("#additional-inputs").append("<li><div>"+addInput+ '<a href="#" id="remScnt">Remove</a>' +"</div></li>");
    	i++;
        return false;

    });


    $('#remScnt').live('click', function() { 
    	
        if( i > 2 ) {
            $(this).parents('li').remove();
            i--;
        }
        return false;
    });

    // set up date application leave

	$(document).ready(function(){             
		$('#LeaveApplication_leave_startdate').datepicker({
		    format: "yyyy-mm-dd",
		    todayHighlight:'TRUE',
		    autoclose: true,
		    minDate: 0,
		    maxDate: '+1Y+6M'
		}).on('changeDate', function (ev) {
		        $('#LeaveApplication_leave_enddate').datepicker('setStartDate', $("#LeaveApplication_leave_startdate").val());
		});

		$('#LeaveApplication_leave_enddate').datepicker({
		    format: "yyyy-mm-dd",
		    todayHighlight:'TRUE',
		    autoclose: true,
		    minDate: '0',
		    maxDate: '+1Y+6M'
		}).on('changeDate', function (ev) {
			var start = $("#LeaveApplication_leave_startdate").val();
	        var startD = new Date(start);
	        var end = $("#LeaveApplication_leave_enddate").val();
	        var endD = new Date(end);
	        var diff = parseInt((endD.getTime()-startD.getTime())/(24*3600*1000))+1;
	        // $("#days").val(diff);
	        $('.row-list-date-setup').css('display', 'inline-flex');
	        $('.row-list-date-update').remove();	
	        $('.list-title-date label').remove();
	        $('.list-date-leave input').remove();
	        $('.show-select-style-date div').remove();
	        $('.title-detail').css('display', 'none');
	        for (var i = 0; i < diff; i++) {
	          var currentDate = new Date(startD.getTime());
	          var day = currentDate.getDate()+i;
	          var month = currentDate.getMonth()+1;
	          var year = currentDate.getFullYear();

	          var addSelectListDate = $('.list-style-date-select').html();
	          var listDay = month + "/" + day + "/" + year;
          	  var sumI = i + 1;
          	  $(".list-title-date").append("<label>"+ "Date " + sumI + " :" +"</label>")
        	  $(".list-date-leave").append('<input type="text" name="leave_list_day[]" value="'+listDay+'" readonly />');

			  $(".show-select-style-date").append("<div>"+ addSelectListDate +"</div>");

	        };
		});

	});


	function checkdata(){
		var LeaveApplication_leave_type_name = $('#LeaveApplication_leave_type_name').val();
		var LeaveApplication_leave_reason = $('#LeaveApplication_leave_reason').val();
		var LeaveApplication_leave_startdate = $('#LeaveApplication_leave_startdate').val();
		var LeaveApplication_leave_enddate = $('#LeaveApplication_leave_enddate').val();
		var LeaveApplication_leave_approver = $('#LeaveApplication_leave_approver').val();

		var check = true;

		// require leavetype
		if(LeaveApplication_leave_type_name==''){
			$('#LeaveApplication_leave_type_name_em_').css('display', 'block');
			$('#LeaveApplication_leave_type_name_em_').html('<p class="color-erros color-erros-leave-type"><i>Type Leave cannot be blank !</i></p>');
			
			check = false;
		}
		else{
			$('#LeaveApplication_leave_type_name_em_').css('display', 'none');
			
		}

		// require reason
		if (LeaveApplication_leave_reason=='') {
			$('#LeaveApplication_leave_reason_em_').css('display', 'block');
			$('#LeaveApplication_leave_reason_em_').html('<p class="color-erros color-erros-reason"><i>Reason cannot be blank !</i></p>');
			
			check = false;
		}
		else{

			$('#LeaveApplication_leave_reason_em_').css('display', 'none');
			
		}
		// require startdate
		if (LeaveApplication_leave_startdate=='') {
			$('#LeaveApplication_leave_startdate_em_').css('display', 'block');
			$('#LeaveApplication_leave_startdate_em_').html('<p class="color-erros color-erros-start"><i>Start date cannot be blank !</i></p>');
			
			check = false;
		}
		else{

			$('#LeaveApplication_leave_startdate_em_').css('display', 'none');
			
		}
		// require enddate
		if (LeaveApplication_leave_enddate=='') {
			$('#LeaveApplication_leave_enddate_em_').css('display', 'block');
			$('#LeaveApplication_leave_enddate_em_').html('<p class="color-erros color-erros-end"><i>Enddate cannot be blank !</i></p>');
			
			check = false;
		}
		else{

			$('#LeaveApplication_leave_enddate_em_').css('display', 'none');
			
		}

		// require approver
		if (LeaveApplication_leave_approver=='') {
			$('#LeaveApplication_leave_approver_em_').css('display', 'block');
			$('#LeaveApplication_leave_approver_em_').html('<p class="color-erros color-erros-approver"><i>Approver cannot be blank !</i></p>');
			
			check = false;
		}
		else{

			$('#LeaveApplication_leave_approver_em_').css('display', 'none');
			
		}

		return check;
	}
</script>