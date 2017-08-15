<?php

echo '<br/>';

$this->widget('ext.EExcelView.EExcelView', array(
    'dataProvider' => new CArrayDataProvider($account_tasks, array(
            'id'=>'id',
            'pagination'=>array(
                'pageSize'=>30,
            ))),
            'grid_mode'=>$download ? 'export' : 'grid',
            'title'=>'Title',
            'filename'=>  AccountProfile::model()->getShortFullName($account->account_id, true),
            'stream'=> true,
            'exportType'=>'Excel2007',
    'id' => "linxcircle-account-tasks-".$account->account_id,
    //'ajaxUpdate' => true,
    'beforeAjaxUpdate' => 'function(id, data){removeWorkspaceClickEvent(null);}',
    'afterAjaxUpdate' => 'function(id, data){addWorkspaceClickEvent(null);}',
    'template' => '{items}{pager}<a href="'
        .Yii::app()->createUrl('/task/accountTasksReport', 
                array('account_id'=>$account->account_id,
                    'range'=>$range, 'ajax'=>1, 'download'=>1)).'">'.YII::t('core','Export to Excel').'</a>',
    'columns' => array(
        array(
            'header'=>YII::t('core','Project'),
            'type'=>'raw',
            'value'=>'(Project::model()->findByPk($data["project_id"]) != null ? '
                . 'Project::model()->findByPk($data["project_id"])->project_name : "")',
            
            'htmlOptions' => array('width' => '150px;'),
        ),
        array(
            'name' => 'task_name',
            'header' => YII::t('core','Task'),
            'type' => 'raw',
            'htmlOptions' => array('width' => '400px;'),
            'value' => 'CHtml::link($data["task_name"],Task::model()->getTaskURL($data["task_id"]),array("id" => "ajax-id-" . uniqid(), "data-workspace" => "1"))'
        ),
        array(
            'name' => 'task_start_date',
            'header' => Yii::t('core','Start'),
            'type' => 'raw',
            'value' => 'Utilities::displayFriendlyDate($data["task_start_date"])',
            'htmlOptions' => array('width' => '100px;')),
        array(
            'name' => 'task_end_date',
            'header' => Yii::t('core','End Date'),
            'type' => 'raw',
            'value' => 'Utilities::displayFriendlyDate($data["task_end_date"])',
            'htmlOptions' => array('width' => '100px;')),
    )
));
