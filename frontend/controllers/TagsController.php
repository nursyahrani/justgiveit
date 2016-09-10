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
        $tick = isset($_POST['tick']) ? $_POST['tick'] : false;
        $user_id = Yii::$app->user->getId();
        
        $tag_item = $this->tag_service->getTag($tag_name, $user_id);
        $data['status'] = 1;
        $data['views'] = TagNavigationItem::widget(['id' => 'tag-' . $tag_item->getTagId(), 'tag' => $tag_item, 'tick' => $tick]);
        return json_encode($data);
    }
}
