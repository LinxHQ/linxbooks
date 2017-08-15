<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $taskModel Task */

//echo '<h4>Tasks</h4>';
if(isset($model->project_id)){
	$more_tasks_link = CHtml::link(
			YII::t('core','More'),
			"#",
			array(
					"onClick" => " {". CHtml::ajax(
							array(
									"url" => array("task/index", 'project_id' => $model->project_id, 'ajax' => 1),
									"success" => "js: function(data){
										$('html, body').animate({ scrollTop: 0 }, 600);
										$('#content').html(data);
										resetWorkspaceClickEvent('content');
									}"),
							array("live" => false, "id"=> "ajax-id-" . uniqid())) . " return false; }",
					"id" => "ajax-id-" . uniqid()));


	// if we are loading the wholy html body or parent container of this with ajax, then must use unique id from _
	// other wise, not loading of ajax we can safely delare constant id
	$grid_id = 'project-recent-tasks-grid-' . (isset($_GET['_']) ? $_GET['_'] : '');

	// sort
	/**
	echo 'Sort by: ';
	$this->widget('bootstrap.widgets.TbButtonGroup', array(
			'type' => '',
			'toggle' => 'radio', // 'checkbox' or 'radio'
			'buttons' => array(
					array('label'=>'Activity'),
					array('label'=>'Schedule'),
					array('label'=>'Right'),
			),
	));**/

	// $task_comment = TaskComment::model()->getTaskCommentsDetail(12);
	// echo "<pre>";
		// print_r($task_comment);
	// $task_comment_detail = "";
	// foreach($task_comment as $result_task_comment){
		
	// 	$task_comment_detail .= $result_task_comment['task_comment_content'];
	// }
	// echo $task_comment_detail;
	$this->widget('bootstrap.widgets.TbGridView', array(
			'type' => 'striped',
			'dataProvider' => $taskModel->search('task_is_sticky DESC, task_end_date ASC, task_start_date ASC, task_name ASC', 20, 'all_but_issues'),
			'id' => $grid_id,
			'ajaxUpdate' => true,
			'filter'=>$taskModel,
			'beforeAjaxUpdate' => 'function(id, data){removeWorkspaceClickEvent(null);}',
			'afterAjaxUpdate' => 'function(id, data){addWorkspaceClickEvent(null);}',
			'template' => '{items}
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>{pager}</td>
					<td>&nbsp;' . $more_tasks_link . '</td>
				</tr>
			</table>',
			'htmlOptions' => array('style' => 'padding-top: 0px; padding-bottom: 0px; margin-top: -35px'),
			'columns'=>array(
					//array('name'=>'id', 'header'=>'#'),
					array(
							
							'type' => 'raw',
							'value' => '"<div style=\'display: inline; width: 55px; float: left;\'>" 
								. (isset($data->comments[0]->task_comment_owner_id) ?
									AccountProfile::model()->getProfilePhoto($data->comments[0]->task_comment_owner_id)
									: AccountProfile::model()->getProfilePhoto($data->task_owner_id)) . "</div>" . 
						"<div style=\'display: block; width: auto;\'>" . CHtml::link(
							$data->task_name,
							$data->getTaskURL(),
							array("id" => "ajax-id-" . uniqid(), "data-workspace" => "1")) .
	                                        "<br/></div>" .
	                    "<div style=\'display: block; width: auto; margin-left: 55px; color: #999999\'>" .TaskComment::model()->getTaskCommentsDetail($data->task_id).
	                                        "<br/></div>" .
						"<span class=\'blur-summary\'></span><br/>".
	                                        //$data->getTaskTypeBadge() .
	                                        //"<span class=\'badge badge-info\'>".$data->getTaskTypeLabel()."</span>".
	                                        "</div>"',
	                                        'headerHtmlOptions'=>array('width'=>'845'),
					),
					//array('header' => '',
					//		'type' => 'raw',
					//		'value'=>' .
	                                //                        '),
					array(
							'name'=>'task_end_date',
							'header'=>'End Date',
	                                                'type'=>'raw',
							'value'=>'(isset($data->task_end_date) ? Utilities::displayFriendlyDate($data->task_end_date) : "")',
							'htmlOptions'=>array('width'=>'100px;')),
					array(
							//'name' => 'task_last_commented_date',
							'header'=>'',
							'type' => 'raw',
							'htmlOptions' => array('width'=>'300px', 'style'=>'text-align: right'),
							'value' => '"<div style=\'width: 100%; clear: both; float: right;\'>".'
	                                                                . 'AccountProfile::model()->getProfilePhoto(explode(",",$data->getTask_assignees()), false, 30)."<br/>".'
	                                                    . '(isset($data->task_end_date) ? "<span class=\"blur\">".Utilities::displayFriendlyDate($data->task_end_date)."</span>" : "").'
	                                                    . '"</div>"',
	                                                        //Utilities::displayFriendlyDateTime($data->task_last_commented_date)."<br/>"', // format time
							'sortable' => true,
	                                    ),
	                    
	                                array(
	                                                'filter'=>false,
	                                                'name' => 'task_no',
	                                                'header'=>'',
	                                                'htmlOptions' => array('width'=>'20px', 'align' => 'right'),
	                                                'type'=>'raw',
	                                                'value'=> '($data->task_is_sticky == TASK::TASK_IS_STICKY ? '
	                                                        . 'CHtml::image(Yii::app()->baseUrl."/img/pin-black.png")'
	                                                        . ': "").'
	                                                        . '($data->task_no!="" ? "<span class=\"blur\" style=\"float:right;\">'
	                                                        . '</span>" : "")',
	                                                'filter' => CHtml::activeTextField($taskModel, 'task_no', array('class' => 'input-mini','style'=>'float:right','placeholder'=>YII::t('core','Enter id'))),
	                                )
	                    ),
	)); 
	/*
	OLD CODE for viewing task links in grid 
	 array("onClick" => " {". CHtml::ajax(
									array(
											"url" => array("task/view", "id" => $data->task_id),
											"success" => "js: function(data){
												$(\'html, body\').animate({ scrollTop: 0 }, 600);
												$(\'#content\').html(data);
											}"),
									array("live" => false, "id"=> "ajax-id-" . uniqid())

							) . " return false; }"
	 */

	/*
	 // Auto refresh grid periodically
	Yii::app()->clientScript->registerScript('ajax-id' . uniqid(),
			'window.setInterval(function(){
					$.get(\'' . Yii::app()->createUrl("implementation/canRefresh", array('project_id' => $model->project_id)) . '\', function(data){
							if (data == "1")
							{
							//$.fn.yiiGridView.update("' . $implementations_grid_id . '");
							}
							});
					}, 1000*60*5);',
			CClientScript::POS_LOAD);
	*/
}
?>
<style>
    table .filters td{
        border-top: none;
        padding: 0px;
    }
</style>