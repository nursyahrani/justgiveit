<?php

use yii\helpers\Html;

?>

<div class="bid-reply" id="<?= $id ?>">
    <?= Html::img($bid_reply->getCreatorPhotoPath(), ['class' => 'bid-reply-profile-pic']) ?>
    <?= Html::a($bid_reply->getCreatorFullName(),$bid_reply->getCreatorUserLink(), ['class' => 'bid-reply-name']) ?>
    <?= $bid_reply->getMessage() ?>
    <span class="bid-reply-time">
       - <?= $bid_reply->getCreatedAt() ?>
    </span>
</div>