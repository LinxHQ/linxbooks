<?php
/* @var $project_id project ID */
/* @var $return_tab name id of tab to return to in main project page */

$items_array = array();
$is_main_project_page = false;
echo '<div id="lb-container-header">
            <div class="lb-header-right" style="margin-left:-11px;"><h3>Dự án</h3></div>
            <div class="lb-header-left">
                &nbsp;
                ';
                if(isset($project->project_id) && isset($project->project_name)){
                    echo Utilities::workspaceLink('<i class="icon-plus icon-white"></i>', array(
                    '/lbProject/task/create', 
                    'project_id' => $project->project_id,
                    'project_name' => $project->project_name,
                    'display' => $this::INDEX_DISPLAY_STYLE_TILE), array(
                        'live' => false, 
                        'style' => "color: #5DA028"));
                }
                echo ' <input placeholder="Search" value="" style="border-radius: 15px; margin-top: 3px;" onkeyup="search_name_invoice(this.value);" type="text">
            </div>
</div><br>';
?>

<div id="project-name-container" class="container-header">
	<h3><?php
	if (isset($project))
	{
            // show PM's photo
            $projectManager = ProjectMember::model()->getProjectManager($project->project_id);
            if ($projectManager != null) {
                echo AccountProfile::model()->getProfilePhoto($projectManager->account_id, false, 30, 'margin-top: -5px;');
            }
            
            $is_main_project_page = true;
		// being called by project main page
		// if (Permission::checkPermission($project, PERMISSION_PROJECT_UPDATE_GENERAL_INFO))
		// {
		// 	$this->widget('editable.EditableField', array(
		// 			'type' => 'text',
		// 			'model' => $project,
		// 			'attribute' => 'project_name',
		// 			'url' => $this->createUrl('default/ajaxUpdateField'),
		// 			'placement' => 'right',
		// 	));
		// } else {
		// 	echo $project->project_name;
		// }
	} else {
		// being caleld by other pages of project
		$project = Project::model()->findByPk($project_id);
		// echo CHtml::link(
		// 		($project ? '<i style="margin-top: 7px;" class="icon-chevron-left"></i> '.$project->project_name : '-'),
		// 		'',
		// 		//array('project/view', 'id' => $project_id, 'tab' => $return_tab), // Yii URL
		// 		//array('update' => '#content'), // jQuery selector
		// 		array('id' => 'ajax-id-'.uniqid(), 'data-workspace' => '1', 
		// 				'href'=>CHtml::normalizeUrl($project->getProjectURL()) . "?tab=$return_tab")
		// );
		
		// actions array
                /**
		$create_new_items_array = array();
		$create_new_items_array[] = array('label'=>'New Task', 'url'=> array('task/create',
						'project_id' => $project->project_id,
						'project_name' => $project->project_name,
						'data-workspace'=>'1'));
		
		// show if not simple view
		if (!$project->project_simple_view)
		{
			$create_new_items_array[] = array('label'=>'New Issue', 'url'=>array('issue/create',
							'project_id' => $project->project_id,
							'project_name' => $project->project_name,
							'data-workspace'=>'1'));
			$create_new_items_array[] = array('label'=>'New Implementation', 'url'=>array('implementation/create',
							'project_id' => $project->project_id,
							'project_name' => $project->project_name,
							'data-workspace'=>'1'));
		}
                 * 
                 */
		//$items_array[] = '---';
	}
	
	// show archived?
    echo "<div style='text-align: right; margin-right: 20px;'>";
        if ($project->project_status == PROJECT_STATUS_ARCHIVED)
        {
            echo '&nbsp;&nbsp;';
            $this->widget('bootstrap.widgets.TbBadge', array(
                    'type'=>'inverse', // 'success', 'warning', 'important', 'info' or 'inverse'
                    'label'=>YII::t('core','ARCHIVED'),
            ));
        }
	echo "</div>";
	?>
			
	</h3>
	<!-- <div class="pull-right btn-toolbar"> -->
        <?php 
