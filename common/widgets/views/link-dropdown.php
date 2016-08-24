<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
?>

<div id="<?= $id ?>" class="link-dropdown">
    <?= Html::button($label, ['class' => 'link-dropdown-button ' .$button_class]) ?>
    <div class="link-dropdown-area">
        <?php foreach($items as $item) { 
            if(isset($item['options']) ) {
               
                $options = $item['options'];
    
            }  
            $options['class'] = 'link-dropdown-item';
                      
            echo Html::a($item['label'], $item['url'], $options);
         } ?>
    </div>
</div>