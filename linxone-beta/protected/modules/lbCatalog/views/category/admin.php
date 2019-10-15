<?php
/* @var $this CategoryController */
/* @var $model LbCatalogCategories */

$this->breadcrumbs=array(
	'Lb Catalog Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LbCatalogCategories', 'url'=>array('index')),
	array('label'=>'Create LbCatalogCategories', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lb-catalog-categories-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

echo '<div id="lb-view-header" style="margin: -20px -20px 17px; padding: 4px 20px;">';
echo '<div class="lb-right-header" ><h3><a href="'.LbInvoice::model()->getActionURLNormalized("dashboard").'" style="color: #fff !important;">'.Yii::t('app','Categories').'</a></h3></div>';
echo '<div class="lb-header-left" >';
echo LBApplicationUI::backButton(LbCatalogProducts::model()->getActionURLNormalized('product/index'));
echo '&nbsp';
echo LBApplicationUI::newButton(Yii::t('app','Category'),array('url'=>LbCatalogCategories::model()->getActionURLNormalized('category/create')));
echo '</div>';
echo '</div>';
?>


<div style="display:bock">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'lb-catalog-categories-grid',
	'dataProvider'=>$model->search(),
    'template' => "{items}\n{pager}\n{summary}", 
//	'filter'=>$model,
	'columns'=>array(
                array(
                    'name'=>'lb_category_name',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'width:250px;')
                ),
                array(
                    'name'=>'lb_category_description',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'width:400px;')
                ),
                array(
                    'name'=>'lb_category_created_date',
                    'htmlOptions'=>array('style'=>'width:400px;'),
                    'value'=> 'LBApplication::displayFriendlyDateTime($data->lb_category_created_date)'
                ),
                array(
                    'name'=>'lb_category_status',
                    'type'=>'raw',
                    'value'=>function($data){
                        if($data->lb_category_status == 1)
                            echo '<a href="#" onclick="updateStatus('.$data->lb_record_primary_key.',0); return false;"><i class="icon-ok"></i></a>';
                        else
                            echo '<a href="#" onclick="updateStatus('.$data->lb_record_primary_key.',1); return false;"><i class="icon-remove"></i></a>';
                    },
                    'htmlOptions'=>array('style'=>'width:60px;text-align: center;')
                ),
		/*
		'lb_category_parent',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{update} {delete}',
                        'buttons'=>array(
                            'delete'=>array(
                                'visible'=>'$data->isCanDetete()'
                            )
                        ),
                        'htmlOptions'=>array('style'=>'width:40px;')
		),
	),
)); ?>

<script type="text/javascript">
    function updateStatus(categoty_id,status){
            $.blockUI();
            $.ajax({
                type: 'Post',
                url: '<?php echo $this->createURL("updateStatus"); ?>',
                data:{categoty_id:categoty_id,status:status},
                success:function(data){ 
                    $.fn.yiiGridView.update("lb-catalog-categories-grid");
                    $.unblockUI();
                },
        });
    }
</script>