<?php
use frontend\widgets\PostCard;
use yii\helpers\Html;
?>

<div id="<?= $id ?>" class="profile-post-list">
    <div class="profile-post-list-swiper">
        <?= Html::button('<span class="glyphicon glyphicon-chevron-left"></span>', 
                ['class' => 'profile-post-list-chevron profile-post-list-chevron-left hide', 
                'align' => 'left']) ?>
        
        <?= Html::button('<span class="glyphicon glyphicon-chevron-right"></span>', 
                ['class' => 'profile-post-list-chevron profile-post-list-chevron-right hide', 
                'align' => 'right']) ?>
    </div>
    <div class="profile-post-list-area">
        <?php foreach($post_list as $post) { ?>
            <?= PostCard::widget(['id' => $id  . '-' . $post->getPostId(), 'post_vo' => $post]) ?>
        <?php } ?>
        
    </div>

</div>
