<?php
    $task = Tasks::model()->findByPk($task_id);
    $task_assignee = $task_assignee_arr= TaskAssignees::model()->findAll('task_id='.  intval($task_id));
    $count_task_assignee  = count($task_assignee);
?>
<h3>Task Progress</h3>

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" onclick="AddTaskProcess();return false;">Task Detail</button>


<!-- Modal -->
<div class="modal fade" id="myModal" style="z-index: 0;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Task Details</h4>
        <input type="hidden" id="toal_assign_task" value="<?php echo $count_task_assignee; ?>"  />
      </div>
        <div class="modal-body" style="max-height: 500px;">
          <!-- ==================== SCHEDULE ================================ -->
          <div id="tp-schedule" >
              <h4>Schedule</h4>
              Start: <?php echo CHtml::textField('tp-shedule-start', date('d-m-Y',  strtotime($task->task_start_date)), array('class'=>'span2')); ?>&nbsp;&nbsp;&nbsp;&nbsp;
              End: <?php echo CHtml::textField('tp-shedule-end', date('d-m-Y',  strtotime($task->task_end_date)), array('class'=>'span2')); ?>
          </div>
          <!-- ----------------------END SCHEDULE ------------------------------------ -->
          
          <!-- ==================== INDIVIDUAL PROGRESS ================================ -->
          <div id="tp-individual" style="margin-top: 20px;">
              <h4>Individual Progress</h4>
              <div>
                  <ul style="margin: 0 0 10px 5px;">
                      <?php 
                            $i=0;
                            foreach ($task_assignee as $task_assignee_item) {
                                $i++;
                                $account_id = $task_assignee_item->account_id;
                                $task_progress = TaskProgress::model()->getTaskProgress($task_id, $account_id);
                                if(count($task_progress)>0)
                                {
                      ?>
                      <li style="list-style: none;">
                                <div style="width: 10%; float: left;margin-top: -3px;"><?php echo CHtml::image('images/user.png',$task_progress->account_id,array('width'=>'40')) ?></div>
                                
                                <div style="width: 56%; background: none repeat scroll 0 0 #ccc; float: left;">
                                    <?php echo CHtml::hiddenField('tp_assignee_startAt_'.$i, $task_progress->tp_percent_completed , array('class'=>'span1'));  ?>
                                    <?php echo CHtml::hiddenField('tp_account_'.$i, $account_id, array('class'=>'span1'));  ?>
                                    <div id="tp_assignee_<?php echo $i; ?>" ></div>
                                </div>
                                
                                <div id="percentage_<?php echo $i; ?>" style="width: 5%; float: left;margin-top: 5px; margin-left: 5px;"><?php echo $task_progress->tp_percent_completed.'%'; ?></div>
                                
                                <div style="width: 24%; float: left;padding-left: 20px;">Days:
                                    <?php echo CHtml::textField('tp_days_completed_'.$i, $task_progress->tp_days_completed , array('class'=>'span1'));  ?>
                                </div>
                            </li>
                            <?php }} ?>
                  </ul>
              </div>
              <?php if(count($task_progress)>0) { ?>
              <div style="width: 100%;text-align: right;"><button type="button" class="btn btn-primary" onclick="updateTaskProcess();return false;">Save</button></div>
              <?php } ?>
          </div>
          <!-- ---------------- END INDIVIDUAL PROGRESS -------------------------------------- -->
          
          <!-- ==================== RESOURCE PLANNING ================================ -->
          <div id="trp-resource" style="margin-top: 20px;">
                <h4>Resource Planning</h4>
                <div>
                    <table border="0" style="width: 100%;margin-left: 10px;">
                      <thead>
                          <tr>
                              <td>Personnel</td>
                              <td>Start</td>
                              <td>End</td>
                              <td>Work Load</td>
                              <td>Effort (days)</td>
                          </tr>
                      </thead>
                      <tbody>
                        <?php 
                              $i=0;
                              foreach ($task_assignee as $task_assignee_item) {
                                  $i++;
                                  $account_id = $task_assignee_item->account_id;
                                  $resource_plan = TaskResourcePlan::model()->getTaskResourcePlan($task_id, $account_id);
                                  if(count($resource_plan)){
                        ?>
                          <tr>
                              <td><?php echo CHtml::image('images/user.png',$account_id,array('width'=>'40')) ?> [Name Account]</td>
                              <td><?php echo CHtml::textField('trp-start-'.$i, date('d-m-Y', strtotime($resource_plan->trp_start)), array('class'=>'span1 date')); ?></td>
                              <td><?php echo CHtml::textField('trp-end-'.$i, date('d-m-Y', strtotime($resource_plan->trp_end)), array('class'=>'span1 date')); ?></td>
                              <td><?php echo CHtml::dropDownList('trp-work-load-'.$i, $resource_plan->trp_work_load, TaskResourcePlan::getDataWorkLoad(), array(
                                                                    'class'=>'span1'))?></td>
                              <td>
                                  <?php echo CHtml::textField('trp-effort-'.$i,$resource_plan->trp_effort, array('class'=>'span1')); ?>
                                  <?php echo CHtml::hiddenField('trp_id_'.$i, $resource_plan->trp_id, array('class'=>'span1'));  ?>
                              </td>
                          </tr>
                              <?php }} ?>
                      </tbody>
                  </table>
              </div>
                <?php if(count($resource_plan)>0) { ?>
                <div style="width: 100%;text-align: right;"><button type="button" class="btn btn-primary" onclick="updateTaskResourcePlan(<?php echo $resource_plan->trp_id;?>);return false;">Save</button></div>
                <?php } ?>
          </div>
         <!-- ---------------------------------- END RESOURCE PLANNING ----------------------------------------->
      </div>
