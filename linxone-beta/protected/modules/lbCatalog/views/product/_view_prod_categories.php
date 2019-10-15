<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="accordion-group">
    <div class="accordion-heading lb_accordion_heading">
        <a class="accordion-toggle lb_accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#">
            Categories</a>
    </div>
    <div id="" class="accordion-body collapse in">
      			
        <div class="accordion-inner">
            <div>
                <div>
                    <?php echo LbCatalogCategories::model()->menuUlCategory(0,$model->getCategory()); ?>           
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