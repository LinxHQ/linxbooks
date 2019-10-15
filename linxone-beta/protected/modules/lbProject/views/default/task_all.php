<!-- <?php 
	$list_task = Task::model()->findAll();
	foreach($list_task as $result_list_task){
		if($result_list_task['task_type'] == 1){
			$task_type = '<div style="padding-right: 8px;" class="btn-group badge badge-info">Feature</div>';
		} else if ($result_list_task['task_type'] == 2){
			$task_type = '<div style="padding-right: 8px;" class="btn-group badge badge-warning">Issue</div>';
		} else if ($result_list_task['task_type'] == 3){
			$task_type = '<div style="padding-right: 8px;" class="btn-group badge badge-info">Forum</div>';
		}

		if($result_list_task['task_status'] == 0){
			$task_status = '<div style="padding-right: 8px;" class="badge">Open</div>';
		} else if($result_list_task['task_status'] == 1){
			$task_status = '<div style="padding-right: 8px;" class="badge">Done</div>';
		}
		echo '
			<div class="media task_item" style="" lc_task_id="4318">
                <div class="media-body" style=" float: left;width: 700px;">
                            <div style="display: inline; width: 55px; float: left;">
						<a style="display: inline-block;" rel="tooltip" title="You" href="">'.AccountProfile::model()->getProfilePhoto($result_list_task['task_owner_id']).'</a></div> 
				<div style="display: block; width: auto; margin-left: 55px;">
                                        <a data-workspace="1" href="'.Yii::app()->getBaseUrl().'/index.php/lbProject/task/view/id/'.$result_list_task['task_id'].'">'.$result_list_task['task_name'].'</a>                                        <br>
                                        <span class="blur-summary">'.TaskComment::model()->getTaskCommentsDetail($result_list_task['task_id']).'</span>
                                        <br /><span class="blur-summary">'.$task_status.'&nbsp;'.$task_type.'</span>
                                    </div> 
                    
                </div>
              
                <div style="float: left; text-align: center">
                        <div style="display: inline">'.Utilities::displayFriendlyDate($result_list_task['task_end_date']).'</div>                        <br>
                </div>
                
              <div style=" float: left;width: 250px; text-align: right;">
                    <div style="width: 100%; clear: both; float: right;">
                        <a style="display: inline-block;" rel="tooltip" href="">'.AccountProfile::model()->getProfilePhoto(explode(",",Task::model()->getTask_assignees($result_list_task['task_id'])), false, 30).'</a><br>
                    </div>
                </div>
                
            </div><hr />';
	}
 ?> -->

 <?php 
	$grid_id = 'project-recent-tasks-grid-' . (isset($_GET['_']) ? $_GET['_'] : '');
	// echo '<input type="hidden" name="id_task" id="id_task" value="ajax-id-'.$data->task_id.'">';
	$this->widget('bootstrap.widgets.TbGridView', array(
			'type' => 'striped',
			'dataProvider' => $taskModel->search('task_is_sticky DESC, task_end_date ASC, task_start_date ASC, task_name ASC', 5, 'all_but_issues'),
			'id' => $grid_id,
			'ajaxUpdate' => true,
			'filter'=>$taskModel,
			'beforeAjaxUpdate' => 'function(id, data){removeWorkspaceClickEvent(null);}',
			'afterAjaxUpdate' => 'function(id, data){addWorkspaceClickEvent(null);}',
			// 'template' => '{items}
			// <table border="0" cellspacing="0" cellpadding="0">
			// 	<tr>
			// 		<td>{pager}</td>
			// 		<td>&nbsp;' . $more_tasks_link . '</td>
			// 	</tr>
			// </table>',
			'htmlOptions' => array('style' => 'padding-top: 0px; padding-bottom: 0px; margin-top: -24px'),
			'columns'=>array(
					//array('name'=>'id', 'header'=>'#'),
					array(
							
							'type' => 'raw',
							'value' => '"<div style=\'display: inline; width: 55px; float: left;\'>" 
								. (isset($data->comments[0]->task_comment_owner_id) ?
									AccountProfile::model()->getProfilePhoto($data->comments[0]->task_comment_owner_id)
									: AccountProfile::model()->getProfilePhoto($data->task_owner_id)) . "</div>" . 
						"<div style=\'display: block; width: auto;\'><a href=\'#\' onclick=\'registerComposeButtonEvent(\"$data->task_name\", \"'.uniqid().'\", $data->task_id)\' id=\'ajax-id-".uniqid()."\'>" . $data->task_name .
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
							'filter'=>false,
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

 ?>
 <style>
    /*table .filters td{
        border-top: none;
        padding: 0px;
    }*/
    .items thead{
    	display: none;
    }
</style>

<script type='text/javascript'>
	var currentTab;
	var composeCount = 0;
	//initilize tabs
	$(function () {

	    //when ever any tab is clicked this method will be call
	    $("#yw1").on("click", "a", function (e) {
	        e.preventDefault();

	        $(this).tab('show');
	        $currentTab = $(this);
	    });


	    // registerComposeButtonEvent();
	    // registerCloseEvent();
	});

	//this method will demonstrate how to add tab dynamically
	function registerComposeButtonEvent(task_name, id_tabs, id_task) {
	    var tabId = id_tabs; //this is id on tab content div where the 
        // composeCount = composeCount + 1; //increment compose count
        var count_task_name = task_name.length;
        if(count_task_name > 20){
        	var task_name = task_name.substr(0, 20);
        	var task_name_subtr = task_name+"...";
        } else {
        	var task_name_subtr = task_name;
        }

        if($('#'+id_task).length) {
		     // it exists tab
		     $('.nav-tabs a[id="'+id_task+'"]').tab('show') ;
		} else {
			$('.nav-tabs').append('<li><a id="' + id_task + '" data-toggle="tab" href="#' + tabId + '"><button onclick="registerCloseEvent(this);" id="#' + tabId + '" class="close closeTab" type="button" >×</button>'+task_name_subtr+'</a></li>');
	        $('.tab-content').append('<div class="tab-pane" id="' + tabId + '"></div>');
	        ctUrl = '<?php echo Yii::app()->baseUrl.'/lbProject/task/loadmutiletabs' ?>?id='+id_task+'';
	        craeteNewTabAndLoadUrl("", ctUrl, "#" + tabId);
	        // $("#lb-top-menu").hide();
	        $(this).tab('show');
	        showTab(tabId);
		}

        
        // registerCloseEvent();

	}

	//this method will register event on close icon on the tab..
	function registerCloseEvent(el) {
		close_tab = $(el).attr('id');
		$(el).parent().parent().remove(); //remove li of tab
        $('#yw1 a:last').tab('show'); // Select first tab
        $(close_tab).remove(); //remove respective tab content
	}

	//shows the tab with passed content div id..paramter tabid indicates the div where the content resides
	function showTab(tabId) {
	    $('#yw1 a[href="#' + tabId + '"]').tab('show');
	}
	//return current active tab
	function getCurrentTab() {
	    return currentTab;
	}

	//This function will create a new tab here and it will load the url content in tab content div.
	function craeteNewTabAndLoadUrl(parms, url, loadDivSelector) {

	    $("" + loadDivSelector).load(url, function (response, status, xhr) {
	        if (status == "error") {
	            var msg = "Sorry but there was an error getting details ! ";
	            $("" + loadDivSelector).html(msg + xhr.status + " " + xhr.statusText);
	            $("" + loadDivSelector).html("Load Ajax Content Here...");
	        }
	    });

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
	    $('#yw1 a:last').tab('show'); // Select first tab
	    $(tabContentId).remove(); //remove respective tab content
	}
</script>