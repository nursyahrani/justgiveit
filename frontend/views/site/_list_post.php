<?php
    use yii\helpers\Html;
    use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\dialog\Dialog;
    /** @var $model array */
?>

<?= Dialog::widget() ?>


<div class="col-md-4">
<article>

        <div class="col-md-12 ">
            <div class="post-name">
                <u><?= $model['title'] ?></u>
            </div>
            <br>
            <?= $model['description'] ?>
        </div>



        <div class="col-md-12">
            <?php if($model['photo_path'] == null){ ?>
                <img style="width:80%;height: 250px" src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/default.png' ?>">
            <?php }else{ ?>
                <img style="width:80%;height: 250px" src="<?= Yii::$app->request->baseUrl . '/frontend/web/' . $model['photo_path']  ?>">
            <?php } ?>

            <?php Pjax::begin([
                'id' => 'interested_button_section_' . $model['id'],
                'enablePushState' => false,
                'timeout' => 6000,
                'options' => [
                    'container' => '#interested_button_section_' . $model['id']
                ]
            ]) ?>
                <?php  $form = ActiveForm::begin(['action' =>['site/interested'],
                    'method' => 'post',
                    'id' => 'interested_button_form_' . $model['id'],
                    'options' => [ 'data-pjax' => '#interested_button_section_' . $model['id']]])  ?>

                    <?= Html::hiddenInput('user_id' , Yii::$app->user->getId()) ?>

                    <?= Html::hiddenInput('stuff_id', $model['id']) ?>

                    <?= Html::hiddenInput('type', $model['type']) ?>

                    <?php if($model['type'] == \common\models\Post::GIVE_STUFF){ ?>
                        <?= Html::button('Get now', ['class' => 'btn btn-default interested_button', 'style' => 'width:80%', 'data-services' => $model['id']]) ?>
                    <?php }else{ ?>
                        <?= Html::button('Give now', ['class' => 'btn btn-default interested_button', 'style' => 'width:80%', 'data-services' => $model['id']]) ?>
                    <?php } ?>

                <?php ActiveForm::end() ?>

            <?php Pjax::end() ?>
        </div>

</article>
<hr>
</div>

