<?php
/* @var $this LeavePackageController */
/* @var $model LeavePackage */

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canview = BasicPermission::model()->checkModules($m, 'view');
$canEdit = BasicPermission::model()->checkModules($m, 'update');
$canviewOwn = BasicPermission::model()->checkModules($m, 'view',Yii::app()->user->id);
$canViewPacPerIn = DefinePermission::model()->checkFunction($m, 'Leave Management');
// echo $canViewPacPerIn;
// exit();
$this->breadcrumbs=array(
	'Leave Packages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LeavePackage', 'url'=>array('index')),
	array('label'=>'Create LeavePackage', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#leave-package-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$account=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true);
?>


 <!-- Modal -->
<div class="modal fade" id="myModalPackage" style="position: absolute; left: 20%; width: 60%; margin-left: 0px;     overflow: hidden;" role="dialog">
    <div class="modal-dialog">
		
      <!-- Modal content-->
        <div class="modal-content">
			

             <h2 style="background: rgb(91, 183, 91); color: #fff; text-align: left; padding: 8px 20px; margin-top: 0; border-radius: 5px 5px 0px 0px;"><?php echo Yii::t('lang','Add new package') ?></h2>
            <button style="float: right;position: relative;bottom: 55px;right: 10px;background: rgb(91, 183, 91);border: none;" type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-remove"></i></button>
             <div class="form-new-package" style="width: 90%;margin: auto;">
                
             </div>
      
        </div>
    </div>
</div>

<div>
	<span style="position: relative;bottom: 5px;"><?php echo Yii::t('lang','Package') ?> : </span>
	
	<?php 
		$leave_package=CHtml::listData(LeavePackage::model()->findAll(), 'leave_package_id', 'leave_package_name');
		$leave_package_show = CHtml::dropDownList('item_leave_package_id',"", $leave_package ,array('prompt'=>Yii::t('lang','Select Package'),'onchange'=>'load_package_by_custom();'));


		$LeaveAssignment = LeaveAssignment::model()->findAll('assignment_account_id='.Yii::app()->user->id);

 		$LeaveType = array();
 		$leave_type_package = '';
		foreach ($LeaveAssignment as $value) {
			if($value->assignment_leave_name=='Package'){
				$itemParkage = LeavePackageItem::model()->findAll('item_leave_package_id='.$value->assignment_leave_type_id);
				$package = LeavePackage::model()->findByPk($value->assignment_leave_type_id);
				if (isset($package->leave_package_name)) {
					$package_name = $package->leave_package_name;
				}
				?>
				<p style="color: rgb(91, 183, 91)">
				<?php if (isset($package_name)) {
					echo $package_name;
				} ?></p>
				<table class="table-bordered items table" style="margin-bottom: 100px;">
						<thead>
							<tr>
								<th style="width: 60%;"><?php echo Yii::t('lang','Type Leave'); ?></th>
								<th style="width: 40%;"><?php echo Yii::t('lang','Total of Days'); ?></th>
							</tr>
						</thead>
				<?php
				foreach ($itemParkage as $value_package) {
					$leave_type_all=UserList::model()->getItemsListCodeById('leave_type',true);
					$package_name_total_day = $value_package->item_total_days;
					$package_name_type_user = $leave_type_all[$value_package->item_leave_type_id];
					?>
					
						<tbody>
							<tr>
								<td><?php echo $package_name_type_user; ?></td>
								<td><?php echo $package_name_total_day; ?></td>
							</tr>
						</tbody>
					
					<?php



				}
				?>
				</table>
				<?php

			}
		}
		if($canviewOwn){
			$leave_type_package='';
		}
		if($canview){
			$leave_type_package=$leave_package_show;
		}
		if($canViewPacPerIn==1){
			$leave_type_package=$leave_package_show;
		}

	?>

	<?php 
		echo $leave_type_package;

	?>
	<!-- ?php echo CHtml::dropDownList('employee_id',"", $model ,array('prompt'=>'Select Employee','class'=>'span3','onchange'=>'searchLeaveAplication();')); ?> -->
		<a id="add-package-tab" style="position: relative;bottom: 5px;border: 1px solid rgb(91, 183, 91)!important;border-radius: 4px;padding: 5px;}" href="#" data-toggle="modal" data-target="#myModalPackage" onclick="load_ajax_package();"><?php echo Yii::t('lang','Create New Package'); ?></a>
	
		<a id="remove-package" style="position: relative;bottom: 5px;border: 1px solid rgb(91, 183, 91)!important;border-radius: 4px;padding: 5px; display: none;}" href="#" data-toggle="" data-target="" onclick="DeleteAll();"><?php echo Yii::t('lang','Delete Package Current'); ?></a>
</div>
<div id="show-hide-packageitem" style="display: none;">
<p style="position: relative;top: 45px;"><?php echo Yii::t('lang','Entitlement'); ?> :</p>

	<div id="griview_package_item">
		<?php $this->renderPartial('lbLeave.views.leavePackageItem.admin',array(
					'model'=>$modelitempackage,)); 
		?>
	</div>
</div>

<script type="text/javascript">
	function load_ajax_package(){
	    $.ajax({
	        url : "<?php echo Yii::app()->baseUrl; ?>/lbLeave/leavePackage/FormCreatePackage",
	        type : "post",
	        success : function (result){
	            $('.form-new-package').html(result);
	        }
	    });

	}

	function load_package_by_custom(){
    	var item_leave_package_id = $('#item_leave_package_id').val();
    	if (item_leave_package_id==='') {
    		$('#show-hide-packageitem').css('display', 'none');
    		$('#remove-package').css('display', 'none');
    	}
    	else {
    		$('#show-hide-packageitem').css('display', 'block');
    		$('#remove-package').css('display', 'inline');
    	}
    	$('#griview_package_item').load('<?php echo Yii::app()->baseUrl; ?>/lbLeave/leavePackageItem/SearchLeavePackageItem',{
    				item_leave_package_id: item_leave_package_id});
    	
    }
    function DeleteAll() {
    	var item_leave_package_id = $('#item_leave_package_id').val();
    	$.ajax({
	        url : "<?php echo Yii::app()->baseUrl; ?>/lbLeave/leavePackage/DeleteAll",
	        type : "post",
	        data:{id:item_leave_package_id},
	        success : function (result){
	        	$('#griview_package_item').fadeOut(100, function(){
                            $('#griview_package_item').html(msg).fadeIn().delay(1000);
                        });
	        	$('#item_leave_package_id').fadeOut(100, function(){
                            $('#item_leave_package_id').html(msg).fadeIn().delay(1000);
                        });
	        }

	    });
    }

    var canAdd = '<?php echo $canAdd; ?>';
    var canViewPacPerIn = '<?php echo $canViewPacPerIn; ?>'   
    if((canAdd==0)&&(canViewPacPerIn==0)){
        $('#add-package-tab').remove();
        $('#select-package-user').remove();
    }

</script>
<style type="text/css" media="screen">
	#griview_package_item {
		padding-top: 40px;
	}
	#item_leave_package_id {
		border: 1px solid rgb(91, 183, 91)!important;
		height: 28px;
		margin-bottom: 12px;
	}
	#show-hide-packageitem {
		position: relative;
    	bottom: 12px;
	}
</style>
