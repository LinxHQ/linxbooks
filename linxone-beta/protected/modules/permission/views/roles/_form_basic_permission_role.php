<?php
/**
 * author Thongnv
 * $model Roles;
 * $this RolesControler
 */
$moduleRoles = RolesBasicPermission::model()->getModuleByRoles($model->lb_record_primary_key);
$permissionRoles = array();
?>
<table id="table-center" class="items table table-striped table-bordered table-condensed">
          <thead>
              <tr class="grid-header">
                  <td style="text-align: left"><?php echo Yii::t('lang','Module Name'); ?></td>
                <td width="8%"><?php echo Yii::t('lang','Add'); ?></td>
                <td width="8%"><?php echo Yii::t('lang','View Own'); ?></td>
                <td width="8%"><?php echo Yii::t('lang','View All'); ?></td>
                <td width="8%"><?php echo Yii::t('lang','Update Own'); ?></td>
                <td width="8%"><?php echo Yii::t('lang','Update All'); ?></td>
                <td width="8%"><?php echo Yii::t('lang','Delete Own'); ?></td>
                <td width="8%"><?php echo Yii::t('lang','Delete All'); ?></td>
                <td width="8%"><?php echo Yii::t('lang','List Own'); ?></td>
                <td width="8%"><?php echo Yii::t('lang','List All'); ?></td>
                <td width="5%">&nbsp;</td>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($moduleRoles->data as $moduleRolesItem) { 
              $permissionRoles = RolesBasicPermission::model()->getPermissionByRoles($model->lb_record_primary_key, $moduleRolesItem->module_id);
          ?>
            <tr>
                <td style="text-align: left"><?php echo $moduleRolesItem->module->module_name; ?></td>
                <?php foreach ($permissionRoles->data as $permissionRolesItem) {

                ?>
                <td><?php
                    $checked = false;
                    $status = 1;
                    if($permissionRolesItem->basic_permission_status==1)
                    {
                        $checked= true;
                        $status=0;
                    }
                    echo CHtml::checkBox('permission', $checked, array('value'=>$permissionRolesItem->role_basic_permission_id,'onclick'=>'updatePermissionRole(this.value,'.$status.');')); ?>
                </td>
              <?php } ?>
                <td><a href="#" onclick="deleteModuleRole(<?php echo $model->lb_record_primary_key; ?>,<?php echo $moduleRolesItem->module_id;?>); return false;"><i class="icon-trash"></i></a></td>
            </tr>
          <?php } ?>
          <?php if(count($permissionRoles)<=0){ ?>
            <tr><td colspan="10" style="text-align: left;">No result</td></tr>
          <?php } ?>
          </tbody>
</table>

<script type="text/javascript">
    function deleteModuleRole(role_id,module_id)
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('deleteModuleRole'); ?>',
            beforeSend: function(){
                $('#contentai-role-basic').block();
                if(confirm('Are you sure you want to delete this item?'))
                    return true;
                return false;
            },
            data:{role_id:role_id,module_id:module_id},
            success: function(data){
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $('#contentai-role-basic').load('<?php echo $this->createUrl('reloadRolesBasicPermission'); ?>',{role_id:role_id});
                else
                    alert('Error');
            },
            done: function(){
                $('#contentai-role-basic').unblock();
            }
        });
    }
</script>
