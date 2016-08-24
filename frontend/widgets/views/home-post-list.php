<?php
    use yii\helpers\Html;
    use kartik\dialog\Dialog;
    use yii\bootstrap\Modal;
    use frontend\widgets\HomeProposalBox;
    use common\widgets\ButtonWithTooltip;
    use common\libraries\CommonLibrary;
    /** @var $post_vo PostVo */
    $image_photo_path = $post_vo->getImage();
    $post_title = $post_vo->getTitle();
    $post_description = $post_vo->getDescription();
    $creator_full_name = $post_vo->getPostCreatorFullName();
    $creator_user_link = $post_vo->getPostCreatorUserLink();
    $creator_photo_path = $post_vo->getPostCreatorPhotoPath();
    $creator_user_id =  $post_vo->getPostCreatorId();
    $post_id = $post_vo->getPostId();
    $post_tags = $post_vo->getPostTags();
    $post_deadline = $post_vo->getDeadline();
    $post_link = $post_vo->getPostLink();
    $post_created_at = $post_vo->getCreatedAt();
?>

<?= Dialog::widget() ?>


<div id="<?= $id ?>" class="home-post-list-container" data-stuff_id="<?= $post_id ?>" data-is_owner ="<?= $post_vo->isOwner() ?>">
    <img class="home-post-list-img" src="<?= $image_photo_path ?>">
    <div class="home-post-list-view">
        <div class="home-post-list-header">
            Give &bull;
            <span class="home-post-list-tag">
                <?= Html::a($post_vo->getPostTags()[0], CommonLibrary::buildTagLibrary($post_vo->getPostTags()[0])) ?>
            </span>
        </div>
        <div class="home-post-list-name">
            <?= Html::a($post_title, $post_link)     ?>
        </div>
        
        <div class="home-post-list-button">
            <div class="home-post-list-total-bid">
                <?= $post_vo->getTotalBids() ?>
            </div>
            <?= ButtonWithTooltip::widget(['id' => $id . '-bid-button', 
                'tooltip_text' => !$post_vo->isOwner() ? ($post_vo->hasBid() ? 'You have bid' : 'Propose') : 'You are owner',
                'text' => '<span class="glyphicon glyphicon-envelope"></span>',
                'button_class' => 'button-like-link home-post-list-button-propose '
                     . ($post_vo->hasBid() ? 'home-post-list-button-red ' : ' ') 
                
                     . ($post_vo->isOwner() ? 'home-post-list-disabled' : '')
                ,
                'button_options' => [
                    'data-has_bid' => $post_vo->hasBid()
                ]
            ]) ?>
            <div class="home-post-list-total-favorite">
                <?= $post_vo->getTotalFavorites() ?>
            </div>
            
            <?= ButtonWithTooltip::widget(['id' => $id . '-favorite-button', 
                'tooltip_text' => 'Favorite',
                'text' => '<span class="glyphicon glyphicon-heart"></span>',
                'button_class' => 'button-like-link home-post-list-button-favorite ' 
                
                     . ($post_vo->hasFavorited() ? 'home-post-list-button-red' : ''),
                'button_options' => [
                    'data-has_favorite' => $post_vo->hasFavorited()
                ]
            ]) ?>

        </div>
        
        <div class='home-post-list-details'>
            <?=     Html::img($creator_photo_path, ['class' => 'home-post-list-creator-photo-path']) ?>
            <div class='home-post-list-details-name-and-created-time'>
                <?= Html::a($creator_full_name, $creator_user_link, ['class' => 'home-post-list-details-name']) ?>
                <div class='home-post-list-details-created-time'>
                    <?= $post_created_at ?>
                </div>

            </div>
        </div>
    </div>
    
    <?php
    Modal::begin([
        'options' => [
            'class' => 'home-post-list-proposal-box-modal'
        ],
        'size' => Modal::SIZE_LARGE
    ]);
        echo HomeProposalBox::widget(['id' => $id . '-proposal-box', 'post_vo' => $post_vo]);
    Modal::end();
    ?>
</div>
