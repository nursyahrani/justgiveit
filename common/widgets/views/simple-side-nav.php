<?php
use yii\bootstrap\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div id='<?= $id ?>' class='simple-side-nav-container'>
    <div class='simple-side-nav-title'>
        <?= $title ?>
    </div>
    <div class='simple-side-nav-area'>
        <?php foreach($items as $item) { ?>
            <?= Html::a($item['label'], $item['url'], ['class' => 'simple-side-nav-item']) ?>
        <?php } ?>
    </div>
</div>