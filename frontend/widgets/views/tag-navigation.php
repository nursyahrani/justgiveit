<?php

use yii\helpers\Html;
$items = ['Book', 'Lecture note', 'Clothes', 'Gadget'];
?>

<div id="<?= $id ?>" class="tag-navigation" data-id="<?= $id ?>">
    <div class="tag-navigation-label">
        Navigation
    </div>
    <div class="tag-navigation-all">
        <?=  Html::checkbox('All', false, ['class' => 'tag-navigation-all-checkbox', 'data-item'   => 'All' ]) ?>
        <span class="tag-navigation-all-label"> All</span>
    </div>
    <?php foreach($items as $item) { ?>
        <div class="tag-navigation-item">
            <?=  Html::checkbox($item, false, ['class' => 'tag-navigation-item-checkbox', 'data-item'   => $item ]) ?>
            <span class="tag-navigation-item-label"> <?= $item ?></span>
        </div>
    <?php } ?>
</div>