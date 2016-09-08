<?php
use common\widgets\Loading;
use yii\helpers\Html;
use yii\captcha\Captcha;
?>

<div id="<?= $id ?>" class="login" data-id="<?= $id ?>">
    <div class="login-login">
        <?= Html::textInput('login-login-email', null,['class' => 'login-input login-login-email', 
            'placeholder' => 'Email Address']) ?>
        <div class="login-error-msg login-login-email-error">
        </div>
        <?= Html::passwordInput('login-login-password', null, ['class' => 'login-input login-login-password', 
            'placeholder' => 'Password']) ?>
        <div class="login-error-msg login-login-password-error">
            
        </div>
        <div class="login-login-button-area">
            <?= Html::button('Forgot Password?', ['class' => 'login-button-like-link login-login-forgot-password']) ?>
            <?= Html::button('Login', ['class' => 'login-button login-login-button', 'align' => 'right']) ?>
        </div>
        
        <div class="login-auth-two">
            <?= Html::button('Register with Email', ['class' => 'btn btn-default login-login-register-email', 'align' => 'left']) ?>
            <?= Html::button('Continue with Facebook', ['class' => 'btn btn-primary login-continue-with-facebook']) ?>
        </div>
    </div>
    <div class="login-register hide">
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
            <?= Html::button('Go to Login', ['class' => 'login-button-like-link login-register-login']) ?>
            <?= Html::button('Register', ['class' => 'login-button login-register-button', 'align' => 'right']) ?>
        </div>
        <div class="login-auth-two">
            <?= Html::button('Continue with Facebook', ['class' => 'btn btn-primary login-continue-with-facebook']) ?>
        </div>
    
    </div>
    <div class="login-forgot-password hide">
        <?= Html::textInput('login-forgot-password-email', null,['class' => 'login-input login-forgot-password-email', 
            'placeholder' => 'Email Address']) ?>
        <div class="login-error-msg login-forgot-password-email-error">
        </div>
        <div class="login-forgot-password-captcha-area">
            <?= Captcha::widget([
                'id' => $id . '-forgot-password-captcha',
                
                'name' => 'login-forgot-password-captcha'
            ]) ?>
        </div>
        <div class="site-input-error login-forgot-password-captcha-error">
            
        </div>
        <div class="login-forgot-password-button-area">
            <?= Html::button('Send', ['class' => 'login-forgot-password-button btn btn-primary']) ?>
            <?= Loading::widget(['id' => $id .'-forgot-password-loading']) ?>
        </div>
        <div class="login-forgot-password-validated hide">
            We have sent you the email, Please check your spam folder if you cannot find it.
        </div>
    </div>
</div>
