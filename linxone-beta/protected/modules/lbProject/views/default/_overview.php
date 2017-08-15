<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$project_health_color = TaskProgress::model()->getProjectHealthColor($project_health['project_actual_progress'], 
        $project_health['project_planned_progress'], 
        $project_health['time_lapsed'],
        $model->hasOverdueTask(),
        $model->hasInprogressTask());

$total_open_task_count = Task::model()->countTasks($model->project_id);
$overdue_task_count = $model->hasOverdueTask();
$project_overdue_color = $overdue_task_count ? TaskProgress::model()->getHealthColorHex('red') : 
    TaskProgress::model()->getHealthColorHex();
$project_lapsed_from_formatted = Utilities::displayFriendlyDate($model->project_lapsed_from);
$project_lapsed_to_formatted = Utilities::displayFriendlyDate($model->project_lapsed_to);

/**$project_health_color = '#777'; // normal
// red flag:
if (($project_health['project_actual_progress'] < $project_health['project_planned_progress'])
        || ($project_health['time_lapsed'] == 1 && $project_health['project_actual_progress'] < 1)) {
    $project_health_color = '#f89406';
}**/

$show_milestone_chart = (isset($ms_chart) && $ms_chart == 1) || !isset($ms_chart);
?>
<!--// project health div-->
<div id="linxcircle-project-health-container" style='margin-top: 20px;'>
    <?php   
    // if milestone chart is not shown
    // show milestone number
    if (!$show_milestone_chart)
    {
    ?>
    <div class='project-milestones-count' style='display: inline-block; text-align: center; width: 90px;'>
        <span class='project-milestones' style=' font-size: 24px; font-weight: bold;
              color: <?php echo (Milestones::model()->projectHasOverdueMilestones($model->project_id) ? TaskProgress::model()->getHealthColorHex('red') : '#777'); ?>;'>
            <?php echo Milestones::model()->countMilestones($model->project_id); ?>
        </span>
        <div style="clear: both; height: 10px;"></div>
        <span style='color: #777'>Milestones</span>
    </div>
    <?php
    } // endif showing milestone number
    ?>
    <div id='linxcircle-project-completion-<?php echo $model->project_id; ?>' class='project-completion' style='display: inline-block; text-align: center; width: 110px;'
         rel='tooltip'
         data-original-title='<?php echo 'Actual: ' . number_format($project_health['project_actual_progress'] * 100, 0)
            . '%  Estimated: ' . number_format($project_health['project_planned_progress'] * 100, 0) .'%<br/>(Excluding unplanned work)';?>'>
        <span class='project-actual' style=' font-size: 24px; font-weight: bold; color: <?php echo $project_health_color; ?>;'>
            <?php echo number_format($project_health['project_actual_progress'] * 100, 0) . '%'; ?>
        </span>
        <!--span class='project-planned' style=' font-size: 14px; color: #dcdcdc'>
        <?php //echo $project_health['project_planned_progress']*100 . '%';?>
        </span-->
        <div style="clear: both; height: 10px;"></div>
        <span style='color: #777'>Work completed</span>
    </div>

    <div id='project-lapsed-<?php echo $model->project_id; ?>' style='display: inline-block; text-align: center; width: 90px;'
         rel='tooltip'
         data-original-title='<?php echo "From {$project_lapsed_from_formatted} to {$project_lapsed_to_formatted}"; ?>'>
        <span class='project-actual' style=' font-size: 24px; font-weight: bold; color: <?php echo $project_health_color; ?>;'>
            <?php echo number_format($project_health['time_lapsed'] * 100, 0) . '%'; ?>
        </span>
        <div style="clear: both; height: 10px;"></div>
        <span style='color: #777'>Time lapsed</span>
    </div>

    <div id='project-blockers' style='display: inline-block; text-align: center; width: 80px;'>
        <span class='project-blockers' style=' font-size: 24px; font-weight: bold; color: #777'>
            <?php echo '0'; ?>
        </span>
        <div style="clear: both; height: 10px;"></div>
        <span style='color: #777'>Blockers</span>
    </div>

    <div id='project-open-<?php echo $model->project_id; ?>' style='display: inline-block; text-align: center; width: 80px;'
         rel="tooltip"
         data-original-title="<?php echo "Overdue: $overdue_task_count. Total: $total_open_task_count"; ?>">
        <span class='project-open' style=' font-size: 24px; font-weight: bold; color: <?php echo $project_overdue_color; ?>'>
            <?php echo $total_open_task_count; ?>
        </span>
        <div style="clear: both; height: 10px;"></div>
        <span style='color: #777'>Open</span>
    </div>
</div>
<!--// end project health dig container #linxcircle-project-health-containerboard -->

<!-- START ms chart -->
<?php
if ($show_milestone_chart)
{
?>
<div id="project-timeline-container" style="padding-top: 0px; padding-bottom: 0px;">

    <div id="LC-project-timeline-graph-body-<?php echo $model->project_id; ?>" style="padding-top: 50px; padding-right: 20px; padding-left: 20px; padding-bottom: 30px;">

    </div>
</div>

    <div style="clear: both; width: 100%; text-align: center">
        <span style="padding: 5px; border-radius: 5px; font-size: 10pt; 
              color: <?php echo ($model->project_health_zone == Project::PROJECT_HEALTH_ZONE_GREEN || $model->project_health_zone == Project::PROJECT_HEALTH_ZONE_RED ? '#fff' : '#777'); ?>; 
              margin-top: -10px; 
              background-color:<?php echo $model->getProjectHealthZoneColor($model->project_health_zone); ?>"><?php echo $model->getProjectHealthZoneLabel($model->project_health_zone);?></span>
    </div>
<?php
} // endif check to show ms chart or not
?>
<!-- END ms chart -->

<script language='javascript'>
    $(document).ready(function() {
        <?php
        if ($show_milestone_chart)
        {
        ?>
        $.get("<?php
            echo Yii::app()->createUrl('/milestone/default/showGraph', array('project_id' => $model->project_id,
                'ajax' => '1'));?>",
                function(data) {
                    var project_milestone_graph = "#LC-project-timeline-graph-body-<?php echo $model->project_id; ?>";
                    removeWorkspaceClickEvent(null);
                    $(project_milestone_graph).html(data);
                    addWorkspaceClickEvent(null);
                });
        <?php
        } // end if check if we want to show milestone chart or not.
        ?>
        $('#linxcircle-project-completion-<?php echo $model->project_id; ?>').tooltip({html: true});
        $('#project-lapsed-<?php echo $model->project_id; ?>').tooltip({html: true});
        $('#project-open-<?php echo $model->project_id; ?>').tooltip({html: true});
    });
</script>