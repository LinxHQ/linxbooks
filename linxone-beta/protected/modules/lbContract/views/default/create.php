<?php
/* @var $this LbContractsController */
/* @var $model LbContracts */
/* @var $model LbContractDocument */

$this->breadcrumbs=array(
	'Lb Contracts'=>array('index'),
	'Create',
);

echo '<div id="lb-container-header">';
            ?>
            <div class="lb-header-right" ><h3>
                <?php echo Yii::t('lang','Contracts'); ?> 
            </h3></div>
            

            <?php
            echo '<div class="lb-header-left" style="margin-top:-35px;">';
            LBApplicationUI::backButton(LbInvoice::model()->getActionURLNormalized("dashboard"));
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> '.Yii::t('lang','New Contract'), 'url'=>$this->createUrl('create') ),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div>';

?>

<h3><?php echo Yii::t('lang','New Contract'); ?></h3>

<?php $this->renderPartial('_form', array(
                                            'model'=>$model,
                                            'documentModel'=>$documentModel,
                                            'customer_id'=>$customer_id,
                                            'paymentModel'=>$paymentModel
                            )); ?>