<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$model = new LbPvExpenses();
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$id = 0;
if(isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
//echo '<pre>';
//print_r(LbExpenses::model()->getExpensesByPk(4));
$this->widget('bootstrap.widgets.TbGridView', array(
		'id' => 'payment_invoice_grid',
        //         'htmlOptions'=>array('class'=>'items table table-bordered'),
       // 'type'=>'bordered',
		'dataProvider' => $model->listPV($id),
		'columns' => array(
				
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{delete}',
                                    'deleteButtonUrl'=>'CHtml::normalizeUrl(array("/lbExpenses/default/deletePVExpenses", "id"=>$data->lb_record_primary_key))',
                                    'htmlOptions'=>array('width'=>'30'),
                                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                                array(
                                    'header'=>Yii::t('lang','Date'),
                                    'name'=>'lb_customer_id',
                                    'type'=>'raw',
                                    'id'=>'$data->lb_record_primary_key',
                                    
                                    'value' =>'CHtml::textField("date_ex_{LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)[lb_expenses_date]}",LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)["lb_expenses_date"] ? date("d M, Y", strtotime(LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)["lb_expenses_date"])) : "",array(
                                                                                                "style"=>"width: 110px;text-align: left; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"date_ex_{$data->lb_record_primary_key}",
                                            ))',
                                    'htmlOptions'=>array('width'=>'120'),
                                      'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
//                    
                                 array(
                                        'header'=>Yii::t('lang','Expenses No'),
                                        'type'=>'raw',
                                         'value' =>'CHtml::textField("ex_no_{LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)[lb_expenses_no]}",LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)["lb_expenses_no"],array(
                                                                                                "style"=>"width: 110px;text-align: left; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"ex_no_{$data->lb_record_primary_key}",
                                            ))',
                                        'htmlOptions'=>array('width'=>'180'),
                                     'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                    ),
                                    array(
                                    'header'=>Yii::t('lang','Category'),
                                    'type'=>'raw',
                                    'value' =>'CHtml::textField("ex_category_{LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)[lb_expenses_no]}",(count(UserList::model()->getItem(LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)["lb_category_id"])))>0 ?(UserList::model()->getItem(LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)["lb_category_id"])->system_list_item_name): "",array(
                                                                                                "style"=>"text-align: left; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"ex_category_{$data->lb_record_primary_key}",
                                            ))',
                                    
                                    'htmlOptions'=>array('width'=>'150'),
                                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                                array(
                                'header'=>Yii::t('lang','Note'),
                                'type'=>'raw',
                                
                                    'value' =>'CHtml::textField("ex_note_{LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)[lb_expenses_no]}",LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)["lb_expenses_note"],array(
                                                                                                "style"=>"text-align: left; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"ex_note_{$data->lb_record_primary_key}",
                                            ))',
                                'htmlOptions'=>array('width'=>'250'),
                                'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                            ),
                                array(
                                        'header' =>  Yii::t('lang','Total'),
                                        'type' => 'raw',
                                        'value' =>'CHtml::textField("ex_Total_{LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)[lb_expenses_no]}",LbExpenses::model()->getExpensesByPk($data->lb_expenses_id)["lb_expenses_amount"],array(
                                                                                                "style"=>"width: 110px;text-align: left; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"ex_Total_{$data->lb_record_primary_key}",
                                            ))',
                                        'htmlOptions'=>array('style'=>'width: 80px;text-align:left;'),
                                'headerHtmlOptions'=>array('class'=>'lb-grid-header'),        
                                ),
                                
                    ),
    ));

?>

<?php

echo CHtml::link(Yii::t('lang','Assign Expenses'), '#', array(
	'onclick'=>'addItemExpenses();'));
    echo '&nbsp&nbsp&nbsp';
    if($id > 0)
    {
    echo CHtml::link(Yii::t('lang','Add Expenses'), $this->createUrl('create',array('idPV'=>$id) ), array(
	'onclick'=>  Yii::app()->baseUrl.'',
    
        ));
    }



$this->beginWidget('bootstrap.widgets.TbModal',
    array('id'=>'modal-holder'));
echo '<div class="modal-header">';
echo '<a class="close" data-dismiss="modal">&times;</a>';
echo '<h4 id="modal-header"></h4>';
echo '</div>'; // end modal header
// modal body
echo '<div id="modal-body" class="modal-body" hidden = "true">';
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_expenses_pv_gridview',
            'dataProvider'=> LbExpenses::model()->search($canList),
