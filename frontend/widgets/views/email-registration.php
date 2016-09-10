<?php
use common\widgets\Loading;
use yii\helpers\Html;
use yii\captcha\Captcha;
?>

<div id="<?= $id ?>" class="email-registration" data-id="<?= $id ?>">
    
    <?php if(!$profile->isValidated()) { ?>
    <div class="email-registration-registration <?= (!$profile->getEmail()) ? '' : 'hide' ?> " >
        <div class="email-registration-registration-header">
            Please Register an Email
        </div>
        <?= Html::textInput('email', null, ['class' => 'site-input  email-registration-registration-email', 'placeholder' => 'Email Address']) ?>
        <div class="email-registration-registration-email-error site-input-error">
        </div>
        <?= Html::passwordInput('password', null, ['class' => 'site-input  email-registration-registration-password', 'placeholder' => 'Password']) ?>
        <div class="email-registration-registration-password-error site-input-error">
        </div>
        <?= Html::passwordInput('confirm-password', null, ['class' => 'site-input  email-registration-registration-confirm-password', 'placeholder' => 'Confirm Password']) ?>
        <div class="email-registration-registration-confirm-password-error site-input-error">
        </div>
        <div class="email-registration-registration-action">
            <?= Html::button('Save', ['class' => 'btn btn-sm btn-primary email-registration-registration-save']) ?>
            <?= Loading::widget(['id' => $id . '-registration-loading']) ?>
        </div>
    </div>
    <div class="email-registration-validation <?= (!$profile->getEmail()) ? 'hide' : '' ?>" >
        <div class="email-registration-validation-text">
            We have sent a validation link to your email 
        </div>
        <div class="email-registration-validation-action">
            <span class="email-registration-validation-email"><?= $profile->getEmail() ?></span>
            <?= Html::button('Resend', ['class' => 'email-registration-validation-resend-view']) ?>
        </div>
    </div>
    <div class="email-registration-resend hide">
        <div class="email-registration-resend-header">
            Resend Email to: <span class="email-registration-validation-email"> <?= $profile->getEmail() ?></span>
        </div>
        <div class="email-registration-resend-captcha-area">
            <?= Captcha::widget([
                'id' => $id . '-resend-captcha',
                'options' =>['class' => 'form-control email-registration-resend-captcha'],
                'name' => 'email-registration-resend-captcha'
            ]) ?>
            <div class="email-registration-resend-captcha-error site-input-error"></div>
        </div>
        <div class="email-registration-resend-action">
            <?= Html::button('Resend', ['class' => 'site-blue-button site-button email-registration-resend-resend']) ?>
            <?= Loading::widget(['id' => $id . '-resend-loading']) ?>
            <?= Html::button('Cancel', ['class' => 'site-red-button site-button email-registration-resend-cancel']) ?>
        </div>
    </div>
    <?php } else { ?>
    <?php } ?>
    
</div>
