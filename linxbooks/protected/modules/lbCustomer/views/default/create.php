<?php
/* @var $this LbCustomerController */
/* @var $model LbCustomer */
/* @var $addressModel LbCustomerAddress */
/* @var $contactModel LbCustomerContact */
//$this->renderPartial('//layouts/lang');
?>
<?php
    echo '<div id="lb-container-header">';
                echo '<div class="lb-header-right" ><h3>'.Yii::t('lang','Customers').'</h3></div>';
                echo '<div class="lb-header-left">';
                    LBApplicationUI::backButton($model->getHomeURLNormalized());
                echo '</div>';
    echo '</div>';
?>
<h3><?php echo Yii::t('lang','New Customers'); ?></h3>
<div style="clear: both">
<?php $this->renderPartial('_form', 
		array('model'=>$model,
				'addressModel'=>$addressModel,
				'contactModel'=>$contactModel,
                                'own'=>$own,
        ));
    ?>
</div>