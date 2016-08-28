


<div id="<?= $id ?>" style="background: url('http:<?= Yii::$app->request->baseUrl . '/frontend/web/common-img/banner.jpg' ?>');"
     class="banner-with-search" id="<?= $id ?>">
    <div class='banner-with-search-header'>
        Give Small Things with Great Heart
    </div>
    <div class="banner-with-search-bar">
        <?= \frontend\widgets\SearchBar::widget(['id' => $id  . "-search-bar"]) ?>
        
    </div>
</div>