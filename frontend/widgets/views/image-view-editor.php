<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
?>
<div id='<?= $id ?>' class='image-view-editor' data-id="<?= $id ?>">
    <?= Html::img($image_path, ['class' => 'image-view-editor-image default-image']) ?>

    <?php
        Modal::begin([
            'options' => [
                    'id' => $id . '-modal',
                    'class' => 'image-view-editor-photo-modal'
            ]
        ]);
            echo Html::img($image_path, ['class' => 'image-view-editor-image-modal']);

        Modal::end();
    ?>    
    
    
</div>