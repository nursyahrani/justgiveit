<?php

use yii\bootstrap\Html;
use common\widgets\Loading;
?>

<div id="<?= $id ?>" class="notification-list" data-id="<?= $id ?>">
    <?= Html::button('<span class="glyphicon glyphicon-bell"></span>', ['class' => 'btn notification-list-button notification-list-retrieve-button']) ?>
    <div class="notification-list-button notification-list-count hide"></div>
    <div class="notification-list-area hide">
        <div class="notification-list-area-header">
            Notification
        </div>
        <?=        Loading::widget(['id' => $id . '-loading-retrieve-notif']) ?>
        <div class='notification-list-items-area'>
        </div>
        <div class='notification-item-button'>
        </div>
        <div class="notification-list-no-more-notification hide">
            <span class="glyphicon glyphicon-bell"></span> &nbsp; No more notifications to show
        </div>
    </div>
</div>