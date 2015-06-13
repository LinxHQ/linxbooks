<?php
/* @var $this LbCustomerController */
/* @var $model LbCustomer */

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canview = BasicPermission::model()->checkModules($m, 'view');

if(!$canview)
{
    echo "Have no permission to see this record";
    return;
}
$this->breadcrumbs=array(
	'Lb Customers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LbCustomer', 'url'=>array('index')),
	array('label'=>'Create LbCustomer', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lb-customer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;" ><h3> '.Yii::t('lang','Customers').'</h3></div>';
            echo '<div class="lb-header-left">&nbsp;';
            echo '</div>';
echo '</div>';

?>


<?php
//echo LbContracts::model()->getContractCustomer(5);
?>
<?php 
echo '<br/>';
echo '<div style="display: inline">';
// NEW BUTTON
//if($canAdd)
//{
//    LBApplicationUI::newButton(Yii::t('lang','New Customer'), array(
//            'url'=>LbCustomer::model()->getCreateURL(),
//    ));
//    echo "<br><br><br>";
//}

// SEARCH

$subcription =  LbCustomer::model()->getOwnCompany();

$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'lb-customer-grid',
        'type'=>'bordered',
	'dataProvider'=>$model->search($canList),
	'filter'=>$model,
	'columns'=>array(
		
		array(
			'name'=>'lb_customer_name',
			'type'=>'raw',
                       
                        
			'value'=>'LBApplication::workspaceLink($data->lb_customer_name, $data->getViewURLNormalized($data->lb_customer_name),array("id"=>$data->lb_record_primary_key))',
                        'htmlOptions'=>array('width'=>'40%'),
                        'headerHtmlOptions'=>array('width'=>'250','id'=>'$data->lb_customer_name'),
                        'filter' => CHtml::activeTextField($model, 'lb_customer_name', array('class' => 'input-mini','style'=>'width:90%')),
                ),
		
                array(
                        'htmlOptions'=>array('width'=>'20%'),
                        'headerHtmlOptions'=>array('width'=>'120'),
                        'name'=>'lb_customer_registration',
                        'filter' => CHtml::activeTextField($model, 'lb_customer_registration', array('class' => 'input-mini','style'=>'width:90%')),
                        
                    ),
                
                    array(
		'name'=>'lb_customer_website_url',
               'htmlOptions'=>array('width'=>'30%'),
                'headerHtmlOptions'=>array('width'=>'135'),
                        'filter' => CHtml::activeTextField($model, 'lb_customer_website_url', array('class' => 'input-mini','style'=>'width:90%')),
                             ),
//                        array(
//		'name'=>'lb_customer_is_own_company',
//               'htmlOptions'=>array('width'=>'110'),
//            'headerHtmlOptions'=>array('width'=>'110'),
//                            'filter' => CHtml::activeTextField($model, 'lb_customer_is_own_company', array('class' => 'input-mini')),
//                                 ),
            
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
</div>
<style>
/*    function($data){
                        return '<span class="badge badge-success">My company</span> ';*/
                        /*},*/
    </style>
    <script>
    $('#<?php echo $subcription->lb_record_primary_key;?>').append("  <span class='badge badge-success'>My company</span>");
    
    </script>