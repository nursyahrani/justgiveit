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
            if($create_stuff_form->create() ) {
                    return $this->redirect(Yii::$app->request->baseUrl);
            }
        }
   
        return $this->render('post-create', ['create_stuff_form' => $create_stuff_form]) ;
    }
    
    public function actionIndex() {
        
    }
}
