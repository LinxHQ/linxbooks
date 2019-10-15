<?php 

echo '<div id="show_small_groups">';
$this->Widget('bootstrap.widgets.TbGridView',array(
    'id'=>'lb_show_small_groups',
    'dataProvider'=>  LbPeople::model()->searchLeaderByName($leader_name,10),
    // 'itemsCssClass' => 'table-bordered items',
    'template' => "{items}\n{pager}\n{summary}", 
    'columns'=>array(
      array(
          'header'=>Yii::t('lang','Group Name'),
          'type'=>'raw',
          'value'=>function($data){
            $small_group_name=LbSmallGroups::model()->findByPk($data->lb_small_group_id);
            if($small_group_name != "") {
              $redirect_small_group = $this->createUrl('/lbSmallgroups/smallgroups/view/id/'.$small_group_name->lb_record_primary_key.'');
              return "<a href=".$redirect_small_group.">".$small_group_name->lb_group_name."";
            }
          },
          'htmlOptions'=>array('width'=>'200'),
      ),
      array(
          'header'=>Yii::t('lang','Leader'),
          'type'=>'raw',
          'value'=>function($data){
            return $data->lb_given_name;
          	// // return "leader";
           //  $leader_arr = LbSmallGroupPeople::model()->findAll('lb_small_group_id IN ('.$data->lb_record_primary_key.')');
           //  foreach ($leader_arr as $result_leader_arr) {
           //    if($result_leader_arr['lb_position_id'] == 1){
           //      $people_member=LbPeople::model()->findByPk($result_leader_arr['lb_people_id']);
           //      echo $people_member->lb_given_name;
           //    }
           //  }
          },
          'htmlOptions'=>array('width'=>'250'),
      ),
      array(
          'header'=>Yii::t('lang','Assistant'),
          'type'=>'raw',
          'value'=>function($data){
          	// return "Assistant";
            $leader_arr = LbSmallGroupPeople::model()->findAll('lb_small_group_id IN ('.$data->lb_small_group_id.')');
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
            $small_group_name=LbSmallGroups::model()->findByPk($data->lb_small_group_id);
          	if($small_group_name->lb_group_type != "") {
          		$small_group_type = UserList::model()->getTermName('small_group_type', $small_group_name->lb_group_type);
      			  return $small_group_type[0]['system_list_item_name'];
          	}
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Location'),
          'type'=>'raw',
          'value'=> function($data){
            $small_group_name=LbSmallGroups::model()->findByPk($data->lb_small_group_id);
          	if($small_group_name->lb_group_location != "") {
          		return $small_group_name->lb_group_location;
          	}
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Active'),
          'type'=>'raw',
          'value'=> function($data){
            $small_group_name=LbSmallGroups::model()->findByPk($data->lb_small_group_id);
          	if($small_group_name->lb_group_active != "") {
          		// return $data->lb_group_active;
          		$small_group_active = UserList::model()->getTermName('small_group_active', $small_group_name->lb_group_active);
      			return $small_group_active[0]['system_list_item_name'];
          	}
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>'',
          'type'=>'raw',
          'value'=> function($data){
            $edit = "<a class='update' title='Update' rel='tooltip' href=".$this->createUrl('/lbSmallgroups/smallgroups/update/id/'.$data->lb_small_group_id.'')."><i class='icon-pencil'></i></a>";

            $delete = "<a class='delete' title='Delete' rel='tooltip' href=".$this->createUrl('/lbSmallgroups/smallgroups/delete/id/'.$data->lb_small_group_id.'')."><i class='icon-trash'></i></a>";

            return $edit."&nbsp;&nbsp;".$delete;
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
    )
));
echo '</div>';
?>