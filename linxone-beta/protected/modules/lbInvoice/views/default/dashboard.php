<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $quotationModel LbQuotation */

if(isset(Yii::app()->user->id))
    $lang = lbLangUser::model()->getLangName(Yii::app()->user->id);



if($lang != "")
{
    Yii::app()->language=$lang;
    $_SESSION["sess_lang"] = strtolower($lang);
}

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canView = BasicPermission::model()->checkModules($m, 'view');
$canAddQuotation = BasicPermission::model()->checkModules('lbQuotation', 'add');
$canListQuotation = BasicPermission::model()->checkModules('lbQuotation', 'list');
$canAddPayment = BasicPermission::model()->checkModules('lbPayment', 'add');

if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}
$status='("'.LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")';
$count_invoice=  LbInvoice::model()->getInvoiceByStatus($status);
$count_invoice= $count_invoice->totalItemCount;
$count_quotation= LbQuotation::model()->getQuotationByStatus('("'.LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT.'","'.LbQuotation::LB_QUOTATION_STATUS_CODE_SENT.'","'.LbQuotation::LB_QUOTATION_STATUS_CODE_APPROVED.'")');
$count_quotation=$count_quotation->totalItemCount;
//$status_arr = LbInvoice::model()->getArrayStatusInvoice();
//$option_status = '<options>'.$status_arr.'</options>';
// Buttons

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left: -10px"><h3>'.Yii::t("lang","Dashboard").'</h3></div>';
            echo '<div class="lb-header-left">';
            echo '<div id="lb_invoice" class="btn-toolbar" style="margin-top:2px;" >';
                echo ' <input type="text" placeholder="Search" value="" style="border-radius: 15px;" onKeyup="search_name_invoice(this.value);">';
//            if($canAdd)
//                echo '<button id="btn_invoice" class = "btn" onclick="view_oustanding_invoice()">Outstanding Invoice<span class="notification-badge">'.$count_invoice.'</span></button>';
//            if($canAddQuotation)
//                echo '<button id="btn_quotation" class = "btn" onclick="view_oustanding_quotation()">Outstanding Quotation<span class="notification-badge">'.$count_quotation.'</span></button>';
//            if($canAddPayment)
//                echo '<button id="btn_graph" class = "btn" onclick="view_chart()">Chart</button>';
            echo '</div>';
            echo '<div id="lb_quotation" class="btn-toolbar" style="margin-top:2px;">';
                echo '<input type="text" placeholder="Search" value="" style="border-radius: 15px;" onKeyup="search_name_quotation(this.value);">';
            echo '</div>';
            echo '</div>';
echo '</div>';
    
echo '<div id="lb_dashboard_summary">';
    //echo '<div style="width:15%;"></div>';
    LBApplication::renderPartial($this,'dashboard_summary',  array('model'=>$model));                   
echo '</div>';
echo '</br>';
echo '<div id="lb_dashboard_submenu">';
    echo '<div class="lb_submenu_left">';
        echo '<img id="img_invoice" class="lb_img_submenu_left" src='.Yii::app()->baseUrl.'/images/icons/invoice-green.png onclick="view_oustanding_invoice()"><br/>';
        echo '<label  style="margin-left:10px;" class="submenu_label" id="btn_invoice"  onclick="view_oustanding_invoice()">Invoice</label>&nbsp&nbsp';
  
    echo '</div>';
     echo '<div class="lb_submenu_left">';
        echo '<img id="img_quotation" class="lb_img_submenu_left_opacity" onclick="view_oustanding_quotation()" src='.Yii::app()->baseUrl.'/images/icons/icon_quote3.png ><br/>';
        
        echo '<label class="submenu_label" id="btn_quotation" style="color:black !important;" onclick="view_oustanding_quotation()">Quotations</label>&nbsp&nbsp';  
    echo '</div>';
     echo '<div class="lb_submenu_left">';
        echo '<img id="img_chart" class="lb_img_submenu_left_opacity" src='.Yii::app()->baseUrl.'/images/icons/chart.png onclick="view_chart()"><br/>';
        echo '<label class="submenu_label" id="btn_graph"  style="margin-left:16px;" onclick="view_chart()">Charts</label>';
    echo '</div>';
    
    
echo '</div>';
echo '<br />';
echo '<div style="border-bottom:3px solid #e8e8e8;margin-top:107px"></div>';
echo '<div id="lb_submenu_right_invoice" class="lb_submenu_right">';

            
  
       
    ?>
    



        
        
    <?php
    echo '<div class="dropdown" style="display:inline-flex;color:rgb(91,183,91); float:right;">';
//                echo 'Invoice Status:&nbsp;';
                echo'<label data-toggle="dropdown">All Status
                 <span class="caret"></span></label>';
                 echo'<ul class="dropdown-menu">';
                   
                    $list = LbInvoice::model()->getArrayStatusInvoice();
                    foreach ($list as $value) {
                        $status_invoice = LbInvoice::model()->getInvoiceStatus($value);
                        ?>
                            <li><a href="#" onclick="search_invoice('<?php echo $status_invoice;?>'); return false;"><?php echo $value?></a></li>
                            <?php                      
                   }                 
                 echo '</ul>';
            echo '</div>';
    echo '</div>';
