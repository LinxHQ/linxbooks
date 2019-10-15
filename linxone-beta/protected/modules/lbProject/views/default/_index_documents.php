<?php

/* @var $model Project model */
/* @var $documentModel Documents */
        
echo '<p class="blur" style="text-align: center">'.YII::t('lang','Documents uploaded to your tasks, issues, implementations, etc. will be listed here').'</p>';
if(isset($model->project_id)) {
    $this->widget('ext.EAjaxUpload.EAjaxUpload',
                array(
                        'id'=>'project_upload_file_'.$model->project_id,
                        'config' => array(
                                'action' => Yii::app()->createUrl('lbProject/document/ajaxProjectUpload', array('project_id'=>$model->project_id)),
                                'allowedExtensions' => Documents::model()->supportedTypes(), //array("jpg","jpeg","gif","exe","mov" and etc...
                                'sizeLimit' => 10*1024*1024, // maximum file size in bytes
                                //'minSizeLimit' => 10*1024*1024, // minimum file size in bytes
                                'onComplete'=>"js:function(id, fileName, responseJSON){ linxcirclePostProjectUpload(id, fileName, responseJSON); }",
                                                            'template'=>'<div class="qq-uploader">
                                                                            <div class="qq-upload-drop-area"><span>Drop files here to upload</span></div>
                                                                            <div class="qq-upload-button"><i class="icon-upload"></i>'.YII::t('lang','Upload document').'</div>
                                                                            <ul class="qq-upload-list"></ul>
                                                                         </div>',
                        //'messages'=>array(
                        //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                        //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                        //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                        //                  'emptyError'=>"{file} is empty, please select files again without it.",
                        //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                        //                 ),
                        //'showMessage'=>"js:function(message){ alert(message); }"
                        ),
        ));
    //echo '<h4>Documents</h4>';
    $docModel = new Documents('getDocuments');
    $docModel->unsetAttributes();

    // $docActiveDataProvider = Documents::model()->getDocuments($model->project_id);
    $doc_grid_id = 'recent-dccuments-grid-' . $model->project_id;
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped',
        'dataProvider' => $documentModel->getDocuments($model->project_id),
        'filter' => $documentModel,
        'template' => "{items}{pager}",
        'id' => $doc_grid_id,
        'ajaxUpdate' => true,
        'htmlOptions' => array('style' => 'padding-top: 5px;'),
        'columns' => array(
            //array('name'=>'id', 'header'=>'#'),
            array(
                //'name' => 'task_name',
                'name' => 'document_real_name',
                'header' => YII::t('core','Name'),
                'type' => 'raw',
                'value' => 'CHtml::image($data->getDocumentIcon()) 
                            . CHtml::link(
                            $data->document_real_name,
                            array("document/download", "id" => $data->document_id),
                            array(
                                                        "target" => "_blank",
                                                    ) // end array
                                        ) . "<br/>"
                            . CHtml::link(
                                            $data->getDocumentEntityName(), 
                                            $data->getDocumentEntityURL(),
                                            array("class"=>"blur")
                                        )            
                            ', // end chtml::link
                /**
                'value' => 'CHtml::link(
                            $data->document_real_name,
                            "#",
                            array(
                                                        "onClick" => " {". CHtml::ajax(
                                    array(
                                            "url" => array("document/download", "id" => $data->document_id)),
                                    array("live" => false, "id"=> "ajax-id-" . uniqid())

                                                                    ) . " return false; }",
                                                        "id" => "ajax-id-" . uniqid(),
                                                        "target" => "_blank",
                                                    ) // end array
                                        )', // end chtml::link
                 * 
                 */
            ),
            array(
                'header'=>YII::t('core','Uploaded by'),
                'type'=>'raw',
                'value'=>'AccountProfile::model()->getProfilePhoto($data->document_owner_id)',
            ),
            array(
                //'name' => '',
                'header' => YII::t('core','Date'),
                'type' => 'html',
                'htmlOptions' => array('width' => '200px'),
                'value' => 'Utilities::displayFriendlyDateTime($data->document_date)', // format time
                'sortable' => false),
        ),
    ));

    /*
     // Auto refresh grid periodically
    Yii::app()->clientScript->registerScript('ajax-id' . uniqid(),
            'window.setInterval(function(){
                    $.get(\'' . Yii::app()->createUrl("implementation/canRefresh", array('project_id' => $model->project_id)) . '\', function(data){
                            if (data == "1")
                            {
                            //$.fn.yiiGridView.update("' . $implementations_grid_id . '");
                            }
                            });
                    }, 1000*60*5);',
            CClientScript::POS_LOAD);
    */

?>
<script type="text/javascript">
    function linxcirclePostProjectUpload(id, fileName, responseJSON)
    {
        var foo = "#project_upload_file_<?php echo $model->project_id?> .qq-upload-list";
        $(foo).html('');
        $.fn.yiiGridView.update('<?php echo $doc_grid_id;?>');
    }
    </script>
<?php } ?>