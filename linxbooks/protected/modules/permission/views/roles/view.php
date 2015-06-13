<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	'Roles'=>array('index'),
	$model->lb_record_primary_key,
);

?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/protected/modules/permission/css/style.css">
<h1>View Role</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'role_name',
		'role_description',
	),
)); ?>
<!-- =============== BASIC PERMISSION ROLE ============= -->
<fieldset>
    <legend><b>Basic Permission</b></legend>
    <div><h4>Add permission:</h4></div>
    <div style="margin-bottom: 10px;">
        Module: 
        <?php 
            $modelModule = Modules::model()->getModules();
            echo CHtml::dropDownList('assign_module_roles', '', CHtml::listData($modelModule, 'lb_record_primary_key', 'module_name'), array());
            echo CHtml::button('Add',array(
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
    <legend><b>Define Permission</b></legend>

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
