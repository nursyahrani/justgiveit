<?php
namespace frontend\controllers;

use frontend\models\CreateStuffForm;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
/**
 * Site controller
 */
class PostController extends Controller
{

    public function actionCreate(){
        $create_stuff_form = new CreateStuffForm();
        $create_stuff_form->poster_id = Yii::$app->user->getId();
        if($create_stuff_form->load(Yii::$app->request->post()) && $create_stuff_form->validate()){

            if($create_stuff_form->create()){

                return $this->redirect(Yii::$app->request->baseUrl);
            }

        }
        else{
            if($create_stuff_form->hasErrors()){
                Yii::$app->end(print_r($create_stuff_form->getErrors()));
            }
        }

        return $this->render('create', ['create_stuff_form' => $create_stuff_form]) ;
    }
}
