<?php
// only show milestone timeline for full project
if (!$model->project_simple_view) {
    ?>
    <div class="header-container" style="">Overview</div>
    <div id='linxcircle-project-overview-container'>
        <?php echo LinxUI::showLoadingImage(); ?>
    </div>
    <?php
} // end if showing milestone timeline
?>
<div id="project-updates-container" style="padding-top: 10px; padding-bottom: 0px;">
    <div class="header-container" style="">Recent Updates</div>
    <?php
    $this->renderPartial('_recent_updates', array(
        'project' => $model,
        'notification' => $notification,
    ));
    ?>
</div>
<script language="javascript">
    $(document).ready(function() {
        $.get("<?php echo Yii::app()->createUrl('/project/overview', array('id' => $model->project_id,
        'ajax' => '1', 'ms_chart' => 1));?>", 
                function(data){
                    var project_overview_container = "#linxcircle-project-overview-container";
                    removeWorkspaceClickEvent(null);
                    $(project_overview_container).html(data);
                    addWorkspaceClickEvent(null);
            });
        });
</script>