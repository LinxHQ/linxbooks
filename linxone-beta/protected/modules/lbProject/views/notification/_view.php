<?php
/* @var $this NotificationController */
/* @var $data Notification */
?>

<div>
    <?php
    // determine url
    $click_url = '';
    switch ($data->notification_parent_type) {
        case Notification::NOTIFICATION_TYPE_NEW_TASK:
            $click_url = Task::model()->getTaskURL($data->notification_parent_id);
            break;
        case Notification::NOTIFICATION_TYPE_NEW_ISSUE:
            $click_url = Issue::model()->getIssueURL($data->notification_parent_id);
            break;
        case Notification::NOTIFICATION_TYPE_NEW_IMPLEMENTION:
            $click_url = Implementation::model()->getImplementationURL($data->notification_parent_id);
            break;
        case Notification::NOTIFICATION_TYPE_TASK_COMMENT:
            // though it's task comment, we are only redirecting user to that task
            $click_url = Task::model()->getTaskURL($data->notification_parent_id);
            break;
        case Notification::NOTIFICATION_TYPE_ISSUE_COMMENT:
            // though it's task comment, we are only redirecting user to that issue
            $click_url = Issue::model()->getIssueURL($data->notification_parent_id);
            break;
        case Notification::NOTIFICATION_TYPE_IMPLEMENTATION_COMMENT:
            // though it's task comment, we are only redirecting user to that impl
            $click_url = Implementation::model()->getImplementationURL($data->notification_parent_id);
            break;
        default:
            $click_url = array('#');
    } // end switch for differet case
    $click_url = CHtml::normalizeUrl($click_url);
    
    // Account profile
    $accountPtofile = AccountProfile::model()->getProfile($data->notification_sender_account_id);

    // display proper
    echo '<div class="two-column-news-block'.($data->notification_status==Notification::NOTIFICATION_STATUS_UNREAD ? ' notification-unread ' : '').'">';
    echo '<div class="profile-photo-column">';
    echo $accountPtofile->getProfilePhoto(0, false, 35);
    echo '</div>';
    echo '<div class="news-column" style="width: 400px;">';
    echo CHtml::link(CHtml::encode($data->notification_subject),'#', 
            array('onclick'=>"linxCircleUpdateNotificationAsRead({$data->notification_id}); window.location='$click_url'; return false;")) . ' ';
    echo '<span class="blur" style="font-size: 9pt;">'.$accountPtofile->getShortFullName() . 
            ': ' .CHtml::encode($data->notification_excerpt).
            '</span>';
    echo ' <span style="font-size: 8pt; color: #999"> on ' .
            Utilities::formatDisplayDate($data->notification_created_date).
            '</span>';
    echo '</div>';
    if ($data->notification_status==Notification::NOTIFICATION_STATUS_UNREAD) 
    {
    echo '<div class="flag-column">&nbsp;</div>';
    }
    echo '</div>'; // end two-column-news-block
    ?>

    <?php /*
      <b><?php echo CHtml::encode($data->getAttributeLabel('notification_hash')); ?>:</b>
      <?php echo CHtml::encode($data->notification_hash); ?>
      <br />

      <b><?php  ?>:</b>
      <?php  ?>
      <br />

      <b><?php  ?>:</b>
      <?php  ?>
      <br />

     */ ?>

</div>