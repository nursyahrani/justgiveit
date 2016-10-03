<?php
use backend\libraries\CommonLibrary;
use yii\helpers\Html;
?>
<?= Html::img(CommonLibrary::loadingResourceUrl(), 
        ['id' => $id, 'class' => 'loading-img ' . $widget_class, 'align' => $align]) ?>