<?php
    use yii\helpers\Html;
    use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\dialog\Dialog;
    use yii\bootstrap\Modal;
    /** @var $model array */
?>

<?= Dialog::widget() ?>


<article>
    <div class="col-md-3" style="margin-bottom: 25px;
                                padding:5px;
                                padding-bottom: 15px;"
                                >
        <div class="container" style="width:90%;margin:15px;padding: 15px;background-color: white;height: 100%;box-shadow: 1px 1px 1px #888888;">
            <div style="margin-left: 25px;width: 90%">
                <div class="row">
                    <div>
                        <?= Html::a( $model['first_name'] . ' ' . $model['last_name'] , Yii::$app->request->baseUrl . '/user/' . $model['username']) ?></> gives
                    </div>
                    <div class="post-name">
                        <u><?= $model['title'] ?></u>
                    </div>
                    <br>
                    <?= $model['description'] ?>
                </div>



                <div class="row">
                    <?php if($model['photo_path'] == null){ ?>
                        <img style="width:80%;height: 250px" src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/default.png' ?>">
                    <?php }else{ ?>
                        <img style="width:80%;height: 250px" src="<?= Yii::$app->request->baseUrl . '/frontend/web/' . $model['photo_path']  ?>">
                    <?php } ?>

                    <?= $this->render('_interested_button', ['stuff_id' => $model['stuff_id'], 'type' => $model['type']]) ?>
                </div>
                <div class="row">
                    <?= Html::button('Love this', ['class' => 'btn btn-default inline', 'style' => 'width:39%']) ?>

                    <?php if($model['type'] == \common\models\Post::GIVE_STUFF){ ?>
                        <?= Html::button('Interested', ['class' => 'btn btn-default interested_button inline', 'style' => 'width:39%', 'data-services' => $model['stuff_id']]) ?>
                    <?php }else{ ?>
                        <?= Html::button('Give now', ['class' => 'btn btn-default interested_button inline', 'style' => 'width:39%', 'data-services' => $model['stuff_id']]) ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>


    <?php
    Modal::begin([
        'id' => 'send-message-modal-' . $model['stuff_id'],
        'size' => Modal::SIZE_LARGE
    ]);
    $send_message_form = new \frontend\models\SendMessageForm();
    $send_message_form->sender_id = Yii::$app->user->getId();
    $send_message_form->receiver_id = $model['poster_id'];
    echo $this->render('../site/_message_box', ['send_message_form' => $send_message_form,
        'first_name' => $model['first_name'],
        'last_name' => $model['last_name']
    ]);
    Modal::end();
    ?>

</article>

