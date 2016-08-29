<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use frontend\widgets\BidReply;
?>

<div class="bid-reply-container" id="<?= $id ?>" data-id="<?= $id ?>" data-bid_id="<?= $bid_id ?>">
    <div class="bid-reply-container-item-transition">
        
    </div>
    <div class="bid-reply-container-item-area">
        <?php if($chosen_bid_reply instanceof \frontend\vo\BidReplyVo) { ?>
            <?=   BidReply::widget(['id' => $id ,      'bid_reply' => $chosen_bid_reply]) ?>
            
        <?php } ?>
        
    </div>
</div>