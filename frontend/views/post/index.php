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
        
        <div class="post-information">
            <div class='post-image'>
                <?= ImageViewEditor::widget(['id' => 'image-view-editor', 'image_path' => $post->getImage()
                        , 'active' => true]) ?>
                <?= Html::button('Change Image', ['class' => 'post-change-image hide']) ?>
            </div>
        
            <?= PostSection::widget(['id' => 'post-section', 'post' => $post]) ?>
            
            <div class="post-card-button">
                <div class="post-card-total-bid">
                    <?= $post->getTotalBids() ?>
                </div>
                <?= ButtonWithTooltip::widget(['id' =>  'post-bid-button', 
                    'tooltip_text' => !$post->isOwner() ? ($post->hasBid() ? 'You have bid' : 'Propose') : 'You are owner',
                    'button_class' => 'glyphicon glyphicon-envelope button-like-link post-card-button-propose '
                         . ($post->hasBid() ? 'post-card-button-red ' : ' ') 

                         . ($post->isOwner() ? 'post-card-disabled' : '')
                    ,
                    'button_options' => [
                        'data-has_bid' => $post->hasBid()
                    ]
                ]) ?>
                <div class="post-card-total-favorite">
                    <?= $post->getTotalFavorites() ?>
                </div>

                <?= ButtonWithTooltip::widget(['id' => 'post-favorite-button', 
                    'tooltip_text' => 'Favorite',
                    'button_class' => 'glyphicon glyphicon-heart button-like-link post-card-button-favorite ' 

                         . ($post->hasFavorited() ? 'post-card-button-red' : ''),
                    'button_options' => [
                        'data-has_favorite' => $post->hasFavorited()
                    ]
                ]) ?>

            </div>
        
            
        </div>
        <div class="post-bids">
            <?= \frontend\widgets\BidContainer::widget(['id' => 'post-bid-container', 
                'bid_list' => $post->getBidList()]) ?>
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

