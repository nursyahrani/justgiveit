<?php
use yii\helpers\Html;
use common\widgets\AutoHeightTextArea;
?>

<div class="profile-bio" id="<?= $id ?>">
    <div class="profile-bio-header">
        Intro
        <?=  Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['class' => 'profile-bio-edit']) ?>
    </div>
    <i><div class="profile-bio-information">
        <?= ($intro === '') ? 'Empty' : $intro ?>
    </div> </i>
    
    <div class="profile-bio-information-edit-area hide">
        <?=        AutoHeightTextArea::widget(['id' => $id . '-edit', 
                        'widget_class' => 'profile-bio-information-edit-text-area', 
                        'value' => $intro ,
                        'rows' => 2, 'placeholder' => 'Put Short Introduction about yourself [Press Enter]']) ?>
        <div class="profile-bio-information-edit-area-message">
            100
        </div>
    </div>
</div>
