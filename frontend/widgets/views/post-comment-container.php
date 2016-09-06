<?php

use yii\bootstrap\Html;
?>

<div id="<?= $id ?>" class="post-comment-container" data-id="<?= $id ?>" data-post_id="<?= $post_id ?>">
    <div class="post-comment-container-text-box">
        <?=        \common\widgets\AutoHeightTextArea::widget(['id' => $id . '-text-area','rows' => 3, 'placeholder' => 'Write a comment...']) ?>
        <div class="post-comment-container-text-box-error site-input-error">
            
        </div>
        <?= Html::button('Comment', ['class' => 'btn btn-primary post-comment-container-submit-comment']) ?>
    </div>
    <div class="post-comment-container-area">
        
    </div>
    
</div>