<?php
/* @var $this NotificationController */
/* @var $model Notification */

$adp = $model->getNotificationsForAccount();
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$adp,
	'itemView'=>'_view',
        'template'=>'{items}{pager}',
)); 

$adp_tmp = $adp;
$adp_tmp->setPagination(false);
$notifications_arr = $adp_tmp->getData();
$unread_notification_ids = '';
foreach ($notifications_arr as $notification)
{
    if ($notification->notification_status == Notification::NOTIFICATION_STATUS_UNREAD)
    {
        $unread_notification_ids .= $notification->notification_id . ',';
    }
}
?>
<script type="text/javascript">
var loaded_unread_notifications_<?php echo Yii::app()->user->id; ?> = '<?php echo $unread_notification_ids;?>';

function linxCircleUpdateNotificationAsRead(notification_id)
{
    $.post("<?php echo Yii::app()->createUrl('notification/updateAsRead') ?>?ajax=1&id="+notification_id, function(data){
        if (data == 'true')
            return true;
        return false;
    });
}

function linxCircleUpdateMultipleNotificationAsRead()
{
    $.post("<?php echo Yii::app()->createUrl('notification/updateMultipleAsRead') ?>?ajax=1&ids=all");
    $("#linx-app-notification-container .notification-badge").html('0');
    $("#linx-app-notification-container .notification-unread").each( function(){
        $(this).removeClass('notification-unread');
    });
    $("#linx-app-notification-container .flag-column").each( function(){
        $(this).css('background-color','#fff');
    });
}
$("#linx-app-notification-container #mark-all-as-read").html('<?php echo CHtml::link('Mark all as read', '#', array('onclick'=>'linxCircleUpdateMultipleNotificationAsRead(); return false;'));?>');
</script>