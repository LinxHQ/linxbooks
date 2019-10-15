<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$userList = new UserList();
?>
<div class="accordion-group">
    <div class="accordion-heading lb_accordion_heading">
        <a class="accordion-toggle lb_accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#">
            Inventory</a>
    </div>
    <div id="" class="accordion-body collapse in">
      			
        <div class="accordion-inner">
             <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_qty',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_qty'); ?>
                    <?php echo $form->error($model,'lb_product_qty'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_qty_out_of_stock',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_qty_out_of_stock'); ?>
                    <?php echo $form->error($model,'lb_product_qty_out_of_stock'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_qty_min_order',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_qty_min_order'); ?>
                    <?php echo $form->error($model,'lb_product_qty_min_order'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_qty_max_order',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_qty_max_order'); ?>
                    <?php echo $form->error($model,'lb_product_qty_max_order'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_qty_notify',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_qty_notify'); ?>
                    <?php echo $form->error($model,'lb_product_qty_notify'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_stock_availability',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'lb_product_stock_availability',$userList->getItemsListCodeById('catalog_stock_availability',true)); ?>
                    <?php echo $form->error($model,'lb_product_stock_availability'); ?>
                </div>
            </div>
            <!--hr>
            
            <div style="padding-left: 200px;">
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