echo '<div id="lb_submenu_right_quotation" class="lb_submenu_right">';
        ?>
        

        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
         <a style="margin-left:-17px" href="<?php echo $model->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))); ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Invoice'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <a href="<?php echo LbQuotation::model()->getCreateURLNormalized(); ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Quotation'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
         <a href="#" data-toggle="modal" data-target="#myModal" onclick="load_ajax();"><img width="16" src="<?php echo Yii::app()->baseUrl.'/images/icons/dolar.png' ?>" /><?php echo Yii::t('lang','New Payment'); ?></a> -->

    <?php
         echo '<div class="dropdown" style="display:inline-flex;color:rgb(91,183,91);float:right">';
//                echo 'Quotation Status:&nbsp;';
                echo'<label data-toggle="dropdown">All Status
                 <span class="caret"></span></label>';
                 echo'<ul class="dropdown-menu">';
                   
                    $listQuoStatus = LbQuotation::model()->ArrayStatusQuotation();
                    foreach ($listQuoStatus as $value) {
                        $status_quotation = LbQuotation::model()->getQuotationStatus($value);
                        
                        ?>
                            <li><a href="#" onclick="search_quotation('<?php echo $status_quotation;?>'); return false;"><?php echo $value?></a></li>
                            <?php                      
                   }                 
                 echo '</ul>';
            echo '</div>';
//            echo 'Quotation Status: '.CHtml::dropDownList('status_quo_id', '',
//    LbQuotation::model()->ArrayStatusQuotation(), array('empty' => 'All','onchange'=>'search_quotation();return false;','style'=>'width:100px;'));
//       
    
    echo '</div>';
    echo '<div id="lb_menu_right" class="lb_submenu_right">';
    ?>
         <!-- <a href="<?php echo $model->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))); ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Invoice'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <a href="<?php echo LbQuotation::model()->getCreateURLNormalized(); ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Quotation'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <a href="<?php echo Yii::app()->createAbsoluteUrl('lbPayment/default/create'); ?>"><img width="16" src="<?php echo Yii::app()->baseUrl.'/images/icons/dolar.png' ?>" /> <?php echo Yii::t('lang','New Payment'); ?></a> -->
    <?php
    echo '</div>';
?>
<div class="form-modal-up-payment">
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a style="margin-left:-17px" href="<?php echo $model->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))); ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Invoice'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <a href="<?php echo LbQuotation::model()->getCreateURLNormalized(); ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Quotation'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <!-- <a href="<?php echo Yii::app()->createAbsoluteUrl('lbPayment/default/create'); ?>"><img width="16" src="<?php echo Yii::app()->baseUrl.'/images/icons/dolar.png' ?>" /> <?php echo Yii::t('lang','New Payment'); ?></a> -->

         <a href="#" data-toggle="modal" data-target="#myModal" onclick="load_ajax();"><img width="16" src="<?php echo Yii::app()->baseUrl.'/images/icons/dolar.png' ?>" /><?php echo Yii::t('lang','New Payment'); ?></a>

         <!-- Modal -->
        <div class="modal fade" id="myModal" style="position: absolute; left: 5%; width: 90%; margin-left: 0px;     overflow: hidden;" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
                <div class="modal-content">

                     <h2 style="background: rgb(91, 183, 91); color: #fff; text-align: center; padding: 8px 0; margin-top: 0; border-radius: 5px 5px 0px 0px;">New Payment</h2>
                     <div class="form-new-payment">
                        
                     </div>
              
                </div>
            </div>
        </div>
    </div>

<?php    
echo '<div id ="view_invoice" style="clear:both">';

echo '</div>';
?>



<script lang="Javascript">
view_oustanding_invoice();
function view_oustanding_invoice()
{
    $("#img_quotation").removeClass();
    $('#img_quotation').addClass("lb_img_submenu_left_opacity");
    
    $("#img_invoice").removeClass();
    $('#img_invoice').addClass("lb_img_submenu_left");
    
    $("#img_chart").removeClass();
    $('#img_chart').addClass("lb_img_submenu_left_opacity");
    $('#view_invoice').load('<?php echo LbInvoice::model()->getActionURLNormalized('_form_oustanding_invoice') ?>',{year:<?php echo date('Y')?>},function(){
    });
    $("#btn_invoice").css("color","rgb(91,183,91) !important");   
     $("#btn_graph").css("color","#dcdcdc !important");
    $("#btn_quotation").css("color","#dcdcdc !important");
    $("#lb_submenu_right_quotation").hide();
    $("#lb_submenu_right_invoice").show();
    $("#lb_menu_right").hide();
    $("#lb_quotation").hide();
    $("#lb_invoice").show();
}

