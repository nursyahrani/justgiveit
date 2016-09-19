<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="<?= $id ?>" class="<?= $widget_class ?> 
          auto-height-text-area" rows=<?= $rows ?> placeholder="<?= $placeholder ?>"  contenteditable="true"
          style="min-height: <?= $rows * 24 ?>px"
          ><?= $value ?>
</div>