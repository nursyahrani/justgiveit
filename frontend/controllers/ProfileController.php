<?php
namespace frontend\controllers;

use common\models\Message;
use common\models\User;
use common\models\UserFacebookAuthentication;
use frontend\models\SendMessageForm;
use frontend\models\UploadProfilePicForm;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\data\ArrayDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Post;
use common\models\Interested;
/**
 * Site controller
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ],
        ];
    }

    public function actionIndex(){
        if(isset($_GET['username'])){

            $user = User::find()->where(['username' => $_GET['username']])->one();

            $message_provider = new ArrayDataProvider([
                'allModels' => Message::getAllMessages($user['id']),
                'pagination' => [
                    'pageSize' => 5
                ]
            ]);

            $message_sent_provider = new ArrayDataProvider([
                'allModels' => Message::getAllSentMessge($user['id']),
                'pagination' => [
                    'pageSize' => 5
                ]
            ]);

            $created_stuff_provider = new ArrayDataProvider([
                'allModels' => Post::getStuffCreatedBy($user['id']),
                'pagination' => [
                    'pageSize' => 5
                ]
            ]);

            return $this->render('index', ['message_received_provider' => $message_provider, 'user' => $user,
            'message_sent_provider' => $message_sent_provider,
            'created_stuff_provider' => $created_stuff_provider]);
        }
    }
}
