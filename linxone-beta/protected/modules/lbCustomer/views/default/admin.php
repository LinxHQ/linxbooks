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
            echo '<div class="lb_customer_header_left">&nbsp;';
                echo'<input type="search" onKeyup="search_name(this.value);" id="search_invoice" value="" class="lb_input_search" value="" placeholder="Search" />';
            echo '</div>';
echo '</div>';

// show add customer link
$customer_canAdd = BasicPermission::model()->checkModules('lbCustomer', 'add');
if ($customer_canAdd) {
    echo '<div class="btn-toolbar">';
    ?>
    <i style="float: left;" class="icon-plus"></i>
    <?php
    echo CHtml::link(Yii::t('lang','New Customer'),
        LbCustomer::model()->getCreateURL(),
        array('data-workspace' => '1', 'id' => uniqid(), 'live' => false, 'style' => 'font-size: 10pt;'));
    echo '</div>';
} // show add new customer link

//echo '<br/>';
echo '<div id="show_customer" style="display: inline; top:-100px;">';
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
       // 'type'=>'bordered',
   //     'htmlOptions'=>array('class'=>'margin-top'),
	'dataProvider'=>$model->search($canList),
    'template' => "{items}\n{pager}\n{summary}", 
	//'filter'=>$model,
	'columns'=>array(
		
		array(
			//'name'=>'lb_customer_name',
			'type'=>'raw',
            'header'=>Yii::t('lang','Name'),          
                        
			'value'=>'LBApplication::workspaceLink($data->lb_customer_name, $data->getViewURLNormalized($data->lb_customer_name),array("id"=>$data->lb_record_primary_key))',
                                                'htmlOptions'=>array('width'=>'30%','height'=>'40px'),
                        'headerHtmlOptions'=>array('width'=>'250','id'=>'$data->lb_customer_name'),
                       // 'filter' => CHtml::activeTextField($model, 'lb_customer_name', array('class' => 'input-mini','style'=>'width:90%')),
                ),
		
                array(
                        'header'=>Yii::t('lang','Registration'),
                        'htmlOptions'=>array('width'=>'25%','height'=>'40px'),
                        'headerHtmlOptions'=>array('width'=>'120'),
                       // 'name'=>'lb_customer_registration',
                        'value'=>'$data->lb_customer_registration',
                        //'filter' => CHtml::activeTextField($model, 'lb_customer_registration', array('class' => 'input-mini','style'=>'width:90%')),
                        
                    ),
                
                    array(
                        'header'=>Yii::t('lang','Website'),
                        'value'=>'$data->lb_customer_website_url',
                       'htmlOptions'=>array('width'=>'20%','height'=>'40px'),
                        'headerHtmlOptions'=>array('width'=>'135'),
                        //'filter' => CHtml::activeTextField($model, 'lb_customer_website_url', array('class' => 'input-mini','style'=>'width:90%')),
                    ),
                    array(
                        'header'=>Yii::t('lang','Customer Type'),
                        'value'=>'$data->lb_customer_type',
                       'htmlOptions'=>array('width'=>'15%','height'=>'40px'),
                        'headerHtmlOptions'=>array('width'=>'135'),
                        //'filter' => CHtml::activeTextField($model, 'lb_customer_type', array('class' => 'input-mini','style'=>'width:90%')),
                    ),
//                        array(
//		'name'=>'lb_customer_is_own_company',
//               'htmlOptions'=>array('width'=>'110'),
//            'headerHtmlOptions'=>array('width'=>'110'),
//                            'filter' => CHtml::activeTextField($model, 'lb_customer_is_own_company', array('class' => 'input-mini')),
//                                 ),
            
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('width'=>'10%','height'=>'40px'),
            'headerHtmlOptions'=>array('width'=>'135'),
		),
	),
)); ?>
</div>
<style>
/*    function($data){
                        return '<span class="badge badge-success">My company</span> ';*/
                        /*},*/

    #lb-customer-grid table thead tr th {
        color: rgb(91, 183, 91);
    }
</style>
    <script>
    $('#<?php echo $subcription->lb_record_primary_key;?>').append("  <span class='badge badge-success'>My company</span>");
    function search_name(name)
    {
        name = replaceAll(name," ", "%");
        
        if(name.length >= 3){
          
                $('#show_customer').load('<?php echo LbCustomer::model()->getActionURLNormalized('_search_customer')?>',{name:name});
            
        }
    }
    function replaceAll(string, find, replace) {
      return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }
    function escapeRegExp(string) {
        return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
    }
    </script>