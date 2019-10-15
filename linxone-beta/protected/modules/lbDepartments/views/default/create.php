
<div id="lb-container-header">
            <div class="lb-header-right" style="margin-left:-11px;"><h3>Create Department</h3></div>
            <div class="lb-header-left">
                <a href="<?php echo $this->createUrl('/lbDepartments/default/departmentsManager'); ?>" class="btn"><i class="icon-arrow-left"></i> Back</a>
            </div>
</div><br>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/select2.min.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/select2.min.js"></script>
<table class="std"  border="0">
    <tbody>
    	<tr>
    		<td>
    			<table width="100%">
    				<tbody>
    					<!-- <tr>
				            <td nowrap="" align="right">Department Company:</td>
				            <td><input class="text" name="dept_name" id="dept_name" value="" size="50" maxlength="255" type="text"></td>
					    </tr> -->
					    <tr>
					            <td nowrap="" >Name:</td>
					            <td>
					                    <input class="text" name="dept_name" id="dept_name" value="" size="50" maxlength="255" type="text">
					                    <!-- <span class="smallNorm">(required)</span> -->
					            </td>
					    </tr>
					    <tr>
					            <td nowrap="" >No:</td>
					            <td>
					                    <input class="text" name="department_no" value="" size="20" maxlength="50" type="text">
					            </td>
					    </tr>
					    <tr>
					            <td nowrap="" >Phone:</td>
					            <td>
					                    <input class="text" name="dept_phone" value="" maxlength="30" type="text">
					            </td>
					    </tr>
					    <tr>
					            <td nowrap="" >Fax:</td>
					            <td>
					                    <input class="text" name="dept_fax" value="" maxlength="30" type="text">
					            </td>
					    </tr>
					    <tr>
					            <td >Address:</td>
					            <td><input class="text" name="dept_address1" value="" size="50" maxlength="255" type="text"></td>
					    </tr>
    				</tbody>
    			</table>
    		</td>
    		<td>
    			<table width="100%" style="margin-left: 100px;">
    				<tbody>
    					<!-- <tr>
					            <td >City:</td>
					            <td><input class="text" name="dept_city" value="" size="50" maxlength="50" type="text"></td>
					    </tr> -->
					    <tr>
					            <td >State:</td>
					            <td><input class="text" name="dept_state" value="" maxlength="50" type="text"></td>
					    </tr>

				        <tr>
				            <td nowrap="" >Parent:</td>
				            <td>
								<select name="dept_parent" class="text" size="1">
									<option selected="selected">LinxHQ Singapore</option>
									<option> -- Administrative Office</option>
									<option> -- Research & Development</option>
									<option> -- Customer Support</option>
									<option> -- Marketing</option>
									<option>Kydon Vietnam</option>
									<option> -- HR Department</option>
									<option> -- Marketing</option>
									<option> -- Engineering</option>
								</select>
				            </td>
				    	</tr>
				       
				    	<!-- <tr>
				            <td >Employees:</td>
				            <td>
				            	<select name="dept_user" id="dept_user" multiple>
			                        <option>John</option>
			                        <option>Tommy</option>
			                        <option>Zac</option>
			                        <option>Tuchido</option>
			                        <option>Josehp</option>
			                    </select>
				            </td>
				    	</tr> -->
				    	<tr>
				            <td valign="top" nowrap="" >Description:</td>
				            <td align="left">
				                    <textarea rows="2" class="textarea" name="dept_desc"></textarea>
				            </td>
				    	</tr>

					    
    				</tbody>
    			</table>
    		</td>
    	</tr>
    </tbody></table>
	<button class=" btn btn-success">Save</button>



<script type="text/javascript">
	$(document).ready(function(){
	    $("#dept_user").select2(); 
	  });
</script>
	