<?php
namespace frontend\controllers;

use common\models\User;
use common\models\UserFacebookAuthentication;
use frontend\models\GiveStuffToUserForm;
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
class SiteController extends Controller
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


    /**
     * This function will be triggered when user is successfuly authenticated using some oAuth client.
     *
     * @param yii\authclient\ClientInterface $client
     * @return boolean|yii\web\Response
     */
    public function oAuthSuccess($client) {
        // get user data from client
        $userAttributes = $client->getUserAttributes();


        // do some thing with user data. for example with $userAttributes['email']
        if(UserFacebookAuthentication::find()->where(['facebook_id' => $userAttributes['id']])->exists()){
            $user = User::find()->select('user.*')->innerJoin('user_facebook_authentication', 'user.id = user_facebook_authentication.user_id')
                ->where(['user_facebook_authentication.facebook_id' => $userAttributes['id']])->one();;
            Yii::$app->user->login($user);
        }
        else{
            $model = new SignupForm();
            $model->facebook_id = $userAttributes['id'];
            $model->first_name = $userAttributes['first_name'];
            $model->last_name = $userAttributes['last_name'];
            $url = "https://graph.facebook.com/". $userAttributes['id'] . "/picture?width=150";
            $photos = file_get_contents($url);
            $model->photo_path = (new UploadProfilePicForm())->uploadFacebookPhoto($photos);

            if($user = $model->signup()){
                Yii::$app->getUser()->login($user);
            }
        }
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(Yii::$app->request->baseUrl . '/site/login');
        }
        if(isset($_GET['give'])){
            $post_data = Post::getAllAskStuffs();
        }
        else{
            $post_data = Post::getAllGiveStuffs();

        }
        $post_data_provider = new ArrayDataProvider([
            'allModels' => $post_data,
            'pagination' => [
                'pageSize' => 8
            ]
        ]);

        return $this->render('index', ['post_data_provider' => $post_data_provider]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
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

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.'
            );

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionInterested(){
        if(Yii::$app->request->isPjax && isset($_POST['user_id']) && isset($_POST['type']) && isset($_POST['stuff_id'])){
            $user_id = $_POST['user_id'];
            $stuff_id = $_POST['stuff_id'];
            $type = $_POST['type'];
            if(!Interested::find()->where(['user_id' => $user_id])->andWhere(['stuff_id' => $stuff_id])->exists()){

                $interest = new Interested();
                $interest->user_id = $user_id;
                $interest->stuff_id = $stuff_id;

                if(!$interest->save()){
                    return false;
                }
            }



            return $this->renderAjax('_interested_button', ['stuff_id' => $stuff_id, 'type' => 'give']) ;
        }
    }

    public function actionSendMessage(){

        $send_message_form = new SendMessageForm();
        if($send_message_form->load(Yii::$app->request->post()) && $send_message_form->validate()){
            if($send_message_form->send()){
                return $this->redirect(Yii::$app->request->baseUrl);
            }
        }
        else{
            Yii::$app->end(var_dump($send_message_form->getErrors()));
        }

    }

    public function actionGiveStuffTo(){
        $give_stuff_to_user = new GiveStuffToUserForm();

        if($give_stuff_to_user->load(Yii::$app->request->post()) && $give_stuff_to_user->validate()){
            if($give_stuff_to_user->create()){
            }
        }
    }
}
