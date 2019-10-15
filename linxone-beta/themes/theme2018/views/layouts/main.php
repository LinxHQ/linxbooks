
    <?php /* @var $this Controller */ ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css_theme2018/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css_theme2018/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css_theme2018/mixins.less">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css_theme2018/datepicker.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/highlight/styles/default.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css_theme2018/jquery.bootstrap.treeselect.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css_theme2018/jquery.datetimepicker.css">
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.datetimepicker.full.min.js"></script>
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
    <script src="<?php echo Yii::App()->baseUrl; ?>/js/jquery.bootstrap.treeselect.js"></script>

    <script src="<?php echo Yii::App()->baseUrl; ?>/js/jquery.blockUI.js"></script>
    <script src="<?php echo Yii::App()->baseUrl; ?>/js/linxbooks.lbInvoice.js"></script>

    <?php //Yii::app()->editable->init(); ?>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/application.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <?php 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datepicker.js', CClientScript::POS_END);

    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css">
    <!-- <style type="text/css" media="screen">
        #yw10 .dropdown .dropdown-toggle .caret{
            display: none;
        }
    </style> -->
    </head>
    <body>
    <?php
    $modelCheckServer = new LbCheckServer();
    $checkServer = $modelCheckServer->checkServer();
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
    $home_img_church_one = CHtml::image(Yii::app()->request->baseUrl . '/images/logoT.png', '',
    array(
        'height' => 30,
        'width' => 100,
        'style' => "margin-top:-10px; background-color: white; padding: 8px;",
    ));
    $ownCompany = LbCustomer::model()->getOwnCompany();
