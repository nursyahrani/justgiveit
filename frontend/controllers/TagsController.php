<?php
namespace frontend\controllers;

use Yii;
use frontend\widgets\TagNavigationItem;
use yii\web\Controller;
use frontend\service\ServiceFactory;
/**
 * Site controller
 */
class TagsController extends Controller
{
    
    private $service_factory;
    
    private $tag_service;
    
    public function init() {
        $this->service_factory = new ServiceFactory();
        $this->tag_service = $this->service_factory->getService(ServiceFactory::TAG_SERVICE);
    }
    
    public function actionSearchTag() {
        $data = array();
        $query = isset($_POST['query']) ? $_POST['query']  : '';
        $ticked_tags = isset($_POST['ticked_tags']) ? $_POST['ticked_tags'] : [];
        $user_id = Yii::$app->user->getId();
        $results = $this->tag_service->searchTag($query, $user_id);
        $view = '';
        $data['status'] = 1;
        foreach($results as $result) {
            $view .= TagNavigationItem::widget(['id' =>'searched-tag-' . $result->getTagId(), 'tag' => $result,
                                                'tick' => in_array($result->getTagName(), $ticked_tags)]);
        }
        
        $data['views'] = $view;
        return json_encode($data);
        
    }
    
    public function actionGetTag() {
        $data = array();
        if(!isset($_POST['label'])) {
            $data['status'] = 0;
            return json_encode($data);
        }
        $tag_name = $_POST['label'];
        $tick = filter_var($_POST['tick'], FILTER_VALIDATE_BOOLEAN);
        $prepend_id = isset($_POST['prepend_id']) ? $_POST['prepend_id'] : 'tag';
        $user_id = Yii::$app->user->getId();
        $starred = isset($_POST['starred']) ? $_POST['starred'] : null;
        $tag_item = $this->tag_service->getTag($tag_name, $user_id, $starred);
        $data['status'] = 1;
        $data['views'] = TagNavigationItem::widget(['id' => $prepend_id . '-' . $tag_item->getTagId(), 'tag' => $tag_item, 'tick' => $tick]);
        return json_encode($data);
    }
    
    public function actionRequestStarred() {
        $data = array();
        if(Yii::$app->user->isGuest || !isset($_POST['tag_name'])) {
            $data['status'] = 0 ;
            return json_encode($data);
        }
        
        $model = new \frontend\models\RequestStarredTagForm;
        $model->user_id = Yii::$app->user->getId();
        $model->tag_name = $_POST['tag_name'];
        if($model->create()) {
            $data['status'] = 1;
        } else {
            
            if($model->hasErrors()) {
                $data['errors'] = $model->getErrors();
            } else {
                $data['errors'] = 'Confused :(';
            }
            $data['status'] = 0;
        }
        return json_encode($data);

    }
    
    
    public function actionCancelStarred() {
        $data = array();
        if(Yii::$app->user->isGuest || !isset($_POST['tag_name'])) {
            $data['status'] = 0 ;
            return json_encode($data);
        }
        
        $model = new \frontend\models\CancelStarredTagForm();
        $model->user_id = Yii::$app->user->getId();
        $model->tag_name = $_POST['tag_name'];
        if($model->delete()) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        return json_encode($data);

    }
        
    
}
