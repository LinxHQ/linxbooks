<?php
/* @var $this SmallgroupsController */
/* @var $model LbSmallGroups */
?>

<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Small Groups").'</h3></div>';
        echo '<div class="lb-header-left lb-header-left-small-group">';
	        echo '<div id="lb_invoice" class="btn-toolbar" style="margin-top:2px;" >';
	        	?>
			    <div class="input-append">
			    	<a live="false" href="<?php echo $this->createUrl('/lbSmallgroups/smallgroups/create'); ?>"><i style="margin-top: -9px;margin-right: 10px;" class="icon-plus"></i> </a>
			      <input onKeyup="search_leader_name(this.value);" type="text" placeholder="Enter leader's name..." value="" style="width: 250px;">
			      <div class="btn-group">
			        <button class="btn dropdown-toggle" data-toggle="dropdown">
			          Location
			          <span class="caret"></span>
			        </button>
			        <ul id="localtion" class="dropdown-menu" style="min-width: 100px !important;">
	                  <li><a href="#">All</a></li>
                    <?php
                      $small_group_arr=LbSmallGroups::model()->findAll(array(
                          'select'=>'t.lb_group_location',
                          'distinct'=>true,
                      ));
                      foreach ($small_group_arr as $result_small_group_arr) {
                        echo '<li><a href="#">'.$result_small_group_arr['lb_group_location'].'</a></li>';
                      }
                     ?>
	                </ul>
			      </div>
			    </div>
	        	<?php
	        echo '</div>';
        echo '</div>';
	echo '</div>';
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

<?php 
echo '<div id="show_small_groups">';
$this->Widget('bootstrap.widgets.TbGridView',array(
    'id'=>'lb_show_small_groups',
    'dataProvider'=>  $model->search(),
    // 'itemsCssClass' => 'table-bordered items',
    'template' => "{items}\n{pager}\n{summary}", 
    'columns'=>array(
      array(
          'header'=>Yii::t('lang','Group Name'),
          'type'=>'raw',
          'value'=>function($data){
          	// return ;
          	if($data->lb_group_name != "") {
          		$redirect_small_group = $this->createUrl('/lbSmallgroups/smallgroups/view/id/'.$data->lb_record_primary_key.'');
          		return "<a href=".$redirect_small_group.">".$data->lb_group_name."";
          	}
          },
          'htmlOptions'=>array('width'=>'200'),
      ),
      array(
          'header'=>Yii::t('lang','Leader'),
          'type'=>'raw',
          'value'=>function($data){
          	// return "leader";
            $leader_arr = LbSmallGroupPeople::model()->findAll('lb_small_group_id IN ('.$data->lb_record_primary_key.')');
            foreach ($leader_arr as $result_leader_arr) {
              if($result_leader_arr['lb_position_id'] == 1){
                $people_member=LbPeople::model()->findByPk($result_leader_arr['lb_people_id']);
                echo $people_member->lb_given_name;
              }
            }
          },
          'htmlOptions'=>array('width'=>'250'),
      ),
      array(
          'header'=>Yii::t('lang','Assistant'),
          'type'=>'raw',
          'value'=>function($data){
          	// return "Assistant";
            $leader_arr = LbSmallGroupPeople::model()->findAll('lb_small_group_id IN ('.$data->lb_record_primary_key.')');
            foreach ($leader_arr as $result_leader_arr) {
              if($result_leader_arr['lb_position_id'] == 2){
                // echo $result_leader_arr['lb_people_id'];
                $people_member=LbPeople::model()->findByPk($result_leader_arr['lb_people_id']);
                echo $people_member->lb_given_name."<br>";
              }
            }
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Type'),
          'type'=>'raw',
          'value'=> function($data){
          	if($data->lb_group_type != "") {
          		// return $data->lb_group_type;
          		$small_group_type = UserList::model()->getTermName('small_group_type', $data->lb_group_type);
      			return ($small_group_type ? $small_group_type[0]['system_list_item_name'] : '');
          	}
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Location'),
          'type'=>'raw',
          'value'=> function($data){
          	if($data->lb_group_location != "") {
          		return $data->lb_group_location;
          	}
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Active'),
          'type'=>'raw',
          'value'=> function($data){
          	if($data->lb_group_active != "") {
          		// return $data->lb_group_active;
          		$small_group_active = UserList::model()->getTermName('small_group_active', $data->lb_group_active);
      			return ($small_group_active ? $small_group_active[0]['system_list_item_name'] : '');
          	}
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{update} {delete}',
                        'buttons'=>array(
                            'delete'=>array(
                                // 'visible'=>'$data->isCanDetete()'
                            )
                        ),
                        'htmlOptions'=>array('style'=>'width:40px;')
		),
    )
));
echo '</div>';
?>
<script type="text/javascript">
  function search_leader_name(leader_name) {
        $("#lb_show_small_groups").load("<?php echo $this->createUrl('/lbSmallgroups/Smallgroups/_search_leader_name'); ?>",{leader_name:leader_name});
  }

  $('#localtion li').click(function(){
    var localtion_name = $(this).text();
     $("#lb_show_small_groups").load("<?php echo $this->createUrl('/lbSmallgroups/Smallgroups/_search_location_name'); ?>",{localtion_name:localtion_name});
  });

</script>