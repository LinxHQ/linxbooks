<?php

?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pr-system-translate-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
    <?php $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'gridview_system_translate',
        'type'=>'striped bordered condensed',
        'dataProvider'=>$translate->search(),
        'filter'=>$translate,
        'template'=>"{items}{pager}",
        'columns'=>array(
            array(
                'header'=>'#',
                'type'=>'raw',
                'value'=>'$data->lb_record_primary_key',
            ),
            array(
                'class' => 'editable.EditableColumn',
                'header'=>'English',
                'name'=>'lb_tranlate_en',
                'type'=>'raw',
                'value'=>'$data->lb_tranlate_en',
                'editable' => array(
                       'url'        => $this->createUrl('ajaxUpdateField'),
                       'placement'  => 'right',
                       'inputclass' => 'span3',
                     ),
                'htmlOptions'=>array('style'=>'width:400px;'),
                'footer'=> CHtml::textField('lb_tranlate_en','',array()),
            ),
            array(
                'class' => 'editable.EditableColumn',
                'header'=>'Vietnamese',
                'type'=>'raw',
                'name'=>'lb_translate_vn',
                'value'=>'$data->lb_translate_vn',
                'editable'=>array(
                        'type'      =>'textarea',
                        'url'       =>$this->createUrl('ajaxUpdateField'),
                        'placement' =>'right',
                        'inputclass'=>'span3',
//                        'onShown' => 'js: function() {
//                            var $tip = $(this).data("editableContainer").tip();
//                            $tip.find("textarea").val("123");
//                        }'
                    ),
                'footer'=> CHtml::textArea('lb_translate_vn','',array('cols'=>'70','rows'=>'1')),

            ),
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'template' => '{delete}',
                'deleteButtonUrl'=>'Yii::app()->createUrl("/configuration/deleteLineTranslate", array("id" => $data->lb_record_primary_key))',
                'htmlOptions'=>array('style'=>'width: 50px;text-align: center;'),
                'footer'=> CHtml::button('Add',array('name'=>'AddLineTranslate','onclick'=>'AjaxAddLineTranslate();return false')),
            ),
        ),
    )); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    function AjaxAddLineTranslate()
    {
        var translate_en = $('#lb_tranlate_en').val();
        var translate_vn = $('#lb_translate_vn').val();
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('addLineTranslate'); ?>',
            data:{translate_en:translate_en,translate_vn:translate_vn},
            beforeSend: function(data)
            {
                //code..
            },
            success:function(response)
            {
                $.fn.yiiGridView.update('gridview_system_translate');
            },
            error: function(data){
                //code...
            }
        });
    }
</script>
