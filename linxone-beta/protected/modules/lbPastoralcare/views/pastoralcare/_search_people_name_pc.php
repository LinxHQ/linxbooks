<?php 
echo '<div id="show_pastoral_care">';
$this->Widget('bootstrap.widgets.TbGridView',array(
    'id'=>'lb_show_pastoral_care',
    'dataProvider'=>  LbPeople::model()->searchPeopleNamePastoralCare($people_name_pc,10),
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
      				return $pastoralcare_type[0]['system_list_item_name'];
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