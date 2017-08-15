<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $my_tasks_final array of Task models */
// $my_tasks_final[priority: 1,2,3]
//   = array(
//      project_id  => array (0=> project object, 1=> array(task,...)),
//      project_id  => ....
//   )

// reformat data into array of stdClasses to generate json
$gantt_tasks_data = array();
//
// HIGH PRIORITY TASK
//
$high_priority_projects = isset($my_tasks_final[Project::PROJECT_PRORITY_HIGH]) ?
        $my_tasks_final[Project::PROJECT_PRORITY_HIGH] : array();
// for each project in this priority, print project name, followed by tasks grid
foreach ($high_priority_projects as $project_id => $data_array) {
    $thisProject = $data_array[0];
    $this_tasks_list = $data_array[1];
    
    // transfer project to stdClass
    $thisProjectStdClass = new stdClass();
    $thisProjectStdClass->id = $thisProject->project_id;
    $thisProjectStdClass->text = $thisProject->project_name;
    $thisProjectStdClass->open = true;
    $gantt_tasks_data[] = $thisProjectStdClass;
    
    // transfer all tasks into stdclass 
    foreach ($this_tasks_list as $task_data)
    {
        $thisTaskStdClass = new stdClass();
        $thisTaskStdClass->id = $task_data['task_id'];
        $thisTaskStdClass->text = $task_data['task_name'];
        $thisTaskStdClass->open = true;
        $thisTaskStdClass->start_date = Utilities::formatDisplayDate($task_data['task_start_date'], 'd-m-Y') ;
        $thisTaskStdClass->end_date = Utilities::formatDisplayDate($task_data['task_end_date'], 'd-m-Y') ;
        $thisTaskStdClass->parent = $thisProject->project_id;
        $thisTaskStdClass->task_url = Task::model()->getTaskURL($task_data['task_id']);
        $gantt_tasks_data[] = $thisTaskStdClass;
    }
}

//
// NORMAL PRIORITY TASK
//
$normal_priority_projects = isset($my_tasks_final[Project::PROJECT_PRIORITY_NORMAL]) ?
        $my_tasks_final[Project::PROJECT_PRIORITY_NORMAL] : array();
// for each project in this priority, print project name, followed by tasks grid
foreach ($normal_priority_projects as $project_id => $data_array) {
    $thisProject = $data_array[0];
    $this_tasks_list = $data_array[1];
    
    // transfer project to stdClass
    $thisProjectStdClass = new stdClass();
    $thisProjectStdClass->id = $thisProject->project_id;
    $thisProjectStdClass->text = $thisProject->project_name;
    $thisProjectStdClass->open = true;
    $gantt_tasks_data[] = $thisProjectStdClass;
    
    // transfer all tasks into stdclass 
    foreach ($this_tasks_list as $task_data)
    {
        $thisTaskStdClass = new stdClass();
        $thisTaskStdClass->id = $task_data['task_id'];
        $thisTaskStdClass->text = $task_data['task_name'];
        $thisTaskStdClass->open = true;
        $thisTaskStdClass->start_date = Utilities::formatDisplayDate($task_data['task_start_date'], 'd-m-Y') ;
        $thisTaskStdClass->end_date = Utilities::formatDisplayDate($task_data['task_end_date'], 'd-m-Y') ;
        $thisTaskStdClass->parent = $thisProject->project_id;
        $thisTaskStdClass->task_url = Task::model()->getTaskURL($task_data['task_id']);
        $gantt_tasks_data[] = $thisTaskStdClass;
    }
}

$low_priority_projects = isset($my_tasks_final[Project::PROJECT_PRIORITY_LOW]) ?
        $my_tasks_final[Project::PROJECT_PRIORITY_LOW] : array();
