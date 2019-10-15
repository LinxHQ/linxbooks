<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="form">
    <div style="clear: both; width: 100%"></div>
    <p class="text-danger"><?php echo $form->errorSummary($model); ?></p>
    
    <div class="tabbable tabs-left" style="margin-top: 20px;">
      <ul class="nav nav-tabs" style="width: 180px;">
          <li class="active"><a href="#product-general" data-toggle="tab"><?php echo Yii::t('lang','General');?>&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
           <li><a href="#product-prices" data-toggle="tab"><?php echo Yii::t('lang','Prices');?></a></li>
           <li><a href="#product-images" data-toggle="tab"><?php echo Yii::t('lang','Images');?></a></li>
           <li><a href="#product-inventory" data-toggle="tab"><?php echo Yii::t('lang','Inventory');?></a></li>
           <li><a href="#product-categories" data-toggle="tab"><?php echo Yii::t('lang','Categories');?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="product-general">
            <?php $this->renderPartial('_view_prod_general', array('model'=>$model,'form'=>$form));  ?>
        </div>
        <div class="tab-pane" id="product-prices">
            <?php $this->renderPartial('_view_prod_prices', array('model'=>$model,'form'=>$form));  ?>
        </div>
        <div class="tab-pane" id="product-images">
            <?php $this->renderPartial('_view_prod_images', array('model'=>$model,'form'=>$form,'images'=>$images));  ?>
        </div>
        <div class="tab-pane " id="product-inventory">
            <?php $this->renderPartial('_view_prod_inventory', array('model'=>$model,'form'=>$form));  ?>
        </div>
        <div class="tab-pane " id="product-categories">
            <?php $this->renderPartial('_view_prod_categories', array('model'=>$model,'form'=>$form));  ?>
        </div>
      </div>
    </div>

</div>