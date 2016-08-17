<?php
/** @var $post_vo frontend/vo/PostVo */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use frontend\widgets\HomeProposalBox;

?>

<div class="col-xs-8 col-xs-offset-1 post-index">
    <div class="post-section">
        <?= Html::img($post->getImage(), ['class' => 'post-image']) ?>
        <div class="post-information">
            <div class="post-title">
                <?= $post->getTitle() ?>            
            </div>
            <div class="post-description">
                <?= $post->getDescription() ?>
            </div>
            <div class="post-user-information">
                <?= Html::img($post->getPostCreatorPhotoPath(), ['class' => 'post-image-profile-pic']) ?> 
                <?= Html::a( $post->getPostCreatorFullName() , $post->getPostCreatorUserLink()) ?>
            </div>
        </div>
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
                <?= Html::button('<span class="glyphicon glyphicon-envelope"></span> Bid on this stuff', 
                        ['class' => 'btn btn-primary post-bid-button', 'id' => 'post-bid-button']) ?>
            </div>
        </div>
        <?= \frontend\widgets\BidContainer::widget(['id' => 'post-bid-container', 'post' => $post]) ?>
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
</div>