// for each project in this priority, print project name, followed by tasks grid
foreach ($low_priority_projects as $project_id => $data_array) {
    $thisProject = $data_array[0];
    $this_tasks_list = $data_array[1];
    
    // transfer project to stdClass
    $thisProjectStdClass = new stdClass();
    $thisProjectStdClass->id = $thisProject->project_id;
    $thisProjectStdClass->text = $thisProject->project_name;
    $thisProjectStdClass->open = true;
    $gantt_tasks_data[] = $thisProjectStdClass;
    
    // transfer all tasks into stdclass 
    foreach ($this_tasks_list as $task_data)
    {
        $thisTaskStdClass = new stdClass();
        $thisTaskStdClass->id = $task_data['task_id'];
        $thisTaskStdClass->text = $task_data['task_name'];
        $thisTaskStdClass->open = true;
        $thisTaskStdClass->start_date = Utilities::formatDisplayDate($task_data['task_start_date'], 'd-m-Y') ;
        $thisTaskStdClass->end_date = Utilities::formatDisplayDate($task_data['task_end_date'], 'd-m-Y') ;
        $thisTaskStdClass->parent = $thisProject->project_id;
        $thisTaskStdClass->task_url = Task::model()->getTaskURL($task_data['task_id']);
        $gantt_tasks_data[] = $thisTaskStdClass;
    }
}

// setting style
foreach ($gantt_tasks_data as $taskStdClass) {
    if (Task::model()->isOverdue($taskStdClass->id)) {
        $taskStdClass->color = LinxUI::getOverdueColor();
    }
}
// end setting style

echo '<script src="' . Yii::app()->baseUrl . '/js/dhtmlx/dhtmlxgantt.js"></script>';
echo '<script type="text/javascript" src="//export.dhtmlx.com/gantt/api.js"></script>';
echo '<link href="' . Yii::app()->baseUrl . '/js/dhtmlx/dhtmlxgantt.css" rel="stylesheet">';
echo '<script src="' . Yii::app()->baseUrl . '/js/dhtmlx/ext/dhtmlxgantt_tooltip.js"></script>';
// Chosen plugin
echo '<link href="'.Yii::app()->baseUrl.'/js/chosen/chosen.min.css" rel="stylesheet">';
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chosen/chosen.jquery.min.js', CClientScript::POS_BEGIN);
// end chosen plugin
//echo CJSON::encode($gantt_tasks_data);

//
// FILTERING FORM
//

// prepare selected items array for dropdownList
$selected_projects_option = array();
foreach ($selected_projects_ids as $id)
{
    $selected_projects_option[$id] = array('selected'=>true);
}
echo Yii::t("core",'Projects').': ' . CHtml::dropDownList('lc_gantt_selected_projects',-1, 
        array(0 => Yii::t("core",'All')) + 
        CHtml::listData($filtered_projects, 'project_id', function($project) {
            return $project->project_name;
        }), 
        array(
            'options' => $selected_projects_option,
            'id'=>'lc_gantt_selected_projects', 
            'multiple'=>'true',
            'class'=>'span8')
    );

echo '&nbsp;';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'button',
    'htmlOptions' => array('onclick'=>'lcReloadGanttWithSelectedProjects()'),
    'label' => YII::t('core','Submit'),
    'type' => '', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
));

echo '&nbsp;'.YII::t('core','Display').':&nbsp;';
echo '<input type="radio" checked="" value="trplweek" onclick="zoom_tasks(this)" name="lc_gantt_scales">
    <span>'.Yii::t("core","Days").'</span>&nbsp;';
echo '<input type="radio" checked="true" value="year" onclick="zoom_tasks(this)" name="lc_gantt_scales" id="lc_gantt_scales_month">
    <span>'.Yii::t("core",'Months').'</span>';
echo '<br/><br/>';
// END FILTERING FORM
?>

