<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style_js_modules_lbOpportunities/css/style.css">
<?php
$list_comment = LbOpportunityComment::model()->findAll(array('order'=>'id DESC', 'condition'=>'opportunity_id=:x', 'params'=>array(':x'=>$_POST['opportunity_id_hidden'])));
foreach($list_comment as $result_list_comment){

		$model_comment_opp = LbOpportunityComment::model()->findByPk($result_list_comment['id']);

        $create_by = AccountProfile::model()->findAll('account_id IN ('.$result_list_comment['created_by'].')');
        $user_name = "<b>".$create_by[0]['account_profile_surname'].",".$create_by[0]['account_profile_given_name']."</b>";
        $content = nl2br($result_list_comment['comment_content']); // nl2br khi người dùng enter xuống dòng trong textarea thì khi hiển thị cũng phải theo format đó.
		$dateTime = new DateTime($result_list_comment['created_date'], new DateTimeZone('Asia/Ho_Chi_Minh')); 
		$time_create = $dateTime->format("d/m/y  H:i A");
		$picture = Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png";

        echo '
	        <div>
			 	<img id="picture_user_comment" src="'.$picture.'" class="img-circle" alt="Cinque Terre"> 
			 	'.$user_name.': <br />';
			 	$this->widget('editable.EditableField', array(
				    'type'        => 'textarea',
				    'inputclass'  => 'input-large-textarea',
				    'emptytext'   => 'Change comment',
				    'model'       => $model_comment_opp,
				    'attribute'   => 'comment_content',
				    'url'         => $this->createUrl('default/ajaxUpdateField'),
				    'placement'   => 'right',
				    'showbuttons' => 'bottom',
				    // 'htmlOptions' => array('class'=>'lb_edit_table'),s
				    'options'	=> array(
				    ),
				));
			echo '<hr>
			 	<p id="time_user_post_comment">Posted on '.$time_create.'</p>
			 </div>';
} 
?>