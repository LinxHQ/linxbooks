<?php
/* @var $this DefaultController */
?>
<?php
$m = $this->module->id;
$canView = BasicPermission::model()->checkModules($m, 'view');
if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" ><h3>Expenses</h3></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbExpenses::model()->getAdminURLNormalized());
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> '.Yii::t('lang','New'), 'items'=>array(
                        array('label'=>Yii::t('lang','New Expenses'),'url'=>  LbExpenses::model()->getActionURLNormalized('create')),
                        array('label'=>Yii::t('lang','New Payment Voucher'),'url'=> LbExpenses::model()->getActionURLNormalized('createPaymentVoucher')),
                     )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div><br>';
?>

<?php

    $this->widget('bootstrap.widgets.TbTabs', array(
                    'type'=>'tabs', // 'tabs' or 'pills'
                    'encodeLabel'=>false,
                    'tabs'=> 
                    array(
                                array('id'=>'tab1','label'=>'<strong>'.Yii::t('lang','Expenses').'</strong>',
                                                    'content'=>LBApplication::renderPartial($this,'view_expenses',array(
                                                    'model'=>$model,
                                                    'modelPv'=>$modelPv  ),true),'active'=>true,
                                                ),
                                array('id'=>'tab2','label'=>'<strong>'.Yii::t('lang','Payment voucher').'</strong>', 
                                                'content'=> $this->renderPartial('view_payment_voucher', array(
                                                 'model'=>$model,
                                                    'modelPv'=>$modelPv      
                                                ),true),
                                                'active'=>false),
                                
                                 
                            ),
    ));
?>
