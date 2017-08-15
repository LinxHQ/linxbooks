<?php
$canAdd = BasicPermission::model()->checkModules('lbPayment', 'add');
    $customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
				LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
    $option_customer=array(0=>'Choose Customer')+$customer_arr;
   
?>
<style>
    .accordion-heading{
        background: rgb(91,183,91);
    }
</style>
<?php 

    echo '<div id="lb-container-header">';
                echo '<div class="lb-header-right" style="margin-left:-11px;"><h3>'.Yii::t('lang','Payment').'</h3></div>';
                echo '<div class="lb-header-left">';
                        LBApplicationUI::backButton(LbInvoice::model()->getAdminURLNormalized());
                        echo '&nbsp;';
                echo '</div>';
    echo '</div>';
echo '<div style="clear: both;overflow:hidden"><Br>';

?>
<div style="overflow: hidden;">
    <div class="accordion" id="accordion2">
        <?php if($canAdd) { ?>
        <div class="accordion-group">
            <div class="accordion-heading" id="new_payment">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#form_new_payment">
                    <i></i>
                    <span style="color: #fff;font-size: 20px; font-weight: bold"><?php echo Yii::t('lang','New Payment'); ?></span>
                </a>
            </div>
            <div id="form_new_payment" class="accordion-body collapse in">
                <div class="accordion-inner">
                    <?php LBApplication::renderPartial($this,'_form_new_payment',  array('lbInvoiceModel'=>$lbInvoiceModel, 'customer_id'=>$customer_id,'model'=>$model)) ?>
                </div>
            </div>
        </div> 
        <?php } ?>
        <div class="accordion-group">
            <div class="accordion-heading" id="view_payment">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#form_view_payment">
                    <i></i>
                    <span style="color: #fff;font-size: 20px; font-weight: bold"><?php echo Yii::t('lang','View Payment'); ?></span>
                </a>
            </div>
            <div id="form_view_payment" class="accordion-body collapse">
                <div class="accordion-inner">
                    <?php LBApplication::renderPartial($this,'_view_payment',  array('lbInvoiceModel'=>$lbInvoiceModel,'model'=>$model)) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Style accodtion icon
    //$('a:active i').addClass("icon-minus-sign");
    //$('.accordion-body.in.collapse i').addClass("icon-plus-sign");
    $('#new_payment i').addClass('icon-minus-sign');
    $('#view_payment i').addClass('icon-plus-sign');
    $('#form_new_payment').on('show', function () {
        $('#new_payment i').removeClass();
        $('#new_payment i').addClass('icon-minus-sign');
    });
    $('#form_new_payment').on('hidden', function () {
        $('#new_payment i').removeClass();
        $('#new_payment i').addClass('icon-plus-sign');
    });
    $('#form_view_payment').on('show', function () {
        $('#view_payment i').removeClass();
        $('#view_payment i').addClass('icon-minus-sign');
        $('#form_view_payment').css('min-height','300px');
    });
    $('#form_view_payment').on('hidden', function () {
        $('#view_payment i').removeClass();
        $('#view_payment i').addClass('icon-plus-sign');
        $('#form_view_payment').css('min-height','0px');
    });


</script>
    
