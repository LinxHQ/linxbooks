<?php
/* @var $this LbQuotationController */
/* @var $model LbQuotation */
/* @var $quotationItem LbQuotationItem */
/* @var $invoiceItemTemplate LbInvoiceItemTemplate */

$grid_id = 'grid-quotation-item-templates-' . $model->lb_record_primary_key;
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>$grid_id,
    'type'=>'striped bordered condensed',
    'dataProvider'=>$invoiceItemTemplate->getInvoiceItemTemplates(),
    'filter'=>$invoiceItemTemplate,
    //'template'=>"{items}",
    'columns'=>array(
        array(
            'name'=>'lb_item_description',
            'header'=>'Item',
            'type'=>'raw',
            'value'=>'( $data->lb_item_title ? "<strong>" . $data->lb_item_title . "</strong><br/>" : "")
                . str_replace("\n", "<br/>", $data->lb_item_description)
                . CHtml::activeHiddenField($data, "lb_item_title",array("id"=>"lb_item_title_" . $data->lb_record_primary_key))
                . CHtml::activeHiddenField($data, "lb_item_description",array("id"=>"lb_item_description_" . $data->lb_record_primary_key))
            ',
        ),
        array(
            'name'=>'lb_item_unit_price',
            'header'=>'Unit Price',
            'htmlOptions'=>array('width'=>'100', 'style'=>'width: 100px; text-align: right', 'align'=>'right'),
            'filter'=>false,
            'type'=>'raw',
            'value'=>'
                $data->lb_item_unit_price
                . CHtml::activeHiddenField($data, "lb_item_unit_price",array("id"=>"lb_item_unit_price_" . $data->lb_record_primary_key))
            '
        ),
        array(
            'header'=>'',
            'type'=>'raw',
            'value'=>'"<a href=\"javascript:void(0)\"
                onclick=\"updateItemWithTemplate('.$quotationItem->lb_record_primary_key.',
                    ".$data->lb_record_primary_key.")\">Insert</a>"',
        ),
    ),
));

?>
<script language="javascript">
    function updateItemWithTemplate(item_id, template_id)
    {
        var item_title = $("#<?php echo $grid_id; ?> #lb_item_title_"+template_id).val();
        var item_description = '';

        if (item_title != '')
            item_description += '\n';
        item_description += $("#<?php echo $grid_id; ?> #lb_item_description_"+template_id).val();

        var item_unit_price = $("#<?php echo $grid_id; ?> #lb_item_unit_price_"+template_id).val();
        var item_quantity = $("#lb_quotation_item_quantity_"+item_id).val();
        var total = parseFloat(item_unit_price)*parseFloat(item_quantity);
        var item_total = total.toFixed(2);
        $("#lb_quotation_item_description_"+item_id).val(item_description);
        $("#lb_quotation_item_price_"+item_id).val(item_unit_price);
       // $("#lb_quotation_item_total_"+item_id).val(item_unit_price);
        $("#lb_quotation_item_total_"+item_id).val(item_total);
        lbquotation_line_items_updated = true;
        lbAppUIHideModal(<?php echo $model->lb_record_primary_key?>);
    }
</script>