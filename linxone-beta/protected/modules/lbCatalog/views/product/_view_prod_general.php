<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$userList = new UserList();
$catalog_available_color = $userList->getItemsListCodeById('catalog_available_colors',true); 
?>
<form enctype="multipart/form-data" onsubmit="" class="form-horizontal MultiFile-intercepted" 
      id="" action="" method="post">
<div class="accordion-group">
    <div class="accordion-heading lb_accordion_heading">
        <a class="accordion-toggle lb_accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#">
            General Information</a>
    </div>
    <div id="" class="accordion-body collapse in">
      			
        <div class="accordion-inner">
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_name',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_name',array('size'=>60,'maxlength'=>100)); ?>
                    <?php echo $form->error($model,'lb_product_name'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_sku',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_sku',array('size'=>30,'maxlength'=>30)); ?>
                    <?php echo $form->error($model,'lb_product_sku'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_status',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'lb_product_status',$userList->getItemsListCodeById('status_product',true)); ?>
                    <?php echo $form->error($model,'lb_product_status'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_description',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model,'lb_product_description',array('size'=>60,'maxlength'=>255,'rows'=>'10','style'=>'width:410px;')); ?>
                    <?php echo $form->error($model,'lb_product_description'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_sort_description',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model,'lb_product_sort_description',array('size'=>60,'maxlength'=>255,'rows'=>'10','style'=>'width:410px;')); ?>
                    <?php echo $form->error($model,'lb_product_sort_description'); ?>
                </div>
            </div>       
            <div class="control-group ">
                <label class="control-label" for="">Available colors</label>
                <div class="controls">
                    <?php 
                    $available_color = explode(',', $model->lb_product_available_color);
                    foreach ($catalog_available_color as $key => $value) {  
                        $checked = "";
                        if(in_array($key, $available_color))
                                $checked = "checked";
                    ?>
                        <input type="checkbox" value="<?php echo $key; ?>" name="available_color[]" id="available_color" <?php echo $checked; ?>> <?php echo $value; ?>
                    <?php } ?>
                </div>
            </div> 
            <div class="control-group ">
                <label class="control-label required" for="">Dimension</label>
                <div class="controls">
                    <?php $dimension = explode(',', $model->lb_product_dimension); ?>
                    H: <input class="span1" value="<?php echo (isset($dimension[0]) ? $dimension[0] : ""); ?>" name="" id="" maxlength="10" type="text" size="5">
                    W: <input class="span1" value="<?php echo (isset($dimension[1]) ? $dimension[1] : ""); ?>" name="" id="" maxlength="10" type="text" size="5">
                    D: <input class="span1" value="<?php echo (isset($dimension[2]) ? $dimension[2] : ""); ?>" name="" id="" maxlength="10" type="text" size="5">
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'lb_product_weight',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lb_product_weight',array('size'=>14,'maxlength'=>14)); ?> kg.
                    <?php echo $form->error($model,'lb_product_weight'); ?>
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
</form>