<div id="container-quotation-customer-info" style="padding-top: 20px;clear: both;">
    <div id="container-quotation-customer-name">
        <div class="field-label-left"><?php echo Yii::t('lang','To'); ?>:</div>
        <div class="field-value-left">
            <?php
                $this->widget('editable.EditableField',array(
                    'type'=>'select',
                    'model'=>$model,
                    'attribute'=>'lb_quotation_customer_id',
                    'emptytext' => 'Choose customer',
                    'url'=>  $this->createUrl('ajaxUpdateCustomer'),
                    'source' => $this->createUrl('/lbCustomer/default/dropdownJSON',array('allow_add'=>YES)),
                    'placement' => 'right',
                    'validate' => 'function(value){
                                if (value < 0) return "Please select a valid customer";
                            }',
                    'success' => 'js: function(response, newValue) {
                                var jsonResponse = jQuery.parseJSON(response);		 
                                updateQuotationAddressLines(jsonResponse);
                                updateAttentionUI('.$model->lb_record_primary_key.',0,"Choose contact");
                                lbQuotation_choose_customer = true;

                            // put customer id into hidden field
                            $("#hidden-quotation-customer-id").val(newValue);
                    }',
                    'onShown' => 'js: function() {
                        var $tip = $(this).data("editableContainer").tip();
                        var dropdown = $tip.find("select");
                        $(dropdown).bind("change", function(e){
                            onChangeCustomerDropdown(e,'.$model->lb_record_primary_key.');
                        });
                    }',
                    'options'	=> array(
                          'sourceCache'=> false,
                      ),
                    'htmlOptions'=>array(
                        'id'=>'LbInvoice_quotation_customer_id_'.$model->lb_record_primary_key,
                    ),
                ));
            ?>
        </div>
        
    </div>
    <div id="container-quotation-customer-address">
        <div class="field-label-left"><?php echo Yii::t('lang','Billing Address'); ?>:</div>
        <div class="field-value-left">
            <?php
                $this->widget('editable.EditableField',array(
                    'type'=>'select',
                    'model'=>$model,
                    'attribute'=>'lb_quotation_customer_address_id',
                    'emptytext' => 'Choose address',
                    'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
                    'source'=> $this->createUrl('/lbCustomerAddress/default/dropdownJSON',
				array('allow_add'=>YES, 'quotation_id'=>$model->lb_record_primary_key)),
                    'placement' => 'right',
                    'display' => 'js: function(value, sourceData) {
                            var el = $(this);
                            $.get("'.LbCustomerAddress::model()->getActionURLNormalized('addressLinesJSON').'?id="+value,function(response){
                                    var jsonResponse = jQuery.parseJSON(response);
                                    updateQuotationAddressLines(jsonResponse);
                            });
                    }',
                    'options'	=> array(
                          'sourceCache'=> false,
                      ),
                    'onShown' => 'js: function() {
                        var $tip = $(this).data("editableContainer").tip();
                        var dropdown = $tip.find("select");
                        $(dropdown).bind("change", function(e){
                            onChangeAddressDropdown(e,'.$model->lb_record_primary_key.');
                        });
                    }',
                    'htmlOptions'=>array(
                        'id'=>'LbInvoice_quotation_address_id_'.$model->lb_record_primary_key,
                    ),
                ));
            ?>
        </div>
    </div>
    
