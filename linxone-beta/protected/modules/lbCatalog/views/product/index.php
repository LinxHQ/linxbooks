<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;" ><h3> '.Yii::t('lang','Product Catalog').'</h3></div>';
//            echo '<div class="lb_customer_header_left">&nbsp;';
//                echo'<input type="search" onKeyup="search_name(this.value);" id="search_invoice" value="" class="lb_input_search" value="" placeholder="Search" />';
//            echo '</div>';
echo '</div>';

//echo '<div class="btn-toolbar" style="display: block; margin-top: 30px; margin-bottom: 30px"><a data-workspace="1" id="597f05313005f" live="" style="font-size: 10pt;" href="#">'
//. '<i class="icon-plus"></i> New Product  </a> &nbsp;&nbsp;<a href="#" style="font-size: 10pt;"><i class="icon-plus"></i> New Category</a></div>';

Yii::app()->clientScript->registerScript('searchTalent', "
    $('#search-form form').submit(function(){
        $.fn.yiiGridView.update('lb-catalog-products-grid', {
            data: $(this).serialize(),
        });
        return false;
    });
");
?>

<div style="width: 100%; text-align: center; margin-top: 30px;">
    <div style="display:bock">
    <?php $this->renderPartial('_search',array(
            'model'=>$model,
    )); ?>
    </div><!-- search-form -->
</div>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'lb-catalog-products-grid',
	'dataProvider'=>$model->search(),
//	'filter'=>$model,
	'columns'=>array(
//		'lb_record_primary_key',
                array(
                    'name'=>'lb_product_name',
                    'type'=>'raw',
                    'value'=> '"<a href=\'".LbCatalogProducts::model()->getActionURLNormalized("product/update/id/".$data->lb_record_primary_key)."\'>".$data->lb_product_name."</a>"',
                    'htmlOptions'=>array('style'=>'width:150px;')
                ),
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
