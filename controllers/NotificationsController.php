<?php

namespace app\controllers;

use app\components\BaseController;
use Yii;
use app\models\Notifications;
use app\models\search\SearchNotifications;
use yii\web\NotFoundHttpException;

/**
 * NotificationsController implements the CRUD actions for Notifications model.
 */
class NotificationsController extends BaseController
{
    const PERMISSION_INDEX_ALL = 'BasicNotificationsIndexAll';

    /**
     * Lists all Notifications models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchNotifications();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notifications model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if($model->user_id == Yii::$app->user->id){
            $model->setReaded();
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Notifications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notifications();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Notifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Notifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(Yii::$app->user->can(self::PERMISSION_INDEX_ALL)){
            $model = Notifications::findOne($id);
        } else {
            $model = Notifications::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