//         //
//         // New items dropdown
//         //
//         echo '<div class="btn-group" style="padding-right: 0px;">';
//         echo '<a href="#" class="btn dropdown-toggle" data-toggle="dropdown" '
//             . 'style="border: none; background: none; box-shadow: none;">';
//         echo '<i class="icon-plus"></i> '.YII::t('core','New').'</a>';
//         echo '<ul class="dropdown-menu" id="yw1">';
        
//         // new task
//         $taskTemp = new Task();
// 	$taskTemp->project_id = $project->project_id;
// 	if (Permission::checkPermission($taskTemp, PERMISSION_TASK_CREATE))
// 	{
//             echo '<li>';
//             echo Utilities::workspaceLink(YII::t('core','New Task'), array(
//                 '/lbProject/task/create',
//                 'project_id' => $project->project_id,
//                 'project_name' => $project->project_name));
//             echo '</li>'; // end new task item
//         }
        
//         // show if not simple view
// 	if (!$project->project_simple_view)
// 	{
//             // new issue
//             echo '<li>';
//             echo Utilities::workspaceLink('New Issue', array(
//                '/issue/create',
//                'project_id' => $project->project_id,
//                'project_name' => $project->project_name));
//             echo '</li>'; // end new issue item
            
// //            // new implementation
// //            $implTemp = new Implementation();
// //            $implTemp->project_id = $project->project_id;
// //            if (Permission::checkPermission($implTemp, PERMISSION_IMPLEMENTATION_CREATE))
// //            {
// //                echo '<li>';
// //                echo Utilities::workspaceLink(YII::t('core','New Implementation'), array(
// //                    '/implementation/create',
// //                    'project_id' => $project->project_id,
// //                    'project_name' => $project->project_name));
// //                echo '</li>'; // end new implementation item
// //            }
//         } // end new issue, new implementtion if-block;
        
//         // new Wiki
//         echo '<li>';
//         echo Utilities::workspaceLink(YII::t('core','New Wiki Page'), array(
//             '/wikiPage/create',
//             'project_id' => $project->project_id,
//             'project_name' => $project->project_name));
//         echo '</li>'; // end new wiki page item
        
//         echo '</ul>'; // end list of menu items
//         echo '</div>'; // end btn group for new item
//         // END new item dropdown
        
//         //
//         // Jump to project dropdown
//         //
        
//         // get active projects
// 	$active_projects = Project::model()->getActiveProjects(Yii::app()->user->id,'datasourceArray', true);
//         asort($active_projects);
//         echo '<div class="btn-group" style="padding-right: 0px;">';
//         echo '<a href="#" class="btn dropdown-toggle" data-toggle="dropdown" '
//             . 'style="border: none; background: none; box-shadow: none;">';
//         echo '<i class="icon-th-large"></i> '.YII::t('core','Projects').'</a>';
//         echo '<ul class="dropdown-menu" id="yw1">';
//         foreach ($active_projects as $id=>$proj_name)
// 	{
//             //if ($id == $project->project_id) continue;
            
//             echo '<li>';
//             echo Utilities::workspaceLink(
//                     Utilities::getShortName($proj_name, true, 20), 
//                     Project::model()->getProjectURL($id));
//             echo '</li>';
//         }
//         echo '</ul>'; // end btn group ul block     
//         echo '</div>'; // end btn group for projects list item   
//         // end jump to project dropdown
        
//         // additional item on main page of project
//         if ($is_main_project_page)
//         {
//             //
//             // Settings dropdown
//             //
//             echo '<div class="btn-group" style="padding-right: 0px; margin-left: -10px;">';
//             echo '<a href="#" class="btn dropdown-toggle" data-toggle="dropdown" '
//                 . 'style="border: none; background: none; box-shadow: none;">';
//             echo '<i class="icon-wrench"></i> '.YII::t('core','Settings').'</a>';
//             echo '<ul class="dropdown-menu" id="yw1">';

