<?php
    use yii\helpers\Html;
    ?>
<div id="<?= $id ?>" class="quantity-widget" data-max_value="<?= $max_value ?>">
    <?=    Html::button('<span class="glyphicon glyphicon-minus"></span>', ['class' => 'quantity-widget-button quantity-widget-minus']) ?>
    <?=    Html::input('number', 'quantity', 1, ['class' => 'quantity-widget-number-input', 'max' => $max_value, 'min' => 1]) ?>
    <?=    Html::button('<span class="glyphicon glyphicon-plus"></span>', ['class' => 'quantity-widget-button quantity-widget-plus']) ?>
</div>