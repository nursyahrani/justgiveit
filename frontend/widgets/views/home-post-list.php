<?php
    use yii\helpers\Html;
    use kartik\dialog\Dialog;
    use yii\bootstrap\Modal;
    use frontend\widgets\HomeProposalBox;
    use common\widgets\ButtonWithTooltip;
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


<div id="<?= $id ?>" class="home-post-list-container" data-id="<?= $post_id ?>" >
    <img class="home-post-list-img" src="<?= $image_photo_path ?>">
    <div class="home-post-view">
        <div class="home-post-list-name">
            <?= Html::a($post_title, $post_link)     ?>
        </div>
        
        <div class="home-post-list-button">
            <?= ButtonWithTooltip::widget(['id' => $id . '-bid-button', 
                'tooltip_text' => 'Send Message to Propose',
                'text' => '<span class="glyphicon glyphicon-envelope"></span>',
                'button_class' => 'button-like-link home-post-list-button-propose',
                'button_options' => [
                    'data-id' => $id,
                    'data-service' => $post_id
                ]
            ]) ?>

        </div>
        
        <div class='home-post-list-details'>
            <?=     Html::img($creator_photo_path, ['class' => 'home-post-list-creator-photo-path']) ?>
            <div class='home-post-list-details-name-and-created-time'>
                <div class='home-post-list-details-name' >
                    <?= Html::a($creator_full_name, $creator_user_link) ?>
                </div>
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
