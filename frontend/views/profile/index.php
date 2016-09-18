<?php
    use yii\helpers\Html;
    use frontend\widgets\ProfileSection;
    use frontend\widgets\ProfileBio;
    use frontend\widgets\ProfilePostList;
?>
<div class="profile-index">
    <?=    ProfileSection::widget(['id' => 'profile-section', 'profile' => $profile]) ?>
    <?=    ProfileBio::widget(['id' => 'profile-bio', 'intro' => '']) ?>
    <div class="profile-label">
        Stuffs ( <?= $profile->getTotalGives() ?> )
    </div>
    <?=  ProfilePostList::widget(['id' => 'profile-post-list-gives', 'post_list' => $profile->getGiveList()]) ?>
   
</div>

