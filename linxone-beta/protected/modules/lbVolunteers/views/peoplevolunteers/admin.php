<?php
/* @var $this PeoplevolunteersController */
/* @var $model LbPeopleVolunteers */

?>

<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Volunteers").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar">';
	        	echo '<a live="false" data-workspace="1" href="'.$this->createUrl('/lbVolunteers/peoplevolunteers/create').'"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	            echo ' <input type="text" placeholder="Enter name..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_volunteers(this.value);">';
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

<?php 
echo '<div id="show_volunteers">';
$this->Widget('bootstrap.widgets.TbGridView',array(
    'id'=>'lb_show_show_volunteers',
    'dataProvider'=>  $model->search(),
    // 'itemsCssClass' => 'table-bordered items',
    'template' => "{items}\n{pager}\n{summary}", 
    'columns'=>array(
      array(
          'header'=>Yii::t('lang','Name'),
          'type'=>'raw',
          'value'=>function($data){
            // return $data->lb_record_primary_key;
            if($data->lb_record_primary_key != ""){
              $volunteers_stage = LbPeopleVolunteersStage::model()->findAll('lb_volunteers_id IN ('.$data->lb_record_primary_key.')');
              foreach ($volunteers_stage as $result_volunteers_stage) {
                if($result_volunteers_stage->lb_people_id != ""){
                  $people_member=LbPeople::model()->findByPk($result_volunteers_stage->lb_people_id);
                  $redirect_volunteers = $this->createUrl('/lbVolunteers/peoplevolunteers/view/id/'.$result_volunteers_stage->lb_record_primary_key.'');
                  return "
                      <div style='width: 100%; width: auto;height: 60px; display: flex;'>
                <div style='width: 20%; height: 60px;'>
                  <img data-toggle='tooltip' title='".$people_member->lb_given_name."' id='picture_user_comment' style='width: 60px;' src='".Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png' class='img-circle' alt='Cinque Terre'>
                </div>
                <div style='width: 80%; height: 60px;'>
                    <p></p> &nbsp;
                    <a href=".$redirect_volunteers.">".$people_member->lb_given_name."</a><br />
                </div>
                      </div>";
                }
              }
            }
          	
          },
          'htmlOptions'=>array('width'=>'200'),
      ),
      array(
          'header'=>Yii::t('lang','Ministry'),
          'type'=>'raw',
          'value'=>function($data){
            if($data->lb_record_primary_key != ""){
              $criteria = new CDbCriteria();
              $criteria->condition  = "lb_volunteers_id = ".$data->lb_record_primary_key."";
              $criteria->order = "lb_record_primary_key DESC";
              $criteria->limit = 1;
              $volunteers_stage = LbPeopleVolunteersStage::model()->findAll($criteria);
              
              foreach ($volunteers_stage as $result_volunteers_stage) {
                $volunteers_ministry = UserList::model()->getTermName('volunteers_ministry', $result_volunteers_stage->lb_volunteers_type);
                return ($volunteers_ministry ? $volunteers_ministry[0]['system_list_item_name'] : '');
              }
            }
          },
          'htmlOptions'=>array('width'=>'250'),
      ),
      array(
          'header'=>Yii::t('lang','Position'),
          'type'=>'raw',
          'value'=>function($data){
            if($data->lb_record_primary_key != ""){
              $criteria = new CDbCriteria();
              $criteria->condition  = "lb_volunteers_id = ".$data->lb_record_primary_key."";
              $criteria->order = "lb_record_primary_key DESC";
              $criteria->limit = 1;
              $volunteers_stage = LbPeopleVolunteersStage::model()->findAll($criteria);
              
              foreach ($volunteers_stage as $result_volunteers_stage) {
                $volunteers_position = UserList::model()->getTermName('volunteers_position', $result_volunteers_stage->lb_volunteers_position);
                return ($volunteers_position ? $volunteers_position[0]['system_list_item_name'] : '');
              }
            }
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Mobile'),
          'type'=>'raw',
          'value'=> function($data){
            if($data->lb_record_primary_key != ""){
              $volunteers_stage = LbPeopleVolunteersStage::model()->findAll('lb_volunteers_id IN ('.$data->lb_record_primary_key.')');
              foreach ($volunteers_stage as $result_volunteers_stage) {
                $people_member=LbPeople::model()->findByPk($result_volunteers_stage->lb_people_id);
                return $people_member->lb_local_address_mobile;
              }
            }
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Email'),
          'type'=>'raw',
          'value'=> function($data){
            if($data->lb_record_primary_key != ""){
              $volunteers_stage = LbPeopleVolunteersStage::model()->findAll('lb_volunteers_id IN ('.$data->lb_record_primary_key.')');
              foreach ($volunteers_stage as $result_volunteers_stage) {
                $people_member=LbPeople::model()->findByPk($result_volunteers_stage->lb_people_id);
                return $people_member->lb_local_address_email;
              }
            }
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Active'),
          'type'=>'raw',
          'value'=> function($data){
          	if($data->lb_volunteers_active != "") {
              $volunteers_active = UserList::model()->getTermName('volunteers_active', $data->lb_volunteers_active);
              return ($volunteers_active ? $volunteers_active[0]['system_list_item_name'] : '');
          	}
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            // 'template'=>'{update} {delete}',
            'template'=>'{delete}',
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

<?php 
	// $this->widget('zii.widgets.grid.CGridView', array(
	// 	'id'=>'lb-people-volunteers-grid',
	// 	'dataProvider'=>$model->search(),
	// 	'filter'=>$model,
	// 	'columns'=>array(
	// 		'lb_record_primary_key',
	// 		'lb_people_id',
	// 		'lb_volunteers_type',
	// 		'lb_volunteers_position',
	// 		'lb_volunteers_active',
	// 		'lb_volunteers_start_date',
	// 		/*
	// 		'lb_volunteers_end_date',
	// 		'lb_entity_id',
	// 		'lb_entity_type',
	// 		*/
	// 		array(
	// 			'class'=>'CButtonColumn',
	// 		),
	// 	),
	// )); 
?>

<script type="text/javascript">
  function search_name_volunteers(volunteer_people_name) {
    $("#lb_show_show_volunteers").load("<?php echo $this->createUrl('/lbVolunteers/Peoplevolunteers/_search_volunteers_name'); ?>",{volunteer_people_name:volunteer_people_name});
  }
</script>
