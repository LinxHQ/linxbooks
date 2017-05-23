<?php
/* @var $this LbExpensesController */
/* @var $model LbExpenses */

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
?>

<!--<h1>Expenses</h1>-->


<?php 
//    'category_id'=>$category_id,'date_from'=>$date_from,'date_to'=>$date_to
    
    if(isset($category_id))
    {
        $date_form = DateTime::createFromFormat('d-m-Y', $date_from)->format('Y-m-d');
        $date_to = DateTime::createFromFormat('d-m-Y', $date_to)->format('Y-m-d');
        $model = LbExpenses::model();
        $model->lb_category_id=$category_id;
        $model->from_date=$date_form;
        $model->to_date=$date_to;
      
        
    }
    else{
// NEW BUTTON
    echo '<div id="lb-container-header">';
            
            echo '<div style="margin-left: -10px" class="lb-header-right"><h3>Expenses</h3></div>';
            echo '<div class="lb-header-left">';
//            LBApplicationUI::backButton(LbExpenses::model()->getActionURLNormalized('expenses'));


            echo '&nbsp;';
            echo LBApplication::workspaceLink('<i class="icon-plus icon-white"></i> ', LbExpenses::model()->getCreateURL('create'), array('live'=>'false'));
	    echo '&nbsp;';
            echo CHtml::link('<i class="icon-download-alt icon-white"></i> ', 
                    '#', array('live'=>'false', 'onclick'=>'export_excel(); return false;'));
            
            //$this->widget('bootstrap.widgets.TbButtonGroup', array(
            //    'type' => '',
            //    'buttons' => array(           
                        //array('label'=>'<i class="icon-plus"></i> New Expenses','url'=>  LbExpenses::model()->getActionURLNormalized('create')),
                        //array('label'=>'<i class="icon-plus"></i> New Payment Voucher','url'=> LbExpenses::model()->getActionURLNormalized('createPaymentVoucher')),
                        //array('label'=>Yii::t('lang','Export Excel'),'htmlOptions'=>array('onclick'=>'export_excel()'),'url'=>'#'),
                                          
            //    ),
            //    'encodeLabel'=>false,
            //));
            echo '</div>';
echo '</div><br>';
    echo '<div style="margin-left:0px;margin-top:0px;margin-bottom:-22px;">';

    $category_arr = UserList::model()->getItemsListCode('expenses_category');
    echo '</div><br/>';
    echo '<div style="margin-top:18px;">';
        echo Yii::t('lang','Category').':</td>';echo '&nbsp;&nbsp;';
        echo CHtml::dropDownList('lb_category_id', '', array(''=>'All')+CHtml::listData($category_arr, 'system_list_item_id', 'system_list_item_name'), array('style'=>'width:150px;'));echo '&nbsp;&nbsp;&nbsp;';

        //from
        echo Yii::t('lang','From').':</td>';echo '&nbsp;&nbsp;';
        echo '<input type="text" id="LbExpenses_from_date" name="LbExpenses[lb_expenses_date]" value="'.date('d-m-Y').'"><span style="display: none" id="LbExpenses_lb_expenses_date_em_" class="help-inline error"></span>';
       
        echo '&nbsp;&nbsp;&nbsp;';

        //to
        echo Yii::t('lang','To').':</td>';echo '&nbsp;&nbsp;';
        echo '<input type="text" id="LbExpenses_to_date" name="LbExpenses[lb_expenses_date]" value="'.date('d-m-Y').'"><span style="display: none" id="LbExpenses_lb_expenses_date_em_" class="help-inline error"></span>';
       
        echo '&nbsp;&nbsp;&nbsp;';
        echo '<button class="btn" name="yt0" type="submit" onclick = "searchExpenses()" style="margin-top:-10px">Search</button>';
                  
        echo '</div><br/>';
    }
       
//$this->renderPartial('index', array('model'=>$model));
echo '<div id="list_payment_voucher"> ';
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_expenses_gridview',
            'dataProvider'=>  $model->search($canList),
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
                    'value'=>'(count(UserList::model()->getItem($data->lb_category_id)))>0 ?(UserList::model()->getItem($data->lb_category_id)->system_list_item_name): ""',
                    'htmlOptions'=>array('width'=>'150','height'=>'40px'),
                ),
                array(
                    'header'=>Yii::t('lang','Note'),
                    'type'=>'raw',
                    'value'=>'$data->lb_expenses_note',
                    'htmlOptions'=>array('width'=>'250','height'=>'40px'),
                ),
                array(
                    'header'=>Yii::t('lang','Total'),
                    'type'=>'raw',
                    'value'=>'"$".number_format($data->lb_expenses_amount,2)',
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
echo '</div>';
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
    
    function searchExpenses()
    {
        var date_from = $('#LbExpenses_from_date').val();
        var date_to =$('#LbExpenses_to_date').val();
        var category_id=$('#lb_category_id option:selected').val();
      
        $('#list_payment_voucher').load('SearchExpenses',{category_id:category_id,date_from:date_from,date_to:date_to});
      
    }
    function export_excel(){
        var date_from = $('#LbExpenses_from_date').val();
        var date_to =$('#LbExpenses_to_date').val();
        var category_id=$('#lb_category_id option:selected').val();
        location.href = 'ExcelExpenses?category_id='+category_id+'&date_from='+date_from+'&date_to='+date_to;
    }
    
</script>
