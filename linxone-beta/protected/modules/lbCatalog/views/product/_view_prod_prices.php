<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$userList = new UserList();
$catalog_tax = $userList->getItemsListCodeById('catalog_available_colors',true); 
?>
<div class="accordion-group">
    <div class="accordion-heading lb_accordion_heading">
        <a class="accordion-toggle lb_accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#">
            Prices</a>
    </div>
    <div id="" class="accordion-body collapse in">
      			
        <div class="accordion-inner">
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_price',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_price'); ?>
                    <?php echo $form->error($model,'lb_product_price'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_special_price',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_special_price'); ?>
                    <?php echo $form->error($model,'lb_product_special_price'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_special_price_from_date',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php $model->lb_product_special_price_from_date = LBApplication::displayDate($model->lb_product_special_price_from_date); ?>
                    <?php echo $form->textField($model,'lb_product_special_price_from_date'); ?>
                    <?php echo $form->error($model,'lb_product_special_price_from_date'); ?>
                    <span class="add-on"><i class="icon-calendar" id="icon_lb_product_special_price_from_date"></i></span>
                </div>
            </div>
            <div class="control-group ">
                <?php $model->lb_product_special_price_to_date = LBApplication::displayDate($model->lb_product_special_price_to_date); ?>
                <?php echo $form->labelEx($model,'lb_product_special_price_to_date',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_special_price_to_date'); ?>
                    <?php echo $form->error($model,'lb_product_special_price_to_date'); ?>
                    <span class="add-on"><i class="icon-calendar" id="icon_lb_product_special_price_to_date"></i></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label required" for="">Tax <span class="required">*</span></label>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'lb_product_tax',array('0.00'=>"0.00") + CHtml::listData(LbTax::model()->getTaxes("",LbTax::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),'lb_tax_value','lb_tax_value')); ?>
                    <?php echo $form->error($model,'lb_product_tax'); ?>
                </div>
            </div>
            <hr>
            
            <!--div style="padding-left: 200px;">
                <a data-workspace="1" class="btn" href=""><i class="icon-arrow-left"></i>&nbsp;Back</a>
                <button onclick="" 
                        style="margin-left: auto; margin-right: auto" 
                        class="btn btn-success" type="submit" name="yt0">
                    <i class=""></i>&nbsp;Reset
                </button>
		<button onclick="" 
                        style="margin-left: auto; margin-right: auto" 
                        class="btn btn-success" type="submit" name="yt0">
                    <i class="icon-ok icon-white"></i>&nbsp;Save
                </button>
                <button onclick="" 
                        style="margin-left: auto; margin-right: auto;" 
                        class="btn btn-success" type="submit" name="yt0">
                    <i class="icon-plus icon-white"></i>&nbsp;Duplicate
                </button>
                <button onclick="" 
                        style="margin-left: auto; margin-right: auto" 
                        class="btn btn-success" type="submit" name="yt0">
                    <i class="icon-trash icon-white"></i>&nbsp;Delete
                </button>
                
            </div-->
        </div>
    </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
    $('#icon_lb_product_special_price_from_date').click(function(){
        $('#LbCatalogProducts_lb_product_special_price_from_date').datepicker({
            format: 'dd-mm-yyyy',
        }).focus();
    });
    
    $('#icon_lb_product_special_price_to_date').click(function(){
        $('#LbCatalogProducts_lb_product_special_price_to_date').datepicker({
            format: 'dd-mm-yyyy',
        }).focus();
    });

})
</script>