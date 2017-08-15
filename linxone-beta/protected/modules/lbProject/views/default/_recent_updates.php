<?php
$cadp = $notification->search();

$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped',
    'dataProvider' => $cadp,
    'template' => "{items}",
    'id' => 'linxcircle-project-recent-updates-'.$project->project_id,
    'emptyText'=>'No updates',
    'ajaxUpdate' => true,
    'htmlOptions'=>array('style'=>'margin-top: -20px;'),
    'columns' => array(
        array(
            'header'=>'',
            'type'=>'raw',
            'value'=>'AccountProfile::model()->getProfilePhoto($data->notification_sender_account_id)',
            'htmlOptions' => array('width'=>'50px', 'style'=>'text-align: center')
        ),
        
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link(
                            CHtml::encode($data->notification_subject),
                            $data->getParentURL(),
                            array("id" => "ajax-id-" . uniqid(), "data-workspace" => "1"))
                        . "<div style=\'display: block; clear: both; width: auto;\'>" 
                        . "<span class=\'blur-summary\'>" . Utilities::getSummary($data->notification_excerpt, false, 100)  . "</span><br/>"
                        . "<span class=\'blur-summary\' style=\'font-size: 10px\'>" .  Utilities::displayFriendlyDate($data->notification_created_date)."</span>"
                        .    "</div>"', 
        ),
    ),
));

