<?php
/**
 * author Thongnv
 * $account_id ;
 */
$moduleAccount = AccountBasicPermission::model()->getModuleByAccount($account_id);
?>
<table id="table-center" class="items table table-striped table-bordered table-condensed">
    <thead class="grid-header">
              <tr>
                  <td style="text-align: left">Module Name</td>
                <td width="8%">Add</td>
                <td width="8%">View Own</td>
                <td width="8%">View All</td>
                <td width="8%">Update Own</td>
                <td width="8%">Update All</td>
                <td width="8%">Delete Own</td>
                <td width="8%">Delete All</td>
                <td width="8%">List Own</td>
                <td width="8%">List All</td>
                <td width="5%">&nbsp;</td>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($moduleAccount->data as $moduleAccountItem) { 
              $permissionAccount = AccountBasicPermission::model()->getPermissionByAccount($account_id, $moduleAccountItem->module_id);
          ?>
            <tr>
                <td style="text-align: left"><?php echo $moduleAccountItem->module->module_name; ?></td>
                <?php foreach ($permissionAccount->data as $permissionAccountItem) {

                ?>
                <td><?php
                    $checked = false;
                    $status = 1;
                    if($permissionAccountItem->basic_permission_status==1)
                    {
                        $checked= true;
                        $status=0;
                    }
                    echo CHtml::checkBox('permission', $checked, array('value'=>$permissionAccountItem->lb_record_primary_key,'onclick'=>'updatePermissionRole(this.value,'.$status.');')); ?>
                </td>
              <?php } ?>
                <?php if($permissionAccount->data){ ?>
                    <td><a href="#" onclick="deleteModuleAccount(<?php echo $account_id; ?>,<?php echo $permissionAccountItem->module_id;?>); return false;"><i class="icon-remove"></i></a></td>
                <?php } ?>
            </tr>
          <?php } ?>
          <?php if(count($moduleAccount->data)<=0){ ?>
            <tr><td colspan="11" style="text-align:left;">No result</td></tr>
          <?php } ?>
          </tbody>
</table>

<script type="text/javascript">
    
    function updatePermissionRole(permission_id,status)
    {
        var account_id = <?php echo $account_id; ?>;
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/permission/default/updateBasicPermissionaccount'); ?>',
            data:{permission_id:permission_id,status:status},
            beforeSend: function(){
                $('#contentai-account-basic').block({message:  '<h5>Please wait...</h5>',});
            },
            success:function(data)
            {
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $('#contentai-account-basic').load('<?php echo $this->createUrl('/permission/default/reloadAccountBasicPermission'); ?>',{account_id:account_id});
                else
                    alert('Error');
            },
           done:function(){
                $('#contentai-account-basic').unblock();
            }
        });
    }
    
    function deleteModuleAccount(account_id,module_id)
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/permission/default/DeleteModuleAccount'); ?>',
            beforeSend: function(){
                $('#contentai-account-basic').block({message:  '<h5>Please wait...</h5>'});
                if(confirm('Are you sure you want to delete this item?'))
                    return true;
                return false;
            },
            data:{account_id:account_id,module_id:module_id},
            success: function(data){
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $('#contentai-account-basic').load('<?php echo $this->createUrl('/permission/default/reloadAccountBasicPermission'); ?>',{account_id:account_id});
                else
                    alert('Error');
            },
           done:function(){
                $('#contentai-account-basic').unblock();
            }
        });
    }
</script>
