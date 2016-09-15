<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\imagine\Image;
use Imagine\Image\Box;  

class ImageController extends Controller {
    
    const DEFAULT_WIDTH = 500;
    const DEFAULT_HEIGHT = 500;
    
    public function actionIndex() {
        
        $default_path =  Yii::$app->request->baseUrl . '/frontend/web';

        if(!isset($_GET['path'])) {
            return null;
        }
        $width = isset($_GET['width']) ? $_GET['width'] : self::DEFAULT_WIDTH;
        $height = isset($_GET['height'])  ? $_GET['height'] : self::DEFAULT_HEIGHT;
        
        $response = Yii::$app->getResponse();
        $image = Image::getImagine()->open(Yii::getAlias('@webroot/') . $_GET['path'])->thumbnail(new Box($width, $height));
        $response->sendContentAsFile($image, $_GET['path']);
    }
}