//             // members
//             echo '<li>';
//             echo CHtml::link(YII::t('core','Members'), '#', 
//                     array(
//                         'onclick' => 'js: $("#project-info-container").hide(); 
//                             $("#project-members-container").slideToggle(); return false;',
//                     ));
//             echo '</li>'; // end members

//             // proj info
//             echo '<li>';
//             echo CHtml::link(YII::t('core','Project Details'), '#', 
//                     array(
//                         'onclick' => 'js: $("#project-members-container").hide(); 
//                             $("#project-info-container").slideToggle(); return false;'
//                     ));// end info
//             echo '</li>';

//             echo '</ul>'; // end btn group ul block     
//             echo '</div>'; // end btn group for projects list item   
//             // end jump to project dropdown

//             // Refresh
//             echo Utilities::workspaceLink('<i class="icon-refresh"></i>'.YII::t('core','Refresh'),
//                     array(
//                         'default/view', 
//                         'id' => $project->project_id),
//                     array(
//                         'class' => 'btn dropdown-toggle',
//                         'style'=>"border: none; background: none; box-shadow: none;  margin-left: -10px;",
//                         )
//                     );
//         }// end additional item block, for main page
//         else
//         {
//             echo '<div class="btn-group" id="linxcircle-task-header" style="padding-right: 0px; margin-left: -10px;">';
//             echo '<a href="#" id="linxcircle-task-header-item" class="btn dropdown-toggle" data-toggle="dropdown" '
//                 . 'style="border: none; background: none; box-shadow: none;" onclick="loadTaskHeader(); return false;">';
//             echo '<i class="icon-list"></i> '.YII::t('core','Tasks').'</a></div>';
            
//             echo '<div class="btn-group" id="linxcircle-issue-header" style="padding-right: 0px; margin-left: -10px;">';
//             echo '<a href="#" id="linxcircle-issue-header-item" class="btn dropdown-toggle" data-toggle="dropdown" '
//                 . 'style="border: none; background: none; box-shadow: none;" onclick="loadIssueHeader(); return false;">';
//             echo '<i class="icon-warning-sign"></i> '.YII::t('core','Issues').'</a></div>';
//         }
        
	
// 	$project_items_array = array();//[] = array('label'=>'SWITCH PROJECT');
// 	foreach ($active_projects as $id=>$proj_name)
// 	{
// 		$project_items_array[] = array(
// 			'label'=> Utilities::getShortName($proj_name, true, 18), 
// 			'url'=>Project::model()->getProjectURL($id),//array('project/view','id' => $id,'data-workspace'=>'1')
// 			'linkOptions'=>array('data-workspace'=>1)
// 		);
// 	}
        
//         // NEW - create new menu 
        
//         if (isset($create_new_items_array))
//         {
//             $this->widget('bootstrap.widgets.TbButtonGroup', array(
//                     'type'=>'', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//                     'encodeLabel'=>false,
//                     'buttons'=>array(
//                         array('label'=>'New', 'items'=>$create_new_items_array),
//                     ),
//                     'htmlOptions'=>array('style'=>'padding-right: 0px;'),
//                 ));	
//         }
        
//         // Switch projects
// 	$this->widget('bootstrap.widgets.TbButtonGroup', array(
// 	        'type'=>'', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//                 'encodeLabel'=>false,
// 	        'buttons'=>array(
// 	            array('label'=>'Switch Project','items'=>$project_items_array),
// 	        ),
//                 'htmlOptions'=>array('style'=>'padding-right: 20px;'),
// 	    ));
         

            
	?>
	<!-- </div> -->
    
