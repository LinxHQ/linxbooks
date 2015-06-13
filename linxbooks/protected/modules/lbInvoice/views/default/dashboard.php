<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $quotationModel LbQuotation */

/**
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lb-invoice-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");**/
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canView = BasicPermission::model()->checkModules($m, 'view');
$canAddQuotation = BasicPermission::model()->checkModules('lbQuotation', 'add');
$canListQuotation = BasicPermission::model()->checkModules('lbQuotation', 'list');
$canAddPayment = BasicPermission::model()->checkModules('lbPayment', 'add');
//$test = LbQuotation::model()->searchQuotationByName($_REQUEST['name'],10,$canListQuotation);
//echo '<pre>';
//print_r($test);
if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}

// Buttons

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left: -10px"><h4>'.Yii::t("lang","Invoice Dashboard").'</h4></div>';
            echo '<div class="lb-header-left">';
            echo '<div class="btn-toolbar" style="margin-top:2px;">';
            if($canAdd)
                echo '<button id="btn_invoice" class = "btn" onclick="view_oustanding_invoice()">Outstanding Invoice</button>';
            if($canAddQuotation)
                echo '<button id="btn_quotation" class = "btn" onclick="view_oustanding_quotation()">Outstanding Quotation</button>';
            if($canAddPayment)
                echo '<button id="btn_graph" class = "btn" onclick="view_chart()">Chart</button>';
            echo '</div>';
            echo '</div>';
echo '</div>';
echo '<br />';
echo '<div id ="view_invoice">';

echo '</div>';
?>

<?php

//    $this->widget('bootstrap.widgets.TbTabs', array(
//                    'type'=>'tabs', // 'tabs' or 'pills'
//                    'encodeLabel'=>false,
//                    'tabs'=> 
//                    array(
//                                array('id'=>'tab1','label'=>'<strong>'.Yii::t('lang','Outstanding Invoice').'</strong>',
//                                                    'content'=>$this->renderPartial('_form_oustanding_invoice',array('model'=>$model,
//                                                    ),true),'active'=>true,
//                                                ),
//                                array('id'=>'tab2','label'=>'<strong>'.Yii::t('lang','Outstanding Quotation').'</strong>', 
//                                                'content'=> $this->renderPartial('_form_oustanding_quotation', array(
//                                                       
//                                              'quotationModel'=>$quotationModel,  ),true),
//                                                'active'=>false),
//                                array('id'=>'tab3','label'=>'<strong>'.Yii::t('lang','Chart').'</strong>',
//                                                'content'=> $this->renderPartial('chart', array(
//                                                
//                                                'model'=>$model,),true),
//                                                'active'=>false),
//                               
//                               
//                                
//                            )
//    ));

?>
<script lang="Javascript">
    $('#view_invoice').load('<?php echo LbInvoice::model()->getActionURLNormalized('_form_oustanding_invoice') ?>',{year:<?php echo date('Y')?>});
     $("#btn_invoice").css("background-color","#5bb75b");

function view_oustanding_invoice()
{
        $('#view_invoice').load('<?php echo LbInvoice::model()->getActionURLNormalized('_form_oustanding_invoice') ?>',{year:<?php echo date('Y')?>});

     $("#btn_invoice").css("background-color","#5bb75b");
     $("#btn_graph").css("background-color","#f5f5f5");
      $("#btn_quotation").css("background-color","#f5f5f5");
}

function view_oustanding_quotation()
{
    $("#btn_quotation").css("background-color","#5bb75b");
    $("#btn_invoice").css("background-color","#f5f5f5");
    $("#btn_graph").css("background-color","#f5f5f5");
    $('#view_invoice').load('<?php echo LbInvoice::model()->getActionURLNormalized('_form_oustanding_quotation') ?>');
}
function view_chart()
{
   $("#btn_graph").css("background-color","#5bb75b");
   $("#btn_invoice").css("background-color","#f5f5f5");
   $("#btn_quotation").css("background-color","#f5f5f5");
    $('#view_invoice').load('<?php echo LbInvoice::model()->getActionURLNormalized('chart') ?>');
}
</script>



