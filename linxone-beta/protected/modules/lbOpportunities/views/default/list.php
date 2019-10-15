<?php 
  if(isset($category_id))
    {
        $date_form = DateTime::createFromFormat('d-m-Y', $date_from)->format('Y-m-d');
        $date_to = DateTime::createFromFormat('d-m-Y', $date_to)->format('Y-m-d');
        $model = LbOpportunity::model();
        $model->from_date=$date_form;
        $model->to_date=$date_to;
      
        
    } else {
 ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/css/style.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/js/script.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.js"></script>
<div id="lb-container-header">
            <div class="lb-header-right"><h3>List Opportunities</h3></div>
            <div class="lb-header-left lb-header-left-board-list">
                <a href="#" onclick="add_opportunity();"><i class="icon-plus"></i></a>&nbsp;
                <a href="board?tab=board" onclick=""><i class="icon-th-large"></i></a>&nbsp;
                <a href="#" onclick="export_excel_view();"><i class="icon-download-alt"></i></a>&nbsp;
            </div>
</div><br>
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
        
        <button onclick="save_all_opportunity('list');" type="button" class="btn btn-success" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Popup new task -->
<?php echo Yii::t('lang','From') ?>: <input type="text" id="LbOpportunity_from_date" name="LbOpportunity[deadline]" value="<?php echo date('d-m-Y') ?>">
<?php echo Yii::t('lang','To') ?>: <input type="text" id="LbOpportunity_to_date" name="LbOpportunity[deadline]" value="<?php echo date('d-m-Y') ?>">
<button class="btn btn-success" name="yt0" type="submit" style="margin-top: -10px;" onclick="searchOpp()"><?php echo Yii::t('lang','Search') ?></button>
<?php
}
// $test = Yii::app()->baseUrl."/index.php/lbOpportunities/default/viewdetailopportunity/id".$data->opportunity_id;
// http://localhost/linxbook/index.php/lbOpportunities/default/viewdetailopportunity/id/229
echo '<div id="show_opportunities">';
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_show_opportunities',
            'dataProvider'=>  $model->search(),
            'template' => "{items}\n{pager}\n{summary}", 
            'columns'=>array(
              array(
                  'header'=>Yii::t('lang','Name'),
                  'type'=>'raw',
                  'value'=>function($data){
                    $redirect_opportunity_name = "viewdetailopportunity/id/".$data->opportunity_id;
                    return '<a href="'.$redirect_opportunity_name.'">'.$data->opportunity_name.'</a>';
                  },
              ),
              array(
                  'header'=>Yii::t('lang','Customer'),
                  'type'=>'raw',
                  'value'=>function($data){
                    $customer = LbCustomer::model()->customerInformation($data->customer_id);
                    if(isset($customer->attributes["lb_customer_name"])){
                      return $customer->attributes["lb_customer_name"];
                    } else {
                      return "";
                    }
                  },
                  // 'value'=>'LbCustomer::model()->customerInformation($data->customer_id)->attributes["lb_customer_name"]',
                  'htmlOptions'=>array('width'=>'130','height'=>'40px'),
              ),
              array(
                  'header'=>Yii::t('lang','Industry'),
                  'type'=>'raw',
                  'value'=>function($data){
                    $industry = LbOpportunityIndustry::model()->searchIndustryName($data->industry);
                    if(isset($industry->attributes["industry_name"])){
                      return $industry->attributes["industry_name"];
                    } else {
                      return "";
                    }
                  },
                  // 'value'=>'LbOpportunityIndustry::model()->searchIndustryName($data->industry)->attributes["industry_name"]',
                  'htmlOptions'=>array('width'=>'130','height'=>'40px'),
              ),
              array(
                  'header'=>Yii::t('lang','Value'),
                  'type'=>'raw',
                  'value'=>'$data->value',
                  'htmlOptions'=>array('width'=>'130','height'=>'40px'),
              ),
              array(
                  'header'=>Yii::t('lang','Deadline'),
                  'type'=>'raw',
                  'value'=>'date("d-m-Y", strtotime($data->deadline))',
                  'htmlOptions'=>array('width'=>'130','height'=>'40px'),
              ),
              array(
                  'header'=>Yii::t('lang','Status'),
                  'type'=>'raw',
                  'value'=>function($data){
                    $status = LbOpportunityStatus::model()->searchStatus($data->opportunity_status_id);
                    if(isset($status->attributes["column_name"])){
                      return $status->attributes["column_name"];
                    } else {
                      return "";
                    }
                  },
                  // 'value'=>'LbOpportunityStatus::model()->searchStatus($data->opportunity_status_id)->attributes["column_name"]',
                  'htmlOptions'=>array('width'=>'130','height'=>'40px'),
              ),
            )
        ));
echo '</div>';
?>
<!-- <script>
  
  jQuery('.sp-container').css("display","none");
	load_search_aging_report();
   $('#form_view_list').load('admin');

   function load_search_aging_report(){
       var select_timeRange = $('#select_timeRange').val();
       $('#form_view_list').html('<img src="<?php echo YII::app()->baseUrl; ?>/images/loading.gif" /> Loading...');
       $('#form_view_list').load('AjaxLoadViewList');
   } 
   
</script> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script language="javascript">
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
    $(document).ready(function(){
        var from_date = $("#LbOpportunity_from_date").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            from_date.hide();
        }).data('datepicker');  
        
        var to_date = $("#LbOpportunity_to_date").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            to_date.hide();
        }).data('datepicker');  
    });
    
    function searchOpp()
    {
        var date_from = $('#LbOpportunity_from_date').val();
        var date_to =$('#LbOpportunity_to_date').val();
        $('#show_opportunities').load('SearchOpportunities',{date_from:date_from,date_to:date_to});
      
    }
    
</script>