<?php 
	$opportunity_id = $_GET['id'];
	$list_opportunity = LbOpportunity::model()->findAll('opportunity_id IN ('.$opportunity_id.')');
	if(isset($list_opportunity[0]['customer_id'])){
	$customer_id = $list_opportunity[0]['customer_id'];
 ?>
<div id="lb-container-header">
            <div class="lb-header-right"><h3><?php echo $list_opportunity[0]['opportunity_name']; ?></h3></div>
            <div class="lb-header-left lb-header-left-view-detail-opp">
                &nbsp;
                <a data-workspace="1" class="btn" href="#" onclick="delete_opportunity(<?php echo $opportunity_id ?>);">Delete</a>
            </div>
</div><br>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/css/spectrum.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/js/script.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/js/spectrum.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.js"></script>
<?php 
	$document_name = "";
    $list_document = LbOpportunityDocument::model()->findAll('opportunity_id IN ('.$opportunity_id.')');
    foreach($list_document as $result_return_list_document){
    	$document_name .= '<a target="_blank" href="'.Yii::app()->basePath.'\modules\lbOpportunities\document_upload'.basename($opportunity_id.'_'.$result_return_list_document["opportunity_document_name"]).'">'.$result_return_list_document['opportunity_document_name'].'</a> , ';
    }
?>
<div class="accordion-group">
	<div class="accordion-heading" id="form_info_opp">
      <span style="color: #fff;font-size: 14px; font-weight: bold">Information</span>
    </div>
	<div id="form_info_opps" class="accordion-body collapse in">
      	<div class="accordion-inner">
      		<table>
				<tbody>
					<tr>
						<td>
							<!-- left -->
							<table style="margin-left: 30px;">
								<tbody>
									<tr>
										<td>Name:</td>
										<td><input type="text" name="name" id="name" value="<?php echo $list_opportunity[0]['opportunity_name']; ?>"></td>
									</tr>
									<tr>
										<td>Customer:</td>
										<td>
										<select class="text" id="customer_id" name="customer_id" style="width: 200px;">
					                        <option value=""> - Select a Customer -</option>
					                            <?php
					                                $list_customer = LbCustomer::model()->findAll();
					                                if (sizeof($list_customer) > 0) {
					                                    foreach ($list_customer as $row) {
					                                        $company_id = $row['lb_record_primary_key'];
					                                        // echo '<option value="'. $row['lb_record_primary_key'] .'">'. stripcslashes($row['lb_customer_name']) .'</option>';
					                                        if (isset($company_id) && intval($company_id) == intval($customer_id))
					                                            echo '<option value="'. $row['lb_record_primary_key'] .'" selected>'. stripcslashes($row['lb_customer_name']) .'</option>';
					                                        else
					                                            echo '<option value="'. $row['lb_record_primary_key'] .'">'. stripcslashes($row['lb_customer_name']) .'</option>';
					                                    }
					                                }
					                            ?>
					                    </select>
										</td>
									</tr>
									<tr>
										<td>Industry:</td>
										<td>
			                               <select class="text" id="industry" name="industry" style="width: 200px;">
					                          <option value=""> - Select a Industry -</option>
					                          <?php
					                            $list_industry = LbOpportunityIndustry::model()->findAll();
					                            foreach ($list_industry as $row) {
					                            	if ($row['id'] == intval($list_opportunity[0]['industry']))
			                                            echo '<option value="'. $row['id'] .'" selected>'. stripcslashes($row['industry_name']) .'</option>';
			                                        else
			                                            echo '<option value="'. $row['id'] .'">'. stripcslashes($row['industry_name']) .'</option>';
					                            }
					                          ?>
					                      </select>
										</td>
									</tr>
									<tr>
										<td>Value:</td>
										<td><input type="text" name="value" id="value" value="<?php echo $list_opportunity[0]['value']; ?>"></td>
									</tr>
									<tr>
										<td>Deadline:</td>
										<td id="chosse_date">
											<?php
												 $deadline = date("d-m-Y",  strtotime($list_opportunity[0]['deadline'])); 
												 if($deadline == "01-01-1970"){
												 	$deadline = "";
												 }
											?>
											<input id="deadline" data-format="dd-mm-yyyy" value="<?php echo $deadline; ?>" type="text">
										</td>
									</tr>
									<tr>
										<td>Status:</td>
										<td>
			                               <select class="text" id="status" name="status" style="width: 200px;">
					                          <option value=""> - Select a Status -</option>
					                          <?php
					                            $list_status = LbOpportunityStatus::model()->findAll(array('order'=>'listorder'));
					                            foreach ($list_status as $row) {
					                            	if ($row['id'] == intval($list_opportunity[0]['opportunity_status_id']))
			                                            echo '<option value="'. $row['id'] .'" selected>'. stripcslashes($row['column_name']) .'</option>';
			                                        else
			                                            echo '<option value="'. $row['id'] .'">'. stripcslashes($row['column_name']) .'</option>';
					                            }
					                          ?>
					                      </select>
										</td>
									</tr>
									<tr>
										<td>Note:</td>
										<td>
			                               <textarea name="note" id="note"><?php echo $list_opportunity[0]['note']; ?></textarea>
										</td>
									</tr>
									
								</tbody>
							</table>
						</td>
						<td>
							<table style="margin-left: 180px; width: 100%">
								<tbody>
									<tr hidden>
										<td class="td_view_detail" >Document:</td>
										<td><?php echo $document_name; ?></td>
									</tr>
									<tr>
										<td class="td_view_detail">Contact:</td>
										<td>
										<select name="contact" id="contact_id" multiple>
											 <?php
					                            $list_contact = LbCustomerContact::model()->findAll();
					                            $array_entry_id = array();
					                            $OpportunityEntry = new LbOpportunityEntry();
												$list_contact_entry = $OpportunityEntry->get_opportunity_entry($list_opportunity[0]['opportunity_id'], "contact");
					                            foreach($list_contact_entry as $result_list_contact_entry){
					                            	$array_entry_id[] = $result_list_contact_entry['entry_id'];
					                            }
					                            foreach ($list_contact as $row) {
					                            	if (in_array(intval($row['lb_record_primary_key']), $array_entry_id)){
			                                            echo '<option value="'. $row['lb_record_primary_key'] .'" selected>'. stripcslashes($row['lb_customer_contact_first_name']) .'</option>';
					                            	}
			                                        else {
			                                        	echo '<option value="'. $row['lb_record_primary_key'] .'">'. stripcslashes($row['lb_customer_contact_first_name']) .'</option>';
			                                        }
			                                       
					                            }
					                          ?>
										</select>
										</td>
									</tr>
									<tr>
										<td class="td_view_detail">Staff:</td>
										<td>
			                               <select name="staff" id="staff" multiple>
												<?php
						                            $list_employee = LbEmployee::model()->findAll();
						                            $array_entry_id = array();
						                            $list_employee_entry = $OpportunityEntry->get_opportunity_entry($list_opportunity[0]['opportunity_id'], "employee");
						                            foreach($list_employee_entry as $result_list_employee_entry){
						                            	$array_entry_id[] = $result_list_employee_entry['entry_id'];
						                            }
						                            foreach ($list_employee as $row) {
						                            	if (in_array(intval($row['lb_record_primary_key']), $array_entry_id))
				                                            echo '<option value="'. $row['lb_record_primary_key'] .'" selected>'. stripcslashes($row['employee_name']) .'</option>';
				                                        else
				                                            echo '<option value="'. $row['lb_record_primary_key'] .'">'. stripcslashes($row['employee_name']) .'</option>';
						                            }
						                        ?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="td_view_detail">Created By:</td>
										<td>
			                                <?php
			                                    $create_by = AccountProfile::model()->findAll('account_id IN ('.$list_opportunity[0]['created_by'].')');
			                                	echo "<p>".$create_by[0]['account_profile_surname'].",".$create_by[0]['account_profile_given_name']."</p>";
			                                    ?>
			                                <p></p>
			                            </td>
									</tr>
									<tr>
										<td class="td_view_detail">Created Date:</td>
										<td><input name="deadline" id="deadline" value="<?php echo $list_opportunity[0]['created_date']; ?>"></td>
									</tr>
									<tr>
										<td class="td_view_detail">Invoice:</td>
										<td>
			                               <select name="invoice" id="invoice" multiple>
											<?php
					                            $list_invoice = LbInvoice::model()->findAll();
					                            $list_invoice_entry = $OpportunityEntry->get_opportunity_entry($list_opportunity[0]['opportunity_id'], "invoice");
					                           	$entry_invoice_id = array();
					                            foreach($list_invoice_entry as $result_list_entry){
					                            	$entry_invoice_id[] = $result_list_entry['entry_id'];
					                            }
					                            foreach ($list_invoice as $row) {
					                            	if (in_array(intval($row['lb_record_primary_key']), $entry_invoice_id))
			                                            echo '<option value="'. $row['lb_record_primary_key'] .'" selected>'. stripcslashes($row['lb_invoice_no']) .'</option>';
			                                        else
			                                            echo '<option value="'. $row['lb_record_primary_key'] .'">'. stripcslashes($row['lb_invoice_no']) .'</option>';
					                            }
					                          ?>
										</select>
										</td>
									</tr>
									<tr>
										<td class="td_view_detail">Quotation:</td>
										<td>
			                               <select name="quotation" id="quotation" multiple>
											<?php
					                            $list_quotation = LbQuotation::model()->findAll();
					                            $list_quotation_entry = $OpportunityEntry->get_opportunity_entry($list_opportunity[0]['opportunity_id'], "quotation");
					                           	$entry_quotation_id = array();
					                            foreach($list_quotation_entry as $result_list_entry){
					                            	$entry_quotation_id[] = $result_list_entry['entry_id'];
					                            }
					                            foreach ($list_quotation as $row) {
					                            	if (in_array(intval($row['lb_record_primary_key']), $entry_quotation_id))
			                                            echo '<option value="'. $row['lb_record_primary_key'] .'" selected>'. stripcslashes($row['lb_quotation_no']) .'</option>';
			                                        else
			                                            echo '<option value="'. $row['lb_record_primary_key'] .'">'. stripcslashes($row['lb_quotation_no']) .'</option>';
					                            }
					                        ?>
										</select>
										</td>
									</tr>
								</tbody>
							</table>
							<!-- right -->
						</td>
					</tr>
				</tbody>
			</table>
			<?php 
				if(Yii::app()->user->hasFlash('update_opp_success')){
		            echo
		            '<div class="alert alert-success fade in alert-dismissable">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    '.Yii::app()->user->getFlash('update_opp_success').' 
					</div>';
		        }
			?>
			<div style="text-align: center;">
				<?php 
					$this->widget('bootstrap.widgets.TbButton', array(
						'label'=> Yii::t('lang','Save'),
						'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						'size'=>'medium', // null, 'large', 'small' or 'mini'
						'htmlOptions'=> array('onclick' => 'save_all_update_opportunity()'),
					));
				?>
			</div>
        </div>
    </div>
</div>

<div class="view_document">
        <?php $this->renderPartial('lbDocument.views.default.view',array('id'=>$list_opportunity[0]['opportunity_id'],'module_name'=>'lbOpportunities')); ?>
</div>

<div id="form_enter_comment">
	<textarea name="comment" id="comment" placeholder="Enter Comment"></textarea>
	<button class="btn btn-default" onclick="post_comment();">Save</button>
</div>
<div id="list_comment">
	 
</div>
<table style="margin-left: 30px;" hidden>
	<tbody>
		<tr style="border: 1px solid red; ">
			<td class="detailRowLabel"></td>
			<td class="detailRowField"><textarea name="comment" id="comment"></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td class="detailRowField"><button class="btn btn-success" onclick="post_comment();">Post Comment</button></td>
		</tr>
		<tr>
			<td></td>
			<td class="detailRowField" style="border: 1px solid #a6c9e2; border-radius: 5px; padding: 10px;">
				<input type="hidden" name="opportunity_id_hidden" id="opportunity_id_hidden" value="<?php echo $opportunity_id; ?>">
				
			</td>
		</tr>
	</tbody>
</table>
<?php } ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
	$("#staff").select2();
	$("#contact_id").select2();
	$("#invoice").select2();
	$("#quotation").select2();
	var from_date = $("#deadline").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        from_date.hide();
    }).data('datepicker');

	var opportunity_id_hidden = $("#opportunity_id_hidden").val();
	// alert(opportunity_id_hidden);

	 $("#list_comment").load("<?php echo $this->createUrl('/lbOpportunities/Default/LoadComment'); ?>",{opportunity_id_hidden:opportunity_id_hidden});
 	// khi viết nhiều chữ vuột quá size của textarea thì textarea tự cover
	$textarea = $("#comment");
	var diff = $textarea.prop("scrollHeight") - $textarea.height();
	$textarea.live("keyup", function() {
		var height = $textarea.prop("scrollHeight") - diff;
		$textarea.height(height);
	});
	// end khi viết nhiều chữ vuột quá size của textarea thì textarea tự cover
	function post_comment(){
        var opportunity_id_hidden = $("#opportunity_id_hidden").val();
		var opportunity_id = $("#opportunity_id_hidden").val();
		var comment_content = $("#comment").val();
		$.ajax({
	        type:"POST",
	        url:"<?php echo $this->createUrl('/lbOpportunities/Default/PostComment'); ?>",
	        data: {opportunity_id:opportunity_id, comment_content:comment_content},
	        success:function(data){
                // load lai form
                $("#comment").val("");
                $("#list_comment").load("<?php echo $this->createUrl('/lbOpportunities/Default/LoadComment'); ?>",{opportunity_id_hidden:opportunity_id_hidden});
	        }
	    });
	}
	function save_all_update_opportunity(){
		var opportunity_id = $("#opportunity_id_hidden").val();
		var name = $("#name").val();
		var customer_id = $("#customer_id").val();
		var industry = $("#industry").val();
		var value = $("#value").val();
		var deadline = $("#chosse_date").find("#deadline").val();
		var status = $("#status").val();
		var note = $("#note").val();
		var contact = $("#contact_id").val();
		var staff = $("#staff").val();
		var invoice = $("#invoice").val();
		var quotation = $("#quotation").val();
		$.ajax({
	        'url': "<?php echo $this->createUrl('/lbOpportunities/Default/SaveAllUpdateOpportunity'); ?>",
	        data: {opportunity_id:opportunity_id,name:name, customer_id: customer_id, industry:industry, value:value,deadline:deadline,status:status,note:note,contact:contact,staff:staff,invoice:invoice,quotation:quotation},
	        'success':function(data)
	        {
//	            alert(data);
	             // alert('Update Column Successfully');
	            // $('#myModal').modal('toggle');
	            // window.location.assign('board');
	            window.location.assign("<?php echo $this->createUrl('/lbOpportunities/default/viewdetailopportunity/id/'.$list_opportunity[0]['opportunity_id'].''); ?>");
	        }
	    });
	}
        function delete_opportunity(opportunity_id) {
            if (confirm('Are you sure to delete this record?')) {
                    $.ajax({
                    'url': "<?php echo $this->createUrl('/lbOpportunities/Default/DeleteOpportunity'); ?>",
                    data: {opportunity_id:opportunity_id},
                    'success':function(data)
                    {
                        alert('The opportunity was successfully deleted. ');
                        window.location.assign("<?php echo $this->createUrl('/lbOpportunities/default/board'); ?>");
                    }
                });
            }
        }
</script>