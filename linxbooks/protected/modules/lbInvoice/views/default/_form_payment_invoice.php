<?php 
$PaymentInvoice=  LbPaymentItem::model()->getAllPaymentByInvoice($invoice_id);
$method = LBPayment::model()->method;
if($invoice_status != LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT)
{
    $grid_payment_id = 'invoice-line-payment-grid-'.$invoice_id;
    $this->widget('bootstrap.widgets.TbGridView', array(
                    'id' => $grid_payment_id,
            'type'=>'bordered',
                    'dataProvider' => $PaymentInvoice,

                    'columns' => array(

                     array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>"{delete}",
                        'deleteButtonUrl'=>'"' . LbInvoice::model()->getActionURLNormalized("ajaxDeletePayment") . '" .
                                            "?id={$data->lb_record_primary_key}&invoice_id={$data->lb_invoice_id}"',

                        'afterDelete'=>'function(link,success,data){

                            if(success) {
                                var responseJSON = $.parseJSON(data);

                                var status = responseJSON.status;
                                 if(status == "I_PAID")
                                {
                                    $("#lb_invocie_status").text("Paid");
                                }
                            else
                                $("#lb_invocie_status").text("Open");

                            $("#invoice-outstanding-'.$invoice_id.'").text(responseJSON.outstanding);
                            $("#invoice-paid-'.$invoice_id.'").text(responseJSON.paid);
                            }
                        } ',
                        'htmlOptions'=>array('style'=>'width: 10px'),
                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                    ),

                     array(
                                                    'header' => Yii::t('lang','Payment No'),
                                                    'type' => 'raw',
                                                    'value' => 'LbPayment::model()->getPaymentById($data->lb_payment_id)->lb_payment_no

                                                    ',
                                                    'htmlOptions'=>array('width'=>'100','style'=>'text-align: right;'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                    ),

                     array(
                                                    'header' => Yii::t('lang','Payment Date'),
                                                    'type' => 'raw',

                                                    'value' =>'
                                                                CHtml::activeTextField(LbPayment::model()->getPaymentById($data->lb_payment_id),"lb_payment_date",
                                                                array("style"=>"width: 100px;text-align: right; padding-right: 0px;
                                                                border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                                "class"=>"lbinvoice-line-payment_date",
                                                                "name"=>"lb_invoice_item_payment_{$data->lb_record_primary_key}",
                                                                                 "data_invoice_id"=>"{$data->lb_invoice_id}",
                                                                                  "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                                                  "onChange"=>"js:changeDate($(this).attr(\"line_item_pk\"),
                                                                                                                $(this).val())",


                                                                                  "line_item_field"=>"item-payment"))',

                                                    'htmlOptions'=>array('width'=>'100','style'=>'text-align: right;'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                    ),  
                     array(
                                                    'header' => Yii::t('lang','Method'),
                                                    'type' => 'raw',
                                                    'value' => '
                                                            CHtml::activeDropdownList(LBPayment::model(),
                                                            "lb_payment_method",
                                                            CHtml::listData(LBPayment::model()->getMethod("",LBPayment::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),
                                                                    function($method){return "";},
                                                                    function($method){return LBPayment::model()->method;})
                                                                   ,
                                                                                            array("style"=>"width: 155px; text-align: right;
                                                                                                            border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                                                                            "class"=>"lbinvoice-tax",
                                                                                                            "name"=>"lb_payment_{$data->lb_record_primary_key}",
                                                                                                            "data_invoice_id"=>"{$data->lb_payment_id}",
                                                                                                            "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                                                                            "line_item_field"=>"item-description",
                                                                                                            "options"=>array(
                                                                      LbPayment::model()->getPaymentById($data->lb_payment_id)->lb_payment_method=>array("selected"=>true),
                                                                    ),
                                                                    "onchange"=>"js:onChangeMethodDropdown($(this).attr(\"line_item_pk\"),
                                                                        $(this).val());"
                                                            )
                                            )

                                                    ',
                                                    'htmlOptions'=>array('width'=>'100','style'=>'text-align: right;'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                    ),
                     array(
                                                    'header' => Yii::t('lang','Amount'),
                                                    'type' => 'raw',
                                                    'value' =>'
                                                    CHtml::activeTextField($data,"lb_payment_item_amount",
                                                                                               array("style"=>"width: 100px;text-align: right; padding-right: 0px;
                                                                                                               border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                                                                               "class"=>"lbinvoice-line-payment_amount",
                                                                                                               "name"=>"lb_invoice_payment_amount_{$data->lb_record_primary_key}",
                                                                                                               "data_invoice_id"=>"{$data->lb_invoice_id}",
                                                                                                               "line_item_pk"=>"{$data->lb_record_primary_key}",

                                                                                                               "onChange"=>"js:changeAmount($(this).attr(\"line_item_pk\"),
                                                                                                                $(this).val())",
                                                                                                               "line_item_field"=>"item_payment_amount"),array("onChange"=>"aaa()")
                                                    )',

                                                    'htmlOptions'=>array('width'=>'100','style'=>'text-align: right;'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                    ),
                     array(
                                                    'header' => Yii::t('lang','Note'),
                                                    'type' => 'raw',
                                                    'value' => '
                                                                                       CHtml::activeTextArea($data,"lb_payment_item_note",
                                                                                               array("style"=>"width: 350px; border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                                                                               "class"=>"invoice-item-note_payment",
                                                                                                               "name"=>"lb_invoice_-note_payment{$data->lb_record_primary_key}",
                                                                                                               "data_invoice_id"=>"{$data->lb_payment_id}",
                                                                                                               "onChange"=>"js:changeNote($(this).attr(\"line_item_pk\"),
                                                                                                                $(this).val())",

                                                                                                               "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                                                                               "line_item_field"=>"item-description"))

                                                                               ',

                                                    'htmlOptions'=>array('width'=>'100','style'=>'text-align: right;'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                    ),

            ),
    ));
    if($invoice_status != LbInvoice::LB_INVOICE_STATUS_CODE_PAID)
    {
        echo CHtml::link(Yii::t('lang','Add Payment'), '#', array(
                'onclick'=>'addItemPayment('.$invoice_id.'); return false;'
        ));
    }

    echo '<button onclick="printPdfPayment()" class="btn" style="margin-left:20px;">Print PDF</button>';
}
?>

<script type="text/javascript">
    function addItemPayment(invoice_id)
    {
        var content;
        var method_arr=<?php  echo json_encode($method);?>;
        var id='<?php echo $invoice_id; ?>';
        var method='';
        for(var i=0;i<method_arr.length;i++)
            method +='<option value='+i+'>'+method_arr[i]+'</option>';

        $.ajax({
               type:'POST',
               url:'<?php echo $this->createUrl("AjaxSavePaymentInvoice"); ?>',
               beforeSend:function(){
                   $('#container-payment-invoice').block();
               },
               data:{id:id},
               success:function(response){
                   var responseJSON = jQuery.parseJSON(response);
                   var id_payment=responseJSON.lb_payment_id;
                    content ='<tr id=item_payment'+item+' name=item_payment'+item+'>';
                    content +='<td>1</td>';

                //    content +='<td><button onclick="savePayment('+item+')">save</button><button onclick="deletePayment('+item+');">Delete</button>\n\
                //        \n\
                //        </td>';

                    content +='<td>'+responseJSON.payment_no+'</td>';
                    content +='<td><input line_item_pk = '+id_payment+' type="text" style="width:100px;border-left: none;border-top:none ;border-right: none; box-shadow: none;" onchange="changeDate('+id_payment+', $(this).val());" value="<?php echo date('Y-m-d');?>"></td>';
                    content +='<td><select onchange="js:onChangeMethodDropdown('+id_payment+', $(this).val());" style="width:100%;border-left: none; border-right: none; border-top:none ;box-shadow: none;">'+method+'<select></td>';
                    content +='<td><input line_item_pk = '+id_payment+' type="text" style="width:100px;border-left: none; border-top:none ;border-right: none; box-shadow: none;" value="0.00" onchange="changeAmount('+id_payment+', $(this).val());"></td>';
                    content +='<td><textarea onchange="changeNote('+id_payment+', $(this).val())" line_item_pk = '+id_payment+' style="width:97%;border-left: none; border-top:none ;border-right: none; box-shadow: none;"></textarea></td>';
                    content +='</tr>';
                    $('#invoice-line-payment-grid-'+invoice_id+' table tr:last' ).after(content);
                    item++;
                    $('#container-payment-invoice').unblock();
               },
           });
    //   

        return true;
    }

    function deletePayment(i)
    {
        $('#item_payment'+i).remove();
    }
    function printPdfPayment()
    {
        window.open('<?php echo yii::app()->createUrl('lbPayment/default/');?>/pdf?invoice=<?php echo $invoice_id;?>&search_date_from=false&search_date_to=false','_target');   
    }
</script>