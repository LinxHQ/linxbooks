<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo "<h3>Update List</h3>";
echo '<input type="text" id="list_name" class="" value="'.$list.'"><br/>';
echo '<input type="hidden" hidden="true" value ="'.$list.'" id="list_old">';
echo '<lable id ="err"></lable><br/>';
echo '<button onClick=save_list()>Save</button>';
?>

<script>
    function save_list()
    {
        var list_name=$('#list_name').val();
        var list_old=$('#list_old').val();
        
        if(list_name==""){
            $('#err').html( '<p style="color: red;"><i> Please enter list name </i></p>' );
        }
        else
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('configuration/updateListName') ?>',
                data: {list_name:list_name,list_old:list_old},
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
    </script>
