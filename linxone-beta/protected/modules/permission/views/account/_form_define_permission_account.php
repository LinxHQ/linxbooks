<?php
/**
 * author Thongnv
 * @var $account_id;
 */
$module = Modules::model()->getModules();
?>

<table class="items table table-bordered table-condensed">
    <thead class="grid-header">
        <tr>
            <td>Modules</td>
            <td width="10%" style="text-align: center">Status</td>
        </tr>
    </thead>
    <tbody>
        <?php
        if(count($module)>0)
        {
            foreach ($module as $moduleItem) {
                $definePerModule = DefinePermission::model()->getDefinePerModule($moduleItem->lb_record_primary_key);
                if(count($definePerModule->data)>0)
                {
            ?>
                    <tr>
                        <td colspan="2"><?php echo $moduleItem->module_name; ?></td>
                    </tr>
                    <?php foreach ($definePerModule->data as $definePerModuleItem) { 
                        $checkstatus = AccountDefinePermission::model()->CheckDefinePerAccount($account_id, $definePerModuleItem->define_permission_id);
                        if($checkstatus)
                            $status=1;
                        else
                            $status=0;
                    ?>
                        <tr>
                            <td style="padding-left: 30px;"><?php echo $definePerModuleItem->define_permission_name; ?></td>
                            <td style="text-align: center;"><?php echo CHtml::checkBox('permission', $status, array('value'=>$definePerModuleItem->define_permission_id,'onclick'=>'updateDefinePerAccount(this.value,'.$moduleItem->lb_record_primary_key.','.$status.');')); ?></td>
                        </tr>
                    <?php } ?>
        <?php }}} else { ?>
            <tr>
                <td colspan="2">No result</td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script type="text/javascript">
    function updateDefinePerAccount(define_per_id,module_id,status)
    {
        var account_id = <?php echo $account_id; ?>;
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/permission/default/updateDefinePerAccount'); ?>',
            data:{account_id:account_id,define_per_id:define_per_id,status:status,module_id:module_id},
            beforeSend:function(){
                $('#contentai-account-define').block();
            },
            success: function(data){
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $('#contentai-account-define').load('<?php echo $this->createUrl('/permission/default/reloadAccountDefinePermission'); ?>',{account_id:account_id});
                else
                    alert('Error');
            },
            done:function(){
                $('#contentai-account-define').unblock();
            }
        });
    }
</script>