<?php
/* @var $this DefaultController */
?>
<?php // echo $model->lb_record_primary_key; 
$m = $this->module->id;
$canView = BasicPermission::model()->checkModules($m, 'view');
if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}
    
echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;"><h4>Report</h4></div>';
            echo '<div class="lb-header-left">';
                echo '&nbsp;';
            echo '</div>';
echo '</div><br>';
?>
<?php
    $tab = "all";
    if(isset($_GET['tab']))
        $tab = $_GET['tab'];
    $this->widget('bootstrap.widgets.TbTabs', array(
                    'type'=>'tabs', // 'tabs' or 'pills'
                    'encodeLabel'=>false,
                    'tabs'=> 
                    array(
                                array('id'=>'tab1','label'=>'<strong>'.Yii::t('lang','Aging Report').'</strong>',
                                                    'content'=>LBApplication::renderPartial($this,'_form_aging_report',array(
                                                    ),true),'active'=>($tab=="aging_report" || $tab=="all") ? true : false,
                                                ),
                                array('id'=>'tab2','label'=>'<strong>'.Yii::t('lang','Cash Receipt').'</strong>', 
                                                    'content'=> $this->renderPartial('_form_cash_receipt', array(      
                                                    ),true),'active'=>($tab=="cash_receipt") ? true : false,
                                                ),
                                array('id'=>'tab3','label'=>'<strong>'.Yii::t('lang','Invoice Journal').'</strong>', 
                                                'content'=> $this->renderPartial('_form_invoice_journal', array(
//                                                        'taxModel'=>$taxModel,
                                                ),true),
                                                'active'=>($tab=="invoice_journal") ? true : false),
                                array('id'=>'tab4','label'=>'<strong>'.Yii::t('lang','GST Report').'</strong>', 
                                                'content'=> $this->renderPartial('_form_gst_report', array(
                                                        
                                                ),true),
                                                'active'=>($tab=="gst_report") ? true : false),
                                array('id'=>'tab5','label'=>'<strong>'.Yii::t('lang','Sales Report').'</strong>', 
                                                'content'=> $this->renderPartial('_form_sale_report', array(
                                                        
                                                ),true),
                                                
                                                'active'=>($tab=="sales_report") ? true : false),
                                array('id'=>'tab6','label'=>'<strong>'.Yii::t('lang','Customer Statements').'</strong>', 
                                                'content'=> $this->renderPartial('_form_customer_statements', array(
                                                       
                                                ),true),
                                                'active'=>($tab=="customer_statement") ? true : false),
                                array('id'=>'tab7','label'=>'<strong>'.Yii::t('lang','Employee Report').'</strong>', 
                                                'content'=> $this->renderPartial('_form_employee_report', array(
                                                       
                                                ),true),
                                                'active'=>($tab=="employee_report") ? true : false),
                                array('id'=>'tab8','label'=>'<strong>'.Yii::t('lang','Payment Report').'</strong>', 
                                                'content'=> $this->renderPartial('_form_payment_report', array(
                                                       
                                                ),true),
                                                'active'=>($tab=="payment_report") ? true : false),
                                 
                            ),
    ));
?>
