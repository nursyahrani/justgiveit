<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use frontend\widgets\BidReply;
?>

<div class="bid-reply-container" id="<?= $id ?>" data-id="<?= $id ?>" data-bid_id="<?= $bid_id ?>"
     data-offset="<?= $offset ?>" data-first_created_at="<?= $first_created_at ?>"> 
    <div class="bid-reply-container-item-transition">
        
    </div>
    <div class="bid-reply-container-item-area">
        <?php if($chosen_bid_reply instanceof \frontend\vo\BidReplyVo) { ?>
            <?=   BidReply::widget(['id' => $id ,      'bid_reply' => $chosen_bid_reply]) ?>
            
        <?php } ?>
        
    </div>
    
    <?= Html::button("Load Replies (<span class='bid-reply-container-total-replies'>$total_more_replies</span>+) ", 
            ['class' => (($total_more_replies === 0) ? 'hide' : '') . ' bid-reply-container-load-replies '  ]); ?>

</div>