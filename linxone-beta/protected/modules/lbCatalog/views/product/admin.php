<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;" ><h3> '.Yii::t('lang','Product Catalog').'</h3></div>';
            echo '<div class="lb_customer_header_left">&nbsp;';
                echo'<input type="search" onKeyup="search_name(this.value);" id="search_invoice" value="" class="lb_input_search" value="" placeholder="Search" />';
            echo '</div>';
echo '</div>';

//echo '<div class="btn-toolbar" style="display: block; margin-top: 30px; margin-bottom: 30px"><a data-workspace="1" id="597f05313005f" live="" style="font-size: 10pt;" href="#">'
//. '<i class="icon-plus"></i> New Product  </a> &nbsp;&nbsp;<a href="#" style="font-size: 10pt;"><i class="icon-plus"></i> New Category</a></div>';

?>

<div style="width: 100%; text-align: center; margin-top: 30px;">
    <form  class="form-inline">
            <div class="input-prepend input-append">
                <div class="btn-group">
                        <button class="btn dropdown-toggle" data-toggle="dropdown">
                            Choose Category
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                              <li><a href="#">Cat 1</a></li>
                              <li><a href="#">Cat 2</a></li>
                              <li><a href="#">Cat 3</a></li>
                              <li><a href="#">Cat 4</a></li>
                              <li><a href="#">Cat 5</a></li>
                          </ul>
                </div>
                <input type="text" placeholder="Enter product name to search" style="width: 300px;">
                <button class="btn" type="button">Search</button>
                <a href="<?php echo LbCatalogProducts::model()->getActionURLNormalized("product/create")?>" class="btn" type="button"><i class="icon-plus"></i> Product</a>
                <a href="<?php echo LbCatalogProducts::model()->getActionURLNormalized("category/create")?>" class="btn" type="button"><i class="icon-plus"></i> Category</a>
            </div>
      </form>
</div>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'lb-catalog-products-grid',
	'dataProvider'=>$model->search(),
//	'filter'=>$model,
	'columns'=>array(
//		'lb_record_primary_key',
		'lb_product_name',
		'lb_product_sku',
		'lb_product_status',
		'lb_product_description',
		'lb_product_price',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{update}'
		),
	),
)); ?>
