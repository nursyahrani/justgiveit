<?php
    use yii\helpers\Html;
    ?>
<div id="<?= $id ?>" class="quantity-widget">
    <?=    Html::button('<span class="glyphicon glyphicon-minus"></span>', ['class' => 'quantity-widget-button quantity-widget-minus']) ?>
    <?=    Html::input('number', 'quantity', 0, ['class' => 'quantity-widget-number-input']) ?>
    <?=    Html::button('<span class="glyphicon glyphicon-plus"></span>', ['class' => 'quantity-widget-button quantity-widget-plus']) ?>
</div>