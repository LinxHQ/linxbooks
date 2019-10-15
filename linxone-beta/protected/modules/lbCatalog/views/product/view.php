<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;" ><h3>'
                    . '<a href="'. Yii::app()->createUrl("1/lbCatalog/default/index?") . '"><i class="icon-arrow-left icon-white" style="margin-top: 7px;"></i></a>  '
                    .Yii::t('lang','Hart Arm Chair').'</h3></div>';
            echo '<div class="lb_customer_header_left">&nbsp;';
            echo '<i class="icon-plus icon-white" style="margin-top: -10px;"></i>  ';
                echo'<input type="search" onKeyup="" id="" value="" class="lb_input_search" value="" placeholder="Search" />';
            echo '</div>';
echo '</div>';

?>
<div style="margin-top: 0px; width: 100%">&nbsp;</div>
<div style="float: right; width: 100%; text-align: right">
            <a data-workspace="1" class="btn" href=""><i class="icon-arrow-left"></i>&nbsp;Back</a>
            <button onclick="" 
                    style="margin-left: auto; margin-right: auto" 
                    class="btn btn-success" type="reset" name="yt0">
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
</div>

<?php $this->renderPartial('_form', array());  ?>
