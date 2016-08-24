<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
?>

<div class="home-profile-view" id="<?= $id ?>">
    <div class="home-profile-view-header">
        <?= Html::img($profile->getProfilePic(), ['class' => 'home-profile-view-image']) ?>
        <?= Html::a($profile->getFullName(), $profile->getUserLink(), ['class' => 'home-profile-view-name']) ?>
    </div>
    <div class="home-profile-view-footer">
        <div class="home-profile-view-footer-item">
            <?= $profile->getTotalGives() ?>
            <div class="home-profile-view-footer-item-label">
                Gives
            </div>
        </div>
        <div class="home-profile-view-footer-item">
            <?= $profile->getTotalBids() ?>
            <div class="home-profile-view-footer-item-label">
                Bids
            </div>
        </div>
        <div class="home-profile-view-footer-item">
            <?= $profile->getTotalFavorites() ?>
            <div class="home-profile-view-footer-item-label">
                Favorites
            </div>
        </div>
    </div>
</div>