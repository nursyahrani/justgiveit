<?php

use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use frontend\widgets\HomePostList;
use common\widgets\SimpleSideNav;
use yii\helpers\Html;
use frontend\widgets\HomeProfileView;
/* @var $this yii\web\View */
/* @var $home_vo frontend\vo\HomeVo **/
$post_list_provider = $home_vo->getPostList();
$this->title = 'Just Give it';
?>
<div class="site-index">
<!--        <div class='col-md-2'>
            <?php //   SimpleSideNav::widget(['id' => 'simple-side-nav-tags', 'items' => $home_vo->getSidenavItems(),
                //'title' => 'Navigation by tags']) ?>
    </div>-->
    <div class='col-md-9 col-xs-9 site-post-area'>
        <?=        frontend\widgets\SearchBar::widget(['id' => 'search-bar']) ?>
        <div class="site-banner">
            <p>Give Small Things with Great Heart</p>
           
            <?= Html::button('Start Giving Stuff Today', ['class' => 'btn btn-primary site-banner-button']) ?>
        </div>
        <?= ListView::widget([
            'id' => 'home-list',
            'dataProvider' => $post_list_provider,
            'summary' => false,
            'itemOptions' => ['class' => 'col-lg-6 col-md-12 col-xs-12 home-post-list'],
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
    <div class="col-md-3 col-xs-3 col-lg-3 hide-right-side">
        <?= HomeProfileView::widget(['id' => 'home-profile-view', 'profile' => $home_vo->getHomeProfileView()]) ?>
        <?= SimpleSideNav::widget(['id' => 'simple-side-nav-tags', 'items' => $home_vo->getSidenavItems(),
                'title' => 'Navigation by tags']) ?>
        <?= SimpleSideNav::widget(['id' => 'simple-side-most-popular', 'items' => $home_vo->getMostPopularPost(),
         'title' => 'Popular Post']) ?>
 
    </div>
</div>
