<div id="lb-container-header">
            <div class="lb-header-right" style="margin-left:-11px;"><h3>Opportunities</h3></div>
            <div class="lb-header-left">
                <a href="#" onclick="add_opportunity();"><i class="icon-plus icon-white"></i></a>&nbsp;
                <a href="list?tab=list"><i class="icon-th-list icon-white"></i></i></a>&nbsp;
                <a href="<?php echo Yii::app()->baseUrl ?>/1/configuration?tab7" onclick=""><i class="icon-wrench icon-white"></i></i></a>
            </div>
</div><br> 
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/css/spectrum.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/js/script.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/js/spectrum.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.js"></script>
<!-- <a data-toggle="modal" data-target="#myModal" href="#" ><i class="icon-plus"></i> New Column</a> <br /> <br /> -->


<!-- Popup new column -->
<div id="myModal" class="modal hide" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Column</h4>
      </div>
      <div class="modal-body">
        <table>
        	<tbody>
        		<tr>
        			<td>Column Name : </td>
        			<td><input type="text" name="column_name" id="column_name"></td>
        		</tr>
        		<tr>
        			<td>Chosse Color :</td>
        			<td><input type='text' id="color_picker" /></td>
        		</tr>
        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button onclick="save_add_column();" type="button" class="btn btn-info">New Column</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Popup new column -->

<!-- Popup new task -->
<div id="new_opportunity" class="modal hide" role="dialog" style="width: auto;">

  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo Yii::t('lang','New') ?> Opportunity</h4>
      </div>
      <div class="modal-body">
        <table width="100%">
    <tbody>
      <div id="check_required"><?php echo Yii::t('lang','Please fill in the fields with') ?> <i class="check_required">* </i>.</div>
      <tr>
        <td width="50%" align="center">
          <table width="100%">
              <tbody>
                <tr>
                  <td><?php echo Yii::t('lang','Name') ?><i class="check_required">*</i> :</td>
                  <td><input id="task_name" type="text" name="task_name" /></td>
                </tr>
                <tr>
                  <td><?php echo Yii::t('lang','Status') ?>:</td>
                  <td>
                    <select class="text" id="status" name="status" style="width: 200px;">
                      <?php 
                        $list_status = LbOpportunityStatus::model()->findAll(array('order'=>'listorder'));
                        echo '';
                        foreach ($list_status as $row) {
                            echo '<option value="'. $row['id'] .'">'.$row['column_name'].'</option>';
                        }
                       ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><?php echo Yii::t('lang','Customers') ?> : </td>
                  <td>
                    <select class="text" id="customer_id" name="customer_id" style="width: 200px;" onchange="load_contact_dropdown();">
                        
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><?php echo Yii::t('lang','Industry') ?> :</td>
                  <td>
                      <div id="popup_new_industry"></div>
                      <select class="text" id="industry" name="industry" style="width: 200px;" onchange="add_industry();">
                          <option value=""> - <?php echo Yii::t('lang','Select a Industry') ?> -</option>
                          <option value="0">- Add new Industry -</option>
                          <?php
                            $list_industry = LbOpportunityIndustry::model()->findAll();
                            foreach ($list_industry as $row) {
                                echo '<option value="'. $row['id'] .'">'. stripcslashes($row['industry_name']) .'</option>';
                            }
                          ?>
                      </select>
                  </td>
                </tr>
                <tr>
                  <td><?php echo Yii::t('lang','Deadline') ?>:</td>
                  <td id="chose_deadline">
                      <input id="view_deadline_task" data-format="dd-mm-yyyy" type="text"></input>
                  </td>
                </tr>
                <tr>
                  <td><?php echo Yii::t('lang','Document') ?> &nbsp;</td>
                  <td>
                    <!-- <input id="document" type="file" name="document" multiple="multiple" /> -->
                    <form method="post" action="SaveAllFiles" enctype="multipart/form-data" id="form_upload_images">
                        <input id="document" name="my_file[]" multiple="multiple" type="file">
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
          <td width="50%" align="center">
            <table width="100%">
              <tbody>
                <tr>
                  <td><?php echo Yii::t('lang','Value') ?>($) :</td>
                  <td><input id="task_value" type="text" name="value" /></td>
                </tr>
                <tr>
                  <td><?php echo Yii::t('lang','Contact') ?> :</td>
                  <td>
                      <select class="text" name="contact_id[]" id="contact_id" style="height: 60px; width: 200px;" multiple="multiple"></select>
                  </td>
                </tr>
                <tr>
                  <td><?php echo Yii::t('lang','Staff') ?> : </td>
                  <td>
                      <select class="text" name="task_staf[]" id="task_staf" style="height: 60px; width: 200px;" multiple="multiple">
                      <?php 
                        $list_staf = LbEmployee::model()->findAll();
                        foreach ($list_staf as $row) {
                            echo '<option value="'. $row['lb_record_primary_key'] .'">'.$row['employee_name'].'</option>';
                        }
                       ?>
                      </select>
                  </td>
                </tr>
                <tr>
                  <td><?php echo Yii::t('lang','Note') ?> :</td>
                  <td>
                    <textarea id="task_note" style="width: 300px; height: 90px;" name="note"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
      </div>
      <div class="modal-footer">
        
        <button onclick="save_all_opportunity('board');" type="button" class="btn btn-success" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Popup new task -->

