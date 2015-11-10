<?php
/* @var $this ProcessChecklistDefaultController */
/* @var $model ProcessChecklistDefault */
/* @var $modelChecklist ProcessChecklistDefault*/

//$this->breadcrumbs=array(
//	'Process Checklist Defaults'=>array('index'),
//	'Manage',
//);

//$this->menu=array(
//	array('label'=>'List ProcessChecklistDefault', 'url'=>array('index')),
//	array('label'=>'Create ProcessChecklistDefault', 'url'=>array('create')),
//);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#process-checklist-default-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>
<?php require_once (YII::app()->modulePath.'/process_checklist/js/jquery-ui-1.11.1.js.php'); ?>
<h1><a href="<?php echo $this->createUrl('/process_checklist/processChecklist/admin'); ?>" style="color: #000"><i class="icon-chevron-left" style="margin-top: 18px;"></i><?php echo $modelChecklist->pc_name; ?></a></h1>
<div id="process-checklist-default">
    <?php $this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'process-checklist-default-grid',
            'dataProvider'=>$model,
            'type' => 'striped bordered condensed',
            //'filter'=>$model,
            'rowHtmlOptionsExpression' => 'array("id"=>"row_item_".$data->pcdi_id)',
            'columns'=>array(
                    array(
                        'name'=>'pcdi_name',
                        'footer'=> CHtml::textArea('pcdi_name','',array('cols'=>'100','rows'=>'1','class'=>'span6')),
                    ),
                    array(
                            'class'=>'bootstrap.widgets.TbButtonColumn',
                            'template'=>"{update}{delete}{sort}",
                            'footer'=> CHtml::button('Add',array('name'=>'add_pcdi_name','onclick'=>'AjaxPCDI_name();return false','class'=>'btn','style'=>'text-align:center')),
                            'htmlOptions'=>array('width'=>'70','style'=>'text-align:center'),
                            'buttons'=>array
                            (
                                'sort'=>array(
                                   'label'=>'<i id="item-sort" class="icon-align-justify"></i>',
                                   'options'=>array('title'=>'View Sessions'),
                                   'imageUrl'=>false,
                                ),
                            ),
                    ),
            ),
    )); ?>
</div>
<script type="text/javascript">
 
    $(function() {
        load_sortable();
    });
    
    function load_sortable()
    {
        var id="#process-checklist-default table tbody";
        $(id).sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            handle: "#item-sort",
            items: 'tr',
            update : function (even,ui) {
                var data = $(this).sortable('serialize',{key: 'pcdi_id[]', attribute: 'id'});

                $.ajax({
                    'url': '<?php echo $this->createUrl('/process_checklist/ProcessChecklistDefault/updateOrder'); ?>',
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
   
    function AjaxPCDI_name()
    {
        var pcdi_name = $('#pcdi_name').val();
        var pc_id = <?php echo $modelChecklist->pc_id; ?>;
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('create'); ?>',
            data:{pcdi_name:pcdi_name,pc_id:pc_id},
            beforeSend: function(data)
            {
                //code..
            },
            success:function(response)
            {
                $.fn.yiiGridView.update('process-checklist-default-grid',{ complete: function(jqXHR, status) {
                    if (status=='success'){
                           load_sortable();
                    }
                }});
            },
            error: function(data){
                //code...
            }
        });
    }
</script>
