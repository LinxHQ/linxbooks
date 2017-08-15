<?php
/* @var $this LeaveAssignmentController */
/* @var $model LeaveAssignment */

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canview = BasicPermission::model()->checkModules($m, 'view');
$canEdit = BasicPermission::model()->checkModules($m, 'update');
$canviewOwn = BasicPermission::model()->checkModules($m, 'view',Yii::app()->user->id);
$canDelete = BasicPermission::model()->checkModules($m, 'delete');
$canViewPacPerIn = DefinePermission::model()->checkFunction($m, 'Leave Management');

$this->breadcrumbs=array(
	'Leave Assignments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LeaveAssignment', 'url'=>array('index')),
	array('label'=>'Create LeaveAssignment', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#leave-assignment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$account = array();
$drop_user = '';
if($canviewOwn){
    $account=array(Yii::app()->user->id=>AccountProfile::model() -> getFullName(Yii::app()->user->id));
    $drop_user = CHtml::dropDownList('assignment_account_id',"", $account ,array('class'=>'span3','onchange'=>'searchAssignmentAccount();'));
}
if($canview){
    $account=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true);
    $drop_user = CHtml::dropDownList('assignment_account_id',"", $account ,array('prompt'=>Yii::t('lang','Select Employee'),'class'=>'span3','onchange'=>'searchAssignmentAccount();')); 
}
if($canViewPacPerIn==1){
    $account=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true);
    $drop_user = CHtml::dropDownList('assignment_account_id',"", $account ,array('prompt'=>Yii::t('lang','Select Employee'),'class'=>'span3','onchange'=>'searchAssignmentAccount();')); 
}

// $account=AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true);
$years=UserList::model()->getItemsListCodeById('leave_year',true);



// $role = AccountRoles::model()->getRoleByAccount(Yii::app()->user->id);
// $isuAdmin = false;
// foreach ($role->data as $value) {
   
//    if ($value->role_id == 2) {

//       $isuAdmin = true;
//    }else {
//       $isuAdmin = false;
//    };
// }
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
	        	echo CHtml::dropDownList('assignment_year_id',"", $years ,array('prompt'=>Yii::t('lang','Year'),'class'=>'span2','onchange'=>'searchAssignmentAccount();')); 
	        ?>
	    </div>

	</div>
</div>
<div id="search-assignment-account" style="">
	<p style="color: rgb(91, 183, 91);"><b><?php echo Yii::t('lang','Assigned Package') ?></b></p>

<?php 

    $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'leave-assignment-grid',
    'itemsCssClass' => 'table-bordered items',
    'dataProvider'=>$model->search('Package'),
    // 'filter'=>$model,
    'columns'=>array(

        // 'item_leave_package_id',
        array(
                'header'=>Yii::t('lang','Type Leave'),
                'name'=>'assignment_leave_type_id',
                'type'=>'raw',
                // 'value'=>'$data->item_leave_type_id',
                'value'=>function($data){
                    if (isset($data)) {
                        $package = LeavePackage::model()->findByPk($data->assignment_leave_type_id);
                        
                        if (isset($package->leave_package_name)) {
                            return $package->leave_package_name;
                        }
                        else {
                            return '';
                        }
                    };
                },
                'htmlOptions'=>array('style'=>'width:400px;'),
                'footer'=> CHtml::dropDownList('assignment_leave_type_id0',"", CHtml::listData(LeavePackage::model()->findAll(), 'leave_package_id', 'leave_package_name'),array('prompt'=>Yii::t('lang','Select Package'),'onchange'=>'load_package_by_custom();')),
            ),

        array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'cssClassExpression'=>"'assignment-delete'",
                'template' => '{delete}',
                'deleteButtonUrl'=>'Yii::app()->createUrl("/lbLeave/leaveAssignment/Delete", array("id" => $data->assignment_id))',
                'htmlOptions'=>array('style'=>'width: 50px;text-align: center;'),
                'footer'=> CHtml::button(Yii::t('lang','Add'),array('name'=>'AddPackageAssignment','class'=>'btn btn-add-assignment','onclick'=>'AjaxAddPackageAssignment();return false')),
            ),
    ),
)); 

?>


