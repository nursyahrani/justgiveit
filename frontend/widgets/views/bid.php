<?php
use yii\bootstrap\Html;
use common\widgets\AutoHeightTextArea;
use frontend\widgets\BidReplyContainer;
?>

<div id="<?= $id ?>" class="bid" data-id="<?= $id ?>" data-bid_id="<?= $bid->getBidId() ?>">
    <div class="bid-header">
        <div class="bid-header-information">
            <?=  Html::img($bid->getCreatorPhotoPath(), ['class' => 'bid-creator-photo-path']) ?>
            <span class="bid-creator-full-name">
                <?= Html::a($bid->getCreatorFullName(), $bid->getCreatorUserLink()) ?> &bull; 
                <?= $bid->getCreatedAt() ?>
            </span>
        </div>
        <div class="bid-detail">
            <?= $bid->getMessage() ?>
        </div>
    </div>
    <div class="bid-footer">
        <div class="bid-reply">
            <?=  AutoHeightTextArea::widget(['id' => $id . '-reply-box', 'placeholder' => 'Reply..']) ?>
        </div>

        <?= BidReplyContainer::widget(['id' => $id . '-bid-reply-container', 
            'chosen_bid_reply' => $bid->getChosenBidReply(), 'total_bid' => 0,
            'bid_id' => $bid->getBidId()]) ?>
    </div>
</div>