<div id="container-quotation-customer-attention">
        <div class="field-label-left"><?php echo Yii::t('lang','Attention'); ?>:</div>
        <div class="field-value-left">
            <?php
                $this->widget('editable.EditableField',array(
                    'type'=>'select',
                    'model'=>$model,
                    'attribute'=>'lb_quotation_attention_id',
                    'emptytext' => 'Choose attention',
                    'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
                    'source'    => LbCustomerContact::model()->getActionURLNormalized('dropdownJSON',
                        array('allow_add'=>YES, 'quotation_id'=>$model->lb_record_primary_key)),
                    'placement' => 'right',
                    'options'	=> array(
                          'sourceCache'=> false,
                      ),
                    'onShown' => 'js: function() {
                            var $tip = $(this).data("editableContainer").tip();
                            var dropdown = $tip.find("select");
                            $(dropdown).bind("change", function(e){
                                onChangeAttentionDropdown(e,'.$model->lb_record_primary_key.');
                            });
                        }',
                    'htmlOptions'=>array(
                        'id'=>'LbInvoice_quotation_contact_id_'.$model->lb_record_primary_key,
                    ),
                ));
            ?>
        </div>
</div>
    <br>
    <div id="container-quotation-customer-subject">
        <h4><?php echo Yii::t('lang','Subject'); ?>:</h4>
        <?php
            $this->widget('editable.EditableField', array(
                'type'        => 'textarea',
                'inputclass'  => 'input-large-textarea',
                'emptytext'   => 'Enter quotation subject',
                'model'       => $model,
                'attribute'   => 'lb_quotation_subject',
                'url'         => $model->getActionURLNormalized('ajaxUpdateField'),
                'placement'   => 'right',
                //'showbuttons' => 'bottom',
                'htmlOptions' => array('style'=>'text-decoration: none; border-bottom: none; color: #777'),
                'options'	=> array(
                ),
            ));
        ?>
    </div>
    
</div>
<?php
$quotation_customer_id = 0;
($model->lb_quotation_customer_id) ?  $quotation_customer_id = $model->lb_quotation_customer_id : 0;
?>
<script type="text/javascript">
    var lbQuotation_choose_customer = false;
    var quotation_custiomer_id = <?php echo $quotation_customer_id; ?>;
    if(quotation_custiomer_id != 0)
    {
        lbQuotation_choose_customer=true;
    }
    function updateQuotationAddressLines(jsonResponse){
        var address_lines="";
	if (jsonResponse != null)
	{
		address_lines += jsonResponse.formatted_address_line_1;
		if (jsonResponse.formatted_address_line_2)
			address_lines += "<br/>" + jsonResponse.formatted_address_line_2;
		if (jsonResponse.formatted_address_line_3)
			address_lines += "<br/>" + jsonResponse.formatted_address_line_3;
		if (jsonResponse.formatted_address_line_4)
			address_lines += "<br/>" + jsonResponse.formatted_address_line_4;
                
	}
        if(address_lines!="")
        {
            $('#container-quotation-customer-address .editable').html(address_lines);
            $("#container-quotation-customer-address .editable").attr("class","editable editable-click");
        }else
        {
            $('#container-quotation-customer-address .editable').html("No address availables");
            $("#container-quotation-customer-address .editable").attr("class","editable editable-click editable-empty");
        }
	
    }
    
    
    function onChangeCustomerDropdown(e, quotation_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == 0)
        {
           
            lbAppUILoadModal(quotation_id, 'New Customer','<?php
                echo LbQuotation::model()->getActionURLNormalized("ajaxQuickCreateCustomer",
                    array("ajax"=>1, "id"=>$model->lb_record_primary_key)); ?>');
        }
    }
    
    function onChangeAddressDropdown(e, quotation_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == -1)
        {
            lbAppUILoadModal(quotation_id, 'New Address','<?php
                echo LbQuotation::model()->getActionURLNormalized("ajaxQuickCreateAddress",
                    array("ajax"=>1,
                    "id"=>$model->lb_record_primary_key)); ?>');
        }
    }

    function onChangeAttentionDropdown(e, quotation_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == -1)
        {
            lbAppUILoadModal(quotation_id, 'New Contact','<?php
                echo LbQuotation::model()->getActionURLNormalized("ajaxQuickCreateContact",
                    array("ajax"=>1,
                    "id"=>$model->lb_record_primary_key)); ?>');
        }
    }

</script>
