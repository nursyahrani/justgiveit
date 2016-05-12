<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use kartik\file\FileInput;
    /** @var $create_stuff_form \frontend\models\CreateStuffForm */
?>


<div align="center" class="col-md-6 col-md-offset-3">
    <h1> Create Stuff</h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($create_stuff_form, 'title')  ?>


    <?= $form->field($create_stuff_form, 'description')->textarea()  ?>

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

    <?= Html::hiddenInput('poster_id', Yii::$app->user->getId()) ?>

    <div style="margin-top:15px">
       <?= Html::submitButton('Create', ['class' => 'btn btn-danger']) ?>

    </div>
    <?php ActiveForm::end() ?>
</div>


