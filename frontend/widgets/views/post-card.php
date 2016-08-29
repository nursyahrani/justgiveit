<?php
    use yii\helpers\Html;
    use kartik\dialog\Dialog;
    use yii\bootstrap\Modal;
    use frontend\widgets\HomeProposalBox;
    use common\widgets\ButtonWithTooltip;
    use common\libraries\CommonLibrary;
    use frontend\widgets\ImageViewEditor;
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


<div id="<?= $id ?>" class="post-card" data-stuff_id="<?= $post_id ?>" 
     data-is_owner ="<?= $post_vo->isOwner() ?>" data-id="<?= $id ?>">
    <?= ImageViewEditor::widget(['id' => $id . '-image-view' , 
        'image_path' => $post_vo->getImage() , 'active' => false]) ?>
    <div class="post-card-view">
        <?= Html::a($post_title, $post_link, ['class' => 'post-card-name'])     ?>
       
        <div class="post-card-button">
            <div class="post-card-total-bid">
                <?= $post_vo->getTotalBids() ?>
            </div>
            <?= ButtonWithTooltip::widget(['id' => $id . '-bid-button', 
                'tooltip_text' => !$post_vo->isOwner() ? ($post_vo->hasBid() ? 'You have bid' : 'Propose') : 'You are owner',
                'button_class' => 'glyphicon glyphicon-envelope button-like-link post-card-button-propose '
                     . ($post_vo->hasBid() ? 'post-card-button-red ' : ' ') 
                
                     . ($post_vo->isOwner() ? 'post-card-disabled' : '')
                ,
                'button_options' => [
                    'data-has_bid' => $post_vo->hasBid()
                ]
            ]) ?>
            <div class="post-card-total-favorite">
                <?= $post_vo->getTotalFavorites() ?>
            </div>
            
            <?= ButtonWithTooltip::widget(['id' => $id . '-favorite-button', 
                'tooltip_text' => 'Favorite',
                'button_class' => 'glyphicon glyphicon-heart button-like-link post-card-button-favorite ' 
                
                     . ($post_vo->hasFavorited() ? 'post-card-button-red' : ''),
                'button_options' => [
                    'data-has_favorite' => $post_vo->hasFavorited()
                ]
            ]) ?>

        </div>
        
    </div>
    
    <?php
    Modal::begin([
        'id' => $id . '-proposal-modal',
        'options' => [
            'class' => 'post-card-proposal-box-modal'
        ],
        'size' => Modal::SIZE_LARGE
    ]);
        echo HomeProposalBox::widget(['id' => $id . '-proposal-box', 'post_vo' => $post_vo]);
    Modal::end();
    ?>
</div>
