<?php

use yii\bootstrap\Html;
use frontend\widgets\PostComment;
?>

<div id="<?= $id ?>" class="post-comment-container" data-id="<?= $id ?>" data-post_id="<?= $post_id ?>">
    <div class="post-comment-container-text-box">
        <?=        \common\widgets\AutoHeightTextArea::widget(['id' => $id . '-text-area','rows' => 3, 'placeholder' => 'Write a comment...',
            'widget_class' => 'post-comment-container-text-box']) ?>
        <div class="post-comment-container-text-box-error site-input-error">
            
        </div>
        <?= Html::button('Comment', ['class' => 'btn btn-primary post-comment-container-submit-comment']) ?>
    </div>
    <div class="post-comment-container-area">
        <?php foreach($post_comments as $post_comment) { ?>
            <?= PostComment::widget(['id' => $id . '-post-comment-' . $post_comment->getCommentId(), 'post_comment' => $post_comment]) ?>
        <?php } ?>
    </div>
    
</div>