<p style="color: rgb(91, 183, 91);"><b><?php echo Yii::t('lang','Assigned Leave Entitlement (Other than from package)') ?></b></p>
<?php 
    $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'leave-assignment-leavetype-grid',
    'itemsCssClass' => 'table-bordered items',
    'dataProvider'=>$model->search('Leave Type'),
    // 'filter'=>$model,
    'columns'=>array(

        // 'item_leave_package_id',
        array(
                'header'=>Yii::t('lang','Leave Type'),
                'name'=>'assignment_leave_type_id',
                'type'=>'raw',
                // 'value'=>'$data->item_leave_type_id',
                'value'=>function($data){
                    if (isset($data)) {
                        $leaveType=UserList::model()->findByPk($data->assignment_leave_type_id);
                        if (isset($leaveType->system_list_item_name)) {
                            return Yii::t('lang',$leaveType->system_list_item_name);
                        }
                        else {
                            return '';
                        }
                        
                    }
                },
                'htmlOptions'=>array('style'=>'width:400px;'),
                'footer'=> CHtml::dropDownList('assignment_leave_type_id2',"", UserList::model()->getItemsListCodeById('leave_type',true) ,array('class'=>'span3','prompt'=>Yii::t('lang','Select Type Leave'))),
            ),
        array(
                'header'=>Yii::t('lang','Total of Days'),
                'name'=>'assignment_total_days',
                'type'=>'raw',
                'value'=>'$data->assignment_total_days',
                'htmlOptions'=>array('style'=>'width:400px;'),
                'footer'=> CHtml::textField('assignment_total_days','',array()),
            ),

        array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'template' => '{delete}',
                'cssClassExpression'=>"'assignment-delete'",
                'deleteButtonUrl'=>'Yii::app()->createUrl("/lbLeave/leaveAssignment/Delete", array("id" => $data->assignment_id))',
                'htmlOptions'=>array('style'=>'width: 50px;text-align: center;'),
                'footer'=> CHtml::button(Yii::t('lang','Add'),array('name'=>'AddLeaveTypeAssignment','class'=>'btn btn-add-assignment','onclick'=>'AjaxAddLeaveTypeAssignment();return false')),
            ),
    ),
)); 
?>


<p style="color: rgb(91, 183, 91);"><b><?php echo Yii::t('lang','In -Lieu Leave') ?></b></p>

<?php 
    $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'leave-assignment-inlieu-grid',
    'itemsCssClass' => 'table-bordered items',
    'dataProvider'=>$model->search('In Lieu'),
    // 'filter'=>$model,
    'columns'=>array(

        // 'item_leave_package_id',
        array(
                'header'=>Yii::t('lang','Type Leave'),
                'name'=>'assignment_leave_type_id',
                'type'=>'raw',
                // 'value'=>'$data->item_leave_type_id',
                'value'=>function($data){
                    if (isset($data)) {
                        $inlieu = LeaveInLieu::model()->findByPk($data->assignment_leave_type_id);

                        return $inlieu->leave_in_lieu_name;
                    }
                },
                'htmlOptions'=>array('style'=>'width:400px;'),
                'footer'=> CHtml::dropDownList('assignment_leave_type_id3',"", CHtml::listData(LeaveInLieu::model()->findAll(), 'leave_in_lieu_id', 'leave_in_lieu_name'),array('prompt'=>Yii::t('lang','Select In Lieu'))),
            ),

        array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'template' => '{delete}',
                'cssClassExpression'=>"'assignment-delete'",
                'deleteButtonUrl'=>'Yii::app()->createUrl("/lbLeave/leaveAssignment/Delete", array("id" => $data->assignment_id))',
                'htmlOptions'=>array('style'=>'width: 50px;text-align: center;'),
                'footer'=> CHtml::button(Yii::t('lang','Add'),array('name'=>'AddInLieuAssignment','class'=>'btn btn-add-assignment','onclick'=>'AjaxAddInLieuAssignment();return false')),
            ),
    ),
)); 

?>
</div>


