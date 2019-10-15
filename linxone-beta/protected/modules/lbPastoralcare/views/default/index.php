<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Pastoral Care").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar">';
	        	echo '<a live="false" data-workspace="1" href="'.$this->createUrl('/lbPastoralcare/default/create').'"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	        	echo '<a live="false" data-workspace="1" href=""><i style="margin-top: -12px;margin-right: 10px;" class="icon-calendar"></i> </a>';
	            echo ' <input type="text" placeholder="Enter name to search..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
	$picture = Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png";
 ?>
<div class="lb-empty-15"></div>
<div id="advanced_search" style="width: 100%;height: 30px; display: inline-flex; /*border: 1px solid red;*/">
	<div id="left" style="width: 50%; padding: 5px;">
		<i class="icon-search"></i> Advanced Search
	</div>
	<div id="right" style="width: 50%; padding: 5px;">
		<p style="float: right;"><i class="icon-download-alt"></i> Excel <i class="icon-download-alt"></i> PDF</p>
	</div>
</div>
<div class="lb-empty-15"></div>
<style type="text/css" media="screen">
	.pagination {
    display: inline-block;
}

.pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #eeeeee;
    border-radius: 4px;
}
 </style>

<?php 
echo '<div id="show_pastoral_care">';
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_show_pastoral_care',
            'dataProvider'=>  $model->search(),
            // 'itemsCssClass' => 'table-bordered items',
            'template' => "{items}\n{pager}\n{summary}", 
            'columns'=>array(
              array(
                  'header'=>Yii::t('lang','Date Time'),
                  'type'=>'raw',
                  'value'=>function($data){
                  	// return ;
                  	if($data->lb_pastoral_care_date != "") {
                  		return date("j F Y g:i a", strtotime($data->lb_pastoral_care_date));
                  	}
                  },
                  'htmlOptions'=>array('width'=>'200'),
              ),
              array(
                  'header'=>Yii::t('lang','Type'),
                  'type'=>'raw',
                  'value'=>function($data){
                  	if($data->lb_pastoral_care_type != ""){
						$pastoralcare_type = UserList::model()->getTermName('pastoralcare_type', $data->lb_pastoral_care_type);
						echo $pastoralcare_type[0]['system_list_item_name'];
					}
                  },
                  'htmlOptions'=>array('width'=>'250'),
              ),
              array(
                  'header'=>Yii::t('lang','Member'),
                  'type'=>'raw',
                  'value'=>function($data){
                  	if($data->lb_people_id != ""){
                  		$people_member=LbPeople::model()->findByPk($data->lb_people_id);
                    	return $people_member->lb_given_name;
                    }
                  },
                  'htmlOptions'=>array('width'=>'100'),
              ),
              array(
                  'header'=>Yii::t('lang','Pastor'),
                  'type'=>'raw',
                  'value'=> function($data){
                  	if($data->lb_pastoral_care_pastor_id != ""){
                  		$people_pastor=LbPeople::model()->findByPk($data->lb_pastoral_care_pastor_id);
                    	return $people_pastor->lb_given_name;
                  	}
                  },
                  'htmlOptions'=>array('width'=>'100'),
              ),
              array(
                  'header'=>Yii::t('lang','Remark'),
                  'type'=>'raw',
                  'value'=> function($data){
                  	if($data->lb_pastoral_care_remark != "") {
                  		return $data->lb_pastoral_care_remark;
                  	}
                  },
                  'htmlOptions'=>array('width'=>'100'),
              ),
              array(
                  'header'=>Yii::t('lang','Action'),
                  'type'=>'raw',
                  'value'=> function($data){
                  	return "
                  		<a href='#' onclick='delete_pastoralcare(".$data->lb_record_primary_key.");'><i class='icon-remove'></i></a>
                  		<a href=".$this->createUrl('/lbPastoralcare/default/update/id/'.$data->lb_record_primary_key)."><i class='icon-pencil'></i></a>
                  	";
                  },
                  'htmlOptions'=>array('width'=>'100'),
              ),
            )
        ));
echo '</div>';
?>

<script type="text/javascript">
	function delete_pastoralcare(pastoralcare_id) {
		$.ajax({
	        type:"POST",
	        url:"<?php echo $this->createUrl('/lbPastoralcare/default/delete_pastoralcare'); ?>",
	        data: {pastoralcare_id:pastoralcare_id},
	        success:function(data){
                window.location.assign("<?php echo $this->createUrl('/lbPastoralcare/default/index'); ?>");
	        }
	    });
	}
</script>