<?php
    use yii\helpers\Html;
    use kartik\dialog\Dialog;
    use yii\bootstrap\Modal;
    use frontend\widgets\HomeProposalBox;
    use common\widgets\ButtonWithTooltip;
    use common\libraries\CommonLibrary;
    use frontend\widgets\ImageViewEditor;
    /** @var $post_vo PostVo */
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

<div id="<?= $id ?>" class="post-card" data-stuff_id="<?= $post_id ?>" 
     data-is_owner ="<?= $post_vo->isOwner() ?>" data-id="<?= $id ?>" data-post_link="<?= $post_link ?>">
    <?= Html::img($post_vo->getImage(290,290), ['class' => 'post-card-img']) ?>
    <div class="post-card-view">
        <?= Html::a($post_title, $post_link, ['class' => 'post-card-name'])     ?>
       
        <div class="post-card-button">
            <span class="glyphicon glyphicon-heart post-card-logo <?= ($post_vo->hasFavorited()) ? 'post-card-button-red' : '' ?>" >
            </span>
            <div class="post-card-total-favorite">
                <?= $post_vo->getTotalFavorites() ?>
            </div>
            
            <div class="post-card-right">
                <?= $post_vo->getPostTags()[0] ?>
            </div>
        </div>
    </div>
    
</div>
