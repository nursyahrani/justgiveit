<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\widgets\Loading;
$this->title = 'Login';

?>
<div class="login-index">
    <div class="login-header">
        Login       
    </div>
    <div class="login-email">
        <?= Html::textInput('email', null, ['class' => 'login-email-field site-input-field']) ?>
    </div>
    
    <div class="login-password">
        <?= Html::passwordInput('password', null, ['class' => 'site-input-field login-password-field']) ?>
    </div>
    
    <div class="login-button">
        <?= Html::button('Login', ['class' => 'btn btn-primary login-button']) ?>
        <?= Loading::widget(['id' => 'login-loading']) ?>
    </div>

</div>
