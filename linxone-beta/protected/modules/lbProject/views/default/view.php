<style type="text/css" media="screen">
     /* Dropdown Button */
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
/* @var $this ProjectController */
/* @var $model Project */
/* @var $recentTasksCActiveDataProvicer CActiveDataProvicer for tasks table */
/* @var $recentIssuesCActiveDataProvider CActiveDataProvider */
/* @var $taskModel Task */
/* @var $issueModel Issue */
/* @var $documentModel Documents */

$selected_tab = (isset($_GET['tab']) ? $_GET['tab'] : '');

$this->menu = array(
    array('label' => YII::t('core', 'New Task'),
        'url' => array('task/create', 'project_id' => $model->project_id, 'project_name' => $model->project_name),
        'ajax' => array('update' => '#content', 'id' => 'create-task-' . uniqid())),
    array('label' => YII::t('core', 'New Issue'),
        'url' => array('issue/create', 'project_id' => $model->project_id, 'project_name' => $model->project_name),
        'ajax' => array('update' => '#content', 'id' => 'create-issue-' . uniqid())),
    array('label' => YII::t('core', 'Wiki'),
        'url' => array('wikiPage/index', 'project_id' => $model->project_id, 'project_name' => $model->project_name),
        'ajax' => array('update' => '#content', 'id' => 'project-wiki-' . uniqid())),
    array('label' => YII::t('core', 'Implementations'),
        'url' => array('implementation/admin', 'project_id' => $model->project_id, 'project_name' => $model->project_name),
        'ajax' => array('update' => '#content', 'id' => 'project-implementation-' . uniqid())),
);

// for checking permission later
$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id, $model->project_id);

// print project's header
// Utilities::renderPartial($this, "_project_header", array('project_id' => $model->project_id, 'project' => $model));
echo '<div id="lb-container-header">
            <div class="lb-header-right" style="margin-left:-11px;"><h3>Dự án</h3></div>
            <div class="lb-header-left">
                &nbsp;
                 <div class="dropdown">
                  <button onclick="myFunction()" class="dropbtn"><i class="icon-plus icon-white"></i></button>
                  <div id="myDropdown" class="dropdown-content">
                    <a href="'.Yii::app()->getBaseUrl().'/index.php/lbProject/default/create">Create Project</a>
                    <a href="'.Yii::app()->getBaseUrl().'/index.php/lbProject/wikiPage/create">Create Wiki Page</a>';
                    echo Utilities::workspaceLink('Create Task', array(
                    '/lbProject/task/create', 
                    'project_id' => $model->project_id,
                    'project_name' => $model->project_name,
                    'display' => $this::INDEX_DISPLAY_STYLE_TILE), array(
                        'live' => false, 
                        'style' => "color: #5DA028"));
                  
                echo '</div></div> 
                
                <input placeholder="Search" value="" style="border-radius: 15px; margin-top: 3px;" onkeyup="search_name_invoice(this.value);" type="text">
            </div>
</div><br>';
?>

<div style="display: block; overflow: visible; height: auto; padding-top: 5px; padding-bottom: 10px; "></div>