<!--      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>-->
    </div>
  </div>
</div>
<script language="javascript">
    $(document).ready(function(){
        
        var date_start = $("#tp-shedule-start").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            date_start.hide();
            var shedule_end = $('#tp-shedule-end').val();
            updateScheduleTask(date_start.getFormattedDate(),shedule_end);
        }).data('datepicker');
        
        var date_end = $("#tp-shedule-end").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            date_end.hide();
            var shedule_start = $('#tp-shedule-start').val();
            updateScheduleTask(shedule_start,date_end.getFormattedDate());
        }).data('datepicker');
        
        var toal_assign_task = $('#toal_assign_task').val();
        for(var i=1;i<=toal_assign_task;i++)
        {
            var id = $('#tp_assignee_'+i);
            var startAt = $('#tp_assignee_startAt_'+i).val();
            sGlide(id,startAt,i);
            
            //Load date Resource date start and sate end
            var id_start = "trp-start-"+i;
            var id_end = "trp-end-"+i;
            
            var date_trp_start = $("#trp-start-"+i).datepicker({
                format: 'dd-mm-yyyy'
            }).on('changeDate',{id:i},function(ev) {
                date_trp_start.hide();
                var shedule_start = $('#tp-shedule-start').val();
                var trp_id = $('#trp_id_'+ev.data.id).val();
                //updateTaskResourcePlan(trp_id,ev.data.id);
            }).data('datepicker');
            
            var date = $("#trp-end-"+i).datepicker({
                format: 'dd-mm-yyyy'
            }).on('changeDate',{id:i},function(ev) {
                date.hide();
                var trp_id = $('#trp_id_'+ev.data.id).val();
                //updateTaskResourcePlan(trp_id,ev.data.id);
            }).data('datepicker');
            
            //load_date(id_end);
        }
