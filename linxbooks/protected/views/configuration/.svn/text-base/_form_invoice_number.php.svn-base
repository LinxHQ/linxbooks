<?php
/* @var $this DefaultController */

?>
<div style="width: 40%;">
<?php
    $nextID = LbNextId::model()->getNextIdSubscription();
    $this->widget('editable.EditableDetailView', array(
        'id' => 'next-id-details',
        'data' => $nextID,
        'url'   => $nextID->getActionURL('ajaxUpdateNexIDField'), //common submit url for all editables
        'placement'     => 'right',
        'attributes'=>array(
            array(
                'name'=>'lb_next_invoice_number',
            ),
            array(
                'name'=>'lb_next_quotation_number',
            ),
            array(
                'name'=>'lb_next_payment_number',
            ),
            array(
                'name'=>'lb_next_contract_number',
            ),
        ),
        ));
?>
</div>
