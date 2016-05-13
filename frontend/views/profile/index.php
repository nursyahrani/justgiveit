
<?php
    use yii\widgets\ListView;
    use kop\y2sp\ScrollPager;
    use yii\helpers\Html;
    use kartik\tabs\TabsX;
    use yii\bootstrap\Modal;
    /** @var $message_received_provider \yii\data\ArrayDataProvider */
    /** @var $message_sent_provider \yii\data\ArrayDataProvider */
    /** @var $created_stuff_provider \yii\data\ArrayDataProvider */

    /** @var $user array */

    $belongs = $user['id'] == Yii::$app->user->getId();

    $items = array();
    if($belongs) {
        $items[] =
            [
                'label' => 'Message Received',
                'content' => '<div class="col-md-12">
                            <div align="center">
                                <h1> All Message Received</h1>
                             </div>' .
                    ListView::widget([
                        'id' => 'message_received_list',
                        'dataProvider' => $message_received_provider,
                        'summary' => false,
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => function ($model, $key, $index, $widget) {
                            return $this->render('_list_message', ['model' => $model]);
                        }
                    ]) .
                    '</div>'
                ,
                'active' => true
            ];
    }
    $items[] =   [
            'label'=>'Stuff to Stuff',
            'content' => '<div class="col-md-12">
                            <div align="center">
                                <h1> Stuff to Give</h1>
                             </div>' .
                            ListView::widget([
                                'id' => 'given_stuff_list',
                                'dataProvider' => $created_stuff_provider,
                                'summary' => false,
                                'itemOptions' => ['class' => 'item'],
                                'itemView' => function ($model, $key, $index, $widget) {
                                    $interested_people = \common\models\Interested::getInterestedPeople($model['stuff_id']);
                                    $give_stuff_to_form = new \frontend\models\GiveStuffToUserForm();
                                    return $this->render('_list_stuff',['model' => $model,
                                            'give_stuff_to_form' => $give_stuff_to_form,
                                            'interested_people' => $interested_people,
                                            'user_id' => $model['id']
                                            ]);
                                }
                            ]) .
                            '</div>',
        ];

    if($belongs){
        $items[] =     [
            'label'=>'Message Sent',
            'content'=> '<h1> All Message Sent</h1> ' .
                ListView::widget([
                    'id' => 'message_sent_list',
                    'dataProvider' => $message_sent_provider,
                    'summary' => false,
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $this->render('_list_message',['model' => $model]);
                    }
                ]),
        ];
    }


?>
<div class="col-md-10 col-md-offset-1" style="background-color: white">
    <div class="row" style="margin-top: 12px">
        <div class="col-md-3">
            <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/photos/' . $user['profile_pic']) ?>
        </div>
        <div class="col-md-3">
            <div class="row">
                <h2><?= $user['first_name'] .  ' ' . $user['last_name'] ?></h2>
            </div>
            <?php if(!$belongs){ ?>
                <div class="row">
                    <?= Html::button('Send him a message', ['class' => 'btn btn-primary', 'id' => 'send-message-user-profile']) ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <hr>


    <div class="row" style="margin-top: 12px;margin-left: 10px">

        <?= TabsX::widget([
            'items'=>$items,
            'position'=>TabsX::POS_LEFT,
            'encodeLabels'=>false
        ]); ?>


    </div>

</div>


<?php
Modal::begin([
    'id' => 'send-message-user-profile-modal',
    'size' => Modal::SIZE_LARGE
]);

$send_message_form = new \frontend\models\SendMessageForm();
$send_message_form->sender_id = Yii::$app->user->getId();
$send_message_form->receiver_id = $user['id'];
echo $this->render('../site/_message_box', ['send_message_form' => $send_message_form,
    'first_name' => $user['first_name'],
    'last_name' => $user['last_name']
]);
Modal::end();
?>