//        $('#tp_assignee_1').sGlide({
//            startAt	: 20,
//            pill	: false,
//            width	: 500,
//            height  :32,
//            drag: function(o){
//                console.log(Object.keys(o));
//            },
//        }); 
    });
    
    function AddTaskProcess()
    {
        $('.modal').css({"z-index":"1050"});
        var task_id = <?php echo $task_id; ?>;
        $.ajax({
            'type':'POST',
            'url':'<?php echo $this->createUrl('AddTaskProcess'); ?>',
            'data':{task_id:task_id},
            'success':function()
            {
                
            }
        });
    }
    
    function sGlide(id,startAt,stt)
    {
        $(id).sGlide({
            startAt	: startAt,
            pill	: false,
            width	: 500,
            height  :32,
            drop:function(o)
            {
            	var val = Math.round(o.percent);
		$('#percentage_'+stt).html(val+'%');
                var account_id = $('#tp_account_'+stt).val();
                $('#tp_assignee_startAt_'+stt).val(val);
//                updateTaskProcess(account_id,stt,o.percent);
            }
        }); 
    }
    
    function load_date(id)
    {
        var date = $("#"+id).datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            date.hide();
        }).data('datepicker');
    }
    
    function updateTaskResourcePlan(trp_id)
    {

        var trp_start = "";
        var trp_end = "";
        var trp_work_load = "";
        var trp_effort = "";
        var trp_id ="";
        var toal_assign_task = $('#toal_assign_task').val();
        for(var i=1;i<=toal_assign_task;i++)
        {
            trp_id += '&trp_id[]='+$('#trp_id_'+i).val();
            trp_start += '&trp_start[]='+$('#trp-start-'+i).val();
            trp_end += '&trp_end[]='+$('#trp-end-'+i).val();
            trp_work_load += '&trp_work_load[]='+$('#trp-work-load-'+i).val();
            trp_effort += '&trp_effort[]='+$('#trp-effort-'+i).val();
        }
        
        var manggiatri= trp_id+trp_start+trp_end+trp_work_load+trp_effort;
        
        $.ajax({
            'type':'POST',
            'url':'<?php echo $this->createUrl('/task_progress/taskResourcePlan/update'); ?>',
            'beforeSend':function(){
                var toal_assign_task = $('#toal_assign_task').val();
                var total_trp_work_load = 0;
                for(var i=1;i<=toal_assign_task;i++)
                {
                    total_trp_work_load += parseFloat($('#trp-work-load-'+i).val());
                }
                if(total_trp_work_load<=100)
                {
                    return true;
                }
                else
                {
                    alert("Work load value not allowed over 100");
                    return false;
                }
            },
            'data':manggiatri,
            'success':function(){},
        });
    }
    
    function updateTaskProcess()
    {
        var task_id = <?php echo $task_id; ?>;
//        var days_compl = $('#tp_days_completed_'+stt).val();
//        var percent_completed ="";
//        if(per_comp==undefined)
//        {
//            percent_completed = $('#tp_assignee_startAt_'+stt).val();
//        }
//        else
//        {
//            percent_completed = per_comp.toFixed(0);
//        }
        
        var toal_assign_task = $('#toal_assign_task').val();
        var days_compl = "";
        var percent_completed = "";
        var account_id="";
        for(var i=1;i<=toal_assign_task;i++)
        {
            account_id += '&account_id[]='+$('#tp_account_'+i).val();
            days_compl += '&days_compl[]='+$('#tp_days_completed_'+i).val();
            percent_completed += '&percent_completed[]='+$('#tp_assignee_startAt_'+i).val();
        }
        var manggiatri = '&task_id='+task_id+account_id+days_compl+percent_completed;
            $.ajax({
                'type':'POST',
                'url':'<?php echo $this->createUrl('/task_progress/taskProgress/update'); ?>',
                'data':manggiatri,
                'success':function(){},
            });
    }
    
    function updateScheduleTask(task_start,task_end)
    {
        var task_id = <?php echo $task_id; ?>;
        
       $.ajax({
            'type':'POST',
            'url':'<?php echo $this->createUrl('updateScheduleTask'); ?>',
            'data':{task_id:task_id,task_start:task_start,task_end:task_end},
            'success':function(){},
        });
    }
    
</script>
