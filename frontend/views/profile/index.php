<?php
    use yii\helpers\Html;
?>
<div class="profile-index">
    <div class="profile-header" style="margin-top: 12px">
            <?= Html::img($profile->getProfilePic(), ['class' => 'profile-header-profile-pic']) ?>
        <div class="profile-header-information">
            <div class="profile-header-information-full-name">
                <?= $profile->getFullName() ?>
            </div>
            <div class="profile-header-information-total-favorites">
               #Thanks:  <?= $profile->getTotalFavorites() ?>
            </div>
            <div class="profile-header-information-total-bids">
                #Bids: <?= $profile->getTotalBids() ?> 
            </div>
            <div class="profile-header-information-total-gives">
                #Gives: <?= $profile->getTotalGives() ?>
            </div>
        </div>
    </div>

    <div class="profile-data">
            <?php if($profile->getGiveList() !== null) {  ?>
                <?= 
                frontend\widgets\PostList::widget(['id' => 'post-list', 'posts' => $profile->getGiveList()]) ?>
            <?php }   ?>
    </div>
</div>

