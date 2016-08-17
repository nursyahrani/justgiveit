<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
$button_options['class'] = $button_class . ' button-with-tooltip-button';
$button_options['data-widget'] = $id ;
?>

<div id="<?= $id ?>" class="button-with-tooltip-container" >
    <div class="button-with-tooltip-tooltip button-with-tooltip-hide">
        <?= $tooltip_text ?>
    </div>
    <?= Html::button($text, $button_options) ?>
    
</div>

