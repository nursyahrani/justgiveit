<?php

use yii\widgets\ListView;
use kop\y2sp\ScrollPager;

/* @var $this yii\web\View */
/* @var $post_data_provider \yii\data\ArrayDataProvider **/
$this->title = 'Just Give it';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?= ListView::widget([
                'id' => 'post_list',
                'dataProvider' => $post_data_provider,
                'summary' => false,
                'itemOptions' => ['class' => 'item'],
                'pager' => [
                    'class' => ScrollPager::class,
                    'enabledExtensions' => [
                        ScrollPager::EXTENSION_TRIGGER,
                        ScrollPager::EXTENSION_SPINNER,
                        ScrollPager::EXTENSION_NONE_LEFT,
                        ScrollPager::EXTENSION_PAGING,
                    ],
                    'triggerOffset' => 100
                ],
                'itemView' => function ($model, $key, $index, $widget) {
                       return $this->render('_list_post',['model' => $model]);
                }
            ])
            ?>
        </div>


    </div>
</div>