//            'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'columns'=>array(
               
                array(
                                    'header'=>Yii::t('lang','Date'),
                                    'name'=>'lb_customer_id',
                                    'type'=>'raw',
                                    'id'=>'$data->lb_record_primary_key',
                                    
                                    'value' =>'CHtml::textField("date_ex_{$data->lb_expenses_no}",$data->lb_expenses_date ? date("d M, Y", strtotime($data->lb_expenses_date)) : "",array(
                                                                                                "style"=>"width: 110px;text-align: left; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"date_ex_show_{$data->lb_record_primary_key}",
                                            ))',
                                    'htmlOptions'=>array('width'=>'120'),
                                      'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                    
                                 array(
                                        'header'=>Yii::t('lang','Expenses No'),
                                        'type'=>'raw',
                                         'value' =>'CHtml::textField("ex_no_{$data->lb_expenses_no}",$data->lb_expenses_no,array(
                                                                                                "style"=>"width: 110px;text-align: left; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"ex_no_show_{$data->lb_record_primary_key}",
                                            ))',
                                        'htmlOptions'=>array('width'=>'180'),
                                     'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                    ),
                                    array(
                                    'header'=>Yii::t('lang','Category'),
                                    'type'=>'raw',
                                    'value' =>'CHtml::textField("ex_category_{$data->lb_expenses_no}",(count(UserList::model()->getItem($data->lb_category_id)))>0 ?(UserList::model()->getItem($data->lb_category_id)->system_list_item_name): "",array(
                                                                                                "style"=>"text-align: left; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"ex_category_show_{$data->lb_record_primary_key}",
                                            ))',
                                    
                                    'htmlOptions'=>array('width'=>'150'),
                                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                                array(
                                'header'=>Yii::t('lang','Note'),
                                'type'=>'raw',
                                
                                    'value' =>'CHtml::textField("ex_note_{$data->lb_expenses_no}",$data->lb_expenses_note,array(
                                                                                                "style"=>"text-align: left; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"ex_note_show_{$data->lb_record_primary_key}",
                                            ))',
                                'htmlOptions'=>array('width'=>'250'),
                                'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                            ),
                                array(
                                        'header' =>  Yii::t('lang','Total'),
                                        'type' => 'raw',
                                        'value' =>'CHtml::textField("ex_Total_{$data->lb_expenses_no}",$data->lb_expenses_amount,array(
                                                                                                "style"=>"width: 110px;text-align: left; padding-right: 0px;
                                                                                                 border: none;box-shadow: none;background:#ffffff;",
                                                                                                 "disabled"=>"disabled",
                                                                                                 "id"=>"ex_Total_show_{$data->lb_record_primary_key}",
                                            ))',
                                        'htmlOptions'=>array('style'=>'width: 80px;text-align:left;'),
                                'headerHtmlOptions'=>array('class'=>'lb-grid-header'),        
                                ),
                array(
                    'header'=>'#',
                    'type'=>'raw',
                    'id'=>'1',
                    'value'=>'"<a href=\"#\"
                        onclick=\"updateItemEx(
                            ".$data->lb_record_primary_key.")\">Insert</a>"',
                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'), 
                ),
            )
        ));
echo '</div>'; // end modal body
echo '<div id="modal-footer" class="modal-footer" style="display: none">';
$this->widget('bootstrap.widgets.TbButton', array(
    'id'=>'btn-modal-close',
    'label'=>'Close',
    'url'=>'#',
    'htmlOptions'=>array('data-dismiss'=>'modal'),
));

echo '</div>';
$this->endWidget(); // end modal widget
echo '<br />';
echo '<div style="text-align:center;padding:20px;" >';

echo '<button name="btsavePV" type="submit" class="btn btn-success" id="btn-pv-save-all" style="align:center" onclick="savePaymentVoucher(); return false;"><i class="icon-ok icon-white"></i>&nbsp;Save</button>';
echo '&nbsp;&nbsp;&nbsp;';

$this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>'Cancel',
                    
                    'url'=>LbExpenses::model()->getActionURLNormalized('admin'),
                    'htmlOptions' => array(
                        'class' => 'btn btn-success',
                    ),
                ));


echo '</div>'; 

