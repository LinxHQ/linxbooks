<?php
    // Buttons
    echo '<div class="btn-toolbar">';
    LBApplicationUI::newButton('New Tax', array(
            'url'=>$this->createUrl('createTax'),
    ));
    echo '</div>';
    
    $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'lb_tax_grid',
        'template' => "{items}\n{pager}\n{summary}",
        'dataProvider'=>$taxModel,
        'columns'=>array(
            array(
                'name'      =>'lb_tax_name',
                'header'    =>'Tax Name',
                'value'     =>'$data->lb_tax_name',
            ),
            array(
                'name'      =>'lb_tax_value',
                'header'    =>'Value',
                'value'     =>'$data->lb_tax_value',
            ),
            array(
                'name'      =>'lb_tax_is_default',
                'header'    =>'Tax Default',
                'value'     =>'$data->lb_tax_is_default',
            ),
//            array(
//                 'class' => 'editable.EditableColumn',
//                    'header'    =>'Tax Default',
//                    'name' => 'lb_tax_is_default',
//                    'editable' => array(
//                        'type' => 'select',
//                        'url' => LbTax::model()->getActionURL('ajaxUpdateFieldTax'),
//                        'source'=>array(1=>1,2=>2),
//                        'placement' => 'right',
//                   )
//            ),
  /*          array(
                'class'=>'CButtonColumn',
                    'template'=>'{update}{delete}',
                    'buttons'=>array(
                       'delete'=>array(
                           'url'=>'Yii::app()->createUrl("/configuration/deleteTax",array("id"=>$data->lb_record_primary_key))',
                           'visible'=>'LbTax::model()->IsTaxExistInvoiceORQuotation($data->lb_record_primary_key)==false',
                        ),
                       'update'=>array(
                           'url'=>'Yii::app()->createUrl("/configuration/updateTax",array("id"=>$data->lb_record_primary_key))',
                           'visible'=>'LbTax::model()->IsTaxExistInvoiceORQuotation($data->lb_record_primary_key)==false',
                       )
                    ),
            ),*/
        ),
    ));
?>
