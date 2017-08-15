<?php
/* @var $this LeavePackageItemController */
/* @var $model LeavePackageItem */

$this->breadcrumbs=array(
	'Leave Package Items'=>array('index'),
	'Manage',
);

// $this->menu=array(
// 	array('label'=>'List LeavePackageItem', 'url'=>array('index')),
// 	array('label'=>'Create LeavePackageItem', 'url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#leave-package-item-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>





<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'leave-package-item-grid',
    'itemsCssClass' => 'table-bordered items',
	'dataProvider'=>$model->search(),
	// 'filter'=>$model,
	'columns'=>array(

        // 'item_leave_package_id',
		array(
                'class' => 'editable.EditableColumn',
                'header'=>Yii::t('lang','Type Leave'),
                'name'=>'item_leave_type_id',
                'type'=>'raw',
                // 'value'=>'$data->item_leave_type_id',
                'value'=>function($data){
					$leaveType=UserList::model()->getItemsListCodeById('leave_type',true);
					return $leaveType[$data->item_leave_type_id];
				},
                'editable' => array(
                        'placement'  => 'right',
                       'url'        => $this->createUrl('/lbLeave/leavePackageItem/AjaxUpdateField'),
                       'type'     => 'select',
                       'source'   =>UserList::model()->getItemsListCodeById('leave_type',true),
                       'onSave' => 'js: function(e, params) {
                              console && console.log("saved value: "+params.newValue);
                         }',
                     ),
                'htmlOptions'=>array('style'=>'width:400px;'),
                'footer'=> CHtml::dropDownList('item_leave_type_id',"", UserList::model()->getItemsListCodeById('leave_type',true) ,array('class'=>'span3')),
            ),

		array(
                'class' => 'editable.EditableColumn',
                'header'=>Yii::t('lang','Total of Days'),
                'name'=>'item_total_days',
                'type'=>'raw',
                'value'=>'$data->item_total_days',
                'editable' => array(
                        
                        'inputclass' => 'span3',
                        'apply'      => '$data->item_total_days', //can't edit deleted users
                        'url'        => $this->createUrl('/lbLeave/leavePackageItem/AjaxUpdateField'),
                        'placement'  => 'right',
                     ),
                'htmlOptions'=>array('style'=>'width:400px;'),
                'footer'=> CHtml::textField('item_total_days','',array()),
            ),
		array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'template' => '{delete}',
                'deleteButtonUrl'=>'Yii::app()->createUrl("/lbLeave/leavePackageItem/Delete", array("id" => $data->item_id))',
                'htmlOptions'=>array('style'=>'width: 50px;text-align: center;'),
                'footer'=> CHtml::button(Yii::t('lang','Add'),array('name'=>'AddPackageItem','class'=>'button-inlieu','onclick'=>'AjaxAddPackageItem();return false')),
            ),
	),
)); ?>

<script type="text/javascript">
	function AjaxAddPackageItem()
    {
        var item_leave_package = $('#item_leave_package_id').val();
        var item_leave_type = $('#item_leave_type_id').val();
        var item_total_days = $('#item_total_days').val();
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/lbLeave/leavePackageItem/AddPackageItem'); ?>',
            data:{item_leave_package:item_leave_package,item_leave_type:item_leave_type,item_total_days:item_total_days},
            beforeSend: function(data)
            {
                //code..
            },
            success:function(response)
            {
                $.fn.yiiGridView.update(load_package_by_custom());
            },
            error: function(data){
                //code...
            }
        });
    }

    
</script>
<style type="text/css" media="screen">
   /*  #leave-package-item-grid {
        padding-top: 35px;
    } */
    #leave-assignment-leavetype-grid table tbody tr td.assignment-delete {
        width: 142px !important;
    }
    .button-inlieu {
        border: 1px solid rgb(91, 183, 91)!important;
        background: #fff;
        color: rgb(91, 183, 91)!important;
        border-radius: 4px;
        padding: 3px 12px;
    }
</style>