<?php 
$DecimalSymbol = LbGenera::model()->getGeneraDecimalSymbol();
$ThousandSeparator = LbGenera::model()->getGeneraThousandSeparator();
$GeneraCurrency = LbGenera::model()->getGeneraCurrency();

$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_expenses_gridview',
            'dataProvider'=>  $model->search(),
          //  'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'template' => "{items}\n{pager}\n{summary}", 
            'columns'=>array(              
                array(
                    'header'=>Yii::t('lang','Date'),
                    'name'=>'lb_customer_id',
                    'type'=>'raw',
                    'value'=>'$data->lb_expenses_date ? date("d M, Y", strtotime($data->lb_expenses_date)) : ""',
                    'htmlOptions'=>array('width'=>'120','height'=>'40px'),
                ),
                array(
                    'header'=>Yii::t('lang','Expenses No'),
                    'type'=>'raw',
                    'value'=>'($data->lb_expenses_no) ? LBApplication::workspaceLink($data->lb_expenses_no, $data->getViewURL("view") ) : LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )',
//                    'value'=>'($data->lb_expenses_no) ?
//                                    LBApplication::workspaceLink($data->lb_expenses_no, $data->getViewURL($data->customer->lb_customer_name) )
//                                    :LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )',
                    'htmlOptions'=>array('width'=>'180','height'=>'40px'),
                ),
               array(
                    'header'=>Yii::t('lang','Category'),
                    'type'=>'raw',
                    'value'=>'Yii::t("lang",(count(UserList::model()->getItem($data->lb_category_id)))>0 ?(UserList::model()->getItem($data->lb_category_id)->system_list_item_name): "")',
                    'htmlOptions'=>array('width'=>'150','height'=>'40px'),
                ),
                array(
                    'header'=>Yii::t('lang','Note'),
                    'type'=>'raw',
                    'value'=>'$data->lb_expenses_note',
                    'htmlOptions'=>array('width'=>'250','height'=>'40px'),
                ),
                array(
                    'header'=>Yii::t('lang','Amount'),
                    'type'=>'raw',
                    'value'=>'number_format($data->lb_expenses_amount,2,"'.$DecimalSymbol.'","'.$ThousandSeparator.'")." '.$GeneraCurrency.'"',
                    'htmlOptions'=>array('align'=>'right','height'=>'40px'),
                ),
                array(
			'class'=>'CButtonColumn',
                        'template'=>'{delete}',
                        'deleteButtonUrl'=>'CHtml::normalizeUrl(array("/lbExpenses/default/delete", "id"=>$data->lb_record_primary_key))',
                        'afterDelete'=>'function(){
                            location.reload(true);
                        } ',
                        'htmlOptions'=>array('width'=>'30','height'=>'40px'),
		),
            )
        ));
?>