#ITEM MENU#
    $menu_item = array();
    #CUSTOMER#
    $menu_item['Customers']['items']= array(
                                array('label'=>'<i class="icon-plus"></i>'.Yii::t('lang','New Customer'),
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
                                        'url'=>LbContracts::model()->getActionURL('admin'),
                                        'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                        'visible' => $customer_canView,
                                       ),
                                array('label'=>Yii::t('lang','My Company'),
                                        'url'=>  LbCustomer::model()->getActionURLNormalized('view',array('id'=>$ownCompany->lb_record_primary_key)),
                                        'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                        'visible' => $customer_canView,
                                    ),
                            );
    
    #INVOICE#
    $menu_item['Invoices']['items']= array(
                                        array('label'=>'<i class="icon-plus"></i> '.Yii::t('lang','New Invoice'),
                                                'url'=>LbInvoice::model()->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))),
                                                'visible' => $invoice_canAdd,
                                                ),
                                        array('label'=>'<i class="icon-plus"></i> '.Yii::t('lang','New Quotation'),
                                                
                                                'url'=>LbQuotation::model()->getCreateURLNormalized(),
                                                'visible' => $quotation_canAdd,
                                            ),
                                        '---',
                                        array('label'=>Yii::t('lang','Outstanding'),
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
                                );
    #Contracts
    $menu_item['Contracts']['url']= LbInvoice::model()->getActionURL('dashboard');
    
    #Expenses
    $menu_item['Expenses']['url']= LbInvoice::model()->getActionURL('dashboard');
    $menu_item['Expenses']['items']= array(
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
                                    );
    #Vendor
    $menu_item['Vendor']['url']= LbInvoice::model()->getActionURL('dashboard');
    $menu_item['Vendor']['items']= array(
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
                                       );
    
    #Opportunities
    $menu_item['Opportunities']['url']= LbInvoice::model()->getActionURL('dashboard');
    $menu_item['Opportunities']['items']=array(
                                                array('label'=>Yii::t('lang','Board'),
                                                    'url'=>array('/lbOpportunities/default/board?tab=board'),
                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                    'visible' => $report_canView,
                                                ),
                                                array('label'=>Yii::t('lang','List'),
                                                    'url'=>array('/lbOpportunities/default/list?tab=list'),
                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                    'visible' => $report_canView,
                                                ),
                                        );
    
    #Leave
    $menu_item['Leave']['url']= array('/lbLeave/default/index');
    
    #Reports
    $menu_item['Reports']['url']= LbInvoice::model()->getActionURL('dashboard');
    $menu_item['Reports']['items']= array(
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
                                                'visible' => $report_canView && !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbVendor'),
                                                ),
                                        array('label'=>Yii::t('lang','Payment Report'),
                                                'url'=>array('/lbReport/default/index?tab=payment_report'),
                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                                                'visible' => $report_canView,
                                                ),
                                    );
    
    #Employee
    $menu_item['Employee']['url']= LbInvoice::model()->getActionURL('dashboard');
    $menu_item['Employee']['items']= array(
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
                                       );
        # Departments
        // $menu_item['Departments']['items']= array(
        //         array('label'=>Yii::t('lang','Departments Manage'),
        //             'url'=>array('/lbDepartments/default/departmentsManager'),
        //             'visible' => $report_canView,
        //         ),
        // );
        $menu_item['Departments']['url']= array('/lbDepartments/default/departmentsManager');

        # Talent
        // $menu_item['Talent']['items']= array(
        //         array('label'=>Yii::t('lang','Training Need'),
        //             'url'=>array('/lbTalent/default/index'),
        //             'visible' => $report_canView,
        //         ),
        // );
        $menu_item['Talent']['url']= array('/lbTalent/default/index');
        $menu_item['People']['url']= array('/lbPeople/default/index');
        $menu_item['Smallgroups']['url']= array('/lbSmallgroups/smallgroups/admin');
        $menu_item['Events']['url']= array('/lbEvents/default/index');
        $menu_item['Volunteers']['url']= array('/lbVolunteers/peoplevolunteers/admin');
        $menu_item['Pastoralcare']['url']= array('/lbPastoralcare/pastoralcare/admin');
        
        # Project
        $menu_item['Project']['url']= array('/lbProject/default/index');

        
        
        #Leave
        $menu_item['Product Catalog']['items']= array(
                array('label'=>Yii::t('lang','Products'),
                        'url'=> LbCatalogProducts::model()->getActionURL('product/index'),
                        'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                       ),
                array('label'=>Yii::t('lang','Categories'),
                        'url'=> LbCatalogCategories::model()->getActionURL('category/admin'),
                        'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
                        ),
        )
#END ITEM MENU#

    ?>
    <div class="container" id="page">

    <?php 
        if($checkServer == 'church-one') {
            echo '<div id="lb-top-nav-container-church-one">';
        } else if($checkServer == "linxone"){
            echo '<div id="lb-top-nav-container">';
        }
    ?>
        <div id="lb-top-menu">
        <?php
        $module_data = Modules::model()->getModules(1);
        if($checkServer == 'church-one') {
            $menu_module[0] = array(
                'label'=>$home_img_church_one,
                // 'label'=>"<p><i class='icon icon-home'></i></p>",
                'url'=>array("site/dashboardchurchone"), 
            );
        } else if($checkServer == "linxone"){
            $menu_module[0] = array(
                // 'label'=>$home_img,
                'label'=>"<p><i class='icon icon-home'></i></p>",
                'url'=>array(AccountRoles::model()->getModuleHomeRole(Yii::app()->user->id)),
            );
        }
        
        $menu_module_hide = array();
        $i=1;$j=0;$num_mod = 6;$lable_menu="";
        foreach ($module_data as $item) {
            $lable_menu = ucwords(strtolower($item->module_text));
            if($i<=$num_mod){
                $menu_module[$i]['label'] = Yii::t('lang',$lable_menu);
                $menu_module[$i]['linkOptions'] = array('data-workspace' => '1', 'id' => uniqid(), 'live' => false);
                $menu_module[$i]['url'] = '#';
                if(isset($menu_item[$item->module_name]['url']))
                    $menu_module[$i]['url'] = $menu_item[$item->module_name]['url'];
                $menu_module[$i]['visible'] = !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule($item->module_directory);
                if(isset($menu_item[$item->module_name]['items']))
                    $menu_module[$i]['items'] = $menu_item[$item->module_name]['items'];
            }else
            {
                $menu_module_hide[$j]['label'] = Yii::t('lang',$lable_menu);;
                $menu_module_hide[$j]['linkOptions'] = array('data-workspace' => '1', 'id' => uniqid(), 'live' => false);
                $menu_module_hide[$j]['url'] = '#';
                if(isset($menu_item[$item->module_name]['url']))
                    $menu_module_hide[$j]['url'] = $menu_item[$item->module_name]['url'];
                $menu_module_hide[$j]['visible'] = !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule($item->module_directory);
                if(isset($menu_item[$item->module_name]['items']))
                    $menu_module_hide[$j]['items'] = $menu_item[$item->module_name]['items'];
                $menu_module_hide[$j+1]='---';
                $j=$j+2;
            }
            $i++;
        }
        if(count($menu_module_hide)>0){
            $menu_module[$num_mod+1]['label']='...';
            $menu_module[$num_mod+1]['url']='#';
            $menu_module[$num_mod+1]['linkOptions'] = array('data-workspace' => '1', 'id' => uniqid(), 'live' => false);
            $menu_module[$num_mod+1]['items']=$menu_module_hide;
        }
        
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
        'items'=>$menu_module,
    //    'items'=>array(
    //                    array('label'=>$home_img,
    //                            'url'=>array(AccountRoles::model()->getModuleHomeRole(Yii::app()->user->id)),
    //                          
    //                        ),
    //    array('label'=>Yii::t('lang','Customers'),
    //    'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbCustomer'),
    //                                    'items'=>array(
    //                                        array('label'=>'<i class="icon-plus"></i>'.Yii::t('lang','New Customer'),
    //                                                'url'=>LbCustomer::model()->getCreateURL(),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $customer_canAdd,
    //                                                ),
    //                                        '---',
    //                                        array('label'=>Yii::t('lang','All Customers'),
    //                                                'url'=>LbCustomer::model()->getAdminURL(),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $customer_canView,
    //                                               ),
    //                                        array('label'=>Yii::t('lang','Contracts'),
    //                                                'url'=>LbContracts::model()->getActionURL('admin'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $customer_canView,
    //                                               ),
    //                                        array('label'=>Yii::t('lang','My Company'),
    //                                                'url'=>  LbCustomer::model()->getActionURLNormalized('view',array('id'=>$ownCompany->lb_record_primary_key)),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $customer_canView,
    //                                            ),
    //                                    )
    //                        ),
    //    array('label'=>Yii::t('lang','Income'),
    //    'url'=> LbInvoice::model()->getActionURL('dashboard'),
    //    //                                                                                                        'linkOptions' => array('href'=> LbInvoice::model()->getActionURL('dashboard'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //    'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbInvoice'),
    //                                    'items'=>array(
    //                                        array('label'=>'<i class="icon-plus"></i> '.Yii::t('lang','New Invoice'),
    //                                                'url'=>LbInvoice::model()->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))),
    //                                                'visible' => $invoice_canAdd,
    //                                                ),
    //                                        array('label'=>'<i class="icon-plus"></i> '.Yii::t('lang','New Quotation'),
    //                                                
    //                                                'url'=>LbQuotation::model()->getCreateURLNormalized(),
    //                                                'visible' => $quotation_canAdd,
    //                                            ),
    //                                        /**array('label'=>Yii::t('lang','<i class="icon-plus"></i> Enter Payment'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'url'=>LbPayment::model()->getCreateURLNormalized(),
    //                                                'visible' => $quotation_canAdd,
    //                                            ),**/
    //                                        '---',
    //                                        array('label'=>Yii::t('lang','Outstanding'),
    //                                                'linkOptions' => array('href'=> LbInvoice::model()->getActionURL('dashboard'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'url'=>LbInvoice::model()->getActionURL('dashboard'),
    //                                                'visible' => $invoice_canView,
    //                                               ),
    //                                        array('label'=>Yii::t('lang','All Invoices'),
    //                                                'linkOptions' => array('href'=> LbInvoice::model()->getActionURL('admin'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'url'=>LbInvoice::model()->getActionURL('admin'),
    //                                                'visible' => $invoice_canView,
    //                                               ),
    //                                        array('label'=>Yii::t('lang','All Quotations'),
    //                                                'linkOptions' => array('href'=> LbQuotation::model()->getActionURL('admin'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'url'=>LbQuotation::model()->getActionURL('admin'),
    //                                                'visible' => $quotation_canView,
    //                                               ),
    //                                    )
    //                        ),/**
    //    array('label'=>Yii::t('lang','Contracts'),
    //    'url'=> LbContracts::model()->getActionURL('dashboard'),
    //    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //    'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbContract')),**/
    //                    array('label'=>Yii::t('lang','Expenses'),
    //    //                                                    'url'=> LbExpenses::model()->getActionURL('expenses'),
    //    //                                                    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //    //                                                    'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbExpenses'),
    //                                    'items'=>array(
    //                                        array('label'=>Yii::t('lang','All Expenses'),
    //                                                'linkOptions' => array('href'=> LbExpenses::model()->getActionURL('expenses'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'url'=>LbExpenses::model()->getActionURL('expenses'),
    //                                                'visible' => $expenses_canView,
    //                                               ),
    //                                        array('label'=>Yii::t('lang','All Payment voucher'),
    //                                                'linkOptions' => array('href'=> LbExpenses::model()->getActionURL('paymentVoucher'),'data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'url'=>  LbExpenses::model()->getActionURL('paymentVoucher'),
    //                                                'visible' => $expenses_canView,
    //                                               ),
    //                                    )
    //                    ),
    //                    array('label'=>Yii::t('lang','Bills'),
    //    'url'=> LbVendor::model()->getActionURL('dashboard'),
    //    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //    'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbVendor'),
    //                                    'items'=>array(
    //                                        array('label'=>Yii::t('lang','Outstanding'),
    //                                                'url'=>LbVendor::model()->getActionURL('dashboard'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $bill_canView,
    //                                               ),
    //                                        array('label'=>Yii::t('lang','Make Payment'),
    //                                                'url'=>LbVendor::model()->getActionModuleURL('vendor', 'addPayment'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $bill_canAdd,
    //                                                ),
    //                                       )
    //                        ),
    //         array('label'=>Yii::t('lang','Payroll'),
    //    'url'=> LbEmployee::model()->getActionURL('dashboard'),
    //    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //    'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbVendor'),
    //                                    'items'=>array(
    //                                        array('label'=>Yii::t('lang','All Employees'),
    //                                                'url'=>LbEmployee::model()->getActionURL('dashboard'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $bill_canView,
    //                                               ),
    //                                        array('label'=>Yii::t('lang','Make Payment'),
    //                                                'url'=>  LbEmployee::model()->getActionURL('EnterPayment'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $bill_canAdd,
    //                                                ),
    //                                        array('label'=>Yii::t('lang','All Payment'),
    //                                                'url'=>LbEmployee::model()->getActionURL('ListPayment'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $bill_canView,
    //                                               ),
    //                                       )
    //                        ),
    //    array('label'=>Yii::t('lang','Opportunities'),
    //    'url'=> array('/lbOpportunities/default/index'),
    //    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //    'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbOpportunities'),
    //    'items'=>array(
    //    array('label'=>Yii::t('lang','Board'),
    //    'url'=>array('/lbOpportunities/default/board?tab=board'),
    //    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //    'visible' => $report_canView,
    //    ),
    //    array('label'=>Yii::t('lang','List'),
    //    'url'=>array('/lbOpportunities/default/list?tab=list'),
    //    'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //    'visible' => $report_canView,
    //    ),
    //    )
    //    ),
    //          array(
    //                                        'label'=>Yii::t('lang','Leave'),
    //                                        'url'=>array('/lbLeave/default/index'),
    //                                        'visible' => Modules::model()->checkHiddenModule('lbLeave'),
    //
    //                                    ),
    //                    array('label'=>Yii::t('lang','Report'),
    //    //'url'=> array('/lbReport/default/index'),
    //    //'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                    'visible' => !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbReport'),
    //                                    'items'=>array(
    //                                        /**array('label'=>Yii::t('lang','All'),
    //                                                'url'=>array('/lbReport/default/index?tab=all'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $report_canView,
    //                                               ),**/
    //                                        array('label'=>Yii::t('lang','Aging Report'),
    //                                                'url'=>array('/lbReport/default/index?tab=aging_report'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $report_canView,
    //                                                ),
    //                                        array('label'=>Yii::t('lang','Cash Receipt'),
    //                                                'url'=>array('/lbReport/default/index?tab=cash_receipt'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $report_canView,
    //                                               ),
    //                                        array('label'=>Yii::t('lang','Invoice Journal'),
    //                                                'url'=>array('/lbReport/default/index?tab=invoice_journal'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $report_canView,
    //                                                ),
    //                                        array('label'=>Yii::t('lang','GST Report'),
    //                                                'url'=>array('/lbReport/default/index?tab=gst_report'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $report_canView,
    //                                               ),
    //                                        array('label'=>Yii::t('lang','Sales Report'),
    //                                                'url'=>array('/lbReport/default/index?tab=sales_report'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $report_canView,
    //                                                ),
    //                                        array('label'=>Yii::t('lang','Customer Statement'),
    //                                                'url'=>array('/lbReport/default/index?tab=customer_statement'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $report_canView,
    //                                                ),
    //                                        array('label'=>Yii::t('lang','Employee Report'),
    //                                                'url'=>array('/lbReport/default/index?tab=employee_report'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $report_canView && !Yii::app()->user->isGuest && Modules::model()->checkHiddenModule('lbVendor'),
    //                                                ),
    //                                        array('label'=>Yii::t('lang','Payment Report'),
    //                                                'url'=>array('/lbReport/default/index?tab=payment_report'),
    //                                                'linkOptions' => array('data-workspace' => '1', 'id' => uniqid(), 'live' => false),
    //                                                'visible' => $report_canView,
    //                                                ),
    //                                       )
    //                                    ),
    //),
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
        $selected_subscription_label = "<i class='icon-briefcase'></i>";
        $label .= ' <i class="icon-ok"></i>';
        }

        $linx_app_menu_subscription_items[] = array('label'=>$label, 
        'url'=>array('/site/subscription', 'id' => $sub_id), 
        'visible' => !Yii::app()->user->isGuest);
        }
        $linx_app_menu_subscription_items[]='---';
        $linx_app_menu_subscription_items[] =   array('label'=>'<i class="icon-plus"></i> '.Yii::t('lang','Add Company'),
        'url'=>array('/accountSubscription/create'),
        'visible'=>$onwSubcrip);
        $linx_app_menu_subscription_items[] =   array('label'=>'<i class="icon-plus"></i> '.Yii::t('lang','Manage Companies'),
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
        'height' => 25,
        'width' => 25,
        'style' => "margin-right: 5px; height: 25px; border-radius:12px; width: 25px; "));

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
        array(
          'label' => "<i class='icon icon-envelope'></i>",
          'url' => '#',
        ),
        array(
          'label' => $selected_subscription_label,
          'url' => '#',
          'items' => $linx_app_menu_subscription_items,
            'visible' => !Yii::app()->user->isGuest
        ),
            array('label'=> $ulr_img, 
                    'url'=>'#', 
                    'items'=>array(
                                /**array('label'=> '<span>Company</span>',
                                                'url'=>'#',
                                                //'linkOptions'=>array('id'=>''),
                                                'items'=>$linx_app_menu_subscription_items,
                                                'visible' => !Yii::app()->user->isGuest),**/
                                array('label'=>Yii::t('lang','Configuration'),
                                        'url'=>array('/'.LBApplication::getCurrentlySelectedSubscription().'/configuration'),
                                        'visible'=>$onwSubcrip),
                                array('label'=>Yii::t('lang','My Account'), 'url'=>array('/account/view/' . Yii::app()->user->id), 'visible' => !Yii::app()->user->isGuest),
                                array('label'=>Yii::t('lang','My Team'), 
                                        'url'=> array('/'.LBApplication::getCurrentlySelectedSubscription().'/team'),
                                        'visible' => !Yii::app()->user->isGuest),
                                array('label'=> 'Language',
                                        'url'=>'#',
                        'visible' => !Yii::app()->params['isDemoApp'],
                                        'items'=>array(
                                            array('label'=>'English'.$select_en,'url'=>array('/site/languares','typelang'=>'en')),
                                            array('label'=>'Tiếng việt'.$select_vn,'url'=>array('/site/languares','typelang'=>'vi', 'visible' => !Yii::app()->params['isDemoApp'])),
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
    </div>


    <?php echo $content; ?>

    <div id="footer">
    Copyright &copy; <?php echo date('Y'); ?>, LinxBooks. All Rights Reserved.  LinxHQ Pte Ltd<br/>
    </div><!-- footer -->

    </div><!-- page -->
    <script language="javascript">
    $(document).ready(function(){

            $("#linx-menu-item-selected-subscription").html(
                '<?php echo LBApplication::getShortName($selected_subscription_label, false, 10); ?>');
            // very simple to use!
            $('.dropdown-toggle').dropdownHover().dropdown();
    });
    </script>
    </body>
    </html>
