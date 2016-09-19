<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\libraries\CommonLibrary;
use yii\helpers\Html;
use common\widgets\QuantityWidget;
use common\models\Post;
use common\widgets\AutoHeightTextArea;

$status_open_sup_class = 'post-section-status post-section-status-open';
$status_closed_sup_class = 'post-section-status post-section-status-closed';
$status_open_button_class = 'post-section-owner-close';
$status_closed_button_class = 'post-section-owner-reopen';

if($post->getPostStatus() === Post::STATUS_ACTIVE) {
    $status_closed_sup_class .= ' hide';
    $status_closed_button_class .= ' hide';
    
} else if( $post->getPostStatus() === Post::STATUS_CLOSED) {
    $status_open_sup_class .= ' hide';
    $status_open_button_class .= ' hide';
}
?>
<div id="<?= $id ?>" data-id="<?= $id ?>" data-stuff_id ="<?= $post->getPostId() ?>" class="post-section">
    <div class="post-section-view">
        <div class="post-section-tags">
            <?php foreach($post->getPostTags() as $tag) { ?>
                <?= Html::a($tag, CommonLibrary::buildTagLibrary($tag)) ?>
            <?php } ?>
        </div>
        <div class="post-section-title">
            <?= $post->getTitle() ?>    
            <sup class="<?= $status_open_sup_class ?>">OPEN</sup>    
            <sup class="<?= $status_closed_sup_class ?>">CLOSED</sup>        

        </div>
        <?php if(!$post->isOwner()) { ?>
            <div class="post-section-quantity">
                <div class="post-section-quantity-area">
                    <?= QuantityWidget::widget(['id' => $id . '-quantity-widget', 'max_value' => $post->getQuantity()]) ?> &nbsp; of <?= $post->getQuantity() ?> 
                </div>
                <div class="post-section-quantity-error site-input-error">

                </div>
            </div>
            <div class="post-section-text-area-section">
                <?= AutoHeightTextArea::widget(['id' => $id . '-text-area', 'widget_class' => 'post-section-text-area',
                    'placeholder' => 'Write proposal here..','rows' => 4
                    ])   ?> 
                <div class="post-section-text-area-section-error site-input-error">

                </div>
            </div>
            <div class="post-section-button-section">
                <?php if(!$post->hasBid()) { ?>
                <?= Html::button('<span class="glyphicon glyphicon-send"></span> Send Proposal', ['class' => 'site-button site-blue-button'
                    . ' post-section-bid']) ?>
                <?php } else {?>
                
                <?= Html::button('<span class="glyphicon glyphicon-send"></span> Send New Proposal', ['class' => 'site-button site-blue-button'
                    . ' post-section-bid']) ?>
                <?php } ?>
                
                <?= Html::button('<span class="glyphicon glyphicon-heart"></span> Send Thanks', 
                                ['class' => (!$post->hasFavorited() ? '' : ' hide') . ' site-button site-red-button post-section-request-favorite ']
                        ) ?>

                <?= Html::button('<span class="glyphicon glyphicon-heart"></span> Thanks Sent', 
                        ['class' => (!$post->hasFavorited() ? 'hide' : ' cancel') . ' site-button site-red-button post-section-cancel-favorite ']) ?>
            </div>
        
        <?php } else { ?>
            <div class="post-section-owner">
                You are the owner
            </div>
            <div class="post-section-owner-button">
                <?= Html::button('<span class="glyphicon glyphicon-pencil"></span> Edit', ['class' => 'site-button site-blue-button post-section-owner-edit']) ?>
                <?= Html::button('Close', ['class' => 'site-button site-maroon-button ' . $status_open_button_class]) ?>
                <?= Html::button('Reopen', ['class' => 'site-button site-green-button ' . $status_closed_button_class]) ?>
                
                <?= Html::button('<span class="glyphicon glyphicon-remove"></span> Delete', ['class' => 'site-button site-red-button post-section-owner-delete']) ?>
            </div>
        <?php } ?>
    </div>
    <div class="post-section-edit hide">
        <?=frontend\widgets\EditPost::widget(['id' => $id . '-edit-post', 'post' => $post]) ?>
     </div>
</div>