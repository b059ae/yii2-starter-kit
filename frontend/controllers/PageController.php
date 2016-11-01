<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:01 PM
 */

namespace frontend\controllers;

use Yii;
use common\models\Page;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    public function actionView($slug)
    {
        /** @var Page $model */
        $model = Page::find()->where(['slug'=>$slug, 'status'=>Page::STATUS_PUBLISHED])->one();
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found'));
        }
        //Мета-теги
        foreach (['description', 'keywords'] as $name) {
            $attr = 'meta_' . $name;
            \Yii::$app->view->registerMetaTag([
                'name' => $name,
                'content' => strlen($model->$attr) > 0
                    ? $model->$attr
                    : Yii::$app->keyStorage->get('frontend.' . $attr)
            ], $name);
        }

        $viewFile = $model->view ?: 'view';
        return $this->render($viewFile, ['model'=>$model]);
    }
}
