<?php
/** @var $post_vo frontend/vo/PostVo */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use frontend\widgets\HomeProposalBox;
use frontend\widgets\BidderList;
use frontend\widgets\PostSection;
use common\widgets\ButtonWithTooltip;
use frontend\widgets\ImageViewEditor;
?>

<div class="col-xs-12 col-md-12 post-index" data-stuff_id="<?= $post->getPostId() ?>">
    <div class="col-md-8 post-view">
        
        <div class="post-user-information">
            <?= Html::img($post->getPostCreatorPhotoPath(), ['class' => 'post-image-profile-pic']) ?> 
            <?= Html::a( $post->getPostCreatorFullName() , $post->getPostCreatorUserLink()) ?>
            &bull;
            <?= $post->getCreatedAt() ?>
        </div>
        <div class="post-information">
            <div class='post-image'>
                <?= ImageViewEditor::widget(['id' => 'image-view-editor', 'image_path' => $post->getImage()
                        , 'active' => true]) ?>
                <?= Html::button('Change Image', ['class' => 'post-change-image hide']) ?>
            </div>
            <?= PostSection::widget(['id' => 'post-section', 'post' => $post]) ?>
        </div>
        <div class="post-bids">
            <div class="post-bids-header">
                <div class="post-bids-label">
                    All bids
                    <span class="post-bids-total-bids">
                        <?= $post->getTotalBids() ?>
                    </span>
                </div>
                <div class="post-bids-button">
                    <?php if(!$post->isOwner()) { ?>
                    <?= Html::button('<span class="glyphicon glyphicon-envelope"></span> Bid on this stuff', 
                            ['class' => 'btn btn-primary post-bid-button', 'id' => 'post-bid-button']) ?>
                    <?php } ?>
                </div>
            </div>
            <?php if($post->isOwner()) { ?>
                <?= \frontend\widgets\BidContainer::widget(['id' => 'post-bid-container', 
                    'bid_list' => $post->getBidList()]) ?>
            <?php } else { ?>
            
            <?php } ?>
        </div>
    </div>
    <div class="col-md-4">
        <?php if($post->isOwner()) { ?>
           
            <?=BidderList::widget(['id' => 'bidder-list','stuff_id' => $post->getPostId(), 
                'bid_list' => $post->getBidList()]) ?>
        <?php } ?>
        <?= frontend\widgets\SuggestedPost::widget(['id' => 'post-suggested-post', 'post_list' => $post->getSuggestedPost()]) ?>
    </div>
    
    <?php
    Modal::begin([
        'options' => [
            'class' => 'post-proposal-box-modal'
        ],
        'size' => Modal::SIZE_LARGE
    ]);
        echo HomeProposalBox::widget(['post_vo' => $post]);
    Modal::end();
    ?>
    
    
    <?php Modal::begin([
        'id' => 'change-image-modal'
    ]) ?>
        <?= \frontend\widgets\ChangeImage::widget(['id' => 'change-image',
            'initial_image' => $post->getImage()]) ?>
    <?php Modal::end() ?>
</div>

