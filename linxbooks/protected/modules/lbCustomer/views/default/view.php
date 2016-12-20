<?php
/* @var $this LbCustomerController */
/* @var $model LbCustomer */
/* @var $customer_addresses array of LbCustomerAddress models */
/* @var $customer_contacts ARRAY of LbCustomerContact models */

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canView = BasicPermission::model()->checkModules($m, 'view');
$canAddInvoice = BasicPermission::model()->checkModules(LbInvoice::model()->getEntityType(), 'add');

if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;"><h3>'.Yii::t('lang','Customers').'</h3></div>';
            echo '<div class="lb-header-left">';
                LBApplicationUI::backButton($model->getHomeURLNormalized());
                echo '&nbsp;';
                // new
                if($canAdd || $canAddInvoice)
                LBApplicationUI::newButtonGroup(Yii::t('lang','New'),
                        array(
                                'buttons'=>array(
                                        array( 
                                                'items'=>array(
                                                        array('label'=>Yii::t('lang','New Address'), 'url'=>LbCustomerAddress::model()->getCreateURLNormalized(array('customer_id'=>$model->lb_record_primary_key)),'visible'=>$canAdd),
                                                        array('label'=>Yii::t('lang','New Contact'), 'url'=>LbCustomerContact::model()->getCreateURLNormalized(array('customer_id'=>$model->lb_record_primary_key)),'visible'=>$canAdd),
                                                        array('label'=>Yii::t('lang','New Invoice'), 'url'=>'#','visible'=>$canAddInvoice),
                                                        '---',
                                                        array('label'=>Yii::t('lang','New Customer'), 'url'=>$model->getCreateURLNormalized(),'visible'=>$canAdd),
                                        )),
                                ),
                        )
                );
            echo '</div>';
echo '</div>';
?>

<div style="width:30%;margin-top:19px;margin-bottom:11px;"><span style="font-size: 16px;"><b><?php echo $model->lb_customer_name; ?></b></span></div>

<?php 
echo '<div class="btn-toolbar">';
// go back

/**
LBApplicationUI::newButton('New Address');
echo '&nbsp;';
LBApplicationUI::newButton('New Contact');
echo '&nbsp;';
LBApplicationUI::newButton('New Invoice');**/
echo '</div>';

$this->widget('editable.EditableDetailView', array(
		'data'       => $model,
		'url'        => $model->getActionURL('ajaxUpdateField'), //$this->createUrl('/lbCustomer/ajaxUpdateField'), //common submit url for all fields
		'params'     => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken), //params for all fields
		//'emptytext'  => 'Click to update',
		//'apply' => false, //you can turn off applying editable to all attributes
		'attributes' => array(
				array(
						'name' => 'lb_customer_name',
						'editable' => array(
								'type'       => 'text',
								'inputclass' => 'input-large',
								'emptytext'  => 'Click to Update',
								'validate'   => 'function(value) {
                    				if(!value) return "Customer Name is required."
                				}'
						)
				),
				'lb_customer_registration',
				'lb_customer_tax_id',
				'lb_customer_website_url',
				array(
						'name' => 'lb_customer_is_own_company',
						'editable' => array(
								'type'      => 'select',
								'source'    => array(LbCustomer::LB_CUSTOMER_IS_NOT_OWN_COMPANY,  LbCustomer::LB_CUSTOMER_IS_OWN_COMPANY),
								'placement' =>'right',
								'validate'  => 'function(value) {
                    				if(!value) return "Customer Name is required."
                				}'
						)
				),
		),
));

/**
 * Show tabs of other details: address, contact, invoice
 */
$tab_addresses = LBApplication::renderPartial($this, '_customer_addresses', array(
		'customer_addresses'=>$customer_addresses,
                'customer_id'=>$model->lb_record_primary_key,
		),true);
$tab_contacts = LBApplication::renderPartial($this, '_customer_contacts', array(
		'customer_contacts'=>$customer_contacts,
                'customer_id'=>$model->lb_record_primary_key,
		),true);

$this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs', // 'tabs' or 'pills'
		'encodeLabel'=>false,
		'tabs'=> 
		array(
				array('id'=>'tab1','label'=>'<i class="icon-envelope"></i> <strong>'.Yii::t('lang','Addresses').'</strong>', 
						'content'=> $tab_addresses,
						'active'=>true),
				array('id'=>'tab2','label'=>'<i class="icon-user"></i> <strong>'.Yii::t('lang','Contacts').'</strong>',
						'content'=>$tab_contacts,
						'active'=>false),
				array('id'=>'tab3','label'=>'<i class="icon-file"></i> <strong>'.Yii::t('lang','Invoices').'</strong>',
						'content'=>  LBApplication::renderPartial($this, '_view_invoice_customer', array(
                                                                    'model'=>$model,
                                                                ),true),
						'active'=>false),
				)
));
?>
