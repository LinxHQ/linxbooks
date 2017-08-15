<?php
/* @var $this LeaveInLieuController */
/* @var $model LeaveInLieu */

$this->breadcrumbs=array(
	'Leave In Lieus'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LeaveInLieu', 'url'=>array('index')),
	array('label'=>'Create LeaveInLieu', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#leave-in-lieu-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$years=UserList::model()->getItemsForListCodeByName('leave_year',true);


$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canview = BasicPermission::model()->checkModules($m, 'view');
$canEdit = BasicPermission::model()->checkModules($m, 'update');
$canviewOwn = BasicPermission::model()->checkModules($m, 'view',Yii::app()->user->id);
$canDelete = BasicPermission::model()->checkModules($m, 'delete');
$canViewPacPerIn = DefinePermission::model()->checkFunction($m, 'Leave Management');


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
<div class="control-group" style="display: inline-flex;">
    <?php echo CHtml::label(Yii::t('lang','Year :'), '',array('class'=>'control-label style-application'));?>
    <div class="controls">
        <?php 
        	echo CHtml::dropDownList('inlieu_id',"", $years ,array('prompt'=>Yii::t('lang','Year'),'class'=>'span2','onchange'=>'searchLeaveInlieu();')); 
        ?>
    </div>

</div>

<?php 

$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'leave-in-lieu-grid',
	'itemsCssClass' => 'table-bordered items',
	'dataProvider'=>$model->search(),
	// 'filter'=>$model,
	'columns'=>array(
		// array(
		// 	'class'=>'bootstrap.widgets.TbButtonColumn',
  //           'template' => '{delete}',
  //           'deleteButtonUrl'=>'Yii::app()->createUrl("/lbLeave/leaveInLieu/Delete", array("id" => $data->leave_in_lieu_id))',
		// ),

		array(

                'header'=>Yii::t('lang','Leave In Lieu'),
                'name'=>'leave_in_lieu_name',
                'type'=>'raw',
                'cssClassExpression'=>"'inlieuuseradmin'",
                'value'=>'$data->leave_in_lieu_name',
                'htmlOptions'=>array('style'=>'width:400px;'),
                'footer'=> CHtml::textField('leave_in_lieu_name','',array()),
            ),

		array(
                'header'=>Yii::t('lang','Date'),
                'name'=>'leave_in_lieu_day',
                'type'=>'raw',
                'cssClassExpression'=>"'inlieuuseradmin'",
                'value'=>'$data->leave_in_lieu_day',
                'htmlOptions'=>array('style'=>'width:400px;'),
                'footer'=> CHtml::dateField('leave_in_lieu_day','',array()),
            ),

		array(
                'header'=>Yii::t('lang','Total of Days'),
                'name'=>'leave_in_lieu_totaldays',
                'type'=>'raw',
                'cssClassExpression'=>"'inlieuuseradmin'",
                'value'=>'$data->leave_in_lieu_totaldays',
                'htmlOptions'=>array('style'=>'width:400px;'),
                'footer'=> CHtml::textField('leave_in_lieu_totaldays','',array()),
            ),
		array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'template' => '{delete}',
                'cssClassExpression'=>"'inlieuuseradminDelete'",
                'deleteButtonUrl'=>'Yii::app()->createUrl("/lbLeave/leaveInLieu/Delete", array("id" => $data->leave_in_lieu_id))',
                'htmlOptions'=>array('style'=>'width: 50px;text-align: center;'),
                'footer'=> CHtml::button(Yii::t('lang','Add'),array('name'=>'AddInLieu','class'=>'button-inlieu','onclick'=>'AjaxAddInLieu();return false')),
            ),



		// 'leave_in_lieu_id',


		// 'account_create_id',
		
	),
));

?>


<!-- style css -->
<style type="text/css">
	.button-inlieu {
		border: 1px solid rgb(91, 183, 91)!important;
		background: #fff;
		color: rgb(91, 183, 91)!important;
		border-radius: 4px;
        padding: 3px 12px;
	}

	/* .view, .update {
		display: none;
	} */
    #leave-in-lieu-grid .control-group {
        display: none !important;
    }

</style>

<!-- jquery -->
<script type="text/javascript">
    var canViewPacPerIn = '<?php echo $canViewPacPerIn; ?>';
    var canEdit = '<?php echo $canEdit; ?>';
    if((canEdit==0)&&(canViewPacPerIn==0)){
        $('td.inlieuuseradmin a').contents().unwrap();
    }

    var canDelete = '<?php echo $canDelete; ?>';
    if((canDelete==0)&&(canViewPacPerIn==0)){
        $('td.inlieuuseradminDelete a').remove();
    }

    var canAdd = '<?php echo $canAdd; ?>';
    
    if((canAdd==0)&&(canViewPacPerIn==0)){
        $('#leave-in-lieu-grid table tfoot').remove();
    }


	function AjaxAddInLieu()
    {
        var leave_in_lieu_name = $('#leave_in_lieu_name').val();
        var leave_in_lieu_day = $('#leave_in_lieu_day').val();
        var leave_in_lieu_totaldays = $('#leave_in_lieu_totaldays').val();
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/lbLeave/leaveInLieu/AddInLieu'); ?>',
            data:{leave_in_lieu_name:leave_in_lieu_name,leave_in_lieu_day:leave_in_lieu_day,leave_in_lieu_totaldays:leave_in_lieu_totaldays},
            beforeSend: function(data)
            {
                //code..
            },
            success:function(response)
            {
                $.fn.yiiGridView.update('leave-in-lieu-grid');
            },
            error: function(data){
                //code...
            }
        });
    }

    function searchLeaveInlieu(){

        var inlieu_id = $('#inlieu_id').val();
        $('#leave-in-lieu-grid').load('<?php echo Yii::app()->baseUrl; ?>/lbLeave/leaveInLieu/searchLeaveInlieu',{inlieu_id: inlieu_id});
        
    }

</script>