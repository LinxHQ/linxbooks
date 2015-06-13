<?php
/*
 * $account_id;
 */
$roleAccount = AccountRoles::model()->getRoleByAccount($account_id);
?>
<table class="table table-striped table-bordered table-condensed">
    <thead class="grid-header">
        <tr>
            <td width="90%"><b>Role Name</b></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($roleAccount->data as $roleAccountItem) {
        ?>
            <tr>
                <td><?php echo $roleAccountItem->role->role_name; ?></td>
                <td style="text-align: center;"><a href="#" onclick="deleteRoleAcount(<?php echo $roleAccountItem->lb_record_primary_key; ?>);return false;"><i class="icon-remove"></i></a></td>
            </tr>
        <?php } ?>
       <?php if(count($roleAccount->data)<=0){ ?>
            <tr><td colspan="2">No result</td></tr>
       <?php }?>
    </tbody>
</table>

<script type="text/javascript">
    function deleteRoleAcount(role_account_id)
    {
        var account_id = <?php echo $account_id; ?>;
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/permission/default/deleteRoleAccount'); ?>',
            data:{role_account_id:role_account_id},
            beforeSend: function(){
               $('#contentai-account-role').block({messages:"<h5>Please Wait..</h5>"})
               if(confirm('Are you sure you want to delete this item?'))
                    return true;
                return false;
            },
            success: function(data){
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $('#contentai-account-role').load('<?php echo $this->createUrl('/permission/default/reloadRoleAccount'); ?>',{account_id:account_id});
                else
                    alert('Error');
            },
            done:function(){
                $('#contentai-account-role').unblock();
            }
        });
    }
</script>