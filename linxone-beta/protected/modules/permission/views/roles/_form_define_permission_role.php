<?php
/**
 * author Thongnv
 * @var $model Roles;
 * @var $this RolesControler
 */
$module = Modules::model()->getModules();
?>

<table class="items table table-bordered table-condensed">
    <thead>
        <tr class="grid-header">
            <td><b><?php echo Yii::t('lang','Module'); ?></b></td>
            <td width="10%" style="text-align: center"><b><?php echo Yii::t('lang','Status'); ?></b></td>
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
                        <td colspan="2" style="background: #f3f3f3;"><?php echo $moduleItem->module_name; ?></td>
                    </tr>
                    <?php foreach ($definePerModule->data as $definePerModuleItem) { 
                        $checkstatus = RolesDefinePermission::model()->CheckDefinePerRole($model->lb_record_primary_key, $definePerModuleItem->define_permission_id);
                        if($checkstatus)
                            $status=1;
                        else
                            $status=0;
                    ?>
                        <tr>
                            <td><?php echo $definePerModuleItem->define_permission_name; ?></td>
                            <td style="text-align: center;"><?php echo CHtml::checkBox('permission', $status, array('value'=>$definePerModuleItem->define_permission_id,'onclick'=>'updateDefinePerRole(this.value,'.$moduleItem->lb_record_primary_key.','.$status.');')); ?></td>
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
    function updateDefinePerRole(define_per_id,module_id,status)
    {
        var role_id = <?php echo $model->lb_record_primary_key; ?>;
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('updateDefinePerRole'); ?>',
            data:{role_id:role_id,define_per_id:define_per_id,status:status,module_id:module_id},
            success: function(data){
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $('#contentai-role-basic').load('<?php echo $this->createUrl('reloadRolesBasicPermission'); ?>',{role_id:role_id});
                else
                    alert('Error');
            }
        });
    }
</script>