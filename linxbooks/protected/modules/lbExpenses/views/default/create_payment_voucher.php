<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;"><h4>Expenses</h4></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbExpenses::model()->getActionURLNormalized('paymentVoucher'));
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
            echo '&nbsp;';
            if($id)
            {
                $this->widget('bootstrap.widgets.TbButton', array(
                                 'label'=>'Print PDF',
                                 'htmlOptions'=> array('onclick' => 'print_PDF_PV()'),
                             ));
            }
            echo '</div>';
echo '</div><br>';

   
echo '<div class = "header" style="margin-bottom:10px">';

if($id)
{
    

    echo '<div style="overflow:hidden; border-top: 1px solid #fff;margin-top: 5px; padding-bottom:5px;margin-bottom:5px;">';
    echo '</div>';
}
else
{
        echo '<span style="font-size:16px;"><b>New Payment Voucher</b></span>';
}       
echo '</div>';
$this->renderPartial('_form_pv', array(
		'model'=>$model,
    'modelPV'=>$modelPv)); 

$this->renderPartial('_form_line_expenses', array(
		'model'=>$model,
    'modelPV'=>$modelPv));

?>
<script type="text/javascript">
    function print_PDF_PV() {
        var id = <?php echo $id ?>;
       window.open('<?php echo LbExpenses::model()->getActionURLNormalized("PrintPdfPV",array('id'=>$id)) ?>','_target');
        
    }
</script>