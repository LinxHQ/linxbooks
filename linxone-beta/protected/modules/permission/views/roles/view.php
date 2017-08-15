<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	'Roles'=>array('index'),
	$model->lb_record_primary_key,
);
$modelModule = Modules::model()->getModules();
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/protected/modules/permission/css/style.css">
<h1><?php echo Yii::t('lang','View Role'); ?></h1>

<?php $this->widget('editable.EditableDetailView', array(
	'data'=>$model,
        'url'=> Yii::app()->createUrl('/permission/roles/ajaxUpdateField'),
	'attributes'=>array(
            array(
                'name'=>'role_name',
                'value'=>$model->role_name,
            ),
            array(
                'name'=>'role_description',
                'value'=>$model->role_description,
                'editable' => array(
                    'type'       => 'textarea',
                    'inputclass' => 'input-large',
                    'emptytext'  => Yii::t('app','Click to edit'),
                )
            ),
            array(
                'name'=>'role_module_home',
                'value'=>function($model){
                    $module = Modules::model()->findByPk($model->role_module_home);
                    if($module)
                        return $module->module_name;
                    return "";
                },
                'editable' => array(
                                'type'      => 'select',
                                'source'    => CHtml::listData($modelModule, 'lb_record_primary_key', 'module_name'),
                                'placement' =>'right',
                )
            ),
            array(
                'name'=>'role_module_home_action',
                'value'=>$model->role_module_home_action,
            ), 
	),
)); ?>
<!-- =============== BASIC PERMISSION ROLE ============= -->
<fieldset>
    <legend><b><?php echo Yii::t('lang','Basic Permission'); ?></b></legend>
    <div><h4><?php echo Yii::t('lang','Add permission'); ?>:</h4></div>
    <div style="margin-bottom: 10px;">
        <?php echo Yii::t('lang','Module'); ?>: 
        <?php 
            
            echo CHtml::dropDownList('assign_module_roles', '', CHtml::listData($modelModule, 'lb_record_primary_key', 'module_name'), array());
            echo CHtml::button(Yii::t('lang','Add'),array(
                'onclick'=>'add_permission_role();return false;',
                'class'=>'btn btn-default',
                'style'=>'margin-bottom: 10px;margin-left:10px;'
            ));
        ?>
  </div>
  
  <div id="contentai-role-basic">
      <?php $this->renderPartial('_form_basic_permission_role', array(
          'model'=>$model,
      )) ?>
  </div>  

</fieldset>
  <!-- ------------- END BASIC PERMISSIONROLE -------------- -->

    <!-- =============== DEFINE PERMISSION ROLE ============= -->
<fieldset>
    <legend><b><?php echo Yii::t('lang','Define Permission'); ?></b></legend>

  <div id="contentai-role-define">
      <?php $this->renderPartial('_form_define_permission_role', array(
          'model'=>$model,
      )) ?>
  </div>
    
</fieldset>
    <!-- ------------- END DEFINE PERMISSION ROLE -------------- -->
<script type="text/javascript">
    function add_permission_role()
    {
        var role_id = <?php echo $model->lb_record_primary_key; ?>;
        var modules_id = $('#assign_module_roles').val();
        $.ajax({
            'type':'POST',
            'url':'<?php echo $this->createUrl('assingPermissionRoles'); ?>',
            data:{role_id:role_id,modules_id:modules_id},
            success:function(data)
            {
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $('#contentai-role-basic').load('<?php echo $this->createUrl('reloadRolesBasicPermission'); ?>',{role_id:role_id});
                else if(responseJSON.status=="exist")
                    alert(responseJSON.msg);
                else
                    alert('Error');
            }
        });
    }
    
    function updatePermissionRole(permission_id,status)
    {
        var role_id = <?php echo $model->lb_record_primary_key; ?>;
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('updateBasicPermissionRoles'); ?>',
            data:{permission_id:permission_id,status:status},
            success:function(data)
            {
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $('#contentai-role-basic').load('<?php echo $this->createUrl('reloadRolesBasicPermission'); ?>',{role_id:role_id});
                else
                    alert('Error');
            }
        });
    }
</script>
