<?php
use yii\helpers\Html;

?>

<div class="tag-navigation-item" id="<?= $id ?>" data-id="<?= $id ?>" data-label="<?= $tag->getTagName() ?>" data-tick="<?= $tick ?>">
    <div class="tag-navigation-item-label">
        <?= $tag->getTagName() ?>
    </div>
    <div class="tag-navigation-item-button">
        <?= Html::button('<span class="glyphicon glyphicon-ok"></span>', ['class' => ($tick ? '' : 'hide ') .  'tag-navigation-item-tick']) ?>
        <?= Html::button('<span class="glyphicon glyphicon-star-empty"></span>', ['class' => (!$tag->isStarred() ? '' : 'hide ' ). 'tag-navigation-item-unfavorite']) ?>
        <?= Html::button('<span class="glyphicon glyphicon-star"></span>', ['class' => ($tag->isStarred() ? '' : 'hide ' ). 'tag-navigation-item-favorite']) ?>
    </div>
</div>