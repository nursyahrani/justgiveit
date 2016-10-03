<?php 
    use yii\helpers\Html;
?>

<div id="<?= $id ?>" class="country-search" data-id="<?= $id ?>">
    <?= Html::button("<span class=\"country-search-total\">
        </span><span> Country</span>", ['class' => 'country-search-header']) ?>

    <div class="country-search-view hide">
        <div class="country-search-items-area">
        </div>
    </div>
    
</div>