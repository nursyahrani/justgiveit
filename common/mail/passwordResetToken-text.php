<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user_email->password_reset_token]);
?>
Hello <?= $user->first_name ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