<!-- START linxcircle-project-main-body-container -->
<div id='linxcircle-project-main-body-container' style='display: block'>
    <!-- side bar toggle -->
    <!-- <div class="lc-project-side-menu-icon"><a href="#" onclick="lcProjectToggleSideBar();"><i class="icon-align-justify"></i></a>
    </div -->

    <!-- START left column of project: linxcircle-project-left-column -->
    <div id='linxcircle-project-left-column' style='display: inline-block; float: left; width: 380px; '>

    </div>
    <!-- END left column of project: linxcircle-project-left-column -->

    <!-- START right column of project: linxcircle-project-right-column -->
    <div id='linxcircle-project-right-column' style='display: inline-block; float: right; width: 710px; padding-left: 20px; border-left: 1px solid #dcdcdc; '>
        <div id="project-members-container" style="padding-top: 10px; padding-bottom: 10px; display: none" class="rounded-container">
            <?php
            $close_link = CHtml::link('(' . YII::t('core', 'Close') . ')', '#', array(
                        'onclick' => 'js: $("#project-members-container").slideToggle(); return false;',
                        'style' => 'font-size: 10pt; font-weight: normal;'));

            echo '<div class="header-container">' . YII::t('core', 'Project Members') . ' ' . $close_link . '</div>';

            // PROJECT MANAGER
            echo '<h5>' . YII::t('core', 'Project Manager') . '</h5>';
            $pmModel = ProjectMember::model()->findProjectManager($model->project_id);
            $project_master_account_id = $model->findProjectMasterAccount();
            if (Permission::checkPermission($model, PERMISSION_PROJECT_UPDATE_MANAGER)) {

                // $this->widget('editable.EditableField', array(
                //     'type' => 'select',
                //     'model' => $model,
                //     'attribute' => 'project_manager',
                //     'title' => YII::t('core', 'Check Project Member'),
                //     'url' => $this->createUrl('projectMember/ajaxUpdateProjectManager', array(
                //         'id' => ($pmModel ? $pmModel->project_member_id : 0),
                //         'project_id' => $model->project_id)),
                //     'source' => $this->createUrl('accountTeamMember/dropdownSource', array('account_id' => $project_master_account_id)),
                //     'placement' => 'right',
                // ));
            } else {
                echo ($model->project_manager ? AccountProfile::model()->getShortFullName($model->project_manager) : '');
            }

            echo '<h5>' . YII::t('core', 'Project Members') . '</h5>';
            ?>
            <div id="members-list">
            <?php
            // if user doesn't have permission to update member
            // simply show members here without editable widget.
            if (!Permission::checkPermission($model, PERMISSION_PROJECT_UPDATE_MEMBER)) {
                $members = explode(',', $model->project_member);
                foreach ($members as $mem_account_id) {
                    echo AccountProfile::model()->getShortFullName($mem_account_id) . ' ';
                }
            }
            ?>
            </div>

                <?php
                // show members and editable widget if user has permission to update member
                if (Permission::checkPermission($model, PERMISSION_PROJECT_UPDATE_MEMBER)) {
                    // $this->widget('editable.EditableField', array(
                    //     'type' => 'checklist',
                    //     'model' => $model,
                    //     'attribute' => 'project_member',
                    //     'placement' => 'right',
                    //     'emptytext' => 'Update',
                    //     'url' => $this->createUrl('projectMember/create'),
                    //     'params' => array('id' => 'bootstrap-x-editable'), // to tell server that this submission is by boostrap x-editable
                    //     'source' => $this->createUrl('accountTeamMember/dropdownSource', array('account_id' => $project_master_account_id)), // $account_team_member_list_items,
                            
                    //           'options' => array(
                    //           'display' => "js: function(value, sourceData) {
                    //           var checked, html = '';
                    //           checked = $.grep(sourceData, function(o){
                    //           return $.grep(value, function(v){
                    //           return v == o.value;
                    //           }).length;
                    //           });

                    //           $.each(checked, function(i, v) {
                    //           html+= '<a>' + $.fn.editableutils.escape(v.text) + '</a>&nbsp;';
                    //           });
                    //           if(html) html = ''+html+'';
                    //           $('#members-list').html(html);
                    //           }",
                    //           ),
                    // ));
                } // end if checking permission for show editable widget

                echo '<br/><br/>';
                echo CHtml::link('<i class="icon-plus-sign"></i>&nbsp;' . YII::t('core', 'Invite member to LinxCircle'), array('/accountInvitation/admin'));
                ?>
        </div> <!-- #project-members-container -->

        <div id="project-info-container" style="display: none" class="rounded-container">
            <?php
            $close_link = CHtml::link('(' . YII::t('core', 'Close') . ')', '#', array(
                        'onclick' => 'js: $("#project-info-container").slideToggle(); return false;',
                        'style' => 'font-size: 10pt; font-weight: normal;'));

            echo '<div class="header-container">' . YII::t('core', 'Project Information') . ' ' . $close_link . '</div>';

            echo '<div>';
            echo '<strong>' . YII::t('core', 'Description') . ': </strong>';
            if (Permission::checkPermission($model, PERMISSION_PROJECT_UPDATE_GENERAL_INFO)) {
                echo '<a href="#" id="edit-project-description"><i class="icon-pencil"></i></a>';
            }

            echo "<div id='project_description'";
            echo " data-pk='$model->project_id' data-type='textarea' data-toggle='manual' 
                            data-original-title='Update Description'>";
            echo $model->project_description;
            echo "</div>"; // #project_description
            echo "</div>";

            echo "<br/>";
            echo "<strong>" . YII::t('core', 'Priority') . ": </strong>";
            if (Permission::checkPermission($model, PERMISSION_PROJECT_UPDATE_GENERAL_INFO)) {
                $this->widget('editable.EditableField', array(
                    'type' => 'select',
                    'model' => $model,
                    'attribute' => 'project_priority',
                    'url' => $this->createUrl('default/ajaxUpdateField'),
                    //since 1.1.0 source must be string for remote loading (not array Yii route!)
                    'source' => Project::getPriorityArray(),
                    'placement' => 'right',
                ));
            } else {
                echo $model->getPriorityName();
            }

            echo "<br/>";
            echo "<strong>" . YII::t('core', 'Start Date') . ": </strong>";
            if (Permission::checkPermission($model, PERMISSION_PROJECT_UPDATE_GENERAL_INFO)) {
                echo '<div style="display: inline">';
                $this->widget('editable.EditableField', array(
                    'type' => 'date',
                    'model' => $model,
                    'attribute' => 'project_start_date',
                    'url' => $this->createUrl('default/ajaxUpdateField'),
                    'placement' => 'right',
                    'viewformat' => 'dd MM yyyy',
                    'value'		  => $model->project_start_date,
                    'text' => Utilities::displayFriendlyDate($model->project_start_date),
                ));
                echo '</div>';
            } else {
                echo $model->project_start_date;
            }

            if (Permission::checkPermission($model, PERMISSION_PROJECT_UPDATE_GENERAL_INFO)) {
                echo "<br/>";
                echo '<strong>' . YII::t('core', 'Use Simple View') . ': </strong>';
                $this->widget('editable.EditableField', array(
                    'type' => 'select',
                    'model' => $model,
                    'attribute' => 'project_simple_view',
                    'url' => $this->createUrl('default/ajaxUpdateField'),
                    //since 1.1.0 source must be string for remote loading (not array Yii route!)
                    'source' => array('0' => 'No', '1' => 'Yes'),
                    'placement' => 'right',
                ));
            }

            if (Permission::checkPermission($model, PERMISSION_PROJECT_UPDATE_GENERAL_INFO)) {
                echo "<br/>";
                echo '<strong>' . YII::t('core', 'Use Milestone as Main View') . ': </strong>';
                $this->widget('editable.EditableField', array(
                    'type' => 'select',
                    'model' => $model,
                    'attribute' => 'project_ms_method',
                    'url' => $this->createUrl('default/ajaxUpdateField'),
                    //since 1.1.0 source must be string for remote loading (not array Yii route!)
                    'source' => array('0' => 'No', '1' => 'Yes'),
                    'placement' => 'right',
                ));
            }
            ?>

        </div><!-- #project-info-container -->

        <div id="project-content" style="display: none">
            <!--<div class="header-container" style="">
                Activities &AMP; Resources</div>-->
            <?php
