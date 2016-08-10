<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use kartik\file\FileInput;
    use kartik\select2\Select2;
    use yii\web\JsExpression;
    /** @var $create_stuff_form \frontend\models\CreateStuffForm */
?>

<div class="post-create-container">
    <div class="post-create-title"> Give your Stuff</div>

    <?php $form = ActiveForm::begin(['action' => ['post/create'], 'options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($create_stuff_form, 'title')->textInput([ 'placeholder' => 'Your stuff name'])->label(false)  ?>
        <?= $form->field($create_stuff_form, 'description')->textarea(['placeholder' => 'Put description here..'])->label(false)  ?>

        <?=  FileInput::widget([
            'model' => $create_stuff_form,
            'attribute' => 'imageFile',
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Select Photo'
            ],
            'options' => ['accept' => 'image/*']
        ]) ?>

         <!-- Topic Name -->
         <div class="post-create-tags">
            <?= $form->field($create_stuff_form, 'tags')->widget(Select2::classname(), [
                'initValueText' => $create_stuff_form->tags,
                'maintainOrder' => true,
                'options' => ['placeholder' => 'Select Tags ...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['search-tag']),
                        'dataType' => 'json',
                           'data' => new JsExpression('function(params) { return {query:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
                    'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
                ],
                ])->label(false) ?>
         </div>
        <?= Html::hiddenInput('poster_id', Yii::$app->user->getId()) ?>

        <div style="margin-top:15px">
           <?= Html::submitButton('Create', ['class' => 'btn btn-danger']) ?>

        </div>
    <?php ActiveForm::end() ?>
</div>