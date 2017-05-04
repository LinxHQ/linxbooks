<?php
/* @var $this RolesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Roles',
);
?>

<h1>Roles</h1>
<?php
    $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'lb-role-grid',
        'type'=>'striped bordered condensed',
        'dataProvider'=>$dataProvider->search(),
        'template' => "{items}",
        'columns'=>array(
            array(
                'name'=>'role_name',
                'footer'=> CHtml::textField('role_name','',array()),
            ),
            array(
                'name'=>'role_description',
                'footer'=> CHtml::textArea('role_description','',array('cols'=>'70','rows'=>'1')),
            ),
            array(
                'header'=>'Actions',
                'type'=>'raw',
                'headerHtmlOptions'=>array('style'=>'text-align:center;width:80px'),
                'htmlOptions'=>array('style'=>'text-align:center'),
                'value'=>'\'<a href="#" onclick="ajaxDeleteRole(\'.$data->lb_record_primary_key.\')" id="member_delete" data-original-title="Xóa" rel="tooltip" title><i class="icon-trash"></i></a>
                <a href="roles/view/id/\'.$data->lb_record_primary_key.\'" id="member_delete" data-original-title="View Role" rel="tooltip" title><i class="icon-lock"></i></a>\'',
                'footer'=> CHtml::button('Add',array('name'=>'AddLineRole','onclick'=>'AjaxAddLineRole();return false')),
            ),
        ),
    ));
?>
<script type="text/javascript">
    function AjaxAddLineRole()
    {
        var role_name = $('#role_name').val();
        var role_description = $('#role_description').val();
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('AjaxAddLineRole'); ?>',
            data:{role_name:role_name,role_description:role_description},
            beforeSend: function(data)
            {
                $('#lb-role-grid').block();
            },
            success:function(data)
            {
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $.fn.yiiGridView.update('lb-role-grid');
                else
                    alert('Error');
            },
            error: function(data){
                //code...
            },
            done:function(){
                $('#lb-role-grid').unblock();
            },
        });
    }
    function ajaxDeleteRole(role_id)
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('deleteRole'); ?>',
            beforeSend: function(data)
            {
                $('#lb-role-grid').block();
                if(confirm('Bạn có chắc muốn xóa module này không?'))
                    return true;
                return false;
            },
            data:{role_id:role_id},
            success:function(data)
            {
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $.fn.yiiGridView.update('lb-role-grid');
                else
                    alert('Error'); 
            },
            done:function(){
                $('#lb-role-grid').unblock();
            },
        
        });
    }
</script>