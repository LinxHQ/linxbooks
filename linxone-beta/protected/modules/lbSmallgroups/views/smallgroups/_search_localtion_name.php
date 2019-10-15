<?php 
echo '<div id="show_small_groups">';
$this->Widget('bootstrap.widgets.TbGridView',array(
    'id'=>'lb_show_small_groups',
    'dataProvider'=>  $model->search($localtion_name),
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
      			return $small_group_type[0]['system_list_item_name'];
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
      			return $small_group_active[0]['system_list_item_name'];
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