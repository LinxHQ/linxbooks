<?php
/* @var $customer_contacts array of LbCustomerContact models */

$i=0;
foreach ($customer_contacts as $contact)
{
    $i++;
    echo "
            <div style='overflow:hidden; border-top: 1px solid #EEEEEE;margin-top: 5px;'>
                <div style='float:left'>
                    <h4><span style='padding: 0 8px;background:#EEEEEE;border-radius:50%;'>$i</span> {$contact->lb_customer_contact_first_name} {$contact->lb_customer_contact_last_name}</h4>
                </div>
                <div style='float:right;margin-top:5px;'>
                    <a href='#' onclick=\"onclickContactSlideToggle(".$contact->lb_record_primary_key."); return false;\">
                        <i class='icon-info-sign'></i>
                        ".Yii::t('lang','Detail information')."
                    </a>
                    <a href='#' onclick='ajaxDeleteContact(".$contact->lb_record_primary_key."); return false;'>
                        <i class='icon-trash'></i>
                        ".Yii::t('lang','Delete')."
                    </a>
                </div>
            </div>
            <div id='error_delete_contact_".$contact->lb_record_primary_key."' class='alert alert-block alert-error' style='display:none;'></div>
        ";
        echo "<div id='detail_customer_contact_".$contact->lb_record_primary_key."' style='display:none;'>";
            $this->widget('editable.EditableDetailView', array(
                            'data'       => $contact,
                            'url'        => $contact->getActionURL('ajaxUpdateField'), 
                            'params'     => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken), //params for all fields
                            //'emptytext'  => 'Click to update',
                            //'apply' => false, //you can turn off applying editable to all attributes
                            'attributes' => array(
                                            array(
                                                            'name' => 'lb_customer_contact_first_name',
                                                            'editable' => array(
                                                                            'type'       => 'text',
                                                                            'inputclass' => 'input-large',
                                                                            'emptytext'  => 'Click to Update',
                                                                            'validate'   => 'function(value) {
                                                            if(!value) return "First Name is required."
                                                            }'
                                                            )
                                            ),
                                            array(
                                                            'name' => 'lb_customer_contact_last_name',
                                                            'editable' => array(
                                                                            'type'       => 'text',
                                                                            'inputclass' => 'input-large',
                                                                            'emptytext'  => 'Click to Update',
                                                                            'validate'   => 'function(value) {
                                                            if(!value) return "Last Name is required."
                                                            }'
                                                            )
                                            ),
                                            'lb_customer_contact_office_phone',
                                            'lb_customer_contact_office_fax',
                                            'lb_customer_contact_mobile',
                                            'lb_customer_contact_email_1',
                                            'lb_customer_contact_email_2',
                                            array(
                                                            'name' => 'lb_customer_contact_note',
                                                            'editable' => array(
                                                                            'type'       => 'textarea',
                                                                            'inputclass' => 'input-large span7',
                                                                            'emptytext'  => 'Click to Update',
                                                            )
                                            ),
                                            array(
                                                            'name' => 'lb_customer_contact_is_active',
                                                            'editable' => array(
                                                                            'type'       => 'select',
                                                                            'source'	=> LbCustomerContact::$dropdownActiveContact,
                                                                            'placement' =>'right',
                                                            )
                                            ),
                            ),
            ));
        echo "</div>";
} // end for
?>
<script>
    function onclickContactSlideToggle(id)
    {
        $("#detail_customer_contact_"+id).slideToggle();
        $("#error_delete_contact_"+id).css("display","none");
    }
    function ajaxDeleteContact(id)
    {
        
        $.ajax({
            type:'POST',
            url: "<?php echo $this->createUrl('deleteContact'); ?>",
            success:function(response){
                var responseJSON = jQuery.parseJSON(response);
                if(responseJSON!=null)
                {
                    $("#error_delete_contact_"+id).css("display","block");
                    $("#error_delete_contact_"+id).html(responseJSON.exist);
                }
                else
                {
                    
                    $('#tab2').load("<?php echo $this->createUrl('loadAjaxTabAddress',array('id'=>$customer_id)); ?>");
                }
            },
            data:{id:id,customer_id:<?php echo $customer_id ?>},
        });
    }
    
</script>
