<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/mixins.less">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/datepicker.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/highlight/styles/default.css">
<!--	<link href='https://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800|Rouge+Script|Kaushan+Script' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
            -->
	<?php //Yii::app()->bootstrap->register(); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script language="javascript">
	var BASE_URL = '<?php echo Yii::app()->baseUrl; ?>';
	</script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.tooltip-1.2.6.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.ba-bbq.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-editable.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.yiigridview.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/ducksboard/jquery.gridster.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-tooltip.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.cleditor.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/fileuploader.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/highlight/highlight.pack.js"></script>
	<script src="<?php echo Yii::App()->baseUrl; ?>/js/jstz-1.0.4.min.js"></script>
	<script src="<?php echo Yii::App()->baseUrl; ?>/js/autosize/jquery.autosize.min.js"></script>
	<script src="<?php echo Yii::App()->baseUrl; ?>/js/bootstrap-hover-dropdown.js"></script>
	<script src="<?php echo Yii::App()->baseUrl; ?>/js/bootstrap-hover-dropdown.min.js"></script>
	
        <script src="<?php echo Yii::App()->baseUrl; ?>/js/jquery.blockUI.js"></script>
	<script src="<?php echo Yii::App()->baseUrl; ?>/js/linxbooks.lbInvoice.js"></script>
	
	<?php //Yii::app()->editable->init(); ?>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/application.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>
	<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.contactable.min.js"></script>
	<?php 
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.js', CClientScript::POS_END);
	
	?>
	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/contactable.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css">
</head>
<body>
<?php
//Permission Customer
//$lang = lbLangUser::model()->getLangName(Yii::app()->user->id);
//if($lang != "")
//{
//    Yii::app()->language=$lang;
//    $_SESSION["sess_lang"] = strtolower($lang);
//}
//echo Yii::app()->user->id;
$customer_canAdd = BasicPermission::model()->checkModules('lbCustomer', 'add');
$customer_canView = BasicPermission::model()->checkModules('lbCustomer', 'view');

//Permission Invoice
$invoice_canAdd = BasicPermission::model()->checkModules('lbInvoice', 'add');
$invoice_canView = BasicPermission::model()->checkModules('lbInvoice', 'view');

//Permission Expenses
$expenses_canView = BasicPermission::model()->checkModules('lbExpenses', 'view');
$expenses_canAdd = BasicPermission::model()->checkModules('lbExpenses', 'add');


//Permission Quotation
$quotation_canAdd = BasicPermission::model()->checkModules('lbQuotation', 'add');
$quotation_canView = BasicPermission::model()->checkModules('lbQuotation', 'view');

//Permission Bills
$bill_canAdd = BasicPermission::model()->checkModules('lbVendor', 'add');
$bill_canView = BasicPermission::model()->checkModules('lbVendor', 'view');

//Permission Report
$report_canView = BasicPermission::model()->checkModules('lbReport', 'view');

 $home_img = CHtml::image(Yii::app()->request->baseUrl . '/images/logo_home.png', '',
                            array(
                                            'height' => 30,
                                            'width' => 30,
                                            'style' => "margin-top:-5px",
                                        
                                ));

?>
<div class="container" id="page">

