<?php
    use yii\widgets\Pjax;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<?php Pjax::begin([
    'id' => 'interested_button_section_' . $stuff_id,
    'enablePushState' => false,
    'timeout' => 6000,
    'clientOptions' => [
        'skipOuterContainers' => true,
    ],
    'options' => [
        'class' => 'interested_button_section_pjax',
        'data-service' => $stuff_id,
        'container' => '#interested_button_section_' . $stuff_id
    ]
]) ?>

<?php  $form = ActiveForm::begin(['action' =>['site/interested'],
    'method' => 'post',
    'id' => 'interested_button_form_' . $stuff_id,
    'options' => [ 'data-pjax' => '#interested_button_section_' . $stuff_id,
    'class' => 'interested_button_form',
    'data-service' => $stuff_id]])  ?>

    <?= Html::hiddenInput('user_id' , Yii::$app->user->getId()) ?>

    <?= Html::hiddenInput('stuff_id', $stuff_id) ?>

    <?= Html::hiddenInput('type', $type) ?>



<?php ActiveForm::end() ?>

<?php Pjax::end() ?>