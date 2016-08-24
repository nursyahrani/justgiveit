<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\bootstrap\Html;
?>
<div id='<?= $id ?>' class='image-view-editor'>
    <?= Html::img($post->getImage(), ['class' => 'image-view-editor-image']) ?>
    <?= Html::button('Change Photo', ['class' => 'image-view-editor-button']) ?>
</div>