<?php 
echo '<div class="btn-toolbar">';
LBApplicationUI::backButton(Yii::app()->createUrl('configuration/index'), false); 
echo '</div>';
?> 

<div id ="item" width=100px>
        
     <input hidden="true" class="nameList" value = <?php  echo $list_name; ?> ></input>
    
    <?php
        if($list_name == 'financial_year'){
            $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'usergrid',
            'itemsCssClass' => 'table-bordered items',
            'dataProvider' => $list,
            'columns'=>array(
//                            array(
//                                'class' => 'editable.EditableColumn',
//                                 'name' => 'system_list_item_id',
//                                'headerHtmlOptions' => array('style' => 'width: 110px'),
//                                'editable' => array( //editable section
//                                    'apply' => '$data->system_list_item_id', //can't edit deleted users
//                                    'placement' => 'right',
//                                ),
//                            ),
                            array(
                            'class' => 'editable.EditableColumn',
                            'name' => 'system_list_item_code',
                            'value' =>'$data->system_list_item_name',
                            'headerHtmlOptions' => array('style' => 'width: 110px'),
                            'editable' => array( 
                                'type' =>'text',
                                //'apply' => '$data->system_list_item_name', //can't edit deleted users
                                'url'   => Yii::app()->createAbsoluteUrl('configuration/ajaxUpdateItem'),
                                'placement' => 'right',
                                )
                            ),
                            array(                                 
                                'class' => 'editable.EditableColumn',
                                'name' => 'system_list_item_name',
                                // 'value' => '$data->year',
                                'value'=> '$data->system_list_item_day."/".$data->system_list_item_month',
                                'headerHtmlOptions' => array('style' => 'width: 110px'),
                                'editable' => array( 
                                    
                                    'type' =>'date',
                                    'viewformat'=>'d/m',
                                    //'apply' => '$data->system_list_item_day." ".date("M",strtotime($data->system_list_item_month))', //can't edit deleted users
                                    'url'   => Yii::app()->createAbsoluteUrl('configuration/ajaxUpdateDate'),
                                    'placement' => 'right',
                                    )
                             ),
                           array(
                                'class'=>'CButtonColumn',
                               'template'=>"{delete}",
                                'buttons'=>array(
                                    'delete'=>array(
                                       'url'=>  'Yii::app()->createUrl("configuration/deleteItem", array("id"=>$data->system_list_item_id,"list"=>$data->system_list_code))',
                                    )),
                    ),

                ),
            ));
    
        }else{
           //($model->customerAddress->lb_customer_address_line_1!=NULL) ? $model->customerAddress->lb_customer_address_line_1.'. ' : ''
           $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'usergrid',
            'itemsCssClass' => 'table-bordered items',
            'dataProvider' => $list,
            'columns'=>array(
                            array(
                                'class' => 'editable.EditableColumn',
                                 'name' => 'system_list_item_id',
                                'headerHtmlOptions' => array('style' => 'width: 110px'),
                                'editable' => array( //editable section
                                'apply' => '$data->system_list_item_id', //can't edit deleted users
                                'placement' => 'right',
                            ),
                                ),
                            array(
                            'class' => 'editable.EditableColumn',
                            'name' => 'system_list_item_name',
                            'headerHtmlOptions' => array('style' => 'width: 110px'),
                            'editable' => array( 
                                'apply' => '$data->system_list_item_name', //can't edit deleted users
                                'url'   => Yii::app()->createAbsoluteUrl('configuration/ajaxUpdateItem'),
                                'placement' => 'right',
                            )
                           ),
                           array(
                                'class'=>'CButtonColumn',
                               'template'=>"{delete}",
                                'buttons'=>array(
                                    'delete'=>array(
                                       'url'=>  'Yii::app()->createUrl("configuration/deleteItem", array("id"=>$data->system_list_item_id,"list"=>$data->system_list_code))',
                                    )),
                    ),

    ),
    ))
    ;
        }

?>
    
     
<fieldset>
    
    <?php
//    LBApplicationUI::backButton(Yii::app()->createUrl('configuration/index'), false);
    ?>
    
        <?php 
        echo '<div class="btn-toolbar" id ="new_item">';
            LBApplicationUI::newButton('New Item', array());
        echo '</div>';
//            LBApplicationUI::newButton('New Item', array());
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
<div id = "a"></div>
 </fieldset>
    </div>

<script type="text/javascript">
    
    $(document).ready(function(){
        $("#new_item").click(function(){
            $("#form-new-item").toggle();
        });
            
    });
    function load_item()
    {
        var itemName = $("#new").val();
        var listName = $(".nameList").val();
        if(itemName == "") {
            $('#err').fadeIn( 'slow' )
                        .delay( 1800 )
                        .fadeOut( 'slow' )
                        .html( '<p style="color: red;"><i> Please enter item name </i></p>' );
        } else if(listName != '') {
//            $('#item').load('AjaxLoadFormItem',{item:itemName,list:listName});
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('configuration/AjaxLoadFormItem') ?>',
                data: {item:itemName,list:listName},
                dataType: 'json',
                success: function(da) {
                    if(da.status == 'success') {
                        window.location.href='<?php echo Yii::app()->createUrl("configuration/list_item",array("list"=>$list_name)); ?>';
                    } 
//                    else {
//                        
////                        $('#err').html('Item already exits');
//                        $('#err').fadeIn( 'slow' )
//                        .delay( 1800 )
//                        .fadeOut( 'slow' )
//                        .html( '<p style="color: red;"><i> Item already exits </i></p>' );
////                        $('#new').val('');
//                    }
                }
            })
        } else {
            return false;
        }
    }
</script>
<style>
/*    #new_item
    {
        margin-bottom: 10px;
    margin-left: 83px;
    margin-top: -30px;
    width: 100px;
    }*/
    
</style>