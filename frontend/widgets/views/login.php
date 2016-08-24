<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;

?>

<div id="<?= $id ?>" class="login">
    <div class="login-login">
        <div class="login-header">
            Login
        </div>
        <?= Html::textInput('login-login-email', null,['class' => 'login-input login-login-email', 
            'placeholder' => 'Email Address']) ?>
        <div class="login-error-msg login-login-email-error">
        </div>
        <?= Html::passwordInput('login-login-password', null, ['class' => 'login-input login-login-password', 
            'placeholder' => 'Password']) ?>
        <div class="login-error-msg login-login-password-error">
            
        </div>
        <div class="login-login-button-area">
            <?= Html::button('Register with Email ?', ['class' => 'button-like-link login-login-register-email', 'align' => 'left']) ?>
            <?= Html::button('Login', ['class' => 'login-button login-login-button', 'align' => 'right']) ?>
        </div>
    </div>
    <div class="login-register login-hide">
        <div class="login-header">
            Register
        </div>
        <?= Html::textInput('login-register-first-name', null, 
                ['class' => 'login-input login-register-first-name', 'placeholder' => 'First name']) ?>
        <div class="login-error-msg login-register-first-name-error">
        </div>
        <?= Html::textInput('login-register-last-name', null, [
            'placeholder' => 'Last name', 'class' => 'login-input login-register-last-name']) ?>

        
        <?= Html::textInput('login-register-email', null,['class' => 'login-input login-register-email', 
            'placeholder' => 'Email Address']) ?>
        <div class="login-error-msg login-register-email-error">
        </div>
        <?= Html::passwordInput('login-register-password', null, ['class' => 'login-input login-register-password', 
            'placeholder' => 'Password']) ?>
        <div class="login-error-msg login-register-password-error">
        </div>
        <div class="login-register-button-area">
            <?= Html::button('Go to Login', ['class' => 'button-like-link login-register-login']) ?>
            <?= Html::button('Register', ['class' => 'login-button login-register-button', 'align' => 'right']) ?>
        </div>
    </div>
    <div class="login-auth-two">
        <a href="<?= Yii::$app->request->baseUrl ?>/site/auth?authclient=facebook" 
            id="login-continue-with-facebook" 
            class="login-continue-with-facebook"
             <span class="input-group register-data">
                <span class="fa fa-facebook"></span>
                 Continue With Facebook
             </span>
        </a>
            
    </div>
</div>
