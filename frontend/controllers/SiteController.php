<?php
namespace frontend\controllers;

use common\models\User;
use common\models\UserFacebookAuthentication;
use frontend\models\GiveStuffToUserForm;
use frontend\models\SendMessageForm;
use frontend\models\UploadProfilePicForm;
use Yii;
use common\models\Image;
use yii\helpers\Json;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use frontend\service\ServiceFactory;
use yii\data\ArrayDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\libraries\CommonLibrary;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\widgets\PostCard;
use common\models\Post;
use common\models\Interested;
use frontend\vo\HomeVoBuilder;
/**
 * Site controller
 */
class SiteController extends Controller
{
    private $service_factory;
    
    private $home_service;
    
    public function init() {
        $this->service_factory = new ServiceFactory();
        $this->home_service = $this->service_factory->getService(ServiceFactory::HOME_SERVICE);
    }
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
            
            $model->country_code = isset($_POST['country_code']) ? $_POST['country_code'] : 'SG';
            $model->city = isset($_POST['city']) ? $_POST['city'] : 'Singapore (Western Water Catchment)';
            $model->country = isset($_POST['country']) ? $_POST['country'] : 'Singapore';
            $url = "https://graph.facebook.com/". $userAttributes['id'] . "/picture?width=190";
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
        
        if(isset($_GET['tag'])) {
            $tag = $_GET['tag'];
            $home_vo = $this->home_service->getHomeInfoWithTag(Yii::$app->user->getId(), $tag, new HomeVoBuilder());

        } else {
            $home_vo = $this->home_service->getHomeInfo(Yii::$app->user->getId(), new HomeVoBuilder());
        }

        return $this->render('index', ['home_vo' => $home_vo]);
    }
    
    public function actionGetMorePosts() {
        $data = array();
        if (isset($_POST['ids'])) {
            $limit = isset($_POST['limit']) ? $_POST['limit']  : 10;
            $location = isset($_POST['location']) ? $_POST['location'] : '';
            $query = isset($_POST['query']) ? $_POST['query'] : '';
            $user_id = Yii::$app->user->getId();
            $tag = isset($_POST['tag']) ? $_POST['tag'] : null;
            if($tag === null) {
                
                $post_vos = $this->home_service->getMorePosts($user_id, 
                        $_POST['ids'], $query, $location);
            } else {
                
                $post_vos = $this->home_service->getMorePostsWithTag($user_id, 
                        $_POST['ids'] , $tag);
            }
             
            $view = '';
            foreach($post_vos as $vo) {
                $view .= PostCard::widget(
                        ['id' => 'post-card-' . $vo->getPostId(), 'post_vo' => $vo]);
            }
            $data['status'] = 1;
            $data['view'] = $view;
        } else {    
            $data['status'] = 0;
        }
        return json_encode($data);
    
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        
        $data = array();
        
        if(isset($_POST['email']) && isset($_POST['password'])) {
            $model = new LoginForm();
            $model->email = $_POST['email'];
            $model->password = $_POST['password'];
            if ($model->validate() && $model->login()) {
                return $this->goBack();
            }   
            $data['message'] = $model->getErrors();
        }
        
        $data['status'] = 0;
        
        return json_encode($data);
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
        $data = array();
        
        if(isset($_POST['first_name']) && isset($_POST['last_name'])
                && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['country_code'])
                && isset($_POST['city']) && isset($_POST['country'])) {
            $model = new SignupForm();
            $model->email = $_POST['email'];
            $model->first_name = $_POST['first_name'];
            $model->last_name = $_POST['last_name'];
            $model->password = $_POST['password'];
            $model->city = $_POST['city'];
            $model->country_code = $_POST['country_code'];
            $model->country = $_POST['country'];
            if ($model->validate() && $user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }   
            $data['message'] = $model->getErrors();
        }
        
        $data['status'] = 0;
        
        return json_encode($data);
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
    
    public function actionSearchTag() {
        $q = isset($_GET['query']) ? $_GET['query'] : '';
            
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        $data = $this->home_service->searchIssue($q);
        
        $out['results'] = array_values($data);

        echo Json::encode($out);
    }
    
    public function actionUploadImage() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_FILES['image'])) {
           $model = new \frontend\models\UploadImageForm();
           $model->file = $_FILES['image'];
           $model->user_id = Yii::$app->user->getId();
           $image_id = $model->save();
           if($image_id  !== null) {
                $data['status'] = 1;
                $data['image_id'] = $image_id;
                $image_path = Image::find()->where(['image_id' => $image_id])->one()['image_path'];
                $data['image_path'] = CommonLibrary::buildImageLibrary($image_path);
                return json_encode($data);   
           }
        }
        $data['status'] = 0;
        return json_encode($data);
    }
    
    public function actionSearchCity() {
        $q = isset($_GET['query']) ? $_GET['query'] : '';
            
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $exploded = explode(',', $q);
        if(count($exploded) === 1) {
            $data = $this->home_service->searchCountryCity($exploded[0]);
        } else {
            $data = $this->home_service->searchCountryCity($exploded[0], $exploded[1]);
        }
        
        $out['results'] = array_values($data);

        echo Json::encode($out);
    
    }
}
