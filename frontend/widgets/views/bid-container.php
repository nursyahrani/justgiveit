<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use frontend\widgets\Bid;
?>

<div id="<?= $id ?>" class="bid-container">
    <div class="bid-list-area">
        <?php foreach($bid_list as  $bid) { ?>
            <?= Bid::widget(['bid' => $bid, 'id' => 'bid-' . $bid->getBidId(), 'post_owner' => $post_owner]) ?>
        <?php } ?>
    </div>
</div>