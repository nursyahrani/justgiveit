<?php
    use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="row">
    <div class="col-md-12">
       Send to: <?= $first_name . ' ' . $last_name ?>
    </div>

    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['action' => ['site/send-message'], 'method' => 'post']) ?>

            <?= $form->field($send_message_form, 'message')->textarea(['rows' => 2])    ?>

            <?= $form->field($send_message_form, 'sender_id')->hiddenInput()->label(false) ?>

            <?= $form->field($send_message_form, 'receiver_id')->hiddenInput()->label(false) ?>

            <?= Html::submitButton('Submit', ['class' => 'btn btn-default']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>