<?php
use yii\helpers\Html;
?>

<div id='<?= $id ?>' class='notification-item <?= (!$notification->isRead() ? 'notification-item-not-read' : '') ?>' data-id='<?= $id ?>' data-url='<?= $notification->getUrl() ?>'
     data-notification_id='<?= $notification->getNotificationId() ?>'>
    <?= Html::img($notification->getPhoto(), ['class' => 'notification-item-photo']) ?>
    <div class='notification-item-view'>
        <div class='notification-item-text'>
            <?= $notification->getText() ?>
        </div>
        <div class='notification-item-time'>
            <?= $notification->getTime(); ?>
        </div>
    </div>
    
</div>