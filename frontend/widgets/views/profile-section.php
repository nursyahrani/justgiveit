<?php
use frontend\widgets\ImageViewEditor;
use yii\helpers\Html;
?>

<div id="<?= $id ?>" class="profile-section">
    <div class="profile-section-image">
        <?=  ImageViewEditor::widget(['id' => 'profile-section-image-view',
                                    'image_path' => $profile->getProfilePic(), 'active' => true,
                                    'modal_title' => $profile->getFullName()]) ?>
    </div>
    <div class="profile-section-information">
        <div class="profile-section-information-name">
            <?= $profile->getFullName() ?>
        </div>
        <div class="profile-section-information-location">
            
        </div>
    </div>
    <?= Html::button('Edit Profile', ['class' => 'profile-section-information-edit']) ?>
</div>