<?php
/*
 * @var $account_id
 */
?>
<!-- =============== BASIC PERMISSION ACCOUNT ============= -->
<fieldset style="margin-top: 0px;">
    <legend ><h5>Basic Permission</h5></legend>
  <div>
        Module: 
        <?php 
            $modelModule = Modules::model()->getModules();
            echo CHtml::dropDownList('assign_module_roles', '', CHtml::listData($modelModule, 'lb_record_primary_key', 'module_name'), array());
            echo CHtml::button('Add',array(
                'onclick'=>'add_permission_account();return false;',
                'class'=>'btn btn-default',
                'style'=>'margin-bottom: 10px;margin-left:10px;'
            ));
        ?>
  </div>
  
  <div id="contentai-account-basic">
      <?php $this->renderPartial('permission.views.account._form_basic_permission_account', array(
          'account_id'=>$account_id,
      )) ?>
  </div>  

</fieldset>
  <!-- ------------- END BASIC PERMISSIONROLE -------------- -->

    <!-- =============== DEFINE PERMISSION ACCOUNT ============= -->
<fieldset>
    <legend><h5>Define Permission</h5></legend>

  <div id="contentai-account-define">
      <?php $this->renderPartial('permission.views.account._form_define_permission_account', array(
          'account_id'=>$account_id,
      )) ?>
  </div>
    
</fieldset>
    <!-- ------------- END DEFINE PERMISSION ROLE -------------- -->
    
<script>
    function add_permission_account()
    {
        var account_id = <?php echo $account_id; ?>;
        var modules_id = $('#assign_module_roles').val();
        $.ajax({
            'type':'POST',
            'url':'<?php echo $this->createUrl('permission/default/assingPermissionAccount'); ?>',
            data:{account_id:account_id,modules_id:modules_id},
            beforeSend: function(){
                $('#contentai-account-basic').block({message:  '<h5>Please wait...</h5>',});
            },
            success:function(data)
            {
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $('#contentai-account-basic').load('<?php echo $this->createUrl('permission/default/reloadAccountBasicPermission'); ?>',{account_id:account_id});
                else if(responseJSON.status=="exist")
                {
                    alert(responseJSON.msg);
                    $('#contentai-account-basic').unblock();
                }
                else
                    alert('Error');
            },
            done:function(){
                $('#contentai-account-basic').unblock();
            }
        });
    }
</script>