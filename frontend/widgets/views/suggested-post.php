<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use frontend\widgets\PostCard;
?>

<div id="<?= $id ?>" class="suggested-post">
    <div class="suggested-post-header">
        Suggested Post
    </div>
    <?php foreach($post_list as $post) { ?>
        <?= PostCard::widget(['id' => $id . '-post-' . $post->getPostId(), 'post_vo' => $post]) ?>
    <?php } ?>
</div>