// tabs
            $project_tabs = array();

            // we want to programmatically determine the
            // position of each tab, depending on the config of project
            $tab_index_main = $tab_index_task = $tab_index_issue = $tab_index_document = $tab_index_wiki = $tab_index_implementation = $tab_index_milestone = 0;
            if ($model->project_ms_method) {
                // milestone view as main view
                // we show milestone, implementation, document and wiki
                $tab_index_main = 0;
                $tab_index_milestone = 1;
                $tab_index_implementation = 2;
                $tab_index_document = 3;
                $tab_index_wiki = 4;
            } else {
                // we show
                // tasks, issues, milestone, implementation, document, wiki
                $tab_index_main = 0;
                $tab_index_task = 1;
                $tab_index_issue = 2;
                $tab_index_milestone = 3;
                $tab_index_implementation = 4;
                $tab_index_document = 5;
                $tab_index_wiki = 6;
            }

            // show tasks and issues only for non-milestone-as-main view
            
            $project_tabs[$tab_index_main] = array(
                    'label' => YII::t('core', 'Dự án') . ' ' . $this->widget('bootstrap.widgets.TbBadge', array(
                        'type' => '#111',
                        'label' => count(Project::model()->findAll()),
                            ), true),
                    'content' => $this->renderPartial('project_all', array(
                        'model' => $model,
                        'documentModel' => $documentModel,
                            ), true),
                    'active' => ($selected_tab == 'documents' ? true : false));
            if (!$model->project_ms_method) {
                $project_tabs[$tab_index_task] = array(
                    'label' => YII::t('core', 'Công việc') . ' ' . $this->widget('bootstrap.widgets.TbBadge', array(
                        'type' => 'warning',
                        'label' => count(Task::model()->findAll('project_id IN ('.$model->project_id.')'))
                            ), true),
                    'content' => $this->renderPartial('_index_tasks', array(
                        'model' => $model,
                        'taskModel' => $taskModel,
                            ), true),
                    'active' => ($selected_tab == 'tasks' || $selected_tab == '' ? true : false));
            }

            // // Milestone tab
            // $project_tabs[$tab_index_milestone] = array(
            //     'label' => $model->project_ms_method ? YII::t('core', 'Main') : YII::t('core', 'Milestones'),
            //     'content' => '<div id="LC-project-tab-milestone-' . $model->project_id . '"></div>',
            //     'active' => ($selected_tab != 'implementations' &&
            //     $selected_tab != 'wikihome' && $model->project_ms_method) ? true : false,
            // );
            
            // documents tab
            $project_tabs[$tab_index_document] = array(
                    'label' => YII::t('core', 'Văn bản') . ' ' . $this->widget('bootstrap.widgets.TbBadge', array(
                        'type' => 'success',
                        'label' => count(Documents::model()->findAll('document_parent_id IN ('.$model->project_id.')')),
                            ), true),
                    'content' => $this->renderPartial('_index_documents', array(
                        'model' => $model,
                        'documentModel' => $documentModel,
                            ), true),
                    'active' => ($selected_tab == 'documents' ? true : false));

            // wiki tab
            $project_tabs[$tab_index_wiki] = array(
                    'label' => YII::t('core', 'Wiki') . ' ' . $this->widget('bootstrap.widgets.TbBadge', array(
                        'type' => 'info',
                        'label' => count(WikiPage::model()->findAll('project_id IN ('.$model->project_id.')')),
                            ), true),
                    'content' => $this->renderPartial('wiki_all', array(
                        'model' => $model,
                        'documentModel' => $documentModel,
                            ), true),
                    'active' => ($selected_tab == 'documents' ? true : false));
            // calendar tab

            /**\\
              $project_tabs[] = array(
              'label' => 'Calendar',
              'content'=> $this->renderPartial('_calendar', array(
              'model'=>$model,
              'active_projects'=>array($model->project_id => $model->project_name,),
              ), true, true),
              'active' => false,
              );* */
            $this->widget('bootstrap.widgets.TbTabs', array(
                'type' => 'tabs', // 'tabs' or 'pills'
                'encodeLabel' => false,
                'htmlOptions' => array('id' => 'linxcircle-project-tabs-' . $model->project_id, 'style' => 'margin-top: -11px;'),
                'tabs' => $project_tabs));
            ?>
        </div> <!--  end #project-content -->
            <?php
            echo '<br/><br/>';
            // ARCHIVE FORM AND DELETE
            if (Permission::checkPermission($model, PERMISSION_PROJECT_UPDATE_GENERAL_INFO)) {
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'project-archive-form',
                    'enableAjaxValidation' => false,
                    'action' => array('default/update', 'id' => $model->project_id),
                ));

                // if already archived, allow unlock
                if ($model->project_status == PROJECT_STATUS_ARCHIVED) {
                    echo $form->hiddenField($model, 'project_status', array('value' => PROJECT_STATUS_ACTIVE));
                    $label_tmp = YII::t('core', 'Unlock from Archive');
                } else {
                    echo $form->hiddenField($model, 'project_status', array('value' => PROJECT_STATUS_ARCHIVED));
                    $label_tmp = YII::t('core', 'Archive & Lock Project');
                }
                echo CHtml::link('<i class="icon-th"></i>&nbsp;' . $label_tmp, '#', array('onclick' => 'js: $("#project-archive-form").submit(); return false;'));

                $this->endWidget();
                echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                //EXPORT
                // echo CHtml::link('<i class="icon-share"></i>&nbsp;' . YII::t('core', 'Export Project Resouce Report'), Yii::app()->createUrl('/project/projectResourceReport', array('project_id' => $model->project_id, 'ajax' => 1)));
            }

            if (Permission::checkPermission($model, PERMISSION_PROJECT_DELETE)) {
                echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                // DELETE
                echo CHtml::ajaxLink('<i class="icon-trash"></i>' . YII::t('core', 'Delete Project'), array('default/delete', 'id' => $model->project_id), array(
                    'success' => 'function(data){
                                        if (data == "success")
                                        {
                                                var url = "' . Yii::app()->createUrl(Utilities::getCurrentlySelectedSubscription() . '/') . '";
                                                workspaceLoadContent(url);
                                                workspacePushState(url);
                                        }
                                }',
                    'id' => 'ajax-link' . uniqid(),
                    'type' => 'POST'), array('live' => false, 'confirm' => 'Are you sure to delete this project?')
                );
            }
            ?>
    </div>
    <!-- END right column of project: linxcircle-project-right-column -->



    <div style="display: block; overflow: visible; height: auto; padding-top: 5px; padding-bottom: 40px; ">
            <div style="float: left">
        <?php
        // new task link
        
          $taskTemp = new Task();
          $taskTemp->project_id = $model->project_id;
          if (Permission::checkPermission($taskTemp, PERMISSION_TASK_CREATE))
          {
          

          // If not simple view, show issue and task link
          if (!$model->project_simple_view)
          {
          // echo Utilities::workspaceLink("New Issue", array('issue/create',
          // 'project_id' => $model->project_id,
          // 'project_name' => $model->project_name),
          // array('class' => 'simple-action') );
          }
          }
        ?>
            </div>
    <div style="float: right;">
    <?php
    
      // // REFRESH LINK
      // echo Utilities::workspaceLink('<i class="icon-refresh"></i>Refresh',
      // array(
      // 'default/view',
      // 'id' => $model->project_id),
      // array('class' => 'blur'));
      // echo '&nbsp;';
      // echo CHtml::link('<i class="icon-user"></i>Members', '#',
      // array(
      // 'onclick' => 'js: $("#project-info-container").hide();
      // $("#project-members-container").slideToggle(); return false;',
      // 'class' => 'blur'));
      // echo '&nbsp;';
      // echo CHtml::link('<i class="icon-info-sign"></i>Project information', '#',
      // array(
      // 'onclick' => 'js: $("#project-members-container").hide();
      // $("#project-info-container").slideToggle(); return false;',
      // 'class' => 'blur'));
     
    ?>		
    </div-->
    <!--/div-->
