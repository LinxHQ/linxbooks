<?php
$CheckList = ProcessChecklistItemRel::model()->getPChecklistByEntity($entity_type, $entity_id);
$i=0;
echo '<input type="hidden" value="'.count($CheckList->data).'" id="count_process_check_list" />';
foreach ($CheckList->data as $CheckListItem) {
    $i++;
    $pc_id = $CheckListItem->pc_id;
    $dataProvider= ProcessChecklistItemRel::model()->getPchecklistItemRel($entity_type, $entity_id, $pc_id);
?>
    <h4 style="float: left"><?php echo $CheckListItem->process_checklist->pc_name; ?></h4>
    <a href="#" style="float: right;margin-top: 12px;" onclick="delete_item_by_entity('<?php echo $entity_type; ?>',<?php echo $entity_id; ?>,<?php echo $pc_id; ?>);return false;"><i class="icon-trash"></i></a>
    <?php
    echo '<div style="clear: both;">';
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'process-checklist-item-grid-'.$i,
            'dataProvider'=>$dataProvider,
            'template' => '{items}{pager}',
            'type' => 'striped',
            'rowHtmlOptionsExpression' => 'array("id"=>"row_item_".$data->pcir_id)',
            'columns'=>array(
                array(
                    'header'=>'',
                    'type'=>'raw',
                    'value'=>function($data){
                        if($data->pcir_status==1)
                            return CHtml::checkBox("check_process", true, array('value'=>$data->pcir_status,'onclick'=>'updatePChecklistItem('.$data->pc_id.','.$data->pcir_id.',0);return false'));
                        else
                            return CHtml::checkBox("check_process", false, array('value'=>$data->pcir_status,'onclick'=>'updatePChecklistItem('.$data->pc_id.','.$data->pcir_id.',1);return false;'));
                    },
                    'htmlOptions'=>array('width'=>'30','style'=>'text-align:center'),
                ),
                'pcir_name',
                array(            // display a column with "view", "update" and "delete" buttons
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template' => '{update}{delete}{sort}',
                    'htmlOptions'=>array('width'=>'70','style'=>'text-align:center'),
                    'buttons'=>array(
                        'update'=>array(
                            'url'=>'Yii::app()->createUrl("process_checklist/ProcessChecklistItemRel/update",array("id"=>$data->pcir_id))',
                        ),
                        'delete'=>array(
                            'url'=>'"#"',
                            'optionsExpression' => array("onclick"=>'"deleteItemRel(".$data->pcir_id.");return false;"'),
                        ),
                        'sort'=>array(
                           'url'=>'"#"',
                           'label'=>'<i id="item-sort" class="icon-align-justify"></i>',
                           'options'=>array('title'=>'sort'),
                           'imageUrl'=>false,
                        ),
                    ),
                ),
            ),
        ));
    echo '</div>';
    ?> 
    
<?php } ?>

    <script type="text/javascript">
        $(function() {
            var count = $('#count_process_check_list').val();
            var id = "";
            for(var i=1;i<=count;i++)
            {
                id="#process-checklist-item-grid-"+i+' table tbody';
                $(id).sortable({
                    forcePlaceholderSize: true,
                    forceHelperSize: true,
                    handle: "#item-sort",
                    items: 'tr',
                    update : function (even,ui) {
                        var entity_type = '<?php echo $entity_type; ?>';
                        var entity_id = '<?php echo $entity_id; ?>';
                        var data = $(this).sortable('serialize',{key: 'pcir_id[]', attribute: 'id'});

                        $.ajax({
                            'url': '<?php echo $this->createUrl('/process_checklist/ProcessChecklistItemRel/updateOrder'); ?>',
                            'type': 'post',
                            'data': data,
                            'success': function(data){
                            },
                            'error': function(request, status, error){
                                alert('Error.');
                            }
                        });
                    },
                    delay: 30
                });
                $(id).disableSelection();
            }
        });
        
        function deleteItemRel(pcir_id)
        {
            var entity_type = '<?php echo $entity_type; ?>';
            var entity_id = '<?php echo $entity_id; ?>';
            $.ajax({
                'url': '<?php echo $this->createUrl('/process_checklist/ProcessChecklistItemRel/DeleteItemRel'); ?>',
                'type': 'post',
                'data': {pcir_id:pcir_id},
                'beforeSend':function(){
                    if(confirm("Are you sure you want to delete this item?"))
                        return true;
                    return false;
                },
                'success': function(data){
                    $('#container-process-checklist').load('<?php echo $this->createUrl("/process_checklist/default/loabPCheckList"); ?>',{entity_type:entity_type,entity_id:entity_id});
                },
                'error': function(request, status, error){
                    alert('Error.');
                }
            });
        }
        
    </script>
