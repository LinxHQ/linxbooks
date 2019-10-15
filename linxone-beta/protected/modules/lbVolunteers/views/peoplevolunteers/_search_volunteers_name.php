<?php 
echo '<div id="show_volunteers">';
$this->Widget('bootstrap.widgets.TbGridView',array(
    'id'=>'lb_show_show_volunteers',
    'dataProvider'=>  LbPeople::model()->searchPeopleNameVolunteers($volunteer_people_name,10),
    // 'itemsCssClass' => 'table-bordered items',
    'template' => "{items}\n{pager}\n{summary}", 
    'columns'=>array(
      array(
          'header'=>Yii::t('lang','Name'),
          'type'=>'raw',
          'value'=>function($data){
          	$redirect_volunteers = $this->createUrl('/lbVolunteers/peoplevolunteers/view/id/'.$data->lb_record_primary_key.'');
              return "
                  <div style='width: 100%; width: auto;height: 60px; display: flex;'>
            <div style='width: 20%; height: 60px;'>
              <img data-toggle='tooltip' title='".$data->lb_given_name."' id='picture_user_comment' style='width: 60px;' src='".Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png' class='img-circle' alt='Cinque Terre'>
            </div>
            <div style='width: 80%; height: 60px;'>
                <p></p> &nbsp;
                <a href=".$redirect_volunteers.">".$data->lb_given_name."</a><br />
            </div>
                  </div>";
          },
          'htmlOptions'=>array('width'=>'200'),
      ),
      array(
          'header'=>Yii::t('lang','Ministry'),
          'type'=>'raw',
          'value'=>function($data){
          	if($data->lb_volunteers_position != ""){
          		// return $data->lb_volunteers_type;
          		$volunteers_ministry = UserList::model()->getTermName('volunteers_ministry', $data->lb_volunteers_type);
      			return $volunteers_ministry[0]['system_list_item_name'];
          	}
          },
          'htmlOptions'=>array('width'=>'250'),
      ),
      array(
          'header'=>Yii::t('lang','Position'),
          'type'=>'raw',
          'value'=>function($data){
          	if($data->lb_volunteers_position != ""){
          		// return $data->lb_volunteers_position;
          		$volunteers_position = UserList::model()->getTermName('volunteers_position', $data->lb_volunteers_position);
      			return $volunteers_position[0]['system_list_item_name'];
          	}
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Mobile'),
          'type'=>'raw',
          'value'=> function($data){
          	$people_member=LbPeople::model()->findByPk($data->lb_people_id);
          	return $people_member->lb_local_address_mobile;
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Email'),
          'type'=>'raw',
          'value'=> function($data){
          	$people_member=LbPeople::model()->findByPk($data->lb_people_id);
          	return $people_member->lb_local_address_email;
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Active'),
          'type'=>'raw',
          'value'=> function($data){
          	if($data->lb_volunteers_id != "") {
              $volunteer_info=LbPeopleVolunteers::model()->findByPk($data->lb_volunteers_id);

              $volunteers_active = UserList::model()->getTermName('volunteers_active', $volunteer_info->lb_volunteers_active);
              return $volunteers_active[0]['system_list_item_name'];
          	}
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            // 'template'=>'{update} {delete}',
            'template'=>'{view} {delete}',
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