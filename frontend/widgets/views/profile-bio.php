<?php
use yii\helpers\Html;
use common\widgets\AutoHeightTextArea;
?>

<div class="profile-bio" id="<?= $id ?>">
    <div class="profile-bio-header">
        Intro
        <?=  Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['class' => 'profile-bio-edit']) ?>
    </div>
    <div class="profile-bio-information">
        <i><?= ($intro === '') ? 'Empty' : $intro ?></i>
    </div>
    <div class="profile-bio-information-edit-area hide">
        <?=        AutoHeightTextArea::widget(['id' => $id . '-edit', 
                        'widget_class' => 'profile-bio-information-edit-text-area', 
                        'value' => $intro ,
                        'rows' => 2, 'placeholder' => 'Put Short Introduction about yourself [Press Enter]']) ?>
    </div>
</div>