<div id="lb-top-menu">
			<?php
                        $ownCompany = LbCustomer::model()->getOwnCompany();
			$this->widget('bootstrap.widgets.TbNavbar', array(
                                        'brand'=>false,
					'brandUrl'=> isset(Yii::app()->user)? LbInvoice::model()->getActionURL('dashboard'):Yii::app()->createUrl('site/login'),
					'items'=>array(
							array(
									'class'=>'bootstrap.widgets.TbMenu',
									'items'=>array(
											
									),
							),
							array(
									'class'=>'bootstrap.widgets.TbMenu',
									'encodeLabel'=>false,
									'htmlOptions'=>array('class'=>'pull-left'),
									'items'=>array(
                                                                                        array('label'=>$home_img,
                                                                                                'url'=>LbInvoice::model()->getActionURL('dashboard'),
                                                                                              
                                                                                            ),
											array('label'=>Yii::t('lang','Customers'),
													//'url'=> array('project/index'),
													'url'=> LbCustomer::model()->getAdminURL(),
													'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbCustomer'),
                                                                                                        'items'=>array(
                                                                                                            array('label'=>Yii::t('lang','<i class="icon-plus"></i> New Customer'),
                                                                                                                    'url'=>LbCustomer::model()->getCreateURL(),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $customer_canAdd,
                                                                                                                    ),
                                                                                                            '---',
                                                                                                            array('label'=>Yii::t('lang','All Customers'),
                                                                                                                    'url'=>LbCustomer::model()->getAdminURL(),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $customer_canView,
                                                                                                                   ),
                                                                                                            array('label'=>Yii::t('lang','Contracts'),
                                                                                                                    'url'=>LbContracts::model()->getActionURL('dashboard'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $customer_canView,
                                                                                                                   ),
                                                                                                            array('label'=>Yii::t('lang','My Company'),
                                                                                                                    'url'=>  LbCustomer::model()->getActionURLNormalized('view',array('id'=>$ownCompany->lb_record_primary_key)),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $customer_canView,
                                                                                                                ),
                                                                                                        )
                                                                                            ),
											array('label'=>Yii::t('lang','Income'),
													'url'=> LbInvoice::model()->getActionURL('dashboard'),
//                                                                                                        'linkOptions' => array('href'=> LbInvoice::model()->getActionURL('dashboard'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
													'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbInvoice'),
                                                                                                        'items'=>array(
                                                                                                            array('label'=>Yii::t('lang','<i class="icon-plus"></i> New Invoice'),
                                                                                                                    'url'=>LbInvoice::model()->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))),
                                                                                                                    'visible' => $invoice_canAdd,
                                                                                                                    ),
                                                                                                            array('label'=>Yii::t('lang','<i class="icon-plus"></i> New Quotation'),
                                                                                                                    
                                                                                                                    'url'=>LbQuotation::model()->getCreateURLNormalized(),
                                                                                                                    'visible' => $quotation_canAdd,
                                                                                                                ),
                                                                                                            array('label'=>Yii::t('lang','<i class="icon-plus"></i> Enter Payment'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'url'=>LbPayment::model()->getCreateURLNormalized(),
                                                                                                                    'visible' => $quotation_canAdd,
                                                                                                                ),
                                                                                                            '---',
                                                                                                            array('label'=>Yii::t('lang','Outstanding Invoices and Quotations'),
                                                                                                                    'linkOptions' => array('href'=> LbInvoice::model()->getActionURL('dashboard'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'url'=>LbInvoice::model()->getActionURL('dashboard'),
                                                                                                                    'visible' => $invoice_canView,
                                                                                                                   ),
                                                                                                            array('label'=>Yii::t('lang','All Invoices'),
                                                                                                                    'linkOptions' => array('href'=> LbInvoice::model()->getActionURL('admin'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'url'=>LbInvoice::model()->getActionURL('admin'),
                                                                                                                    'visible' => $invoice_canView,
                                                                                                                   ),
                                                                                                            array('label'=>Yii::t('lang','All Quotations'),
                                                                                                                    'linkOptions' => array('href'=> LbQuotation::model()->getActionURL('admin'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'url'=>LbQuotation::model()->getActionURL('admin'),
                                                                                                                    'visible' => $quotation_canView,
                                                                                                                   ),
                                                                                                        )
                                                                                            ),/**
											array('label'=>Yii::t('lang','Contracts'),
													'url'=> LbContracts::model()->getActionURL('dashboard'),
													'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
													'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbContract')),**/
                                                                                        array('label'=>Yii::t('lang','Expenses'),
//													'url'=> LbExpenses::model()->getActionURL('expenses'),
//													'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
//													'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbExpenses'),
                                                                                                        'items'=>array(
                                                                                                            array('label'=>Yii::t('lang','All Expenses'),
                                                                                                                    'linkOptions' => array('href'=> LbExpenses::model()->getActionURL('expenses'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'url'=>LbExpenses::model()->getActionURL('expenses'),
                                                                                                                    'visible' => $expenses_canView,
                                                                                                                   ),
                                                                                                            array('label'=>Yii::t('lang','All Payment voucher'),
                                                                                                                    'linkOptions' => array('href'=> LbExpenses::model()->getActionURL('paymentVoucher'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'url'=>  LbExpenses::model()->getActionURL('paymentVoucher'),
                                                                                                                    'visible' => $expenses_canView,
                                                                                                                   ),
//                                                                                                            array('label'=>Yii::t('lang','New Expense'),
//                                                                                                                    'linkOptions' => array('href'=> LbExpenses::model()->getActionURL('create'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
//                                                                                                                    'url'=>  LbExpenses::model()->getActionURL('create'),
//                                                                                                                    'visible' => $expenses_canAdd,
//                                                                                                                   ),
//                                                                                                            array('label'=>Yii::t('lang','New Payment Voucher'),
//                                                                                                                    'linkOptions' => array('href'=> LbExpenses::model()->getActionURL('CreatePaymentVoucher'),'data-workspace' => '1', 'live' => false),
//                                                                                                                    'url'=>  LbExpenses::model()->getActionURL('CreatePaymentVoucher'),
//                                                                                                                    'visible' => $expenses_canAdd,
//                                                                                                                   ),
                                                                                                           
                                                                                                        )
                                                                                        ),
                                                                                        array('label'=>Yii::t('lang','Bills'),
													'url'=> LbVendor::model()->getActionURL('dashboard'),
													'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
													'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbVendor'),
                                                                                                        'items'=>array(
                                                                                                            array('label'=>Yii::t('lang','Outstanding'),
                                                                                                                    'url'=>LbVendor::model()->getActionURL('dashboard'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $bill_canView,
                                                                                                                   ),
                                                                                                            array('label'=>Yii::t('lang','Make Payment'),
                                                                                                                    'url'=>LbVendor::model()->getActionModuleURL('vendor', 'addPayment'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $bill_canAdd,
                                                                                                                    ),
                                                                                                           )
                                                                                            ),
                                                                             array('label'=>Yii::t('lang','Payroll'),
													'url'=> LbEmployee::model()->getActionURL('dashboard'),
													'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
													'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbVendor'),
                                                                                                        'items'=>array(
                                                                                                            array('label'=>Yii::t('lang','All Employees'),
                                                                                                                    'url'=>LbEmployee::model()->getActionURL('dashboard'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $bill_canView,
                                                                                                                   ),
                                                                                                            array('label'=>Yii::t('lang','Make Payment'),
                                                                                                                    'url'=>  LbEmployee::model()->getActionURL('EnterPayment'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $bill_canAdd,
                                                                                                                    ),
                                                                                                            array('label'=>Yii::t('lang','All Payment'),
                                                                                                                    'url'=>LbEmployee::model()->getActionURL('ListPayment'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $bill_canView,
                                                                                                                   ),
                                                                                                           )
                                                                                            ),
                                                                                        array('label'=>Yii::t('lang','Report'),
													'url'=> array('/lbReport/default/index'),
													'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                        'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbReport'),
                                                                                                        'items'=>array(
                                                                                                            array('label'=>Yii::t('lang','All'),
                                                                                                                    'url'=>array('/lbReport/default/index?tab=all'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $report_canView,
                                                                                                                   ),
                                                                                                            array('label'=>Yii::t('lang','Aging Report'),
                                                                                                                    'url'=>array('/lbReport/default/index?tab=aging_report'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $report_canView,
                                                                                                                    ),
                                                                                                            array('label'=>Yii::t('lang','Cash Receipt'),
                                                                                                                    'url'=>array('/lbReport/default/index?tab=cash_receipt'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $report_canView,
                                                                                                                   ),
                                                                                                            array('label'=>Yii::t('lang','Invoice Journal'),
                                                                                                                    'url'=>array('/lbReport/default/index?tab=invoice_journal'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $report_canView,
                                                                                                                    ),
                                                                                                            array('label'=>Yii::t('lang','GST Report'),
                                                                                                                    'url'=>array('/lbReport/default/index?tab=gst_report'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $report_canView,
                                                                                                                   ),
                                                                                                            array('label'=>Yii::t('lang','Sales Report'),
                                                                                                                    'url'=>array('/lbReport/default/index?tab=sales_report'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $report_canView,
                                                                                                                    ),
                                                                                                            array('label'=>Yii::t('lang','Customer Statement'),
                                                                                                                    'url'=>array('/lbReport/default/index?tab=customer_statement'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $report_canView,
                                                                                                                    ),
                                                                                                            array('label'=>Yii::t('lang','Employee Report'),
                                                                                                                    'url'=>array('/lbReport/default/index?tab=employee_report'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $report_canView,
                                                                                                                    ),
                                                                                                            array('label'=>Yii::t('lang','Payment Report'),
                                                                                                                    'url'=>array('/lbReport/default/index?tab=payment_report'),
                                                                                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                                                                                    'visible' => $report_canView,
                                                                                                                    ),
                                                                                                           )
                                                                                                        ),
									),
							),
							
					),
					'htmlOptions' => array('class' => 'navbar'),
			));
			
			?>
		</div>
    
<div id="lb-top-shortcuts">
        <?php
            $onwSubcriptAccount = AccountSubscription::model()->getSubscriptionOwnerID(LBApplication::getCurrentlySelectedSubscription());
            $onwSubcrip = false;
            if($onwSubcriptAccount==Yii::app()->user->id)
                $onwSubcrip=true;
            $linx_app_menu_subscription_items = array();
            $selected_subscription_label = 'Subscription';
            if (!Yii::app()->user->isGuest)
            {
                    $linx_app_account_subscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id);

                    foreach ($linx_app_account_subscriptions as $sub_id=>$subscription)
                    {
                            $label = $subscription;
                            if (isset(Yii::app()->user->linx_app_selected_subscription)
                                            && $sub_id == Yii::app()->user->linx_app_selected_subscription)
                            {
                                    $selected_subscription_label = $label;
                                    $label .= ' <i class="icon-ok"></i>';
                            }

                            $linx_app_menu_subscription_items[] = array('label'=>$label, 
                                            'url'=>array('/site/subscription', 'id' => $sub_id), 
                                            'visible' => !Yii::app()->user->isGuest);
                    }
                    $linx_app_menu_subscription_items[]='---';
                    $linx_app_menu_subscription_items[] =   array('label'=>'<i class="icon-plus"></i> '.Yii::t('lang','Add Subscription'),
                                                                'url'=>array('/accountSubscription/create'),
                                                                'visible'=>$onwSubcrip);
                    $linx_app_menu_subscription_items[] =   array('label'=>'<i class="icon-plus"></i> '.Yii::t('lang','Manager Subscription'),
                                                                'url'=>array('/accountSubscription/admin'),
                                                                'visible'=>$onwSubcrip);
            }
            if(isset($_SESSION['sess_lang']) && $_SESSION['sess_lang']== 'vi')
            {
                $select_vn = ' <i class="icon-ok"></i>';
                $select_en ="";
            }
            else
            {
                $select_en = ' <i class="icon-ok"></i>';
                $select_vn ="";
            }
            
            $ulr_img = CHtml::image(AccountProfile::model()->getProfilePhotoURL(Yii::app()->user->id), '',
                            array(
                                            'height' => 30,
                                            'width' => 30,
                                            'style' => "margin-right: 5px; height: 30px; border-radius:15px; width: 30px; "));

            $this->widget('bootstrap.widgets.TbNavbar', array(
                    //'type'=>'inverse', // null or 'inverse'
                    'brand'=>false,
                    //'brandUrl'=> Yii::app()->baseUrl . '/index.php',
                    'collapse'=>true, // requires bootstrap-responsive.css
                    'items'=>array(
                                    array(
                                                    'class'=>'bootstrap.widgets.TbMenu',
                                                    'items'=>array(

                                                    ),
                                    ),
                                    array(
                                                    'class'=>'bootstrap.widgets.TbMenu',
                                                    'encodeLabel'=>false,
                                                    'htmlOptions'=>array('class'=>'pull-right'),
                                                    'items'=>array(
                                                                    array('label'=> $ulr_img.Yii::t('lang',isset(Yii::app()->user->account_profile_short_name) ? Yii::app()->user->account_profile_short_name: 'Actions'), 
                                                                                    'url'=>'#', 
                                                                                    'items'=>array(
                                                                                                array('label'=> '<span>Company</span>',
                                                                                                                'url'=>'#',
                                                                                                                //'linkOptions'=>array('id'=>''),
                                                                                                                'items'=>$linx_app_menu_subscription_items,
                                                                                                                'visible' => !Yii::app()->user->isGuest),
                                                                                                array('label'=>Yii::t('lang','Configuration'),
                                                                                                        'url'=>array('/'.LBApplication::getCurrentlySelectedSubscription().'/configuration'),
                                                                                                        'visible'=>$onwSubcrip),
                                                                                                array('label'=>Yii::t('lang','My Account'), 'url'=>array('/account/view/' . Yii::app()->user->id), 'visible' => !Yii::app()->user->isGuest),
                                                                                                array('label'=>Yii::t('lang','My Team'), 
                                                                                                        'url'=> array('/'.LBApplication::getCurrentlySelectedSubscription().'/team'),
                                                                                                        'visible' => !Yii::app()->user->isGuest),
                                                                                                array('label'=> 'Language',
                                                                                                        'url'=>'#',
                                                                                                        'items'=>array(
                                                                                                            array('label'=>'English'.$select_en,'url'=>array('/site/languares','typelang'=>'en')),
                                                                                                            array('label'=>'Tiếng việt'.$select_vn,'url'=>array('/site/languares','typelang'=>'vi')),
                                                                                                        )),
                                                                                                array('label'=>Yii::t('lang','Contact'), 'url'=>array('/site/contact')),
                                                                                                array('label'=>Yii::t('lang','Logout').'('.Yii::app()->user->name.')', 
                                                                                                        'url'=> array('/'.LBApplication::getCurrentlySelectedSubscription().'/logout'),
                                                                                                        'visible'=>!Yii::app()->user->isGuest)
                                                                                    ), 
                                                                                    'visible' => !Yii::app()->user->isGuest),
                                                                    array('label'=>"<i class=\"icon-user\"></i> ".Yii::t('lang','Login'), 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                                                    ),
                                    ),

                    ),
                    'htmlOptions' => array('class' => 'navbar'),
                ));
            ?>
    </div>
		
	
	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?>, LinxBooks. All Rights Reserved.  LinxHQ Pte Ltd<br/>
	</div><!-- footer -->
	<div id="contactable"></div>
</div><!-- page -->
<script language="javascript">
$(document).ready(function(){
	$('#contactable').contactable({
	    subject: 'I need help',
		url: '<?php echo Yii::app()->createUrl('site/contact'); ?>',
		name: 'Name',
		email: 'Email',
		dropdownTitle: 'Topic',
		dropdownOptions: ['General', 'Bug Report', 'Feature Request'],
		message: 'Message',
		submit: 'Send',
	});

	$("#linx-menu-item-selected-subscription").html(
			'<?php echo LBApplication::getShortName($selected_subscription_label, false, 10); ?>');
                

        // very simple to use!
        $('.dropdown-toggle').dropdownHover().dropdown();

});
</script>
</body>
</html>
