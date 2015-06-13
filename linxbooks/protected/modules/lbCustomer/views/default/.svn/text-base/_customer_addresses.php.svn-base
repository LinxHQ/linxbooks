<?php
/* @var $customer_addresses array of LbCustomerAddress models */
$canDeleteAddress = BasicPermission::model()->checkModules(LbCustomerAddress::model()->getEntityType(), 'delete');
$canEditAddress = BasicPermission::model()->checkModules(LbCustomerAddress::model()->getEntityType(), 'edit');

$i=0;
foreach ($customer_addresses as $address)
{
        $i++;
	echo "
                <div style='overflow:hidden; border-top: 1px solid #EEEEEE;margin-top: 5px;'>
                    <div style='float:left'>
                        <h4><span style='padding: 0 8px;background:#EEEEEE;border-radius:50%;'>$i</span> {$address->lb_customer_address_line_1}</h4>
                    </div>
                    <div style='float:right;margin-top:5px;'>
                        <a href='#' onclick=\"onclickSlideToggle(".$address->lb_record_primary_key."); return false;\">
                            <i class='icon-info-sign'></i>
                            ".Yii::t('lang','Detail information')."
                        </a>";
        if($canDeleteAddress)
            echo           "<a href='#' onclick='ajaxDeleteAddress(".$address->lb_record_primary_key."); return false;'>
                            <i class='icon-trash'></i>
                            ".Yii::t('lang','Delete')."
                        </a>";
        echo        "</div>
                </div>
                <div id='error_delete_address_".$address->lb_record_primary_key."' class='alert alert-block alert-error' style='display:none;'></div>
            ";
	echo "<div id='detail_customer_address_".$address->lb_record_primary_key."' style='display:none;'>";
            $this->widget('editable.EditableDetailView', array(
                            'data'       => $address,
                            'url'        => $address->getActionURL('ajaxUpdateField'), 
                            'params'     => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken), //params for all fields
                            //'emptytext'  => 'Click to update',
                            //'apply' => false, //you can turn off applying editable to all attributes
                            'attributes' => array(
                                            array(
                                                            'name' => 'lb_customer_address_line_1',
                                                            'editable' => array(
                                                                            'type'       => 'text',
                                                                            'inputclass' => 'input-large',
                                                                            'emptytext'  => 'Click to Update',
                                                                            'validate'   => 'function(value) {
                                                            if(!value) return "Address Line 1 is required."
                                                            }'
                                                            )
                                            ),
                                            'lb_customer_address_line_2',
                                            'lb_customer_address_city',
                                            'lb_customer_address_state',
                                            array(
                                                            'name' => 'lb_customer_address_country',
                                                            'editable' => array(
                                                                            'type'       => 'select',
                                                                            'source'	=> LBApplicationUI::countriesDropdownData(),
                                                                            'placement' =>'right',
                                                            )
                                            ),
                                            'lb_customer_address_postal_code',
                                            'lb_customer_address_website_url',
                                            'lb_customer_address_phone_1',
                                            'lb_customer_address_phone_2',
                                            'lb_customer_address_fax',
                                            'lb_customer_address_email',
                                            'lb_customer_address_note',
                                            array(
                                                            'name' => 'lb_customer_address_is_active',
                                                            'editable' => array(
                                                                            'type'       => 'select',
                                                                            'source'	=> LbCustomerAddress::$dropdownActive,
                                                                            'placement' =>'right',
                                                            )
                                            ),
                            ),
            ));
        echo "</div>";
} // end for
?>
<script>
    function onclickSlideToggle(id)
    {
        $("#detail_customer_address_"+id).slideToggle();
        $("#error_delete_address_"+id).css("display","none");
    }
    function ajaxDeleteAddress(id)
    {
        
        $.ajax({
            type:'POST',
            url: "<?php echo $this->createUrl('deleteAddress'); ?>",
            success:function(response){
                var responseJSON = jQuery.parseJSON(response);
                if(responseJSON!=null)
                {
                    $("#error_delete_address_"+id).css("display","block");
                    $("#error_delete_address_"+id).html(responseJSON.exist);
                }
                else
                {
                    
                    $('#tab1').load("<?php echo $this->createUrl('loadAjaxTabAddress',array('id'=>$customer_id)); ?>");
                }
            },
            data:{id:id,customer_id:<?php echo $customer_id ?>},
        });
    }
    
</script>
