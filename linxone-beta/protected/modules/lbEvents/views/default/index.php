<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Events").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar">';
	        	echo '<a live="false" data-workspace="1" href="/linxbooks/index.php/1/lbExpenses/create"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	        	echo '<a live="false" data-workspace="1" href=""><i style="margin-top: -12px;margin-right: 10px;" class="icon-calendar"></i> </a>';
	            echo ' <input type="text" placeholder="Enter keyword to search..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
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
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/calendar_jquery/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>js/calendar_jquery/fullcalendar.print.min.css">
<script src="<?php echo Yii::app()->baseUrl; ?>/js/calendar_jquery/lib/moment.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/calendar_jquery/lib/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/calendar_jquery/fullcalendar.min.js" type="text/javascript"></script>
<script>
	
  $(document).ready(function() {
    
    $('#calendar').fullCalendar({
    	eventClick: function(calEvent, jsEvent, view) {
    		window.location.href = "detailEvent";
	    },
      // viewRender: function(currentView){
      //   $(".fc-listWeek-button").addClass('fc-state-active');
      //   $(".fc-month-button").removeClass('fc-state-active');

      // },
      viewDisplay: function(view) {
        alert('The new title of the view is ' + view.title);
      },
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      listDayFormat: 'D MMMM YYYY',
      defaultDate: '2017-09-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
        {
          title: 'All Day Event',
          start: '2017-09-01',
        },
        {
          title: 'Long Event',
          start: '2017-09-07',
          end: '2017-09-10'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-09-09T16:00:00'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-09-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2017-09-11',
          end: '2017-09-13'
        },
        {
          title: 'Meeting',
          start: '2017-09-12T10:30:00',
          end: '2017-09-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2017-09-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2017-09-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2017-09-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2017-09-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2017-09-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2017-09-28'
        }
      ]
    });
    $('#calendar').fullCalendar('changeView', 'listWeek');
  });
</script>
<style>
  #calendar {
    max-width: auto;
    margin: 0 auto;
  }
</style>
<div id='calendar'></div>

