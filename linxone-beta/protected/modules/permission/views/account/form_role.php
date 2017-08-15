<?php
$account_id;
?>
<div>
  <div>
        Module: 
        <?php 
            $modelModule = Roles::model()->getRoles();
            echo CHtml::dropDownList('assign_roles_account', '', CHtml::listData($modelModule, 'lb_record_primary_key', 'role_name'), array());
            echo CHtml::button('add',array(
                'onclick'=>'add_roles_account();return false;',
                'class'=>'btn btn-default',
                'style'=>'margin-bottom: 10px;margin-left:10px;'
            ));
        ?>
  </div>
  
  <div id="contentai-account-role">
      <?php $this->renderPartial('permission.views.account._form_account_role', array(
          'account_id'=>$account_id,
      )) ?>
  </div> 
</div>

<script type="text/javascript">
    function add_roles_account()
    {
        var account_id = <?php echo $account_id; ?>;
        var role_id = $('#assign_roles_account').val();
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('permission/default/assignRoleAccount'); ?>',
            data:{account_id:account_id,role_id:role_id},
            brforeSend:function(){
                $('#contentai-account-role').block({messages:"<h5>Please Wait..</h5>"})
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