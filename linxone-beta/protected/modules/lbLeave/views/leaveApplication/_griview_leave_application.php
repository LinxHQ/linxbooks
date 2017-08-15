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

<?php 
$leave_type_all=UserList::model()->getItemsListCodeByIdApp('leave_type',true);
$leave_type_user=UserList::model()->getItemsForListCodeByName('leave_type',true);

$LeaveAssignment = LeaveAssignment::model()->findAll();
$LeaveType = array();
foreach ($LeaveAssignment as $value) {
  if($value->assignment_leave_name=='Package'){

      $itemParkage = LeavePackageItem::model()->findAll('item_leave_package_id='.$value->assignment_leave_type_id);

    foreach ($itemParkage as $value_package) {
      
      if(!array_key_exists($value_package->item_leave_type_id, $LeaveType))
        $LeaveType[$leave_type_all[$value_package->item_leave_type_id]] = Yii::t('lang', $leave_type_all[$value_package->item_leave_type_id]);
    }

  }

  if($value->assignment_leave_name=='Leave Type'){
    
      
      if(array_key_exists($value->assignment_leave_type_id, $LeaveType))
        $LeaveType[$leave_type_all[$value->assignment_leave_type_id]] = Yii::t('lang',$leave_type_all[$value->assignment_leave_type_id]);
      

  }
}
if ($canview == 1) {
  $leave_type = $leave_type_user;
}
else {
  $leave_type=$LeaveType;
}

// if($canviewOwn){
  
// }
// if($canview){
//   $leave_type=$leave_type_user;
// }

?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'leave-application-grid',
	'itemsCssClass' => 'table-bordered items',
	'dataProvider'=>$model->search(),
	// 'filter'=>$model,
	'columns'=>array(
		// 'leave_id',

		array(
			'header'=> '',
			'type'=>'raw',
			'value'=>function($data){
				return CHtml::CheckBox('checkboxApplication[]',false, array (
                                        'value'=>$data->leave_id,'class'=>'checkboxApplication','id'=>$data->leave_id
                                        ));
			}
			),
    array(
      'name'=>'account_id',
      'header'=>Yii::t('lang','Employee'),
      'type'=>'raw',
      'value'=>function($data){
        return AccountProfile::model() -> getFullName($data->account_id);
      },
      ),
		array(
       'class' => 'editable.EditableColumn',
       'header'=>Yii::t('lang','Type Leave'),
       'name' => 'leave_type_name',
       'cssClassExpression'=>'$data->leave_status',
       'editable' => array(    //editable section
       		  'type'     => 'select',
              'url'      => $this->createUrl('/lbLeave/leaveApplication/AjaxUpdateField'),
              'source'   => $leave_type,
             //onsave event handler 
             'onSave' => 'js: function(e, params) {
                  console && console.log("saved value: "+params.newValue);
             }',
          ),             
        ),
        array(
           // 'class' => 'editable.EditableColumn',
           'header'=>Yii::t('lang','Reason'),
           'name' => 'leave_reason',
           'cssClassExpression'=>'$data->leave_status',
           // 'editable' => array(    //editable section
           //        'apply'      => '$data->leave_reason', //can't edit deleted users
           //        'url'        => $this->createUrl('/lbLeave/leaveApplication/AjaxUpdateField'),
           //        'placement'  => 'right',
           //    )               
        ),
		array( 
              'name'  => 'leave_startdate',
              'header'=>Yii::t('lang','Start'),
              'cssClassExpression'=>'$data->leave_status',
         ), 
		array( 
              'name'  => 'leave_enddate',
              'header'=>Yii::t('lang','End'),
              'cssClassExpression'=>'$data->leave_status',
            //   'value' => function($data) {
            //   return $this->renderPartial('lbLeave.views.leaveApplication._view_enddate',array('model'=>$data),false);
            // },
         ), 
		array(
			// 'class' => 'editable.EditableColumn',
      'header'=>Yii::t('lang','Approver'),
			'name'=>'leave_approver',
			'cssClassExpression'=>'$data->leave_status',
			'type'=>'raw',
			'value'=>function($data){
				return AccountProfile::model() -> getFullName($data->leave_approver);
			},
			// 'editable' => array(    //editable section
   //         		  'type'     => 'select',
   //                'url'      => $this->createUrl('/lbLeave/leaveApplication/AjaxUpdateField'),
   //                'source'   => AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true),
   //               //onsave event handler 
   //               'onSave' => 'js: function(e, params) {
   //                    console && console.log("saved value: "+params.newValue);
   //               }',
   //            )  
			),
		array(
			// 'class' => 'editable.EditableColumn',
      'header'=>Yii::t('lang','CC-Receiver'),
			'name'=>'leave_ccreceiver',
			'cssClassExpression'=>'$data->leave_status',
			'type'=>'raw',
			'value'=>function($data){
     
        $account_id = explode(',', $data->leave_ccreceiver);

        foreach ($account_id as $value) {
             $account = AccountProfile::model() -> getFullName($value);
             echo $account. "<br>";
        }
			},
			// 'editable' => array(    //editable section
   //         		  'type'     => 'select',
   //                'url'      => $this->createUrl('/lbLeave/leaveApplication/AjaxUpdateField'),
   //                'source'   => AccountTeamMember::model()->getDropTeam(Yii::app()->user->linx_app_selected_subscription,true),
   //               //onsave event handler 
   //               'onSave' => 'js: function(e, params) {
   //                    console && console.log("saved value: "+params.newValue);
   //               }',
   //            ) 
			),

		
		// 'leave_name',
		array(
			'name'=>'leave_status',
      'header'=>Yii::t('lang','Status'),
			'type'=>'raw',
			'value'=>function($data){
				$status=UserList::model()->getItemsListCodeById('status_list',true);
				return $status[$data->leave_status];
			}
			),
		// 'leave_date_submit',
		// 'account_id',
		// 'leave_name_approvers_by',
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{delete}{update}{view}',
            'cssClassExpression'=>'"$data->leave_status"."1"',
            'deleteButtonUrl'=>'Yii::app()->createUrl("/lbLeave/leaveApplication/Delete", array("id" => $data->leave_id))',
            'updateButtonUrl'=>'Yii::app()->createUrl("/lbLeave/leaveApplication/update", array("id" => $data->leave_id))',
            'viewButtonUrl'=>'Yii::app()->createUrl("/lbLeave/leaveApplication/view", array("id" => $data->leave_id))',
		),
	),
)); ?>

<style type="text/css" media="screen">
  /* .view, .update {
    display: block !important;
  }   */
  
  #leave-application-grid {
    position: relative;
    width: 100%;
    overflow: hidden;
  }
  
  .button-column {
    border-right: 1px solid #e8e8e8;
  }

</style>
<script type="text/javascript">
  $('.table-bordered').draggable({
    axis: 'x',
    drag: function(event, ui) {
      var left = ui.position.left,
          offsetWidth = ($(this).width() - $(this).parent().width()) * -1;

      if (left > 0) {
        ui.position.left = 0;
      }
      if (offsetWidth > left) {
        ui.position.left = offsetWidth;
      }
    }
  });
</script>