$model = LbComment::model()->getComment("lbPaymentVoucher", $id, 0);
echo '<div style="overflow:hidden; border-top: 1px solid #333;margin-top: 5px; padding-bottom:5px;margin-bottom:5px;"></div>';
echo '<div id = "view_comment"></div>' ;
echo '<br />';
 
?>
<script type="text/javascript">
    
var idArr =  new Array();
var i = 0;

$("#view_comment").load("<?php echo LbComment::model()->getActionURLNormalized('index',array('id_item'=>$id,'model_name'=>'lbPaymentVoucher'));?>");

function addItemExpenses()
{
    var modal_element = $("#modal-holder");
    modal_element.find("#modal-header").html("Insert Expenses");
    
    modal_element.find("#modal-body").show();
    modal_element.modal("show");
}

function addExpensesPV()
{
    <?php // echo LbExpenses::model()->getActionURLNormalized('create');?>
}
function updateItemEx(ex_id)
{
//  var date_ex = $("#date_ex_"+ex_id).val();
    $("#modal-holder").modal('hide');
    insertRowExenses(ex_id);
}
function lbAppUIHideModal(invoice_id)
{
    var modal_element = $("#modal-holder"+invoice_id);
    modal_element.modal('hide');
}
function insertRowExenses(ex_id)
{
//    $('#date_ex_5').append('<tr><td>')
    var date_ex = $('#date_ex_show_'+ex_id).val();
    var ex_no = $('#ex_no_show_'+ex_id).val();
    var ex_category = $('#ex_category_show_'+ex_id).val();
    var ex_note = $('#ex_note_show_'+ex_id).val();
    var ex_Total = $('#ex_Total_show_'+ex_id).val();
     var html = '<tr id = "'+ex_id+'">\n\
                <td><a onclick=deleteItem('+ex_id+') title="Delete"><?php echo CHtml::image(YII::app()->baseUrl."/assets/5400b6d0/gridview/delete.png","Delete")?></a></td>\n\\n\
                <td>'+date_ex+'</td>\n\
               <td>'+ex_no+'</td>\n\
                <td>'+ex_category+'</td>\n\
                <td>'+ex_note+'</td>\n\
                <td>'+ex_Total+'</td>\n\
        </tr>';

    $('#payment_invoice_grid > table > tbody:last').append(html); 
    idArr[ex_id] = ex_id;
   
}
function deleteItem(ex_id)
{
    
    $('#'+ex_id).remove();
    idArr[ex_id] = null;
   
}

function savePaymentVoucher()
{
    var pv_no = $('#pv_no').val();
    var pv_title = $('#pv_title').val();
    var pv_description = $('#pv_description').val();
    var pv_date = $('#pv_date').val();
    if(pv_no == '')
        alert('Please enter payment voucher no!');
    else
    {
        if(idArr.length < 1)
            idArr = false;
        var pvid = <?php echo $id;?>;

       $.post("<?php echo LbExpenses::model()->getActionURLNormalized('savePaymentVoucher', array())?>",
                {pv_no: pv_no, pv_title: pv_title,pv_description:pv_description,pv_date:pv_date,iem_ex_arr:idArr,idPv:pvid },
                function(response){
                    var responseJSON = jQuery.parseJSON(response);
                    if(responseJSON.success == 0)
                    {
//                        alert("Payment voucher no already exists. Please enter payment voucher no other");
//                         window.location.href = '<?php // echo YII::app()->baseUrl;?>/index.php/lbExpenses/default/CreatePaymentVoucher/id/'+responseJSON.id;

                    }
                    else
                    {
                        alert('Successful Payment Voucher');
                        window.location.href = '<?php echo YII::app()->baseUrl;?>/index.php/lbExpenses/default/CreatePaymentVoucher/id/'+responseJSON.id;
                    }
                }
            ); 
    }
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

function EditComment(id)
{
        var descript = $('#description'+id).text();
       
        html='<textarea type="text" style="width:100%;height:100px" id="description_comment'+id+'">'+descript+'</textarea>\n\
        <div id=""><input type="submit" id="yt0" value="Save" onclick = updateComment('+id+');> <input type="submit" id="yt0" value="Cancel" name="yt0" onclick=cancelCommentUpdate('+id+',"'+descript+'")><br />';
        $("#description"+id).html(html);
     
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