<div id="linxcircle-gantt-chart-container" style='width:100%; height:500px;'></div>
    <script type="text/javascript">
        $("#lc_gantt_selected_projects").chosen();
        
        gantt.config.readonly = true;
        gantt.templates.tooltip_text = function(start,end,task){
            return "<b><?php echo YII::t('core','Task'); ?>:</b> "+task.text+"<br/><b><?php echo YII::t('core','Start'); ?>:</b> " + task.start_date+"<br/><b><?php echo YII::t('core','End'); ?>:</b> "+task.end_date;
        };
        gantt.config.columns = [
            {name:"text",       label:"<?php echo YII::t('core','Name'); ?>",  width:"150", tree:true, resize:true },
            {name:"start_date", label:"<?php echo YII::t('core','Start'); ?>", align: "center", width: 60},
            {name:"end_date",   label:"<?php echo YII::t('core','End'); ?>",   align: "center", width: 80 },
            //{name:"add",        label:"",           width:44 }
        ];
        gantt.init("linxcircle-gantt-chart-container");
        
        <?php
        // only print gantt if there's data
        if (sizeof($gantt_tasks_data))
        {
        ?>
        var tasks = {
            data:<?php echo CJSON::encode($gantt_tasks_data); ?>,
        };
        gantt.parse (tasks);
        
        gantt.attachEvent("onTaskClick", function(id, e) {
            var task = gantt.getTask(id);
            window.open(task.task_url, '_blank');
        });
        
        gantt.showDate(new Date());
        <?php
        } // end if there's gantt data to print
        ?>
        
		function set_scale_units(mode){
			if(mode && mode.getAttribute){
				mode = mode.getAttribute("value");
			}

			switch (mode){
				case "work_hours":
					gantt.config.subscales = [
						{unit:"hour", step:1, date:"%H"}
					];
					gantt.ignore_time = function(date){
						if(date.getHours() < 9 || date.getHours() > 16){
							return true;
						}else{
							return false;
						}
					};

					break;
				case "full_day":
					gantt.config.subscales = [
						{unit:"hour", step:3, date:"%H"}
					];
					gantt.ignore_time = null;
					break;
				case "work_week":
					gantt.ignore_time = function(date){
						if(date.getDay() == 0 || date.getDay() == 6){
							return true;
						}else{
							return false;
						}
					};

					break;
				default:
					gantt.ignore_time = null;
					break;
			}
			gantt.render();
		}


        // gantt zoom
        function zoom_tasks(node){
			switch(node.value){
				case "week":
					gantt.config.scale_unit = "day"; 
					gantt.config.date_scale = "%d %M"; 

					gantt.config.scale_height = 60;
					gantt.config.min_column_width = 30;
					gantt.config.subscales = [
  						  {unit:"hour", step:1, date:"%H"}
					];
				break;
				case "trplweek":
					gantt.config.min_column_width = 70;
					gantt.config.scale_unit = "day"; 
					gantt.config.date_scale = "%d %M"; 
					gantt.config.subscales = [ ];
					gantt.config.scale_height = 35;
				break;
				case "month":
					gantt.config.min_column_width = 70;
					gantt.config.scale_unit = "week"; 
					gantt.config.date_scale = "Week #%W"; 
					gantt.config.subscales = [
  						  {unit:"day", step:1, date:"%D"}
					];
					gantt.config.scale_height = 60;
				break;
				case "year":
					gantt.config.min_column_width = 70;
					gantt.config.scale_unit = "month"; 
					gantt.config.date_scale = "%M"; 
					gantt.config.scale_height = 60;
					gantt.config.subscales = [
  						  //{unit:"week", step:1, date:"#%W"}
					];
				break;
			}
			set_scale_units();
			gantt.render();
		}
        $("#lc_gantt_scales_month").click();
        
        // submit selected projects filter
        function lcReloadGanttWithSelectedProjects()
        {
            var url = '<?php 
                echo Yii::app()->getUrlManager()->createUrl(
                        '/'.Utilities::getCurrentlySelectedSubscription().'/gantt'); ?>?projects='+$("#lc_gantt_selected_projects").chosen().val();
            workspaceLoadContent(url);
            workspacePushState(url);
        }
        
        // remove all projects from selection if "all" option is selected
        // remove "all" option if any project is selected
        $("#lc_gantt_selected_projects").chosen().change(function(e, params) {
            if (params.selected == 0)
            {
                // remove other options when "all" is selected
                $('#lc_gantt_selected_projects').val('0').trigger('chosen:updated');
            } else if (params.selected > 0) {
                // remove "all" when any other option is selected
                var val = $('#lc_gantt_selected_projects').chosen().val();
                var newVal = jQuery.grep(val, function(value) {
                    return value != 0;
                });
                $('#lc_gantt_selected_projects').val(newVal).trigger('chosen:updated');
            }    
        });
    </script>
<?php

echo '<br/><br/>';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'button',
    'htmlOptions' => array('onclick'=>'gantt.exportToPDF()'),
    'label' => Yii::t("core",'Export to PDF'),
    'type' => '', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
));
?>