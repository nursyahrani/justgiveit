<?php
    /** @var $model array */
?>

<div>
    <?php if($model['id'] != Yii::$app->user->getId()){ ?>
    <?= $model['first_name'] . ' ' . $model['last_name'] ?> sent

    <?php }else{ ?>
        You sent
    <?php } ?>
     <?= $model['message'] ?>
</div>
<hr>