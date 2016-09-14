<?php
use yii\helpers\Html;
use common\libraries\CommonImageLibrary;
?>

<div id="<?= $id ?>" class="banner">
    <?=    Html::img(CommonImageLibrary::getBanner(), ['class' => 'banner-background']) ?>
    <div class="banner-view">
        <div class="banner-view-header">
            Give and Get Your Stuff for Free
        </div>
        <div class="banner-view-footer">
        <div class="banner-label">
            Do you have a stuff to give?
        </div>
        <?= Html::a('Give it Away Now!', Yii::$app->request->baseUrl . '/post/create',['class' => 'banner-give']) ?>
            
        </div>
    </div>
</div>
