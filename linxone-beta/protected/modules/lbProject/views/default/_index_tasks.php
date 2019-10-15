<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $taskModel Task */

//echo '<h4>Tasks</h4>';
// if(isset($model->project_id)){
// 	$more_tasks_link = CHtml::link(
// 			YII::t('core','More'),
// 			"#",
// 			array(
// 					"onClick" => " {". CHtml::ajax(
// 							array(
// 									"url" => array("task/index", 'project_id' => $model->project_id, 'ajax' => 1),
// 									"success" => "js: function(data){
// 										$('html, body').animate({ scrollTop: 0 }, 600);
// 										$('#content').html(data);
// 										resetWorkspaceClickEvent('content');
// 									}"),
// 							array("live" => false, "id"=> "ajax-id-" . uniqid())) . " return false; }",
// 					"id" => "ajax-id-" . uniqid()));


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
			'dataProvider' => $taskModel->search('task_is_sticky DESC, task_end_date ASC, task_start_date ASC, task_name ASC', 5, 'all_but_issues'),
			'id' => $grid_id,
			'ajaxUpdate' => true,
			// 'filter'=>$taskModel,
			'beforeAjaxUpdate' => 'function(id, data){removeWorkspaceClickEvent(null);}',
			'afterAjaxUpdate' => 'function(id, data){addWorkspaceClickEvent(null);}',
			// 'template' => '{items}
			// <table border="0" cellspacing="0" cellpadding="0">
			// 	<tr>
			// 		<td>{pager}</td>
			// 		<td>&nbsp;' . $more_tasks_link . '</td>
			// 	</tr>
			// </table>',
			'htmlOptions' => array('style' => 'padding-top: 0px; padding-bottom: 0px; margin-top: -10px'),
			'columns'=>array(
					//array('name'=>'id', 'header'=>'#'),
					array(
							
							'type' => 'raw',
							'value' => '"<div style=\'display: inline; width: 55px; float: left;\'>" 
								. (isset($data->comments[0]->task_comment_owner_id) ?
									AccountProfile::model()->getProfilePhoto($data->comments[0]->task_comment_owner_id)
									: AccountProfile::model()->getProfilePhoto($data->task_owner_id)) . "</div>" . 
						"<div style=\'display: block; width: auto;\'><a href=\'#\' onclick=\'registerComposeButtonEvent(\"$data->task_name\", \"'.uniqid().'\", $data->task_id, \"task\")\' id=\'ajax-id-".uniqid()."\'>" . $data->task_name .
	                                        "</a>
	                                       <br/></div>" .
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
// }
?>
<style>
    table .filters td{
        border-top: none;
        padding: 0px;
    }
</style>
<script type='text/javascript'>
	var currentTab;
	var composeCount = 0;
	//initilize tabs
	$(function () {

	    //when ever any tab is clicked this method will be call
	    $("#yw3").on("click", "a", function (e) {
	        e.preventDefault();

	        $(this).tab('show');
	        $currentTab = $(this);
	    });


	    // registerComposeButtonEvent();
	    // registerCloseEvent();
	});

	//this method will demonstrate how to add tab dynamically
	function registerComposeButtonEvent(task_name, id_tabs, id_task, tabs) {
		var count_task_name = task_name.length;
        if(count_task_name > 20){
        	var task_name = task_name.substr(0, 20);
        	var task_name_subtr = task_name+"...";
        } else {
        	var task_name_subtr = task_name;
        }
	    var tabId = id_task; //this is id on tab content div where the 
        // composeCount = composeCount + 1; //increment compose count
        if(tabs == "task"){
	        if($('.'+id_task).length) {
	        	// alert("test");
	        	$('.nav-tabs a[class="'+id_task+'"]').tab('show') ;
	        } else {
		        $('.nav-tabs').append('<li><a  data-toggle="tab" href="#' + tabId + '"><button onclick="registerCloseEvent(this, \''+tabs+'\');" id="#' + tabId + '" class="close closeTab" type="button" >×</button>'+task_name_subtr+'</a></li>');
		        $('.tab-content').append('<div class="tab-pane" id="' + tabId + '"></div>');
		        ctUrl = '<?php echo Yii::app()->baseUrl.'/lbProject/task/loadmutiletabs' ?>?id='+id_task+'';
		        craeteNewTabAndLoadUrl("", ctUrl, "#" + tabId, tabs);
		        // $("#lb-top-menu").hide();
		        $(this).tab('show');
		        showTab(tabId, tabs);
		        // registerCloseEvent();
		    }
		} else if(tabs == "wiki"){
			if($('.'+id_task).length) {
	        	// alert("test");
	        	$('.nav-tabs a[class="'+id_task+'"]').tab('show') ;
	        } else {
		        $('.nav-tabs').append('<li><a class="'+tabId+'" data-toggle="tab" href="#' + tabId + '"><button onclick="registerCloseEvent(this, \''+tabs+'\');" id="#' + tabId + '" class="close closeTab" type="button" >×</button>'+task_name_subtr+'</a></li>');
		        $('.tab-content').append('<div class="tab-pane" id="' + tabId + '"></div>');
		        ctUrl = '<?php echo Yii::app()->baseUrl.'/lbProject/wikiPage/view/' ?>id/'+id_task+'';
		        craeteNewTabAndLoadUrl("", ctUrl, "#" + tabId, tabs);
		        // $("#lb-top-menu").hide();
		        $(this).tab('show');
		        showTab(tabId, tabs);
		        // registerCloseEvent();
		    }
		}

	}

	//this method will register event on close icon on the tab..
	function registerCloseEvent(el, tabs) {
		if(tabs == 'task') {
			close_tab = $(el).attr('id');
			$(el).parent().parent().remove(); //remove li of tab
	        $('#yw3 a:last').tab('show'); // Select first tab
	        // $('#yw3 li:eq(1) a').tab('show');
	        $(close_tab).remove(); //remove respective tab content
		} else if(tabs == 'wiki'){
			close_tab = $(el).attr('id');
			$(el).parent().parent().remove(); //remove li of tab
	        $('#yw3 a:last').tab('show'); // Select first tab
	        // $('#yw3 li:eq(1) a').tab('show');
	        $(close_tab).remove(); //remove respective tab content
		}
	}

	//shows the tab with passed content div id..paramter tabid indicates the div where the content resides
	function showTab(tabId, tabs) {
	    if(tabs == 'task') {
			$('#yw3 a[href="#' + tabId + '"]').tab('show');
		} else if (tabs == 'wiki'){
			$('#yw3 a[href="#' + tabId + '"]').tab('show');
		}
	    
	}
	//return current active tab
	function getCurrentTab() {
	    return currentTab;
	}

	//This function will create a new tab here and it will load the url content in tab content div.
	function craeteNewTabAndLoadUrl(parms, url, loadDivSelector, tabs) {
		if(tabs == 'task') {
			$("" + loadDivSelector).load(url, function (response, status, xhr) {
		        if (status == "error") {
		            var msg = "Sorry but there was an error getting details ! ";
		            $("" + loadDivSelector).html(msg + xhr.status + " " + xhr.statusText);
		            $("" + loadDivSelector).html("Load Ajax Content Here...");
		        }
		    });
		} else if (tabs == 'wiki'){
			$("" + loadDivSelector).load(url, function (response, status, xhr) {
		        if (status == "error") {
		            var msg = "Sorry but there was an error getting details ! ";
		            $("" + loadDivSelector).html(msg + xhr.status + " " + xhr.statusText);
		            $("" + loadDivSelector).html("Load Ajax Content Here...");
		        }
		    });
		}
	    

	}

	//this will return element from current tab
	//example : if there are two tabs having  textarea with same id or same class name then when $("#someId") whill return both the text area from both tabs
	//to take care this situation we need get the element from current tab.
	function getElement(selector) {
	    var tabContentId = $currentTab.attr("href");
	    return $("" + tabContentId).find("" + selector);

	}


	function removeCurrentTab() {
	    var tabContentId = $currentTab.attr("href");
	    $currentTab.parent().remove(); //remove li of tab
	    $('#yw3 a:last').tab('show'); // Select first tab
	    $(tabContentId).remove(); //remove respective tab content
	}
</script>