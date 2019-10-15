<?php 
  if(isset($departments_id)) {
        $model = LbTalentNeed::model();
        $model->lb_department_id=$departments_id;
        $model->lb_talent_start_date=$year;
      
        
    } else {
 ?>
<div id="lb-container-header">
    <div class="lb-header-right"><h3>Training Need</h3></div>
    <div class="lb-header-left lb-header-left-view-training-need">
        <a href="<?php echo $this->createUrl('/lbTalent/default/create'); ?>"><i class="icon-plus"></i></a>&nbsp;
        <!-- <a href="<?php echo $this->createUrl('/lbTalent/default/training'); ?>"><i class="icon-th-list icon-white"></i></i></a>&nbsp; -->
        <a href="<?php echo $this->createUrl('/lbTalent/default/config'); ?>"><i class="icon-wrench"></i></i></a>
    </div>
</div><br>

<table>
	<tbody>
		<tr>
			<td>
				<select name="departments_select" id="departments_select">
					<?php 
						$department_arr = LbDepartments::model()->findAll();
						echo "<option value=''>Select Department</option>";
						foreach($department_arr as $result_department_arr){
							echo "<option value=".$result_department_arr['lb_record_primary_key'].">".$result_department_arr['lb_department_name']."</option>";
						}
					?>
				</select>
			</td>
			<td>
				<select name="year_departments_select" id="year_departments_select" name="" style="width: 120px !important; margin-left: 25px !important;">
					<?php
						echo "<option value=''>Select Year</option>";
						$level_arr = UserList::model()->getItemsListCodeById('year', true);
						foreach ($level_arr as $key => $value) {
							echo "<option value=".$key.">".$value."</option>";
						}
					 ?>
				</select>
			</td>
			<td>
				<button type="button" onclick="searchTrainingNeed()" style="width: 70px !important; margin-left: 25px !important; margin-bottom: 10px;" type="text" name="" class="btn btn-success">Search</button>
			</td>
		</tr>
	</tbody>
</table>
<br>
<?php } ?>

<?php 
echo '<div id="show_training_ned">';
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_show_opportunities',
            'dataProvider'=>  $model->search(),
            'itemsCssClass' => 'table-bordered items',
            'template' => "{items}\n{pager}\n{summary}", 
            'columns'=>array(
              array(
                  'header'=>Yii::t('lang','Department'),
                  'type'=>'raw',
                  'value'=>function($data){
                    $department=LbDepartments::model()->findByPk($data->lb_department_id);
                    return $department->attributes['lb_department_name'];
                  },
                  'htmlOptions'=>array('width'=>'200'),
              ),
              array(
                  'header'=>Yii::t('lang','Training Need'),
                  'type'=>'raw',
                  'value'=>function($data){
                  	$redirect_training_need = $this->createUrl('/lbTalent/default/training/id/'.$data->lb_record_primary_key.'');
                    return '<a href="'.$redirect_training_need.'">'.$data->lb_talent_name.'</a>';
                  },
                  'htmlOptions'=>array('width'=>'250'),
              ),
              array(
                  'header'=>Yii::t('lang','Start Date'),
                  'type'=>'raw',
                  'value'=>function($data){
                    return date("d/m/Y", strtotime($data->lb_talent_start_date));
                  },
                  // 'value'=>'LbOpportunityIndustry::model()->searchIndustryName($data->industry)->attributes["industry_name"]',
                  'htmlOptions'=>array('width'=>'100'),
              ),
              array(
                  'header'=>Yii::t('lang','Deadline'),
                  'type'=>'raw',
                  'value'=> function($data){
                  	return date("d/m/Y", strtotime($data->lb_talent_end_date));
                  },
                  'htmlOptions'=>array('width'=>'100'),
              ),
              array(
                  'header'=>Yii::t('lang','Description '),
                  'type'=>'raw',
                  'value'=> function($data){
                  	return $data->lb_talent_description;
                  },
                  'htmlOptions'=>array('width'=>'250'),
              ),
              array(
                  'header'=>Yii::t('lang','Status'),
                  'type'=>'raw',
                  'value'=>function($data){
                    if($data->lb_talent_status_id > 0){
                    	return '<a data-toggle="tooltip" title="Complete"><i class="icon-ok text-center"></i></a>';
                    }
                  },
                  // 'value'=>'LbOpportunityStatus::model()->searchStatus($data->opportunity_status_id)->attributes["column_name"]',
                  'htmlOptions'=>array('width'=>'50'),
              ),
            )
        ));
echo '</div>';
?>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

function searchTrainingNeed(){
	var departments_select = $("#departments_select").val();
	var year_departments_select = $("#year_departments_select").val();

	$('#show_training_ned').load('searchTrainingNeed',{departments_select:departments_select,year_departments_select:year_departments_select});
}
</script>