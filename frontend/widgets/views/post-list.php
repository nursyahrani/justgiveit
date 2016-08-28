<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use frontend\widgets\PostCard;
use common\widgets\Loading;
?>

<div id="<?= $id ?>" class="post-list" data-id="<?= $id ?>">
    <div class="post-list-area">
        <?php foreach($posts as $post) { ?>
            <?= PostCard::widget(['id' => $id . '-item-' . $post->getPostId(),
                           'post_vo' => $post]); ?>

        <?php } ?>
    </div>
    <div class="post-list-loading">
        <?= Loading::widget(['id' => $id .'-loading']) ?>
    </div>
</div>
