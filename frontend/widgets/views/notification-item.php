<?php
use yii\helpers\Html;
?>

<div id='<?= $id ?>' class='notification-item' data-id='<?= $id ?>'>
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