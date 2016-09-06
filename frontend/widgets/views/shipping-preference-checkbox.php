<?php

use yii\helpers\Html;
?>

<div class="shipping-preference-checkbox" id="<?= $id ?>">
    <div class="shipping-preference-checkbox-item shipping-preference-checkbox-delivery-area">
        <?= Html::radio('shipping-preference', false, ['value' => 'delivery', 'class' => 'shipping-preference-checkbox-delivery']) ?>
        <span class="shipping-preference-checkbox-label">Delivery</span>
    </div>
    <div class="shipping-preference-checkbox-item shipping-preference-checkbox-meet-up-area">
        <?= Html::radio('shipping-preference', false, ['value' => 'meet-up', 'class' => 'shipping-preference-checkbox-meet-up']) ?>
        <span class="shipping-preference-checkbox-label">Meet up</span>
    </div>
</div>