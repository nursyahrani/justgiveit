<?php/* @var $this \yii\web\View *//* @var $content string */use yii\widgets\Spaceless;use yii\helpers\Html;use yii\widgets\Breadcrumbs;use frontend\assets\AppAsset;use common\libraries\UserLibrary;use frontend\widgets\ConfirmationModal;use frontend\widgets\CreatePost;use frontend\widgets\NotificationList;use yii\bootstrap\Modal;use frontend\vo\BidReplyVoBuilder;use frontend\widgets\BidReply;//all linksif(Yii::$app->user->isGuest){    //all links    $login_link = Yii::$app->request->baseUrl . '/site/link';}else{    $logout_link = Yii::$app->request->baseUrl . '/site/logout';};if(YII_ENV_PROD) {    AppAsset::register($this);} else {    frontend\assets\DevAsset::register($this);}$this->title = "Just Give it!";?><?php $this->beginPage() ?><!DOCTYPE html><html lang="<?= Yii::$app->language ?>"><head>    <meta charset="<?= Yii::$app->charset ?>">    <meta name="viewport" content="width=device-width, initial-scale=1">    <?= Html::csrfMetaTags() ?>    <title><?= Html::encode($this->title) ?></title>    <?php $this->head() ?></head><?php $this->beginBody() ?>    <?php Spaceless::begin() ?>    <nav class="navbar-default navbar-fixed-top menu-bar main-container" >        <div class="logo" align="left">            <?= Html::a('JustGiveIt', Yii::$app->request->baseUrl . '/', ['class' => 'btn menu-btn']) ?>                    </div>        <div class="navbar-button"  align="right">            <?= Html::button('<span class="glyphicon glyphicon-home"></span>', ['class' => 'btn menu-btn home-menu-button']) ?>            <?php if(Yii::$app->user->isGuest){ ?>            <?= Html::button('Login', ['class' => 'btn menu-btn', 'id' => 'login-menu']) ?>            <?php } else { ?>            <?= Html::button('<span class="glyphicon glyphicon-plus"></span>', ['class' => 'btn menu-btn give-stuff-modal-button']) ?>            <?= NotificationList::widget(['id' => 'notification-list']) ?>            <?=  \common\widgets\LinkDropdown::widget(                   ['label' => Html::img(UserLibrary::buildPhotoPath(Yii::$app->user->identity->profile_pic),                                ['class' => 'menu-profile-pic'])                    ,                    'items' =>                        [                           ['label' => 'Profile' ,                              'url' => UserLibrary::buildUserLink(Yii::$app->user->identity->username)],                           ['label' => 'Logout',                               'url' => Yii::$app->request->baseUrl . '/site/logout',                              'options' => [ 'data-method' => 'post']                           ]                       ]                   ,                    'button_class' => 'btn menu-btn', 'id' => 'profile-menu']); ?>                       <?php } ?>        </div>    </nav>    <div class="main-container main-view">        <?= Breadcrumbs::widget([            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],        ]) ?>        <?= common\widgets\Alert::widget() ?>        <?= $content ?>    </div></div><div class="main-hidden-input">    <?= Html::hiddenInput('base-url', Yii::$app->request->baseUrl, ['id' => 'base-url']) ?>    <?= Html::hiddenInput('user-id', Yii::$app->user->getId(), ['id' => 'current-user-id']) ?></div><div id='bid-reply-template' class='hide'>    <?php         //template        $bid_reply_template_builder = new BidReplyVoBuilder();        $bid_reply_template_builder->applyTemplate();    ?>    <?= BidReply::widget(['id' => 'bid-reply-template-id', 'bid_reply' => $bid_reply_template_builder->build()]) ?></div><?phpModal::begin([    'id' => 'login-modal',    'header' => '<h4 class="login-modal-header" align="center">Login</h4>',    'size' => Modal::SIZE_DEFAULT]);    echo  frontend\widgets\Login::widget(['id' => 'login-form']) ;Modal::end();?><?php    Modal::begin([        'id' => 'create-post-modal',        'header' => '<h4 align="center">Create Post</h4>',        'size' => Modal::SIZE_DEFAULT    ]); ?><?php    Modal::end();?><?= ConfirmationModal::widget(['id' => 'confirmation-modal', 'text' => '', 'title' => 'Confirmation Dialog']) ?><?phpSpaceless::end();$this->endBody();?></html><?php $this->endPage() ?>