<!-- Popup add new Customer -->
<div id="popup_add_new_customers" class="modal hide" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Customer</h4>
      </div>
      <div class="modal-body">
        <p>Fields with <i class="check_required">*</i> are required.</p>
        <label>Name<i class="check_required">*</i> : </label>
        <input type="text" id="name_customer_popup" />
        <label>Website : </label>
        <input type="text" id="website_customer_popup" />
      </div>
      <div class="modal-footer">
          <button onclick="save_popup_new_customer();" style="margin-left: auto; margin-right: auto" class="btn btn-success" type="submit" >
            <i class="icon-ok icon-white"></i>&nbsp;Save
        </button>
      </div>
    </div>

  </div>
</div>
<!-- End Popup add new Customer -->

<div class="container-fluid container-fluid-board">
    <div id="sortableKanbanBoards" class="">
		<?php
      $list_column = LbOpportunityStatus::model()->findAll(array('order'=>'listorder'));
			foreach($list_column as $result_list_column){
		 ?>
	        <div class="panel panel-primary kanban-col" id="<?php echo $result_list_column['id']; ?>">
	            <div class="panel-heading">
	                <h4><?php echo $result_list_column['column_name'] ?></h4>
	                <i class="fa fa-2x fa-plus-circle pull-right"></i>
	            </div>
              <div id="color_line" style="background-color: <?php echo $result_list_column['column_color'] ?>;"></div>
	            <div class="panel-body opp">
                  <?php
                    $list_opportunity = LbOpportunity::model()->findAll('opportunity_status_id IN ('.$result_list_column['id'].')');
                    foreach($list_opportunity as $result_list_opportunity){
                        if($result_list_opportunity['customer_id'] > 0) {
                        $list_customers = LbCustomer::model()->findAll('lb_record_primary_key IN ('.$result_list_opportunity['customer_id'].')');
                        foreach ($list_customers as $result_list_customers){
                        ?>
  	                <div id="TODO" class="kanban-centered" data="<?php echo $result_list_opportunity['opportunity_id']; ?>">
  	                    <article class="kanban-entry grab" id="<?php echo $result_list_opportunity['opportunity_id']; ?>" draggable="true">
  	                        <div class="kanban-entry-inner">
  	                            <div class="kanban-label">
                                    <div id="line1"><a href="#" class="text-left"><p class="opp_name"><?php echo CHtml::link($result_list_opportunity['opportunity_name'], $this->createAbsoluteUrl('default/viewdetailopportunity',array('id'=>$result_list_opportunity['opportunity_id']))); ?></p></a></div>
  	                                <div id="line2"><?php echo $result_list_customers['lb_customer_name']?></div>
                                    <div id="line3">
                                        <a style="background-color: <?php echo $result_list_column['column_color'] ?>;" id="line3_left" href="#" onclick="edit_column();"></a>
                                        <div id="line3_right"><?php echo $result_list_opportunity['deadline']; ?></div>
                                    </div>
                                </div>
  	                        </div>
  	                    </article>
  	                </div>
                        
                        
                    <?php 
                  
                    } } else {
                    ?>
                        <div id="TODO" class="kanban-centered" data="<?php echo $result_list_opportunity['opportunity_id']; ?>">
  	                    <article class="kanban-entry grab" id="<?php echo $result_list_opportunity['opportunity_id']; ?>" draggable="true">
  	                        <div class="kanban-entry-inner">
  	                            <div class="kanban-label">
                                    <div id="line1"><a href="#" class="text-left"><p class="opp_name"><?php echo CHtml::link($result_list_opportunity['opportunity_name'], $this->createAbsoluteUrl('default/viewdetailopportunity',array('id'=>$result_list_opportunity['opportunity_id']))); ?></p></a></div>
  	                                
                                    <div id="line3">
                                        <a style="background-color: <?php echo $result_list_column['column_color'] ?>;" id="line3_left" href="#" onclick="edit_column();"></a>
                                        <div id="line3_right"><?php 
                                            if($result_list_opportunity['deadline'] != '0000-00-00'){
                                                echo $result_list_opportunity['deadline']; 
                                            }
                                        ?></div>
                                    </div>
                                </div>
  	                        </div>
  	                    </article>
  	                </div>
                    <?php
                    }
                    }
                    ?>
	            </div>
	            <!-- <div class="panel-footer">
	                <a href="#">Add Opportunity...</a>
	            </div> -->
	        </div>
		<?php } ?>
    </div>
</div>
<div id="popup_update_column"></div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
  $('#customer_id').load('LoadCustomers');
  function add_industry(){
    var industry = $("#industry").val();
    if(industry == 0){
      window.location.href = "<?php echo Yii::app()->baseUrl ?>/1/configuration";
    }
  }
  function save_popup_new_customer()
  {
    var name_customer_popup = $("#name_customer_popup").val();
    var website_customer_popup = $("#website_customer_popup").val();
    $.ajax({
        type:"POST",
        url:"SaveCustomerPopup", 
        data: {name_customer_popup:name_customer_popup, website_customer_popup:website_customer_popup},
        success:function(data){
            $('#popup_add_new_customers').modal('toggle');
            $('#customer_id').load('LoadCustomers');
        }
        });
    }
</script>