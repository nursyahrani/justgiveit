<?php

use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use frontend\widgets\HomePostList;
use common\widgets\SimpleSideNav;
/* @var $this yii\web\View */
/* @var $home_vo frontend\vo\HomeVo **/
$post_list_provider = $home_vo->getPostList();
$this->title = 'Just Give it';
?>
<div class="site-index">
    <div class="container">
        <div class='col-md-2'>
            <?=   SimpleSideNav::widget(['id' => 'simple-side-nav-tags', 'items' => $home_vo->getSidenavItems(),
                'title' => 'Navigation by tags']) ?>
        </div>
        <div class='col-md-10'>
            <?= ListView::widget([
                'id' => 'home-list',
                'dataProvider' => $post_list_provider,
                'summary' => false,
                'itemOptions' => ['class' => 'col-lg-3 col-md-6 col-xs-12 '],
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
                       return \frontend\widgets\HomePostList::widget(['id' => 'home-post-list-' . $model->getPostId(),
                           'post_vo' => $model]);
                }
            ])
            ?>
        </div>
    </div>
</div>
