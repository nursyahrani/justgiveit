<?php
use yii\helpers\Html;
/** @var $model array */
/** @var $interested_people array */
/** @var $give_stuff_to_form \frontend\models\GiveStuffToUserForm */

$first_interested_people = true;


$belongs = (Yii::$app->user->getId() == $model['poster_id']);
$mapped_interested_people = array();

$mapped_interested_people[-1] = 'Give the stuff to';

foreach($interested_people as $person){
    $mapped_interested_people[$person['id']] = $person['first_name'] . ' '  . $person['last_name'];
}
?>

<div class="col-md-12">

    <div class="row">
       <label><?= $model['title'] ?> </label>
    </div>

    <div class="row">
        <?= $model['description'] ?>
    </div>

    <div class="row">
        <?= Html::img( Yii::$app->request->baseUrl . '/frontend/web/' . $model['photo_path'], ['style' => 'max-width:300px']) ?>
    </div>

    <div class="row" style="margin-top:10px">
        <label>Interested People:</label>
        <?php foreach($interested_people as $person){ ?>
            <?php if($first_interested_people == true){ ?>
            <?php $first_interested_people = false;
                }else{ ?>
                ,
            <?php } ?>
                <?= Html::a($person['first_name'] . ' ' . $person['last_name'], Yii::$app->request->baseUrl . '/user/' . $person['username'] )?>
        <?php } ?>
    </div>

    <?php if($belongs){ ?>
        <?php $form = \yii\widgets\ActiveForm::begin(['action' => 'site/give-stuff-to', 'method' => 'post']) ?>

        <?= $form->field($give_stuff_to_form,'user_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>

        <div class="row">
            <?= $form->field($give_stuff_to_form, 'user_id')->dropDownList($mapped_interested_people, ['selected' => -1, 'class' => 'inline form-group'])->label(false) ?>
            <?= Html::submitButton('Choose', ['class'=> 'btn btn-primary']) ?>
        </div>




        <?php \yii\widgets\ActiveForm::end() ?>
    <?php } ?>
    <hr>

</div>

