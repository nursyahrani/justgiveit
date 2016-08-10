<?php

use yii\widgets\ListView;
use kop\y2sp\ScrollPager;

/* @var $this yii\web\View */
/* @var $home_vo frontend\vo\HomeVo **/
$post_list_provider = $home_vo->getPostList();
$this->title = 'Just Give it';
?>
<div class="site-index">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3 col-xs-12 give-stuff-modal-button-section">
                <?=        \yii\helpers\Html::button('Give my stuff', ['class' => 'btn btn-default give-stuff-modal-button'
                    ]) ?>
            </div>
            <?= ListView::widget([
                'id' => 'post-list',
                'dataProvider' => $post_list_provider,
                'summary' => false,
                'itemOptions' => ['class' => 'item post-item'],
                'pager' => [
                    'class' => ScrollPager::class,
                    'enabledExtensions' => [
                        ScrollPager::EXTENSION_TRIGGER,
                        ScrollPager::EXTENSION_SPINNER,
                        ScrollPager::EXTENSION_NONE_LEFT,
                        ScrollPager::EXTENSION_PAGING,
                    ],
                    'triggerOffset' => 100,
                ],
                'itemView' => function ($model, $key, $index, $widget) {
                       return $this->render('home-post-list',['post_vo' => $model]);
                }
            ])
            ?>
        </div>
    </div>
</div>
