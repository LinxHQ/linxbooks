<?php 
echo '<div id="show_people">';
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_show_people',
            'dataProvider'=>  $model->search($info_people),
            // 'itemsCssClass' => 'table-bordered items',
            'template' => "{items}\n{pager}\n{summary}", 
            'columns'=>array(
              array(
                  'header'=>Yii::t('lang','Name'),
                  'type'=>'raw',
                  'value'=>function($data){
                  	$people_title_name = "";
                  	if($data->lb_title != ""){
                  		$people_title = UserList::model()->getTermName('people_title', $data->lb_title);
                  		$people_title_name = "(".$people_title[0]['system_list_item_name'].")";
                  	} 
                  	$redirect_people = $this->createUrl('/lbPeople/default/detailPeople/id/'.$data->lb_record_primary_key.'');
                    return "
                    	<div style='width: 100%; width: auto;height: 60px; display: flex;'>
							<div style='width: 20%; height: 60px;'>
								<img data-toggle='tooltip' title='".$data->lb_given_name."' id='picture_user_comment' style='width: 60px;' src='".Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png' class='img-circle' alt='Cinque Terre'>
							</div>
							<div style='width: 80%; height: 60px;'>
									<p></p>
									<a href=".$redirect_people.">".$data->lb_given_name."</a><br />".$people_title_name."
							</div>
                   		</div>";
                  },
                  'htmlOptions'=>array('width'=>'200'),
              ),
              array(
                  'header'=>Yii::t('lang','Address'),
                  'type'=>'raw',
                  'value'=>function($data){
                  	return $data->lb_local_address_street."<br />".$data->lb_local_address_street2;
                  },
                  'htmlOptions'=>array('width'=>'250'),
              ),
              array(
                  'header'=>Yii::t('lang','Email'),
                  'type'=>'raw',
                  'value'=>function($data){
                    return $data->lb_local_address_email;
                  },
                  // 'value'=>'LbOpportunityIndustry::model()->searchIndustryName($data->industry)->attributes["industry_name"]',
                  'htmlOptions'=>array('width'=>'100'),
              ),
              array(
                  'header'=>Yii::t('lang','Mobile'),
                  'type'=>'raw',
                  'value'=> function($data){
                  	return $data->lb_local_address_mobile;
                  },
                  'htmlOptions'=>array('width'=>'100'),
              ),
            )
        ));
echo '</div>';
?>