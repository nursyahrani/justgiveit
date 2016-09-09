<?php

use yii\bootstrap\Html;
use common\widgets\Loading;
?>

<div id="<?= $id ?>" class="notification-list" data-id="<?= $id ?>">
    <?= Html::button('<span class="glyphicon glyphicon-bell"></span>', ['class' => 'btn menu-btn notification-list-retrieve-button']) ?>
    <div class="menu-btn notification-list-count hide"></div>
    <div class="notification-list-area hide">
        <div class="notification-list-area-header">
            Notification
        </div>
        <?=        Loading::widget(['id' => $id . '-loading-retrieve-notif']) ?>
        <div class='notification-list-items-area'>
        </div>
        <div class='notification-item-button'>
        </div>
    </div>
</div>