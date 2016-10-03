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
        <div class="login-email-error site-input-error"></div>
    </div>
    
    
    <div class="login-password">
        <?= Html::passwordInput('password', null, ['class' => 'site-input-field login-password-field']) ?>
        <div class="login-password-error site-input-error"></div>
    </div>
    
    <div class="login-button">
        <?= Html::button('Login', ['class' => 'btn btn-primary login-login-button']) ?>
        <?= Loading::widget(['id' => 'login-loading']) ?>
    </div>

</div>
