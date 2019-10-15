<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="accordion-group">
    <div class="accordion-heading lb_accordion_heading">
        <a class="accordion-toggle lb_accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#">
            Images</a>
    </div>
    <div id="" class="accordion-body collapse in">
        <?php 
        if(count($images)>0){
            $this->widget('bootstrap.widgets.TbGridView', array(
                    'id'=>'lb-catalog-products-grid',
                    'dataProvider'=>$images,
            //	'filter'=>$model,
                    'columns'=>array(
            //		'lb_record_primary_key',
                            array(
                                'name'=>'lb_document_name',
                                'type'=>'raw',
                                'value'=>function($data){
                                    return $data->getImages();
                                }
                            ),
                            array(
                                'name'=>'lb_document_type',
                                'type'=>'raw',
                                'htmlOptions'=>array('style'=>'width:150px;')
                            ),
                            array(
                                    'class'=>'bootstrap.widgets.TbButtonColumn',
                                    'template'=>'{delete}',
                                    'buttons'=>array(
                                        'delete'=>array(
                                            'url' => function($data) {
                                                return LbDocument::model()->getActionURLNormalized('default/deleteDocument/id/'.$data->lb_record_primary_key);
                                            }
                                        )
                                    ),
                                    'htmlOptions'=>array('style'=>'width:50px;')
                            ),
                    ),
            ));
        }?>
        <div class="accordion-inner">
            <div class="control-group">
                <label class="control-label required" for="">Big Image: <span class="required"></span></label>
                <div class="controls">
                    <input class="form-img" type="file" multiple name="file_big[]"/>
                    <img src="http://ajaxuploader.com/images/drag-drop-file-upload.png"/>
                </div>
                
            </div>
            <div class="control-group ">
                <label class="control-label required" for="">Small Image: <span class="required"></span></label>
                <div class="controls">
                    <input class="form-img" type="file" multiple name="file_small[]"/>
                    <img src="http://ajaxuploader.com/images/drag-drop-file-upload.png"/>
                    
                </div>
                
            </div>
            <div class="control-group ">
                <label class="control-label required" for="">Thumbnail: <span class="required"></span></label>
                <div class="controls">
                    <input class="form-img" type="file" multiple name="file_thumbnail[]"/>
                    <img src="http://ajaxuploader.com/images/drag-drop-file-upload.png"/>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>