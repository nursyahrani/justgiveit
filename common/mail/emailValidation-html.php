<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/validate-email', 'token' => $user_email->validation_code]);
?>
<div class="email-email-validation">
    <p>Hello <?= Html::encode($user->first_name) ?>,</p>

    <p>Follow the link below to validate your email:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