</div>
<div id="kuckoo-header-line" class="kuckoo-header-line" style=""></div>
<script type="text/javascript">
        // load when iconis clicked
        linxcircleTaskPopoverLoaded = false;
        linxcircleIssuePopoverLoaded = false;
        function loadTaskHeader() {
            var el = $("#linxcircle-task-header-item");
            
            if (el.popover)
                el.popover('destroy');
            if (linxcircleTaskPopoverLoaded == false)
            {
                el.popover({
                        content: '<?php echo CHtml::image(Yii::app()->baseUrl . '/images/loading.gif');?>', 
                        html: true,
                        placement: 'bottom', 
                        title: '<input id="linx-task-global-search" onkeyup="loadContentTask(\'all_but_issues\',\'task\',1)" class="search-query" type="text"  autocomplete="off" placeholder="<?php echo YII::t('core','Enter issue name or id'); ?>" style="width: 200px;">',
                        template: '<div class="popover" style="width: 450px;left: -250px;max-height:500px;"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'

                    });
                el.popover('show');
                $("#linxcircle-issue-header-item").popover('hide');
                loadContentTask('all_but_issues','task',13);
            } else {
                linxcircleTaskPopoverLoaded = false;
                el.popover('hide');
            }
        }
       
        function loadIssueHeader() {
            var el = $("#linxcircle-issue-header-item");
            
            if (el.popover)
                el.popover('destroy');
            
            if (linxcircleIssuePopoverLoaded == false)
            {
                el.popover({
                        content: '<?php echo CHtml::image(Yii::app()->baseUrl . '/images/loading.gif');?>', 
                        html: true,
                        placement: 'bottom', 
                        title: '<input id="linx-issue-global-search" class="search-query" type="text"  autocomplete="off" placeholder="<?php echo YII::t('core','Enter task name or id'); ?>" style="width: 200px;">',
                        template: '<div class="popover" style="width: 450px;left: -250px;max-height:500px;"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'

                    });
                el.popover('show');
                $("#linxcircle-task-header-item").popover('hide');
                loadContentTask(2,'issue',13);
                linxcircleTaskPopoverLoaded = false;
            } else {
                linxcircleIssuePopoverLoaded = false;
                el.popover('hide');
            }
        }
        
        function loadContentTask(task_type,entry,enter)
        {
            var id = $('#linx-'+entry+'-global-search');
            if(enter==13)
            {
                var WordSearch = $('#linx-'+entry+'-global-search').val();
                $("#linxcircle-"+entry+"-header .popover-content").css('max-height', '430px');
                $("#linxcircle-"+entry+"-header .popover").css('left', '-250px');
                $("#linxcircle-"+entry+"-header .popover.bottom .arrow").css('margin-left', '65px');
                $("#linxcircle-"+entry+"-header .popover-title").css({'display':'block','color':'#000'});
                $("#linxcircle-"+entry+"-header .popover-content").html('<?php echo CHtml::image(Yii::app()->baseUrl . '/images/loading.gif');?>');
                $.ajax({
                  type: "POST",
                  url: workspaceTransformUrl('<?php echo Yii::app()->createUrl('Project/listTaskProjectHeader',array('id'=>$project->project_id)); ?>'),
                  data: {WordSearch:WordSearch,task_type:task_type},
                  success: function(data){
                        $("#linxcircle-"+entry+"-header .popover-content").html(data);
                        $("#linxcircle-"+entry+"-header .popover-content").css('padding', '0px');
                        $("#linxcircle-"+entry+"-header .popover-content").css('padding-top', '5px');
                        $("#linxcircle-"+entry+"-header .popover-content").css('padding-top', '5px');
                        if(entry=="issue")
                        {
                            linxcircleTaskPopoverLoaded = false;
                            linxcircleIssuePopoverLoaded = true
                        }
                        else
                        {
                            linxcircleTaskPopoverLoaded = true;
                            linxcircleIssuePopoverLoaded = false
                        }
                        $(id).keypress(function( event ) {
                          if (event.which == 13 ) {
                             loadContentTask(task_type,entry,13);
                          }
                        });
                  },
                });
            }
        }
      
        
</script>