<?php
/* @var $this DefaultController */
/* @var $entity_type tham so la các entity như task|issue|invocie...*/
/* @var $entity_id la id cua cac entity như task|issue|invocie...*/
$subscription_id = DefaultController::getSubscriptionId();
?>
<?php //require_once (YII::app()->modulePath.'/process_checklist/js/jquery-ui-1.11.1.js.php'); ?>
<h2>Process Check List</h2>

<div id="container-process-checklist">
    <?php 
        $this->renderPartial('process_checklist.views.default.form_process_checklist',array(
            'entity_type'=>$entity_type,
            'entity_id'=>$entity_id,
        )); 
    ?>
</div>
<br>
<?php
    echo CHtml::dropDownList('process_checklist','', 
            CHtml::listData(ProcessChecklist::model()->getPchecklist($subscription_id)->data, 'pc_id', 'pc_name'));
//    $modelPCdefault = ProcessChecklistDefault::model()->getPCheckListDefaultByCheckList(2);
//    print_r($modelPCdefault->data);
?>
&nbsp;<a href="#" onclick="addPChecklistItem(); return false;" style="font-size: 2.5em; font-weight: bold; text-decoration: none;">+</a>

<script type="text/javascript">
    
    function addPChecklistItem()
    {
        var entity_type = '<?php echo $entity_type; ?>';
        var entity_id = '<?php echo $entity_id; ?>';
        var pc_id = $('#process_checklist').val();
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/process_checklist/ProcessChecklistItemRel/create'); ?>',
            beforeSend:function(){
                //code
            },
            data:{entity_type:entity_type,entity_id:entity_id,pc_id:pc_id},
            success:function(data){
                $('#container-process-checklist').load('<?php echo $this->createUrl("/process_checklist/default/loabPCheckList"); ?>',{entity_type:entity_type,entity_id:entity_id});
            },
        });
    }
    
    function updatePChecklistItem(pc_id,pcir_id,status)
    {
        var entity_type = '<?php echo $entity_type; ?>';
        var entity_id = '<?php echo $entity_id; ?>';
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/process_checklist/ProcessChecklistItemRel/updatePCheckListItem'); ?>',
            beforeSend:function(){
                //code
            },
            data:{pcir_id:pcir_id,status:status},
            success:function(data){
                $('#container-process-checklist').load('<?php echo $this->createUrl("/process_checklist/default/loabPCheckList"); ?>',{entity_type:entity_type,entity_id:entity_id});
            },
        });
    }
    
    function deletePChecklistItem(pcir_id)
    {
        var entity_type = '<?php echo $entity_type; ?>';
        var entity_id = '<?php echo $entity_id; ?>';
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/process_checklist/ProcessChecklistItemRel/deleteItemRel'); ?>',
            beforeSend:function(){
                if(confirm("Are you sure you want to delete this item?"))
                    return true;
                return false;
            },
            data:{pcir_id:pcir_id},
            success:function(data){
                $('#container-process-checklist').load('<?php echo $this->createUrl("/process_checklist/default/loabPCheckList"); ?>',{entity_type:entity_type,entity_id:entity_id});
            },
        });
    }
    
    function delete_item_by_entity(entity_type,entity_id,pc_id)
        {
            $.ajax({
                'url': '<?php echo $this->createUrl('deletePCheckListByEntity'); ?>',
                'type': 'post',
                'data': {entity_type:entity_type,entity_id:entity_id,pc_id:pc_id},
                'success': function(data){
                    $('#container-process-checklist').load('<?php echo $this->createUrl("/process_checklist/default/loabPCheckList"); ?>',{entity_type:entity_type,entity_id:entity_id});
                },
                'error': function(request, status, error){
                    alert('Error.');
                }
            });
        }
</script>