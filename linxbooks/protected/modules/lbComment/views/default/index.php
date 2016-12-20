<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo '<div style="overflow: hidden; margin-top: 5px; padding-bottom: 5px; margin-bottom: 5px; border-top: 1px solid;"></div>';
//echo '<div style="width: 387px; margin-top: 20px; margin-bottom: 40px" class="top-new-form well form" id="form-comment">
$id_item = 0;
$module_anme = 0;
$date = date('Y-m-d');
if(isset($_REQUEST['id_item']))
    $id_item = $_REQUEST['id_item'];
if(isset($_REQUEST['model_name']))
    $module_anme = $_REQUEST['model_name'];


echo '<a  onclick="_form_comment()">Comment</a>';
echo '<div id ="show_form_comment" hidden="true">';
    echo '<textarea type="text" style="width:56%;height:100px" id="pv_comment"></textarea>
    <div id="">
    <input type="submit" id="yt0" value="Save" onclick = saveComment('.$id_item.',"'.$module_anme.'",'.$date.');> <input type="submit" id="yt0" value="Cancel" name="yt0" onclick="cancelComment();">
    <br />';
echo '</div></div>';

echo '<div id ="show_comment">';
    if(isset($_REQUEST['model_name']))
    {
        $model = LbComment::model()->getComment($module_anme, $id_item, 0);
         if(count($model) > 0)
        {
            foreach ($model as $data)
            {
                echo '<div id="comment-root'.$data->lb_record_primary_key.'" class="comment" style="width: 100%;">';
                $customer = AccountProfile::model()->getProfile($data->lb_account_id);

                echo '<div style = " padding:20px" id="comment-content-container'.$data->lb_record_primary_key.'">';
                echo '<div id="comment-content'.$data->lb_record_primary_key.'" style="display: table">';
                echo '<b>'.$customer->account_profile_given_name.' '.$customer->account_profile_surname.'</b>:   ';
                echo '<span id="description'.$data->lb_record_primary_key.'">'.nl2br($data->lb_comment_description).'</span>';
                echo '<br />';
                echo '</div>'

                 .'</div>';
                echo '<div class="footer-container" style="padding-left: 20px">';
                echo '<span id="fotter'.$data->lb_record_primary_key.'">Posted on '.$data->lb_comment_date.'</span>'; 
                echo '<div style="float: right">';
                if($data->lb_account_id == Yii::app()->user->id)
                {
                    echo '<a href="#" onclick = "EditComment('.$data->lb_record_primary_key.');return false;" > Edit</a> &nbsp';
                    echo '<a href="#" onclick = "deleteComment('.$data->lb_record_primary_key.');return false;">Delete</a>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        
    }
echo '</div>';

 ?>

<script lang="Javascript">
    function _form_comment()
    {
        $('#show_form_comment').show();
    }
    function saveComment(item_id,module_name,date)
    {
        var comment = $('#pv_comment').val();
       
         $.post("<?php echo LbComment::model()->getActionURLNormalized('insertComment', array())?>",
                {item_id: item_id, module_name: module_name,date:date,comment:comment },
                function(response){
                    var responseJSON = jQuery.parseJSON(response);
                    if(responseJSON.success == 1)
                    {
                       html = '<div id="comment-root'+responseJSON.lb_record_primary_key+'" class="comment" style="width: 58%;">\n\
                       <div style = " padding:20px" id="comment-content-container'+responseJSON.lb_record_primary_key+'">\n\
                        <div id="comment-content'+responseJSON.lb_record_primary_key+'" style="display: table">\n\
                        <b>'+responseJSON.account_profile_given_name+' '+responseJSON.account_profile_surname+'</b>:   \n\
                        <span id="description'+responseJSON.lb_record_primary_key+'">'+responseJSON.lb_comment_description+'</span><br /></div></div>\n\
                        <div class="footer-container" style="padding-left: 20px">\n\
                        <span id ="fotter'+responseJSON.lb_record_primary_key+'" >Posted on '+responseJSON.lb_comment_date+'</span><div style="float: right">\n\
                        <a href="#" onclick = EditComment('+responseJSON.lb_record_primary_key+')>Edit</a> &nbsp <a href="#" onclick = deleteComment('+responseJSON.lb_record_primary_key+')>Delete</a></div></div></div>';
                        $(html).insertAfter('#show_form_comment');
                        $('#show_form_comment').val('');
                        $('#show_form_comment').hide();
                       
                    }
                   
                }
            )
    }
    
    function cancelComment()
    {
       $('#show_form_comment').hide();
    }
    function EditComment(id)
    {
        var descript = $('#description'+id).text();
       
        html='<textarea type="text" style="width:100%;height:100px" id="description_comment'+id+'">'+descript+'</textarea>\n\
        <div id=""><input type="submit" id="yt0" value="Save" onclick = updateComment('+id+');> <input type="submit" id="yt0" value="Cancel" name="yt0" onclick=cancelCommentUpdate('+id+',"'+descript+'")><br />';
        $("#description"+id).html(html);
     
    }
    function deleteComment(id)
    {
        $.post("<?php echo LbComment::model()->getActionURLNormalized('deleteComment', array())?>",
                    {id:id},
                    function(response){
                        var responseJSON = jQuery.parseJSON(response);
                        if(responseJSON.success == 1)
                        {
                            $('#comment-root'+id).remove();
                        }

                    }
                );
    }
    function updateComment(id)
    {
    var description = $("#description_comment"+id).val();
    $.post("<?php echo LbComment::model()->getActionURLNormalized('updateComment', array())?>",
                {description:description,model_name:'lbPaymentVoucher',id_comment:id},
                function(response){
                    var responseJSON = jQuery.parseJSON(response);
                    if(responseJSON.success == 1)
                    {
                       $('#description_comment'+id).hide();
                       $('#description'+id).html(responseJSON.lb_comment_description);
                       $('#fotter'+id).html(responseJSON.lb_comment_date);
                       
//                        $('#comment-root'+id).remove();
                    }
                  
                }
     );
    }

    function cancelCommentUpdate(id,descript)
    {
    
  
    $('#description_comment'+id).hide();
    $('#description'+id).html(descript);

    }
</script>