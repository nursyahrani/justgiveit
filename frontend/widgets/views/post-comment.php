<?php 

use yii\helpers\Html;
?>

<div id="<?= $id ?>" class="post-comment">
    <div class="post-comment-header">
        <?=        Html::img($post_comment->getCreatorPhotoPath(), ['class' => 'post-comment-creator-photo']) ?>
        <?= Html::a($post_comment->getCreatorFullName(), $post_comment->getCreatorUserLink(), ['class' => 'post-comment-user-link']); ?>
    </div>
    <div class="post-comment-message">
        <?= $post_comment->getMessage() ?>
    </div>
</div>