<script type="text/javascript">

    

	function AjaxAddPackageAssignment()
    {
        var assignment_account = $('#assignment_account_id').val();
        var assignment_year = $('#assignment_year_id').val();
        var assignment_leave_type = $('#assignment_leave_type_id0').val();
        // alert(assignment_account);
        // alert(assignment_year);
        // alert(assignment_leave_type);
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/lbLeave/leaveAssignment/AddPackageAssignment'); ?>',
            data:{assignment_account:assignment_account,assignment_year:assignment_year,assignment_leave_type:assignment_leave_type},
            beforeSend: function(data)
            {
                //code..
            },
            success:function(response)
            {
                searchAssignmentAccount();
            },
            error: function(data){
                //code...
            }
        });
    }

    // searchAssignmentAccount();
    
    function AjaxAddLeaveTypeAssignment()
    {
        var assignment_account = $('#assignment_account_id').val();
        var assignment_year = $('#assignment_year_id').val();
        var assignment_leave_type = $('#assignment_leave_type_id2').val();
        var assignment_total_days = $('#assignment_total_days').val();
        // alert(assignment_account);
        // alert(assignment_year);
        // alert(assignment_leave_type);
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/lbLeave/leaveAssignment/AddLeaveTypeAssignment'); ?>',
            data:{assignment_account:assignment_account,assignment_year:assignment_year,assignment_leave_type:assignment_leave_type,assignment_total_days:assignment_total_days},
            beforeSend: function(data)
            {
                //code..
            },
            success:function(response)
            {
                searchAssignmentAccount();
            },
            error: function(data){
                //code...
            }
        });
    }
    function AjaxAddInLieuAssignment()
    {
        var assignment_account = $('#assignment_account_id').val();
        var assignment_year = $('#assignment_year_id').val();
        var assignment_leave_type = $('#assignment_leave_type_id3').val();
        var assignment_total_days = $('#assignment_total_days').val();
        // alert(assignment_account);
        // alert(assignment_year);
        // alert(assignment_leave_type);
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/lbLeave/leaveAssignment/AddInLieuAssignment'); ?>',
            data:{assignment_account:assignment_account,assignment_year:assignment_year,assignment_leave_type:assignment_leave_type,assignment_total_days:assignment_total_days},
            beforeSend: function(data)
            {
                //code..
            },
            success:function(response)
            {
                searchAssignmentAccount();
            },
            error: function(data){
                //code...
            }
        });
    }
    var assignment_account_id = $('#assignment_account_id').val()
    if (assignment_account_id==='') {
        searchAssignmentAccount();
    }

    function searchAssignmentAccount(){
    	var assignment_account_id = $('#assignment_account_id').val();
        var assignment_year_id = $('#assignment_year_id').val();
    	if (assignment_account_id==='') {
    		$('#search-assignment-account').css('display', 'none');
    	}
    	else {
    		$('#search-assignment-account').css('display', 'block');
    	}
    	$('#search-assignment-account').load('<?php echo Yii::app()->baseUrl; ?>/lbLeave/leaveAssignment/searchAssignmentAccount',{
    				assignment_account_id: assignment_account_id,assignment_year:assignment_year_id});
    	
    }
    var canViewPacPerIn = '<?php echo $canViewPacPerIn; ?>'
    var canDelete = '<?php echo $canDelete; ?>';
    if((canDelete==0)&&(canViewPacPerIn==0)){
        $('td.assignment-delete a').remove();
    }
    var canAdd = '<?php echo $canAdd; ?>';
    if((canAdd==0)&&(canViewPacPerIn==0)){
        $('#leave-assignment-grid table tfoot').remove();
        $('#leave-assignment-leavetype-grid table tfoot').remove();
        $('#leave-assignment-inlieu-grid table tfoot').remove();
    }
    
</script>
<style type="text/css" media="screen">
#leave-assignment-grid table thead,
#leave-assignment-leavetype-grid table thead,
#leave-assignment-inlieu-grid table thead {
    display: none;
}	
#search-assignment-account .select-employee, .summary {
	display: none !important;
}
.btn-add-assignment {
    border: 1px solid rgb(91, 183, 91)!important;
    border-radius: 4px;
    color: rgb(91, 183, 91)!important;
    background: #fff;
}
.button-column {
    text-align: center !important;
}
/* #leave-assignment-leavetype-grid, #leave-assignment-inlieu-grid, #leave-assignment-grid {
    width: 530px;
} */
</style>
