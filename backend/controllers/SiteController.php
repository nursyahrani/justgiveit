<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use backend\services\SiteService;
/**
 * Site controller
 */
class SiteController extends Controller
{   
    
    private $site_service;
    
    public function init() {
        $this->site_service = new SiteService();
    }
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if(key(\Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())) === 'admin') {
         
            $vo = $this->site_service->getHomeInfo();
            return $this->render('index', ['home' => $vo]);   
        } else{
            return $this->render('error', ['name' => 'Prohibited', 'message' => 'You are prohibited to access the page']);
        }
    }
    
    public function actionUser() {
        
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionProcessLogin() {
        
        $data = array();
        if(!isset($_POST['email'])  || !isset($_POST['password'])) {
            $data['status'] = 0;
            return json_encode($data);
        }
        
        $model = new \backend\models\LoginForm;
        $model->email = $_POST['email'];
        $model->password = $_POST['password'];
        if($model->login()) {
            $data['status'] = 1;
            
        } else {
            $data['status'] = 0;
            $data['errors'] = $model->getErrors();
        }
        return json_encode($data);
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
