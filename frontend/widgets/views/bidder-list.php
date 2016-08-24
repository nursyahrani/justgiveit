<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
?>

<div id="<?= $id ?>" class="bidder-list" data-stuff_id = <?= $stuff_id ?>>
    <div class='bidder-list-header'>
        Choose Bidder
    </div>
    <div class='bidder-list-area'>
        <?php foreach($bid_list as $bidder) { ?>
            <div class='bidder-list-item'>
                <?= Html::img($bidder->getCreatorPhotoPath(), ['class' => 'bidder-list-item-image']) ?>
                <div class="bidder-list-item-section">
                    
                    <?= Html::a($bidder->getCreatorFullName(), $bidder->getCreatorUserLink(), 
                            ['class' => 'bidder-list-full-name']) ?>
                    
                    <?= Html::button('Give', ['class' => 'bidder-list-item-give-button ' . 
                        ($bidder->hasObtained() ? 'bidder-list-hide ' : ''), 
                        'data-user_id' => $bidder->getCreatorId()]) ?>
                    <?= Html::button('Cancel', ['class' => 'bidder-list-item-cancel-button ' .
                        (!$bidder->hasObtained() ? 'bidder-list-hide ' : ''),
                        'data-user_id' => $bidder->getCreatorId()]) ?>
                </div>
                    
            </div>
        <?php } ?>
    </div>
</div>