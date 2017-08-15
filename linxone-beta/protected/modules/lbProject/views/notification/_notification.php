<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// icon & placeholder for notification popover
echo '<div id="linx-app-notification-container" style="display: inline-block; margin-top: 7px; margin-right: 10px">';
echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/activity.png') . '<span class="notification-badge">0</span>',
        '#',
        array('onclick'=>'linxcircleAppLoadNotifications(); return false;','id'=>'linxcircle-notification-menu-item'));
echo '</div>';
?>
<script type='text/javascript'>
    $(document).ready(function(){
        var linxcircleAlertAudio;
        if (linxcircleCanPlayMediaType('audio/wav;'))
        {
	        linxcircleAlertAudio = new Audio();
	        linxcircleAlertAudio.src = "<?php echo Yii::app()->baseUrl?>/media/alert.wav";
	        linxcircleAlertAudio.load();
        }
        // check every x seconds to see if there's new notification
        window.setInterval(function(){
            $.get("<?php echo CHtml::normalizeUrl(array('notification/checkNotification'))?>?ajax=1", function(data){
                var jsonData = jQuery.parseJSON(data);
                var totalUnread = 0;
                var hasNew = false
                if (jsonData.unread) totalUnread = parseInt(jsonData.unread);
                if (jsonData.has_new && jsonData.has_new == true) hasNew = true;
                
                $("#linx-app-notification-container .notification-badge").html(totalUnread);
                if (hasNew)
                {
                    if (linxcircleCanPlayMediaType('audio/wav;'))
        			{
        				linxcircleAlertAudio.play();
        			}
                }
            });
        }, 30000);
    });
    
    
        // load when iconis clicked
        function linxcircleAppLoadNotifications() {
            var el = $("#linxcircle-notification-menu-item");
            
            if (el.popover)
                el.popover('destroy');
            
            if (linxcircleNotificationPopoverLoaded == false)
            {
                el.popover({
                        content: '<?php echo CHtml::image(Yii::app()->baseUrl . '/images/loading.gif');?>', 
                        html: true,
                        placement: 'bottom', 
                        title: 'Activities <div id="mark-all-as-read" style="float: right"></div>',
                        template: '<div class="popover notification-popover-medium" style="width: 500px"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'

                    });
                el.popover('show');
                $.get(workspaceTransformUrl('<?php echo Yii::app()->createUrl('notification/index'); ?>'), function(data){ 
                    $("#linx-app-notification-container .popover-content").html(data);
                    $("#linx-app-notification-container .popover-content").css('padding', '0px');
                    $("#linx-app-notification-container .popover-content").css('padding-top', '5px');
                    linxcircleNotificationPopoverLoaded = true;
                }); 
            } else {
                linxcircleNotificationPopoverLoaded = false;
                el.popover('hide');
            }
        }
</script>