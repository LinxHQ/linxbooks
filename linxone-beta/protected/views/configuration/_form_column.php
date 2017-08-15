<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/css/style.css"> -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/css/spectrum.css">
<!-- <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/js/script.js"></script> -->
 <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/js/spectrum.js"></script> 
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.js"></script> 

<a href="#" onclick="hide_show_add_column();"><?php echo Yii::t('lang','Create New Column') ?></a> <br><br>

<div id="add_column" hidden>
	<?php echo Yii::t('lang','Column Name') ?> : <input type="text" name="column_name" id="column_name"> <br>
	<?php echo Yii::t('lang','Chosse Color') ?> : <input type='text' id="color_picker" /> <br> <br><br>
	<!-- <button onclick="save_add_column();" type="button" class="btn btn-info">New Column</button> -->
	<!-- <button   type="button" onclick="save_add_column();">New Column</button> -->
	<a href="#" class="btn btn-success" onclick="save_add_columns();"><?php echo Yii::t('lang','New Column') ?></a>
</div> <br>

<!-- List column -->
<div id="load_list_column">
	<table id="list_column" border="0" width="30%" class="items table table-bordered ">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo Yii::t('lang','Column Name') ?></th>
				<th>Opportunities</th>
				<th><?php echo Yii::t('lang','Delete') ?></th>
			</tr>
		</thead>
		<tbody class="test">
			<?php 
				$list_column = Yii::app()->db->createCommand( 'SELECT * FROM lb_opportunity_status ORDER BY listorder ASC' )->queryAll();
				$stt=0;
				foreach($list_column as $result_list_column){
					$stt++;
					$list_opportunities = Yii::app()->db->createCommand( 'SELECT count(*) FROM `lb_opportunity` WHERE opportunity_status_id = '.$result_list_column['id'].' ' )->queryAll();
					foreach($list_opportunities as $result_list_opportunities){
						echo "<tr id=".$result_list_column['id'].">
							<td>".$stt."</td>
							<td>".$result_list_column['column_name']."</td>
							<td>".$result_list_opportunities['count(*)']." - Opportunities</td>
							<td><a href='#' onclick='delete_columns(".$result_list_column["id"].", ".$result_list_opportunities['count(*)'].");'><i class='icon-trash'></i></a></td>
						</tr>";
					}
				}
			 ?>
			
		</tbody>
	</table>
</div>
<script type="text/javascript">
        $('.test').sortable({
	    // axis: 'y',
	    opacity: 0.7,
	    update: function(event, ui) {
	        var list_sortable = $(this).sortable('toArray').toString();
	        $.ajax({
                    'url': "<?php echo $this->createUrl('lbOpportunities/default/SortingColumn'); ?>",
	            data: {list_order:list_sortable},
	            'success':function(data)
	            {
	                // var responseJSON = jQuery.parseJSON(data);
//	                 alert('Invoice has been copy');
	                 window.location.href = "<?php echo Yii::app()->baseUrl ?>/1/configuration?tab7";
	            }
	        });
	    }
	});
	$("#color_picker").spectrum({
            preferredFormat: "rgb",
            showInput: true,
            showPalette: true,
            palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
        });
	function hide_show_add_column(){
		$("#add_column").toggle(1000);
	}
	function save_add_columns(){
		var column_name = $("#column_name").val();
		var color_picker = $("#color_picker").val();
		if(column_name == ""){
			alert("Please enter Column name");
		} else {
			$.ajax({
		        'url': "<?php echo $this->createUrl('lbOpportunities/default/addcolumn'); ?>",
		        data: {column_name:column_name, color_picker: color_picker},
		        'success':function(data)
		        {
		            alert('Added Column Successfully');
		            window.location.assign("<?php echo Yii::app()->baseUrl ?>/1/configuration");
		        }
		    });
		}
	}

	function delete_columns(column_id, count_task){
		if (confirm('Are you sure delete Column ?')) {
			if(count_task == 0){
				$.ajax({
			        'url': "<?php echo $this->createUrl('lbOpportunities/default/deletecolumn'); ?>",
			        data: {column_id:column_id},
			        'success':function(data) {
			            alert('Delete Column Successfully');
                                    window.location.assign("<?php echo Yii::app()->baseUrl ?>/index.php/lbOpportunities/default/board");
			        }
			    });
			} else {
				alert("You are not allowed to delete this column.");
			}
		}
	}
</script>