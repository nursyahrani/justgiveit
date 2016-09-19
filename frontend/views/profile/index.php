<?php
    use yii\helpers\Html;
    use frontend\widgets\ProfileSection;
    use frontend\widgets\ProfileBio;
    use frontend\widgets\ProfilePostList;
    use kartik\tabs\TabsX;
    $items = array();
    $items[] = ['label' => 'Stuffs (' . $profile->getTotalGives() . ')', 
                'content' => ProfilePostList::widget(['id' => 'profile-post-list-gives', 'post_list' => $profile->getGiveList()]) ];
?>
<div class="profile-index">
    <?=    ProfileSection::widget(['id' => 'profile-section', 'profile' => $profile]) ?>
    <?=    ProfileBio::widget(['id' => 'profile-bio', 'intro' => $profile->getIntro()]) ?>
    <?= TabsX::widget([
        'id' => 'profile-tabs',
        'options' => [
            'class' => 'profile-tabs'
        ],
        'items' => $items
    ]) ?>
   
</div>

