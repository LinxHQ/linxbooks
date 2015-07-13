<?php
/* @var $this LbExpensesController */
/* @var $model LbExpenses */

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
?>

<!--<h1>Expenses</h1>-->


<?php 
// NEW BUTTON
    
    echo '<div align="right">';
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'search-expenses-form',
        'enableAjaxValidation'=>false,
//	'action'=>$model->getActionURLNormalized('ajaxSearchExpenses'),//Yii::app()->createUrl($this->route),
	'method'=>'get',
));
        echo Yii::t('lang','Category');echo '&nbsp;&nbsp;&nbsp;';
        $category_arr = UserList::model()->getItemsListCode('expenses_category');
            echo $form->dropDownList($model, 'lb_category_id',
                    array(''=>'All')+CHtml::listData($category_arr, 'system_list_item_id', 'system_list_item_name'),
                    array('style'=>'width:150px;')
                );
            echo '&nbsp;&nbsp;&nbsp;';
//            echo CHtml::dropDownList('lb_category_id', '', array(''=>'All')+CHtml::listData($category_arr, 'system_list_item_id', 'system_list_item_name'), array('style'=>'width:150px;'));echo '&nbsp;&nbsp;&nbsp;';
            echo Yii::t('lang','From').': ' . $form->textField($model, 'from_date', array('class'=>'span2'));echo '&nbsp;&nbsp;&nbsp;';
//                    echo CHtml::textField('from_date', '', array('value'=>date('d-m-Y'), 'style'=>'width:100px;'));echo '&nbsp;&nbsp;&nbsp;';
            echo Yii::t('lang','To').': ' . $form->textField($model, 'to_date', array('class'=>'span2'));echo '&nbsp;&nbsp;&nbsp;';
//                    echo CHtml::textField('to_date', '', array('value'=>date('d-m-Y'), 'style'=>'width:100px;'));echo '&nbsp;&nbsp;&nbsp;';
                    $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>Yii::t('lang','Search')));
                    $this->endWidget();
    echo '</div><br/>';
       

//$this->renderPartial('index', array('model'=>$model));

$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_expenses_gridview',
            'dataProvider'=>  $model->search($canList),
            'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'columns'=>array(
                array(
			'class'=>'CButtonColumn',
                        'template'=>'{delete}',
                        'deleteButtonUrl'=>'CHtml::normalizeUrl(array("/lbExpenses/default/delete", "id"=>$data->lb_record_primary_key))',
                        'afterDelete'=>'function(){
                            location.reload(true);
                        } ',
                        'htmlOptions'=>array('width'=>'30'),
		),
                array(
                    'header'=>Yii::t('lang','Date'),
                    'name'=>'lb_customer_id',
                    'type'=>'raw',
                    'value'=>'$data->lb_expenses_date ? date("d M, Y", strtotime($data->lb_expenses_date)) : ""',
                    'htmlOptions'=>array('width'=>'120'),
                ),
                array(
                    'header'=>Yii::t('lang','Expenses No'),
                    'type'=>'raw',
                    'value'=>'($data->lb_expenses_no) ? LBApplication::workspaceLink($data->lb_expenses_no, $data->getViewURL("view") ) : LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )',
//                    'value'=>'($data->lb_expenses_no) ?
//                                    LBApplication::workspaceLink($data->lb_expenses_no, $data->getViewURL($data->customer->lb_customer_name) )
//                                    :LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )',
                    'htmlOptions'=>array('width'=>'180'),
                ),
               array(
                    'header'=>Yii::t('lang','Category'),
                    'type'=>'raw',
                    'value'=>'(count(UserList::model()->getItem($data->lb_category_id)))>0 ?(UserList::model()->getItem($data->lb_category_id)->system_list_item_name): ""',
                    'htmlOptions'=>array('width'=>'150'),
                ),
                array(
                    'header'=>Yii::t('lang','Note'),
                    'type'=>'raw',
                    'value'=>'$data->lb_expenses_note',
                    'htmlOptions'=>array('width'=>'250'),
                ),
                array(
                    'header'=>Yii::t('lang','Total'),
                    'type'=>'raw',
                    'value'=>'"$".number_format($data->lb_expenses_amount,2)',
                    'htmlOptions'=>array('align'=>'right'),
                ),
            )
        ));

//        LBApplicationUI::button('Delete', array(
//                'url'=>$this->createUrl('delete'),
//        ));
?>

<script language="javascript">
    $(document).ready(function(){
        var from_date = $("#LbExpenses_from_date").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            from_date.hide();
        }).data('datepicker');	
        
        var to_date = $("#LbExpenses_to_date").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            to_date.hide();
        }).data('datepicker');	
    });
    
</script>
