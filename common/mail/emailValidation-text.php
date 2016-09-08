<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/validate-email', 'token' => $user_email->validation_code]);
?>
Hello <?= $user->first_name ?>,

Follow the link below to validate your email:

<?= $resetLink ?>
