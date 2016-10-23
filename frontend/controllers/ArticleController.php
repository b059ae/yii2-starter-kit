<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleAttachment;
use common\models\ArticleCategory;
use frontend\models\search\ArticleSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{
    /**
     * @param string $category
     * @return string
     */
    public function actionIndex($category)
    {
        $model = ArticleCategory::find()->andWhere(['slug'=>$category])->one();
        if (!$model) {
            throw new NotFoundHttpException;
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

        $searchModel = new ArticleSearch();
        $searchModel->category_id = $model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $this->render('index', ['dataProvider'=>$dataProvider]);
    }

    /**
     * @param string $category
     * @param string $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($category, $slug)
    {
        $model = Article::find()->published()->andWhere(['slug'=>$slug])->one();
        if (!$model) {
            throw new NotFoundHttpException;
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

    /**
     * @param $id
     * @return $this
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionAttachmentDownload($id)
    {
        $model = ArticleAttachment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }

        return Yii::$app->response->sendStreamAsFile(
            Yii::$app->fileStorage->getFilesystem()->readStream($model->path),
            $model->name
        );
    }
}
