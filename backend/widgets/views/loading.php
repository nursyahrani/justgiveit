<?php

use yii\helpers\Html;
?>
<?= Html::img(backend\libraries\CommonLibrary::loadingResourceUrl(), 
        ['id' => $id, 'class' => 'loading-img ' . $widget_class, 'align' => $align]) ?>