


<div id="<?= $id ?>" 
     
     style="background: url('http:<?= Yii::$app->request->baseUrl . '/frontend/web/common-img/banner.jpg' ?>');"
     class="banner-with-search" data-id="<?= $id ?>">
    <div class='banner-with-search-header'>
        Give Small Things with Great Heart
    </div>
    <div class="banner-with-search-bar">
        <div class="banner-with-search-bar-area">
            <?= \frontend\widgets\SearchBar::widget(['id' => $id  . "-search-bar", 'initial_location' => $initial_location]) ?>
        </div>
    </div>
</div>