<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\libraries\CommonLibrary;
use yii\helpers\Html;
use common\widgets\QuantityWidget;
use common\widgets\AutoHeightTextArea;
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
                <?= Html::button('<span class="glyphicon glyphicon-send"></span> Send Proposal', ['class' => 'btn btn-primary'
                    . ' post-section-bid']) ?>
                <?php } else {?>
                
                <?= Html::button('<span class="glyphicon glyphicon-send"></span> Send New Proposal', ['class' => 'btn btn-primary'
                    . ' post-section-bid']) ?>
                <?php } ?>
                
                <?= Html::button('<span class="glyphicon glyphicon-heart"></span> Send Thanks', 
                                ['class' => (!$post->hasFavorited() ? '' : ' hide') . ' btn btn-danger post-section-request-favorite ']
                        ) ?>

                <?= Html::button('<span class="glyphicon glyphicon-heart"></span> Thanks Sent', 
                        ['class' => (!$post->hasFavorited() ? 'hide' : ' cancel') . ' btn btn-danger post-section-cancel-favorite ']) ?>
            </div>
        
        <?php } else { ?>
            <div class="post-section-owner">
                You are the owner
            </div>
            <div class="post-section-owner-button">
                <?= Html::button('<span class="glyphicon glyphicon-pencil"></span> Edit', ['class' => 'btn btn-primary post-section-owner-edit']) ?>
                
                <?= Html::button('<span class="glyphicon glyphicon-remove"></span> Delete', ['class' => 'btn btn-danger post-section-owner-delete']) ?>
            </div>
        <?php } ?>
    </div>
    <div class="post-section-edit hide">
        <?=frontend\widgets\EditPost::widget(['id' => $id . '-edit-post', 'post' => $post]) ?>
     </div>
</div>