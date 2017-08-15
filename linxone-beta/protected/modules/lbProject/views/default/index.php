<style type="text/css" media="screen">
     /* Dropdown Button */
     #content{
        background: white !important;
     }
.dropbtn {
    background-color: rgb(91, 183, 91);
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
    background-color: rgb(91, 183, 91);
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 145px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;} 
</style>
<?php

/* @var active_projects Array */
/* @var archived_projects array */
Yii::app()->getModule('milestone');

// check permission to create project
$projectTemp = new Project();
//$thisSubscription = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id, true);
//reset($thisSubscription);
$projectTemp->account_subscription_id = (isset(Yii::app()->user->linx_app_selected_subscription) ?
                Yii::app()->user->linx_app_selected_subscription : 0); //key($thisSubscription);
echo '<center>';
echo '</center>';
/**
  echo CHtml::link(
  'Create Project',
  array('project/create'), // Yii URL
  //array('update' => '#content'), // jQuery selector
  array('id' => 'ajax-id-'.uniqid(), 'data-workspace' => '1')
  );
 * */
// LEFT MENU
  // http://localhost/linxbooks_project/index.php/lbProject/wikiPage/create
  echo '<div id="lb-container-header">
            <div class="lb-header-right" style="margin-left:-11px;"><h3>Dự án</h3></div>
            <div class="lb-header-left">
                &nbsp;
                 <div class="dropdown">
                  <button onclick="myFunction()" class="dropbtn"><i class="icon-plus icon-white"></i></button>
                  <div id="myDropdown" class="dropdown-content">
                    <a href="create">Create Project</a>
                    <a href="'.Yii::app()->getBaseUrl().'/index.php/lbProject/wikiPage/create">Create Wiki Page</a>
                  </div>
                </div> 
                
                <input placeholder="Search" value="" style="border-radius: 15px; margin-top: 3px;" onkeyup="search_name_invoice(this.value);" type="text">
            </div>
</div><br>';
?>
<?php
/* @var $this DefaultController */
?>
    
