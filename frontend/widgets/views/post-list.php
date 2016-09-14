<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use frontend\widgets\PostCard;
use common\widgets\Loading;
?>

<div id="<?= $id ?>" class="post-list" data-id="<?= $id ?>"
     data-location="<?= $current_location ?>">
    <div class="post-list-header">
        Take All These Stuffs for Free!
    </div>
    <?= Loading::widget(['id' => $id .'-new-loading']) ?>
    <div class="post-list-area">
        <?php foreach($posts as $post) { ?>
            <?= PostCard::widget(['id' => $id . '-item-' . $post->getPostId(),
                           'post_vo' => $post]); ?>

        <?php } ?>
    </div>
    
    <?= Loading::widget(['id' => $id .'-get-more-loading']) ?>
    <div class="post-list-no-more hide">
        You reached the end
    </div>
</div>
