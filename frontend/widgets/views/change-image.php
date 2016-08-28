<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\libraries\CommonImageLibrary;
use yii\helpers\Html;
$image_path = ($initial_image !== null) ? $initial_image : CommonImageLibrary::getNoPhotoPic();
?>

<div id="<?= $id ?>" class="change-image" data-id="<?= $id ?>"> 
    <div class="change-image-area">
        
        <?= Html::img($image_path, ['class' => 'change-image-view default-image']) ?>
        <?= Html::label('Select Photo', $id . '-label', ['class' => 'change-image-label']) ?>
        <?= Html::fileInput('Select Photo', null, ['class' => 'change-image-select-photo hide', 
            'id' => $id . '-label']) ?>
        <div class="change-image-error site-input-error">

        </div>
    </div>
    <div class="change-image-button">
        <?= Html::button('Confirm', ['class' => 'change-image-button-ok btn btn-primary hide']) ?>
        <?= Html::button('Cancel', ['class' => 'change-image-button-cancel btn btn-danger']) ?>
    </div>

</div>