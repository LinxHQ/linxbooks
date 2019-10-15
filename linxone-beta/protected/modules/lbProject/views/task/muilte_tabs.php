<?php 
	$count_task_name = strlen($model->task_name);
	if($count_task_name > 20){
	    $result_task_name = mb_substr($model->task_name,  0, 20);
	    $task_name = $result_task_name."...";
	} else {
	    $task_name = $model->task_name;
	}
	Utilities::renderPartial($this, "/default/_project_header", array(
	    'project_id' => $model->project_id,
	    'return_tab' => ($model->task_type == Task::TASK_TYPE_ISSUE ? 'issues' : 'tasks')
	));
	$model = $this->loadModel($model->task_id);
	$task_comment = new TaskComment();
	$task_comments = $task_comment->getTaskComments($model->task_id);
	echo "<div style='margin-top: -60px;'>";
		$this->widget('bootstrap.widgets.TbTabs', array(
		        'type' => 'tabs',
		        'encodeLabel'=>false,
		        'tabs' => array(
		                array('id' => 'tab1', 'label' => Yii::t('lang','Dự án'). ' <span class="badge">'.count(Project::model()->findAll()).'</span>', 'content' => 'Loading ....'),
		                array('id' => 'tab2', 'label' => Yii::t('lang','Công việc'). ' <span class="badge badge-warning">'.count(Task::model()->findAll('project_id IN ('.$model->project_id.')')).'</span>', 'content' => 'Loading ....'),
		                array('id' => 'tab3', 'label' => Yii::t('lang','Văn bản'). ' <span class="badge badge-success">'.count(Documents::model()->findAll('document_parent_id IN ('.$model->project_id.')')).'</span>', 'content' => 'Loading ....'),
		                array('id' => 'tab4', 'label' => Yii::t('lang','Wiki'). ' <span class="badge badge-info">'.count(WikiPage::model()->findAll('project_id IN ('.$model->project_id.')')).'</span>', 'content' => 'Loading ....'),
		                // array('id' => 'tab5', 'label' => $task_name.'<button style="margin-left: 3px;" class="close closeTab" type="button" >×</button>', 'content' => 'Loading ....', 'active' => true),
		                array('id' => 'tab5', 'label' => $model->task_id.'<button style="margin-left: 3px;" class="close closeTab" type="button" >×</button>', 'content' => $this->renderPartial('application.modules.lbProject.views.task.view', array(
		                		'model' => $model,
		                		'task_comments' => $task_comments,
		                		'task_comment_documents' => $task_comment->task_comment_documents,
		                		'request_mutile_tabs' => 'request_mutile_tabs',
		                	)), 'active' => true),
		        ),
		        'events'=>array('shown'=>'js:loadContent')
		    )
		);
	echo "</div>";
 ?>

 <script type="text/javascript">
 	$("#side-menu").hide(); //remove respective tab content
 	function loadContent(e){

        var tabId = e.target.getAttribute("href");

        var ctUrl = ''; 

        if(tabId == '#tab1') {
        	$("#task-main-body").hide();
            ctUrl = '<?php echo $this->createUrl("/lbProject/default/projectall"); ?>';
        } else if(tabId == '#tab2') {
        	$("#task-main-body").hide();
            ctUrl = '<?php echo $this->createUrl("/lbProject/default/taskall"); ?>';
            // ctUrl = '<?php echo Yii::app()->baseUrl.'/lbProject/default/indextask' ?>?id=424';
        } else if(tabId == '#tab3') {
        	$("#task-main-body").hide();
            ctUrl = '<?php echo $this->createUrl("/lbProject/default/documentall"); ?>';
        } else if (tabId == '#tab4') {
        	$("#task-main-body").hide();
            ctUrl = '<?php echo $this->createUrl("/lbProject/default/wikiall"); ?>';
        } else if (tabId == '#tab5') {
        	$("#task-main-body").show();
        	// ctUrl = '<?php echo $this->createUrl("/lbProject/task/loadmutiletabs"); ?>';
        }

        if(ctUrl != '') {
            $.ajax({
                url      : ctUrl,
                type     : 'POST',
                dataType : 'html',
                cache    : false,
                success  : function(html)
                {
                    jQuery(tabId).html(html);
                },
                error:function(){
                        alert('Request failed');
                }
            });
        }

        preventDefault();
        return false;
    }
 </script>