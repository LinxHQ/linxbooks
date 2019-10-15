<?php
/* @var $this ProductsController */
/* @var $model LbCatalogProducts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lb-catalog-products-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
    
<div style="clear: both; width: 100%"></div>

<div class="tabbable tabs-left" style="margin-top: 20px;">
  <ul class="nav nav-tabs" style="width: 180px;">
      <li class="active"><a href="#product-general" data-toggle="tab">General&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
       <li><a href="#product-prices" data-toggle="tab">Prices</a></li>
       <li><a href="#product-images" data-toggle="tab">Images</a></li>
       <li><a href="#product-inventory" data-toggle="tab">Inventory</a></li>
       <li><a href="#product-categories" data-toggle="tab">Categories</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="product-general">
        <?php $this->renderPartial('_view_prod_general', array('form'=>$form,'model'=>$model));  ?>
    </div>
    <div class="tab-pane" id="product-prices">
        <?php $this->renderPartial('_view_prod_prices', array());  ?>
    </div>
    <div class="tab-pane" id="product-images">
        <?php $this->renderPartial('_view_prod_images', array());  ?>
    </div>
    <div class="tab-pane " id="product-inventory">
        <?php $this->renderPartial('_view_prod_inventory', array());  ?>
    </div>
    <div class="tab-pane " id="product-categories">
        <?php $this->renderPartial('_view_prod_categories', array());  ?>
    </div>
  </div>
</div>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_name'); ?>
		<?php echo $form->textField($model,'lb_product_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'lb_product_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_sku'); ?>
		<?php echo $form->textField($model,'lb_product_sku',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'lb_product_sku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_status'); ?>
		<?php echo $form->textField($model,'lb_product_status'); ?>
		<?php echo $form->error($model,'lb_product_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_description'); ?>
		<?php echo $form->textArea($model,'lb_product_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lb_product_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_price'); ?>
		<?php echo $form->textField($model,'lb_product_price',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'lb_product_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_special_price'); ?>
		<?php echo $form->textField($model,'lb_product_special_price',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'lb_product_special_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_special_price_from_date'); ?>
		<?php echo $form->textField($model,'lb_product_special_price_from_date'); ?>
		<?php echo $form->error($model,'lb_product_special_price_from_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_special_price_to_date'); ?>
		<?php echo $form->textField($model,'lb_product_special_price_to_date'); ?>
		<?php echo $form->error($model,'lb_product_special_price_to_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_tax'); ?>
		<?php echo $form->textField($model,'lb_product_tax'); ?>
		<?php echo $form->error($model,'lb_product_tax'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_qty'); ?>
		<?php echo $form->textField($model,'lb_product_qty'); ?>
		<?php echo $form->error($model,'lb_product_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_qty_out_of_stock'); ?>
		<?php echo $form->textField($model,'lb_product_qty_out_of_stock'); ?>
		<?php echo $form->error($model,'lb_product_qty_out_of_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_qty_min_order'); ?>
		<?php echo $form->textField($model,'lb_product_qty_min_order'); ?>
		<?php echo $form->error($model,'lb_product_qty_min_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_qty_max_order'); ?>
		<?php echo $form->textField($model,'lb_product_qty_max_order'); ?>
		<?php echo $form->error($model,'lb_product_qty_max_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_qty_notify'); ?>
		<?php echo $form->textField($model,'lb_product_qty_notify'); ?>
		<?php echo $form->error($model,'lb_product_qty_notify'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_stock_availability'); ?>
		<?php echo $form->textField($model,'lb_product_stock_availability'); ?>
		<?php echo $form->error($model,'lb_product_stock_availability'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_created_date'); ?>
		<?php echo $form->textField($model,'lb_product_created_date'); ?>
		<?php echo $form->error($model,'lb_product_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_updated_date'); ?>
		<?php echo $form->textField($model,'lb_product_updated_date'); ?>
		<?php echo $form->error($model,'lb_product_updated_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_product_create_by'); ?>
		<?php echo $form->textField($model,'lb_product_create_by'); ?>
		<?php echo $form->error($model,'lb_product_create_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->