<?php

namespace console\controllers;
use Yii;
use yii\console\Controller;
use frontend\models\SignupForm;
class RbacController extends Controller {
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
    // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $model = new SignupForm();
        $model->first_name = "Admin";
        $model->last_name = "Justgivit";
        $model->email = "admin@justgivit.com";
        $model->password = "testing123";
        if($user = $model->signup()) {
            $auth->assign($admin, $user->id);
        }
    }
}