function view_oustanding_quotation()
{
    $("#img_quotation").removeClass();
    $('#img_quotation').addClass("lb_img_submenu_left");
    
    $("#img_invoice").removeClass();
    $('#img_invoice').addClass("lb_img_submenu_left_opacity");
    
    $("#img_chart").removeClass();
    $('#img_chart').addClass("lb_img_submenu_left_opacity");
    
    $("#btn_graph").css("color","#dcdcdc");
  
    $("#btn_invoice").css("color","#dcdcdc");
     $("#btn_quotation").css("color","rgb(91,183,91)!important");
    
    $('#view_invoice').load('<?php echo LbInvoice::model()->getActionURLNormalized('_form_oustanding_quotation') ?>');
    $("#lb_submenu_right_quotation").show();
    $("#lb_submenu_right_invoice").hide();
    $("#lb_menu_right").hide();
    $("#lb_quotation").show();
    $("#lb_invoice").hide();
}
function view_chart()
{
    $("#img_quotation").removeClass();
    $('#img_quotation').addClass("lb_img_submenu_left_opacity");
    
    $("#img_invoice").removeClass();
    $('#img_invoice').addClass("lb_img_submenu_left_opacity");
    
    $("#img_chart").removeClass();
    $('#img_chart').addClass("lb_img_submenu_left");
    
    
    $("#btn_graph").css("color","rgb(91,183,91)!important");
    $("#btn_invoice").css("color","#dcdcdc");
    $("#btn_quotation").css("color","#dcdcdc");

    $('#view_invoice').load('<?php echo LbInvoice::model()->getActionURLNormalized('chart') ?>');
    $("#lb_submenu_right_quotation").hide();
    $("#lb_submenu_right_invoice").hide();
    $("#lb_menu_right").show();
}
function search_name_invoice(name)
    {
        name = replaceAll(name," ", "%");
        
        if(name.length >= 3){
        $('#show_invoice').load('<?php echo $this->createUrl('/lbInvoice/default/_search_invoice');?>?name='+name
                  
            );
        }
    }
    function replaceAll(string, find, replace) {
      return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }
    function escapeRegExp(string) {
        return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
    }
function search_name_quotation(name)
    {
        name = replaceAll(name," ", "%");
         $('#show_quotation').load('<?php echo $this->createUrl('/lbInvoice/default/_search_quotation');?>?name='+name);
    }
   
function search_invoice(status_id)
    {
        //var status_id = $(this).attr("status_id");
     //   var status_id = $('#status_inv_id').attr('value');   
       
        console.log(status_id);
           
       // $('#show_invoice').load('<?//php// echo LbInvoice::model()->getActionURLNormalized('_load_status_invoice',array()) ?>',{status_id:status_id});
      // $('#view_invoice').load('<?//php// echo LbInvoice::model()->getActionURLNormalized('_form_oustanding_invoice') ?>',{status_id:status_id});
       $('#view_invoice').load('<?php echo $this->createUrl('/lbInvoice/default/_form_oustanding_invoice')?>?status_id='+status_id);
    }
function search_quotation(status_id)
    {
       
      //  var status_id = $('#status_quo_id').val();      
      //  $('#show_quotation').load('<?//php// echo LbInvoice::model()->getActionURLNormalized('_load_status_quotation') ?>',{status_id:status_id});
       // $('#view_invoice').load('<?//php// echo LbInvoice::model()->getActionURLNormalized('_form_oustanding_quotation') ?>',{status_id:status_id});
        $('#view_invoice').load('<?php echo $this->createUrl('/lbInvoice/default/_form_oustanding_quotation')?>?status_id='+status_id);
    }

function load_ajax(){
    $.ajax({
        url : "<?php echo Yii::app()->baseUrl; ?>/lbPayment/default/FormPayment",
        type : "post",
        success : function (result){
            $('.form-new-payment').html(result);
        }
    });

}


</script>
<style>
    .notification-badge {
    background-color:#e9852f;
    border-radius: 9px;
    color: #fff;
    display: inline-block;
    font-size: 9pt;
    font-weight: bold;
    left: -5px;
    line-height: 14px;
    padding: 2px 8px;
    position: relative;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    margin-left: 7px;
    vertical-align: baseline;
    white-space: nowrap;
    margin-right: -14px;
}
.hidden-cancel {
   display: inline;
}
.table {
    width: 98%;
    margin: auto;
}
.summary {
    position: relative;
    right: 12px;
}
.form-horizontal .control-label {
    float: left;
    width: 160px;
    padding-top: 5px;
    text-align: left;
    font-size: 18px;
}
form {
    overflow: hidden;
    z-index: 9999999999;
}
.form-horizontal .control-group {
    position: relative;
    left: 30%;
}
input, textarea, .uneditable-input {
    width: 286px;
}
select {
    width: 300px;
}
.controls-button {
   left: 0px !important;
}
.note {
    position: relative;
    left: 44.8%;
}
#contactable-inner {
   z-index:0;
}
.controls {
   font-size: 20px !important;
   margin-bottom: 6px;
}

.span4, #LbPayment_lb_payment_method, #LbPayment_lb_payment_date, #payment_amount {
    font-size: 16px;
}
</style>



