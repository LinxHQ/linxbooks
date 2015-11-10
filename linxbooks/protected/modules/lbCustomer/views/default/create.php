<?php
/* @var $this LbCustomerController */
/* @var $model LbCustomer */
/* @var $addressModel LbCustomerAddress */
/* @var $contactModel LbCustomerContact */
//$this->renderPartial('//layouts/lang');
?>
<?php
    echo '<div id="lb-container-header">';
                echo '<div class="lb-header-right" style="margin-left:-11px" ><h4>'.Yii::t('lang','Customers').'</h4></div>';
                echo '<div class="lb-header-left">';
                    LBApplicationUI::backButton($model->getHomeURLNormalized());
                echo '</div>';
    echo '</div>';
?>
<div style="width:30%;margin-top:19px;margin-bottom:11px;"><span style="font-size: 16px;"><b><?php echo Yii::t('lang','New Customers'); ?></b></span></div>
<div style="clear: both">
<?php $this->renderPartial('_form', 
		array('model'=>$model,
				'addressModel'=>$addressModel,
				'contactModel'=>$contactModel,
                                'own'=>$own,
        ));
    ?>
</div>