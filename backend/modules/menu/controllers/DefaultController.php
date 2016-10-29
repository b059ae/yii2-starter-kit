<?php
namespace backend\modules\menu\controllers;

use backend\models\search\WidgetMenuSearch;
use common\models\WidgetMenu;
use Yii;
use yii\web\Response;
use yii\web\NotFoundHttpException;

class DefaultController extends \yii\web\Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        $searchModel = new WidgetMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new WidgetMenu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $m = $this->findModel($id);
        $r = Yii::$app->request;

        if ($m->load($r->post()) && $m->save()) {
            return $this->redirect(['update', 'id'=>$m->id]);
        }

        if ($r->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            switch (true) {
                case $r->isGet :
                    return ['success' => true, 'menu' => $m->items];
                case $r->post('update'):
                    $m->items = $r->post('menu');
                    return $m->save() ? ['success' => true] : ['success' => false];
                default:
                    return ['success' => false];
            }
        }

        return $this->render('update',[
            'model'=>$m,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the WidgetMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WidgetMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WidgetMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
