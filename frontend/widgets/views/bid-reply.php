<?php

use yii\helpers\Html;

?>

<div class="bid-reply" id="<?= $id ?>">
    <?= Html::img($bid_reply->getCreatorPhotoPath(), ['class' => 'bid-reply-profile-pic']) ?>
    <?= Html::a($bid_reply->getCreatorFullName(),$bid_reply->getCreatorUserLink()) ?>
    <?= $bid_reply->getMessage() ?>
</div>