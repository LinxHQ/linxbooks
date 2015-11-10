<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'lb-customer-grid',
        'type'=>'bordered',
	'dataProvider'=>$customerModel->search(),
	'filter'=>$customerModel,
	'columns'=>array(
           
		array(
                    'name'=>'check',
                    'class'=>'CCheckBoxColumn',
                    'id'=>'selectedIds',
                    'value'=>'$data->lb_record_primary_key',
                    'selectableRows'=>'100',
                    'htmlOptions'=>array('width'=>'3px'),
                    'checkBoxHtmlOptions'=>array("name"=>"customer_id[]"),
                ),
		array(
			'name'=>'lb_customer_name',
			                                     			
                    //    'htmlOptions'=>array('width'=>'50px'),
                        'headerHtmlOptions'=>array('width'=>'70','id'=>'$data->lb_customer_name'),
                        'filter' => CHtml::activeTextField($customerModel, 'lb_customer_name', array('class' => 'input-mini','style'=>'width:90%')),
                ),
		
                array(
                        'htmlOptions'=>array('width'=>'50px'),
                        'headerHtmlOptions'=>array('width'=>'50'),
                        'name'=>'lb_customer_registration',
                        'filter' => CHtml::activeTextField($customerModel, 'lb_customer_registration', array('class' => 'input-mini','style'=>'width:90%')),
                        
                    ),
                
                    array(
		'name'=>'lb_customer_website_url',
               'htmlOptions'=>array('width'=>'50px'),
                'headerHtmlOptions'=>array('width'=>'50'),
                        'filter' => CHtml::activeTextField($customerModel, 'lb_customer_website_url', array('class' => 'input-mini','style'=>'width:90%')),
                             ),

	),
));
LBApplicationUI::submitButton('Save',array(
//    'url'=>LbExpenses::model()->getActionURLNormalized('AssignCustomer',array('customer_id'=>93)),
    'htmlOptions'=>array(
        'onclick'=>'SaveCustomer();',
    ),

));
echo '&nbsp&nbsp&nbsp';

LBApplicationUI::submitButton('Close',array(
        'htmlOptions'=>array('data-dismiss'=>'modal'),
));
?>
<script>
   // var customer_id_arr = new Array();
    function SaveCustomer(){
       var customer_id = $("input[type]:checked").serialize();
      //  alert(customer_id);      
        $.post("<?php echo LbExpenses::model()->getActionURLNormalized('AssignCustomer',array('expenses_id'=>$expensesModel->lb_record_primary_key))?>",customer_id);
        refreshCustomerName();
        $("#modal-customer-assign-form").modal("hide");
    }
</script>	
