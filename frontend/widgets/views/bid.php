<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\bootstrap\Html;
?>

<div id="<?= $id ?>" class="bid" data-id="<?= $id ?>">
    <div class="bid-header">
        <?=  Html::img($bid->getCreatorPhotoPath(), ['class' => 'bid-creator-photo-path']) ?>
        <span class="bid-creator-full-name">
            <?= Html::a($bid->getCreatorFullName(), $bid->getCreatorUserLink()) ?>
        </span>
    </div>
    
    <div class="bid-detail">
        <?= $bid->getMessage() ?>
     </div>
</div>