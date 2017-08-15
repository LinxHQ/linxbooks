<?php
$headerPage = array(
        0=>array('A'=>'','B'=>'Project: '.$project_name.' ['.$project_hight. ' priority]'),
        1=>array('A'=>'','B'=>'No. of developers','C'=>$project_member)
    );
$cellcolor = array('A1'=>'FFA500','B1'=>'FFA500','C1'=>'FFA500','D1'=>'FFA500','E1'=>'FFA500','F1'=>'FFA500',
                    'A2'=>'FFA500','B2'=>'FFA500','C2'=>'FFA500','D2'=>'FFA500','E2'=>'FFA500','F2'=>'FFA500');

$footerPage = array(
        0=>array('A'=>'','B'=>'Subtotal: ','C'=>$total_est,'D'=>$total_complate)
    );

$this->widget('ext.EExcelView.EExcelView', array(
    'dataProvider' => $final_tasks,
            'grid_mode'=>'export',
            'title'=>'Title',
            'filename'=> 'ProjectResouceReport',
            'stream'=> true,
            'exportType'=>'Excel2007',
            'headerPage'=>$headerPage,
            'footerPage'=>$footerPage,
            'colorCell'=>$cellcolor,
            
    'columns' => array(
        array(
            'header'=>YII::t('core','#'),
            'type'=>'raw',
            'value'=>'',
            'htmlOptions' => array('width' => '150px;'),
        ),
        array(
            'name' => 'task_name',
            'header' => YII::t('core','Item'),
            'type' => 'raw',
            'htmlOptions' => array('width' => '400px;'),
            'value' => '$data["task_name"]'
        ),
        array(
            'name' => 'Est',
            'header' => Yii::t('core','Est'),
            'type' => 'raw',
            'value' => 'TaskResourcePlan::model()->getTotalPlanTask($data["task_id"])',
            'htmlOptions' => array('width' => '100px;')),
        array(
            'name' => 'Actual to date',
            'header' => Yii::t('core','Actual to date'),
            'type' => 'raw',
            'value' => 'TaskProgress::model()->getTotalActualTask($data["task_id"])',
            'htmlOptions' => array('width' => '10px;')),
        array(
            'name' => 'Lapsed',
            'header' => Yii::t('core','Lapsed').' (%)',
            'type' => 'raw',
            'value' => 'TaskProgress::model()->calculateLapsed($data["task_id"])',
            'htmlOptions' => array('width' => '10px;')),
        array(
            'name' => 'Comment',
            'header' => Yii::t('core','Comment'),
            'type' => 'raw',
            'value' => '',
            'htmlOptions' => array('width' => '10px;')),
    )
));