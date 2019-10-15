<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lb-catalog-products-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data',
            'class'=>'form-horizontal MultiFile-intercepted'),
)); ?>
<?php
    echo '<div id="lb-container-header">';
                echo '<div class="lb-header-right" style="margin-left:-11px;" ><h3>'
                        . '<a href="'. LbCatalogProducts::model()->getActionURLNormalized("product/index") . '"><i class="icon-arrow-left icon-white" style="margin-top: 7px;"></i></a>  '
                        .Yii::t('lang','Create Product').'</h3></div>';
//                echo '<div class="lb_customer_header_left">&nbsp;';
//                echo '<i class="icon-plus icon-white" style="margin-top: -10px;"></i>  ';
//                    echo'<input type="search" onKeyup="" id="" value="" class="lb_input_search" value="" placeholder="Search" />';
//                echo '</div>';
    echo '</div>';
    ?>
    <div style="margin-top: 0px; width: 100%">&nbsp;</div>
    <div style="float: right; width: 100%; text-align: right">
            <a data-workspace="1" class="btn" href="<?php echo LbCatalogProducts::model()->getActionURLNormalized('product/index');?>">
                <i class="icon-arrow-left"></i>&nbsp;<?php echo Yii::t('lang','Back');?></a>
                <button onclick="" 
                        style="margin-left: auto; margin-right: auto" 
                        class="btn btn-success" type="reset" name="yt0">
                    <i class="icon-refresh icon-white"></i>&nbsp;<?php echo Yii::t('lang','Reset');?>
                </button>
                <button onclick="" 
                        style="margin-left: auto; margin-right: auto" 
                        class="btn btn-success" type="submit" name="yt0">
                    <i class="icon-ok icon-white"></i>&nbsp;<?php echo Yii::t('lang','Save');?>
                </button>
    </div>

    <?php $this->renderPartial('_form', array('model'=>$model,'form'=>$form,'images'=>array()));  ?>
<?php $this->endWidget(); ?>
</div>