</div>
<!-- END linxcircle-project-main-body-container -->

<script language="javascript">
    var lcSideBarShown = true;

    function lcProjectToggleSideBar()
    {
        var rightColID = "#linxcircle-project-right-column";
        var leftColID = "#linxcircle-project-left-column";

        if (lcSideBarShown)
        {
            $(leftColID).hide();
            $(rightColID).css({width: '100%'});
        } else {
            $(rightColID).css({width: '710px'});
            /**$.get("<?php //echo Yii::app()->createUrl('/project/loadOverviewPanel', array('id' => $model->project_id,'ajax' => '1', 'ms_chart' => 1));?>",
                    function(data) {
                        removeWorkspaceClickEvent(null);
                        $(leftColID).html(data);
                        addWorkspaceClickEvent(null);
                        $(leftColID).show();
                    });**/
        }

        lcSideBarShown = !lcSideBarShown;
    }

    $(document).ready(function() {
        lcProjectToggleSideBar();
<?php
if (Permission::checkPermission($model, PERMISSION_PROJECT_UPDATE_GENERAL_INFO)) {
    ?>
            $("#edit-project-description").click(function(e) {
                e.stopPropagation();
                e.preventDefault();
                $('#project_description').editable({
                    tpl: '<textarea style="width: 600px; height: 100px;"></textarea>',
                    url: '<?php echo $this->createUrl('default/ajaxUpdateField'); ?>'
                });
                $('#project_description').editable('toggle');
            });
    <?php
} // end if check permission for loading description as inline editable
?>

<?php
// if customer account, don't show wiki
if (!AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id)) {
    ?>
            $.get("<?php
    echo Yii::app()->createUrl('wikiPage/index', array('project_id' => $model->project_id,
        'workspace' => '1',
        'tab' => $selected_tab,
        '_' => uniqid(),
        'simple' => YES));
    ?>", function(data) {
                var el = "project-wiki-tab-container-<?php echo (isset($_GET['_']) ? $_GET['_'] : ''); ?>";
                removeWorkspaceClickEvent(null);
                $("#" + el).html(data);
                addWorkspaceClickEvent(null);
            });

    <?php
} // end if showing wiki only to non-customer accounts 
?>


        $("#project-content").fadeIn();
    });
    var load_milestone = 0;

<?php
// if not using ms method, only load ms tab when clicked
if (!$model->project_ms_method) {
    echo "$('#linxcircle-project-tabs-{$model->project_id} li:eq({$tab_index_milestone}) a').click(function (e) {";
}
?>
    if (load_milestone == 0)
    {
        // milestone tab
        $.get("<?php
echo Yii::app()->createUrl('milestone/default/index', array('project_id' => $model->project_id,
    'workspace' => '1'));
?>",
                function(data) {
                    var project_milestone_div = "#LC-project-tab-milestone-<?php echo $model->project_id ?>";
                    removeWorkspaceClickEvent(null);
                    $(project_milestone_div).html(data);
                    addWorkspaceClickEvent(null);
                });
    }

    load_milestone = 1;
<?php
// if not using ms method, only load ms tab when clicked
if (!$model->project_ms_method) {
    echo ('});'); // close event click function
}
?>
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