<?php
    // echo ; #999
    // $count_project = " <i style='background-color: #999; color: white; padding: 4px; border-radius: 15px;'>".count(Project::model()->findAll())."</i>";
    $count_project = " <span class='badge'>".count(Project::model()->findAll())."</span>";
    $count_task = " <span class='badge badge badge-warning'>".count(Task::model()->findAll())."</span>";
    $count_document = " <span class='badge badge badge-success'>".count(Documents::model()->findAll())."</span>";
    $count_wiki = " <span class='badge badge-info'>".count(WikiPage::model()->findAll())."</span>";
    $this->widget('bootstrap.widgets.TbTabs', array(
                    'type'=>'tabs', // 'tabs' or 'pills'
                    'encodeLabel'=>false,
                    'tabs'=> 
                    array(
                               array('id'=>'tab1','label'=>Yii::t('lang','Dự án').$count_project, 
                                                'content'=> $this->renderPartial('project_all', array(
                                                        // 'taxModel'=>$taxModel,
                                                ),true),
                                                'active'=>true),
                                array('id'=>'tab2','label'=>Yii::t('lang','Công việc').$count_task, 
                                                'content'=> $this->renderPartial('task_all', array(
                                                        // 'taxModel'=>$taxModel,
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab3','label'=>Yii::t('lang','Văn bản').$count_document, 
                                                'content'=> $this->renderPartial('document_all', array(
                                                        // 'taxModel'=>$taxModel,
                                                ),true),
                                                'active'=>false),
                                array('id'=>'tab4','label'=>Yii::t('lang','Wiki').$count_wiki, 
                                                'content'=> $this->renderPartial('wiki_all', array(
                                                        // 'taxModel'=>$taxModel,
                                                ),true),
                                                'active'=>false),
                                 
                                
                            )
    ));
?>


<?php
echo '<div id="project-side-menu-container" style="float: left; width: 120px; padding-top: 20px;">';
// CREATE PROJECT LINK
// if (Permission::checkPermission($projectTemp, PERMISSION_PROJECT_CREATE)) {
//     echo '<i class="icon-plus"></i>' .
//     Utilities::workspaceLink(Yii::t('core','Create Project'), array('default/create'), array('style' => "font-family: 'Noto Sans', sans-serif; color: #5DA028"));
//     echo '&nbsp;<br/><br/>';
// }

// LIST OR TILE LINK
/**
 * 22 Mar 2016: josephpnc commented this section to avoid computing consumption
if (isset($display_style) && $display_style == $this::INDEX_DISPLAY_STYLE_LIST) {
    echo '<i class="icon-th-large"></i>';
    echo Utilities::workspaceLink('Tile View', array('project/index', 'display' => $this::INDEX_DISPLAY_STYLE_TILE), array('live' => false, 'style' => "font-family: 'Fjalla One', sans-serif; color: #5DA028"));
} else {
    echo '<i class="icon-th-list"></i>';
    echo Utilities::workspaceLink('Live Status', array('project/index', 'display' => $this::INDEX_DISPLAY_STYLE_LIST), array('live' => false, 'style' => "font-family: 'Fjalla One', sans-serif; color: #5DA028"));
}**/

echo '</div>'; // end left menu project-side-menu-container
// MAin content:
echo '<div id="project-list-container" style="margin-top: 20px; float: right; width: 1000px;">';

// DEFAULT/Tile display
if ((isset($display_style) && $display_style == $this::INDEX_DISPLAY_STYLE_TILE) || !isset($display_style)) {
    $col = 3;

    // row by row
    echo '<div id="project-tiles-container" class="gridster" style="display: none"><ul>';
    $row = 1;
    for ($i = 0; $i < count($active_projects);) {
        // col by col
        for ($j = 1; $j <= $col && $i < count($active_projects); $j++, $i++) {
            $project = $active_projects[$i];

            // check permission for viewing
            if (!Permission::checkPermission($project, PERMISSION_PROJECT_VIEW)) {
                continue;
            }

            /**
              $project_ajax_link = CHtml::ajaxLink(
              $project->project_name,
              array('project/view', 'id' => $project->project_id), // Yii URL
              array('update' => '#content'), // jQuery selector
              array('id' => 'ajax-id-'.uniqid())
              );* */
            // priority label
            $project_priority_label = '';
            if ($project->project_priority == Project::PROJECT_PRORITY_HIGH) {
                $project_priority_label = LbProjectUI::getPriorityLabelHigh($project->getPriorityName());
            } else if ($project->project_priority == Project::PROJECT_PRIORITY_NORMAL) {
                $project_priority_label = LbProjectUI::getPriorityLabelNormal($project->getPriorityName());
            } else {
                $project_priority_label = LbProjectUI::getPriorityLabelLow($project->getPriorityName());
            }

            $project_link = $project_priority_label . '&nbsp;' .
                    CHtml::link(
                            Utilities::getShortName($project->project_name, true, 25), $project->getProjectURL(),
                            //array('project/view', 'id' => $project->project_id), // Yii URL
                            array('id' => 'ajax-id-' . uniqid(), 'data-workspace' => '1', 'style' => 'color: #5DA028')
            );

            // echo '<div class="media task_item" style="" lc_task_id="4318">

            // <div class="media-body" style=" float: left;width: 620px; height: 55px;">';
            //     echo "<p style='margin-bottom: -35px;'>";
            //         $project_members = ProjectMember::model()->getProjectMembers(431, true);
            //         $member_count = 0;
            //         foreach ($project_members as $p_m) {
            //             if ($member_count > 7) {
            //                 echo "...";
            //                 break;
            //             }
            //             echo AccountProfile::model()->getProfilePhoto($p_m->account_id);
            //             $member_count++;
            //         }
            //     echo "</p>";

            // echo '<div style="display: block; width: auto; margin-left: 55px;">
            //         <span class="blur-summary">'.$project_link.'</span>
            //         </div>
            //     </div>
              
            //     <div style="margin-top: 13px;">
            //         <div style="float: left; text-align: center">
            //             <div style="display: inline">
            //                 <p>'.date("d-m-Y", strtotime($project->project_start_date)).'</p>
            //             </div><br>
            //         </div>
                    
            //         <div style=" float: left; margin-left: 10px; text-align: right;">';
            //             $this->widget('bootstrap.widgets.TbBadge', array(
            //                 'type' => 'success', // 'success', 'warning', 'important', 'info' or 'inverse'
            //                 'label' => Task::model()->countTasks($project->project_id, false, 1) . ' tasks',
            //             ));
            //             echo "&nbsp&nbsp";
            //             $this->widget('bootstrap.widgets.TbBadge', array(
            //                 'type' => 'warning', // 'success', 'warning', 'important', 'info' or 'inverse'
            //                 'label' => Task::model()->countTasks($project->project_id, false, 2) . ' issues',
            //             ));  
            //             echo "&nbsp&nbsp";
            //             $this->widget('bootstrap.widgets.TbBadge', array(
            //                 'type' => 'important', // 'success', 'warning', 'important', 'info' or 'inverse'
            //                 'label' => Task::model()->countTasks($project->project_id, false, 3) . ' implementations',
            //             ));  
            //         echo '</div>
            //         <div style=" float: left; margin-left: 10px; text-align: right;">
            //             <a href="#" target="_blank"><i class="icon-wrench"></i></a>
            //         </div>
            //     </div>
            // </div>';
            // echo "<hr />";
            // echo '<li style="width: 230px; height: 260px; padding: 10px;" data-row="'
            // . $row
            // . '" data-col="' . $j . '" data-sizex="2" data-sizey="2"><h4 style="max-height: 25px; overflow: hidden; margin-top: 0px">'
            // . $project_link
            // . '</h4>';

            // echo '<div style="height: 40px">' .
            // Utilities::getShortName($project->project_description, true, 50) . '</div><br/><br/>';

            // // show members photos
            // echo '<div style="height: 100px; overflow: hidden; position: relative">';
            // echo '<div style="position: absolute; bottom: 0; left: 0;">';
            // $project_members = ProjectMember::model()->getProjectMembers($project->project_id, true);
            // $member_count = 0;
            // foreach ($project_members as $p_m) {
            //     if ($member_count > 7) {
            //         echo "...";
            //         break;
            //     }
            //     echo AccountProfile::model()->getProfilePhoto($p_m->account_id);
            //     $member_count++;
            // }
            // echo '</div>';
            // echo '</div>';

            // // show badges of number of issues, tasks, implementations
            // echo "<div style='height: 50px'>";
            
            // echo '&nbsp;';
            // $this->widget('bootstrap.widgets.TbBadge', array(
            //     'type' => 'success', // 'success', 'warning', 'important', 'info' or 'inverse'
            //     'label' => Task::model()->countTasks($project->project_id) . ' tasks',
            // ));
            // echo '<br/>';
            
            // echo "</div>";

            // echo "</li>";
        }
        $row++;
    }
    echo '</ul></div>';

    $baseUrl = Yii::app()->baseUrl;
    $cs = Yii::app()->getClientScript();
    //$cs->registerScriptFile($baseUrl.'/js/ducksboard/jquery.gridster.min.js');
    $cs->registerCssFile($baseUrl . '/js/ducksboard/jquery.gridster.min.css');
    $cs->registerCssFile($baseUrl . '/js/ducksboard/ducksboard.css');
    ?>
    <script type="text/javascript">

        var gridster;
        setDashboardStyle();
        $(document).ready(function() {
            gridster = $(".gridster > ul").gridster({
                widget_margins: [10, 10],
                widget_base_dimensions: [140, 140],
                min_cols: 6
            }).data('gridster');
            $("#project-tiles-container").fadeIn(100);
        });
    </script>
    <?php

} // end IF showing TILE display style
else {
    // register script to load project health overview
    /**
    Yii::app()->clientScript->registerScript('create-lcLoadProjectOverview', 'function lcLoadProjectOverview(project_id)
            {
                $.get(\'' . Yii::app()->createUrl('/project/overview') . '/id/\'+project_id,{ms_chart: 0, ajax: 1},function(data){
                    $("#lc-project-milestone-bar-"+project_id).html(data);
                });
            }', CClientScript::POS_BEGIN);
    **/
    
    //
    // print controls section
    //
    echo '<div id="lc-top-control-container" style="width: 100%">';

    // print legend
    echo '<div id="lc-project-status-list-legend" class="lc-top-legend-container" style="float: left; width: 500px;">';
    echo '<div class="legend-item" data-toggle="tooltip" rel="tooltip" data-original-title="You are having both overdue milestone(s) and overdue task(s).">';
    echo '<div class="vertical-bar-symbol" style="background-color:' . Project::model()->getProjectHealthZoneColor(Project::PROJECT_HEALTH_ZONE_RED) . '"></div>';
    echo '<div class="symbol-note">&nbsp;'.Project::model()->getProjectHealthZoneLabel(Project::PROJECT_HEALTH_ZONE_RED).'</div>';
    echo '</div>';
    echo '<div class="legend-item" data-toggle="tooltip" rel="tooltip" data-original-title="You are either: 1. Behind scheduled plans 2. Too close, leaving you with little room for contingency 3. You are working with no plan for open tasks.">';
    echo '<div class="vertical-bar-symbol" style="background-color:' . Project::model()->getProjectHealthZoneColor(Project::PROJECT_HEALTH_ZONE_YELLOW) . '"></div>';
    echo '<div class="symbol-note">&nbsp;'.Project::model()->getProjectHealthZoneLabel(Project::PROJECT_HEALTH_ZONE_YELLOW).'</div>';
    echo '</div>';
    echo '<div class="legend-item" data-toggle="tooltip" rel="tooltip" data-original-title="You are well within scheduled milestones, tasks, and plans. Or these are low priority projects.">';
    echo '<div class="vertical-bar-symbol" style="background-color:' . Project::model()->getProjectHealthZoneColor(Project::PROJECT_HEALTH_ZONE_GREEN) . '"></div>';
    echo '<div class="symbol-note">&nbsp;'.Project::model()->getProjectHealthZoneLabel(Project::PROJECT_HEALTH_ZONE_GREEN).'</div>';
    echo '</div>';
    echo '</div>'; // end lc-project-status-list-legend
    // end legend
    // print filter
    echo '<div id="lc-project-status-list-filter" style="float: right">Sort by:&nbsp;';
    // Button groups for switching between statuses
    $project_status_sort_options = array(1 => 'Status Zone', 2 => 'Priority');

    // radio button for sort selection
    $sort_btns = array();
    foreach ($project_status_sort_options as $key => $value) {
        $this_btn = array();
        $this_btn['label'] = $value;
        $this_btn['buttonType'] = 'ajaxButton';
    $this_btn['ajaxOptions'] = array(
            'success' => 'function(data){
                $("#content").html(data);
                resetWorkspaceClickEvent("content");
            }', 
            'id' => 'ajax-link' . uniqid());
        $this_btn['htmlOptions'] = array('live' => false);
        $this_btn['url'] = array('project/index',
            'sort' => $key, 'ajax' => 1, 'display' => 'list');
        $sort_btns[$key] = $this_btn;
    }
    // get sort request
    $sort = isset($sort) ? $sort : 1;
    if ($sort) {
        $sort_btns[$sort]['htmlOptions'] = array('class' => 'active');
    } else {
        $sort_btns[1]['htmlOptions'] = array('class' => 'active');
    }
    $this->widget('bootstrap.widgets.TbButtonGroup', array(
        'type' => '',
        'toggle' => 'radio', // 'checkbox' or 'radio'
        'buttons' => $sort_btns,
    ));
    echo '</div>'; // end lc-project-status-list-filter
    // end filter
    echo '</div>'; // end lc-top-control-container
    // end print controls
    // LIST display style
    $dataProvider->setPagination(false);
    $projects_array = $dataProvider->getData();

    // for each project, get health color and if applicable, put it into the right zone bucket
    $red_zone = $yellow_zone = $green_zone = array();
    $projects_array_temp = array();
    foreach ($projects_array as $project_arr) {
        $projectModel = Project::model()->findByPk($project_arr['project_id']);
        $project_arr['health_zone'] = $projectModel->getProjectHealthZone();
        $project_arr['health_zone_color'] = $projectModel->getProjectHealthZoneColor($project_arr['health_zone']);
        $project_arr['model']=$projectModel;
        $projects_array_temp[] = $project_arr;
        
        // do we need to resort by health zone?
        if ($sort == 1) {
            if ($project_arr['health_zone'] == Project::PROJECT_HEALTH_ZONE_RED) {
                $red_zone[] = $project_arr;
            } else if ($project_arr['health_zone'] == Project::PROJECT_HEALTH_ZONE_YELLOW) {
                $yellow_zone[] = $project_arr;
            } else {
                $green_zone[] = $project_arr;
            }
        }
    }
    if ($sort == 1)
        $projects_array = array_merge($red_zone, $yellow_zone, $green_zone);
    else 
        $projects_array = $projects_array_temp;
    // end putting project into the right zone bucket

    echo '<table class="table">';
    echo '<tbody style="background: #fff">';
    // for each project, get its milestone
    foreach ($projects_array as $projectObj) {
        $projectModel = $projectObj['model'];
        
        echo '<tr>';
        echo '<td style="padding: 0px; height: 94px; border-bottom: 1px solid #eee; background: #fff">';

        // priority label
        $project_priority_label = '';
        $project_priority = $projectObj['project_priority'];
        if ($project_priority == Project::PROJECT_PRORITY_HIGH) {
            $project_priority_label = LbProjectUI::getPriorityLabelHigh(Project::model()->getPriorityName($project_priority));
        } else if ($project_priority == Project::PROJECT_PRIORITY_NORMAL) {
            $project_priority_label = LbProjectUI::getPriorityLabelNormal(Project::model()->getPriorityName($project_priority));
        } else {
            $project_priority_label = LbProjectUI::getPriorityLabelLow(Project::model()->getPriorityName($project_priority));
        }

        //
        // project name and members
        //        
        echo '<div id="lc-project-health-zone-color-container-'.$projectObj['project_id'].'" style="float: left; width: 10px; margin-right: 10px; height: 100%; background-color: ' . $projectObj['health_zone_color'] . '"></div>';
        echo '<div style="float: left; padding-top: 30px ;  width: 500px; overflow: hidden; height: 49px">';
        $thisPM = ProjectMember::model()->getProjectManager($projectObj['project_id']);
        $this_pm_id = ($thisPM === null ? 0 : $thisPM->account_id);
        echo AccountProfile::model()->getProfilePhoto($this_pm_id, false, 30);
        echo Utilities::workspaceLink("<strong>{$projectObj['project_name']}</strong>", array("project/view", "id" => $projectObj['project_id'])) .
        "&nbsp;$project_priority_label";
        echo '</div>';

        // show members photos
        /**
          echo '<div style="float: left; padding-top: 30px ;  width: 220px; overflow: hidden; height: 49px">';
          $p_members = ProjectMember::model()->getProjectMembers($projectObj['project_id'], true);
          foreach ($p_members as $p_m)
          {
          if ($p_m->account_id == $this_pm_id) continue; // skip project manager, already shown before proj name
          echo AccountProfile::model()->getProfilePhoto($p_m->account_id, false, 30);
          }
          echo '</div>';* */
        // end project name and members
        //
        // milestone for for this project
        //
        if (isset(Yii::app()->modules['milestone'])) {
            $milestone_bar_html = '<div id="lc-project-milestone-bar-' . $projectObj['project_id'] . '" style="float: right; display: table; max-width: 550px; text-align: right;">';
            //$milestone_bar_html .= LbProjectUI::showLoadingImage();
            Utilities::renderPartial($this, '_overview', array(
                'model' => $projectModel,
                'ms_chart' => 0,
                'project_health' => array(
                    'project_actual_progress'=>$projectModel->project_completed,
                    'project_planned_progress'=>$projectModel->project_planned,
                    'time_lapsed'=>$projectModel->project_lapsed),
            ));
            $milestone_bar_html .= '</div>'; // end div lc-project-milestone-bar
            echo $milestone_bar_html;
        } // end checking if milestone module exists
        echo '</tr>';
        //Yii::app()->clientScript->registerScript('call-lcLoadProjectOverview-' . $projectObj['project_id'], 'lcLoadProjectOverview(' . $projectObj['project_id'] . ')', CClientScript::POS_END);        
    } // end for each project
    echo '</tbody>';
    echo '</table>';
    
    // tool tip:
    Yii::app()->clientScript->registerScript('lc-project-health-legend-tooltip','$(\'[data-toggle="tooltip"]\').tooltip({html: true});');
    /**
      $this->widget('bootstrap.widgets.TbGridView', array(
      'type'=>'striped',
      'dataProvider'=>$dataProvider,
      'template'=>"{items}{pager}",
      'columns'=>array(
      //array('name'=>'id', 'header'=>'#'),
      array('name'=>'', 'header'=>'',
      'type' => 'raw',
      //'value' => '"test"'
      'value' => '
      "<div style=\"float: left\">" .
      Utilities::workspaceLink(
      "<strong>{$data["project_name"]}</strong>",
      array("project/view", "id" => $data["project_id"])) .
      "</div>" .
      "<div style=\"float: right; display: table; max-width: 550px; text-align: right;\">" .
      "</div>"
      '
      ),
      ),
      ));* */
    echo '<script type="text/javascript">
      //setDashboardStyle();
    </script>';
}
echo '</div>'; // end project list container project-list-container

echo '<div style="clear: both; width: 100%; height: 40px;"></div>';

// Archived projects
if (isset($archived_projects) && count($archived_projects) > 0) {
    echo '<h5>Archived Projects</h5>';
    foreach ($archived_projects as $ap) {
        echo '<i class="icon-ok-sign"></i>';
        echo Utilities::workspaceLink($ap->project_name, array("default/view", "id" => $ap->project_id));
        echo '<br/>';
    }
}
?>
<script type="text/javascript">
    function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
} 
</script>