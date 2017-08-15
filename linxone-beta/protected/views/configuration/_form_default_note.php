<?php 
$defaultNote = LbDefaultNote::model()->getDefaultNoteSubscription();
$this->widget('editable.EditableDetailView', array(
    'id' => 'default-note-details',
    'data' => $defaultNote,
    'url'   => $defaultNote->getActionURL('AjaxUpdateDefaultNoteField'), //common submit url for all editables
    'placement'     => 'right',
    'attributes'=>array(
        array(
            'name'=>'lb_default_note_quotation',
        ),
        array(
            'name'=>'lb_default_note_invoice',
        ),
    ),
    ));
?>