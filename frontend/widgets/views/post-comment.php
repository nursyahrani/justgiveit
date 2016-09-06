<?php 

use yii\helpers\Html;
?>

<div id="<?= $id ?>" class="post-comment" data-id="<?= $id ?>" data-comment_id="<?= $post_comment->getCommentId() ?>"
     data-user_link="<?= $post_comment->getCreatorUserLink() ?>" data-full_name="<?= $post_comment->getCreatorFullName() ?>">
    <div class="post-comment-header">
        <?=        Html::img($post_comment->getCreatorPhotoPath(), ['class' => 'post-comment-creator-photo']) ?>
        <?= Html::a($post_comment->getCreatorFullName(), $post_comment->getCreatorUserLink(), ['class' => 'post-comment-user-link']); ?>
        <span class="post-comment-time">
            - <?= $post_comment->getCreatedAt() ?>
        </span>
    </div>
    <div class="post-comment-message">
        <?= $post_comment->getMessage() ?>
    </div>
    <div class="post-comment-button">
        <?= Html::button('Reply', ['class' => 'post-comment-reply']) ?>
        <?php if($post_comment->isOwner()) { ?>
            <?= Html::button('Edit', ['class' => 'post-comment-edit']) ?>
            <?= Html::button('Delete', ['class' => 'post-comment-delete']) ?>
        <?php } ?>
    </div>
</div>