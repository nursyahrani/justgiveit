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
        'label' => "Bids ("  . $post->getTotalBids() . ')',
        'content' => \frontend\widgets\BidContainer::widget(['id' => 'bid-container', 'bid_list' => $post->getBidList(), 'post_owner' => $post->isOwner()])
    ];
} else {
    $item_tabs[] = [
        'label' => 'Your Bids',
        'content' => \frontend\widgets\BidContainer::widget(['id' => 'bid-container', 'bid_list' => $post->getBidList(), 'post_owner' => $post->isOwner()])
    ];
}

$item_tabs[] = [
    'label' => 'Product Description',
    'content' =>  $post->getDescription() 
];

$item_tabs[] = [
    'label' => 'Comments (' . $post->getTotalComments() . ')',
    'content' => \frontend\widgets\PostCommentContainer::widget(['id' => 'post-comment-container', 
        'post_id' => $post->getPostId(), 
        'post_comments' => $post->getPostComments()])
]
?>

<div class="col-xs-12 col-md-12 post-index" data-stuff_id="<?= $post->getPostId() ?>">
    <div class="post-information">
        <div class='post-image'>
            <?= ImageViewEditor::widget(['id' => 'image-view-editor', 'image_path' => $post->getImage()
                    , 'active' => true]) ?>
            <?= Html::button('Change Image', ['class' => 'post-change-image hide']) ?>
            
        </div>
        <div class="post-owner">
            <?= Html::img($post->getPostCreatorPhotoPath(), ['class' => 'post-owner-photo-path']) ?>
            <?= Html::a($post->getPostCreatorFullName(), $post->getPostCreatorUserLink(), ['class' => 'post-owner-user-link']) ?>
        </div>
    </div>
    
    <div class="post-right">

        <?= PostSection::widget(['id' => 'post-section', 'post' => $post]) ?>

        <div class="post-tabs-area">
            <?= TabsX::widget([
                'items' => $item_tabs,
                'position' => TabsX::POS_ABOVE
            ]) ?>
        </div>
    </div>
    
    
    
    <?php Modal::begin([
        'id' => 'change-image-modal'
    ]) ?>
        <?= \frontend\widgets\ChangeImage::widget(['id' => 'change-image',
            'initial_image' => $post->getImage()]) ?>
    <?php Modal::end() ?>
</div>

