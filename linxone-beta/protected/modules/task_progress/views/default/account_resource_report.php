<?php
/* @var $this ProcessChecklistController */
/* @var $model ProcessChecklist */
?>
<!-- ================== TỔNG HỢP CÁC OPEN TASK ĐƯỢC GÁN VÀO NHÂN VIÊN ============== -->
<?php 
    $generalAP = Tasks::model()->generalAccountProject($account_id);
    $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'account-resource-report-grid',
	'dataProvider'=>$model,
        'template' => "{items}",
	'columns'=>array(
                array(
                    'name'=>'project_name',
                    'type'=>'raw',
                    'value'=>'$data->projects->project_name',
                ),
                array(
                    'name'=>'End',
                    'type'=>'raw',
                    'value'=>'Tasks::model()->getStartTaskProject($data->project_id,$data->account_id, 0);',
                    'footer'=>"<b>".$generalAP['start']."</b>",
                ),
                array(
                    'name'=>'Start',
                    'type'=>'raw',
                    'value'=>'Tasks::model()->getEndTaskProject($data->project_id,$data->account_id, 0);',
                    'footer'=>"<b>".$generalAP['end']."</b>",
                ),
                array(
                    'name'=>'Total',
                    'type'=>'raw',
                    'value'=>'Tasks::model()->calculateTaskOneProject($data->project_id,$data->account_id, 0);',
                    'footer'=>"<b>".$generalAP['total_task']."<b>",
                ),

	),
)); ?>

<!-------------------- END TỔNG HỢP CÁC OPEN TASK ĐƯỢC GÁN VÀO NHÂN VIÊN ---------------- -->


<!-- ================== TỔNG HỢP KẾ HOACH CỦA NHÂN VIÊN CHO PROJECT ============== -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'account-resource-report-grid',
	'dataProvider'=>$model,
        'template' => "{items}",
	'columns'=>array(
                array(
                    'name'=>'project_name',
                    'type'=>'raw',
                    'value'=>'$data->projects->project_name',
                ),
                array(
                    'name'=>'Planned',
                    'type'=>'raw',
                    'value'=>'TaskResourcePlan::model()->calculatePlannedTask($data->project_id,$data->account_id);',
                ),
                array(
                    'name'=>'Unplanned',
                    'type'=>'raw',
                    'value'=>'TaskResourcePlan::model()->calculateUnplannedTask($data->project_id,$data->account_id);',
                ),
	),
)); ?>

<!-------------------- END TỔNG HỢP KẾ HOACH CỦA NHÂN VIÊN CHO PROJECT ---------------- -->

