<?php
namespace backend\modules\menu;

use Yii;
use yii\helpers\Json;
use backend\modules\menu\models\Model;

class Menu extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\menu\controllers';
    public $defaultRoute = 'default';

    public function init()
    {
        parent::init();      // custom initialization code goes here
    }

    /*public static function NavbarLeft($id)
    {
        $m = Model::findModel($id);
        $m = Json::decode($m->items);
        return $m['left'];
    }

    public static function NavbarRight($id)
    {
        $m = Model::findModel($id);
        $m = Json::decode($m->items);
        return $m['right'];
    }*/
}
