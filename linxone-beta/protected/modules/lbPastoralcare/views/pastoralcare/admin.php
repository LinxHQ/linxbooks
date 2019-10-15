<?php
/* @var $this PastoralcareController */
/* @var $model LbPastoralCare */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css_theme2018/jquery.datetimepicker.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.datetimepicker.full.min.js"></script>
<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Pastoral Care").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar">';
	        	echo '<a live="false"  href="'.$this->createUrl('/lbPastoralcare/pastoralcare/create').'"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	        	echo '<a live="false"  href=""><i id="calendar" style="margin-top: -12px;margin-right: 10px;" class="icon-calendar"></i> </a>';
	            echo ' <input type="text" placeholder="Enter name to search..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_pc(this.value);">';
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
      				return ($pastoralcare_type ? $pastoralcare_type[0]['system_list_item_name'] : '');
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
<script type="text/javascript">
  $( document ).ready(function() {
      $('#calendar').datetimepicker({
        onSelectTime:function(date) {
          var dates = formatDatesss(date);
          $("#show_pastoral_care").load("<?php echo $this->createUrl('/lbPastoralcare/Pastoralcare/_search_date_time_pc'); ?>",{dates:dates});
        },
      });
  });
  // function formatDatesss(date) {
  //   var monthNames = [
  //     "January", "February", "March",
  //     "April", "May", "June", "July",
  //     "August", "September", "October",
  //     "November", "December"
  //   ];

  //   var day = date.getDate();
  //   var monthIndex = date.getMonth();
  //   var year = date.getFullYear();
  //   var hours = date.getHours();
  //   var minutes = date.getMinutes();

  //   return day + ' ' + monthNames[monthIndex] + ' ' + year + hours + minutes;
  // }
  function formatDatesss(date) {
    var year = date.getFullYear(),
        month = date.getMonth() + 1, // months are zero indexed
        day = date.getDate(),
        hour = date.getHours(),
        minute = date.getMinutes(),
        second = date.getSeconds(),
        hourFormatted = hour, // hour returned in 24 hour format
        minuteFormatted = minute < 10 ? "0" + minute : minute,
        morning = hour < 12 ? "am" : "pm";

    return month + "/" + day + "/" + year + " " + hourFormatted + ":" +
            minuteFormatted ;
  }
  function search_name_pc(people_name_pc) {
    $("#show_pastoral_care").load("<?php echo $this->createUrl('/lbPastoralcare/Pastoralcare/_search_people_name_pc'); ?>",{people_name_pc:people_name_pc});
  }
</script>