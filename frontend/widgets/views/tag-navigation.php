<?php
use frontend\widgets\TagNavigationItem;
use yii\helpers\Html;
$items = ['Book', 'Lecture note', 'Clothes', 'Gadget'];
?>

<div id="<?= $id ?>" class="tag-navigation" data-id="<?= $id ?>">
    <?= Html::textInput('search-tag', null, ['class' => 'tag-navigation-search', 'placeholder' => 'Search Product Type..']) ?>
    <div class="tag-navigation-starred">
        <div class="tag-navigation-header">
            <div class="tag-navigation-label">
                <span class="glyphicon glyphicon-star-empty"></span> Starred
            </div>
            <?= Html::button('<span class="glyphicon glyphicon-plus"></span>', 
                    ['class' => 'site-hide tag-navigation-header-button tag-navigation-starred-expand', 
                'align' => 'right']) ?>
            <?= Html::button('<span class="glyphicon glyphicon-minus"></span>', ['class' => 'tag-navigation-header-button tag-navigation-starred-collapse', 'align' => 'right']) ?>
        </div>
        <div class="tag-navigation-starred-area">
            <?php foreach($starred_tags as $tag) { ?>
                <?= TagNavigationItem::widget(['id' => 'starred-tags-' . $tag->getTagId(), 'tag' => $tag, 'tick' => $tag->isChecked()]) ?>
            <?php  } ?>
        </div>
    </div>
    <div class="tag-navigation-all">
        <div class="tag-navigation-header">
            <div class="tag-navigation-label">
                <span class="glyphicon glyphicon-list"></span> All

            </div>
            <?= Html::button('<span class="glyphicon glyphicon-plus"></span>', 
                    ['class' => 'site-hide tag-navigation-header-button tag-navigation-all-expand', 'align' => 'right']) ?>
            <?= Html::button('<span class="glyphicon glyphicon-minus"></span>', ['class' => 'tag-navigation-header-button tag-navigation-all-collapse', 'align' => 'right']) ?>
        
        </div>
        <div class="tag-navigation-all-area">
            <?php foreach($most_popular_tags as $tag) { ?>
                <?= TagNavigationItem::widget(['id' => 'most-popular-tags-' . $tag->getTagId(), 'tag' => $tag, 'tick' => $tag->isChecked()]) ?>
            <?php } ?>
        </div>
    </div>
    <div class="tag-navigation-searched site-hide">
        <div class="tag-navigation-header">
            <div class="tag-navigation-label">
                <span class="glyphicon glyphicon-search"></span> Search
            </div>
        </div>
        <div class="tag-navigation-searched-area">
            
        </div>
    </div>
</div>