<?php
/** @var $post_vo frontend/vo/PostVo */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\tabs\TabsX;
use frontend\widgets\PostSection;
use frontend\widgets\ImageViewEditor;
$item_tabs = [];
if($post->isOwner()) {
    $item_tabs[] = [
        'id' => 'total-bids',
        'options' => ['id' => 'bids'],
        'label' => "Bids ("  . $post->getTotalBids() . ')',
        'content' => \frontend\widgets\BidContainer::widget(['id' => 'bid-container', 'bid_list' => $post->getBidList(), 'post_owner' => $post->isOwner()])
    ];
} else {
    $item_tabs[] = [
        'label' => 'Your Bids',
        'options' => ['id' => 'bids'],
        'content' => \frontend\widgets\BidContainer::widget(['id' => 'bid-container', 'bid_list' => $post->getBidList(), 'post_owner' => $post->isOwner()])
    ];
}

$item_tabs[] = [
    'id' => 'details',
    'label' => 'Details',
    'options' => ['id' => 'details'],
    'content' =>  $post->getDescription() 
];

$item_tabs[] = [
    'label' => 'Comments (' . $post->getTotalComments() . ')',
    'options' => ['id' => 'comments'],
    'content' => \frontend\widgets\PostCommentContainer::widget(['id' => 'post-comment-container', 
        'post_id' => $post->getPostId(), 
        'post_comments' => $post->getPostComments()])
]
?>
<div class="post-index" data-stuff_id="<?= $post->getPostId() ?>" >
    <div class="post-information">
        <div class='post-image'>
            <?= ImageViewEditor::widget(['id' => 'image-view-editor', 'image_path' => $post->getImage(320,420)
                    , 'active' => true, 'modal_title' => $post->getTitle()]) ?>
            <?php if($post->isOwner()) { ?>
                <?= Html::button('Change Image', ['class' => 'post-change-image hide']) ?>
            <?php } ?>
        </div>
        <div class="post-owner">
            <div class="post-pick-up-location">
                <?= $post->getLocationText() ?>
            </div>
            <div class="post-owner-info">
                <?= Html::img($post->getPostCreatorPhotoPath(), ['class' => 'post-owner-photo-path']) ?>
                <?= Html::a($post->getPostCreatorFullName(), $post->getPostCreatorUserLink(), ['class' => 'post-owner-user-link']) ?>
            </div>
            <?= $post->getPostCreatorIntro() ?>
        </div>
    </div>
    <div class="post-right">
        <?= PostSection::widget(['id' => 'post-section', 'post' => $post]) ?>
        <div class="post-tabs-area">
            <?= TabsX::widget([
                'items' => $item_tabs,
                'enableStickyTabs' => true,
                'position' => TabsX::POS_ABOVE]) ?>
        </div>
    </div>
    <?php Modal::begin([
        'id' => 'change-image-modal'
    ]) ?>
        <?= \frontend\widgets\ChangeImage::widget(['id' => 'change-image',
            'initial_image' => $post->getImage(190,190)]) ?>
    <?php Modal::end() ?>
</div>

