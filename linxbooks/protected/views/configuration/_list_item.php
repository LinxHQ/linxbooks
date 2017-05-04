<?php
$model= UserList::model()->search();
$this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'lb_list',
        'template' => "{items}\n{pager}\n{summary}",
        'dataProvider'=>  $model,
       // 'htmlOptions' => array('class'=>'items table table-bordered','width'=>'98%'),
        'columns'=>array(
                        array(
                            'name'=>'List',
                            'type'=>'raw',
                            'value' =>'CHtml::link($data->system_list_code,Yii::app()->createUrl("configuration/list_item",array("list"=>$data->system_list_code)))',),
                        array(
                            'class'=>'CButtonColumn',
                             'template'=>'{update}{delete}',
                    
                            'buttons'=>array(
                                                'delete'=>array(
                                                'url'=>'Yii::app()->createUrl("/configuration/deleteList",array("list"=>$data->system_list_code))',
                                                ),
                                        'update'=>array(
                                        'url'=>'Yii::app()->createUrl("/configuration/updateList",array("list"=>$data->system_list_code))',
                                    )
                             ),
                        ),
               
        ),
    )
);
    
 
echo '<div class="btn-toolbar" id ="new_item">';
      LBApplicationUI::newButton('New List', array());
echo '</div>';

?>
    
    
    

<div hidden ="true" id="form-new-item" class="accordion-body collapse in">
    <input type="text" value="" id="new"><lable id ="err"></lable>
                    <?php //echo '<br>'; ?>
                    <?php 
                        echo '<div id ="newItem">';
                        echo CHtml::Button('Insert',array('onclick'=>'load_item();return false;','class'=>'btn','style'=>'margin-top:-3px;')); 
                        echo '</div>';
                    ?>
                
</div><!-- form -->
<style>
    .table
    {
        width: 98%;
    }
    </style>
<script>
    $( ".list tr:odd" ).css( "background-color", "#f9f9f9" );
    $( ".list tr:odd" ).css( "width", "50%" );
    
    $(document).ready(function(){
        $("#new_item").click(function(){
            $("#form-new-item").toggle();
        });
            
    });
    
    function load_item()
    {
        var itemName = $("#new").val();
        
        
        if(itemName == "") {
            $('#err').fadeIn( 'slow' )
                        .delay( 1800 )
                        .fadeOut( 'slow' )
                        .html( '<p style="color: red;"><i> Please enter list name </i></p>' );
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('configuration/AjaxInsertList') ?>',
                data: {item:itemName},
                dataType: 'json',
                success: function(da) {
//                    if(da.status=="success")
                        window.location.href='<?php echo Yii::app()->createUrl("configuration/index"); ?>';
//                    else {
                        
//                        $('#err').html('Item already exits');
//                        $('#err').fadeIn( 'slow' )
//                        .delay( 1800 )
//                        .fadeOut( 'slow' )
//                        .html( '<p style="color: red;"><i> Item already exits </i></p>' );
//                        $('#new').val('');
//                    }
                }
            })
        } 
    }
    
    function deleteList(list_name)
    {
        $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('configuration/AjaxInsertList') ?>',
                data: {item:itemName},
                dataType: 'json',
                success: function(da) {
                    if(da.status=="success")
                        window.location.href='<?php echo Yii::app()->createUrl("configuration/index"); ?>';
                    else {
                        
//                        $('#err').html('Item already exits');
                        $('#err').fadeIn( 'slow' )
                        .delay( 1800 )
                        .fadeOut( 'slow' )
                        .html( '<p style="color: red;"><i> Item already exits </i></p>' );
//                        $('#new').val('');
                    }
                }
            })
    }


</script>