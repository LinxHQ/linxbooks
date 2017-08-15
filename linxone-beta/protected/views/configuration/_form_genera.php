<?php
/* @var $this DefaultController */

?>
<div style="width: 40%;">
<?php
    $genera = LbGenera::model()->getGeneraSubscription();
    $this->widget('editable.EditableDetailView', array(
        'id' => 'genera-id-details',
        'data' => $genera,
        'url'   => $genera->getActionURL('ajaxUpdateFieldGenera'), //common submit url for all editables
        'placement'     => 'right',
        'attributes'=>array(
            array(
                'name'=>'lb_genera_currency_symbol',
                'editable' => array(
                     'type'       => 'text',
                     'inputclass' => 'input-large',
                     'emptytext'  => 'Click to Update',
                    )
            ),
            array(
                'name'=>'lb_thousand_separator',
                'editable' => array(
                     'type'       => 'text',
                     'inputclass' => 'input-large',
                     'emptytext'  => 'Click to Edit',
                    )
            ),
           
            array(
                'name'=>'lb_decimal_symbol',
                'editable' => array(
                     'type'       => 'text',
                     'inputclass' => 'input-large',
                     'emptytext'  => 'Click to Edit',
                    )
            ),
        ),
    ));
?>
</div>
<script>
    
</script>