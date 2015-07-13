<?php 
//$module_name = $_REQUEST['module_name'];

?>
 <h4><?php echo Yii::t('lang','Document'); ?></h4>
    <?php
        $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb-expenses-documnet_grid',
            'dataProvider'=> LbDocument::model()->getDocumentParentTypeProvider($module_name, $id),
            'template'=>'{items}',
            'hideHeader'=>true,
            'htmlOptions'=>array('width'=>'500'),
            'columns'=>array(
                array(
                    'type'=>'raw',
                    'value'=>'"<a href=\'".LbDocument::model()->getActionURLNormalized("download",array("id"=>$data->lb_record_primary_key))."\' ><img width=\'100px;\' border=\'0\' alt=\'\' src=\'".Yii::app()->getBaseUrl().$data->lb_document_url."\' />".$data->lb_document_name."</a>"',
                ),
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'{delete}',
                    'deleteButtonUrl'=>'LbDocument::model()->getActionURLNormalized("default/deleteDocument",array("id"=>$data->lb_record_primary_key))',
                    'htmlOptions'=>array('width'=>'20'),
                    'afterDelete'=>'function(link,success,data){
                        if(success) {
                            refreshTotals();
                        }
                    } ',
                ),
            ),
        ));
    ?>
    <div>
        <!--<div class="qq-upload-button" style="position: relative; overflow: hidden; direction: ltr;">Upload a file<input type="file" name="file" style="position: absolute; right: 0px; top: 0px; font-family: Arial; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;"></div>-->
            <?php
//            if($canEdit)
                $this->widget('ext.EAjaxUpload.EAjaxUpload',
                    array(
                        'id'=>'uploadFile1',
                        'config'=>array(
                               'action'=>LbDocument::model()->getActionURLNormalized('uploadDocument',array('id'=>$id,'module_name'=>$module_name)),
                               'allowedExtensions'=>array("jpeg","jpg","gif","png","pdf","odt","docx","doc","dia"),//array("jpg","jpeg","gif","exe","mov" and etc...
                               'sizeLimit'=>10*1024*1024,// maximum file size in bytes
                               'minSizeLimit'=>1*1024,// minimum file size in bytes
                               'element' =>'$("#uploadFile)',
                               'onComplete'=>"js:function(id, fileName, responseJSON){
                                        $.fn.yiiGridView.update('lb-expenses-documnet_grid');
                                        $('#uploadFile1 .qq-upload-list').html('');
                                        
                                   }",
                              )
                )); 
            ?>
    </div>
 
 <style>
     #uploadFile1 .qq-uploader .qq-upload-button
     {
         background-color:#5bb75b;color:white;
         background-image: linear-gradient(to bottom, #62c462, #51a351);
          text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
          border-radius: 4px;

     }
     #view_document #uploadFile1 .qq-uploader .qq-upload-button
     {
       margin-left: -456px;

     }
 </style>

