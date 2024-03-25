<?php

namespace app\modules\comments\actions;

use app\modules\comments\models\Comments;
use Yii;
use yii\base\Action;
use yii\web\Response;

class CommentCreateAction extends Action
{

    public function run()
    {
        $model = new Comments();

        $model->user_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : 1; //TODO

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->children = NULL;
            $model->refresh();
            $models = [$model];
            return $this->renderJSON([
                'message' => 'success',
                'id' => $model->id,
                'html' => $this->controller->renderPartial('@app/modules/comments/widgets/views/_index_item.php', [
                    'models' => $models,
                    'options' => [
                        'answers' => false
                    ]
                ])
            ]);
        } else {
            return $this->renderJSON([
                'message' => 'error',
                'error' => $model->getErrors()
            ]);
        }

    }

    protected function renderJSON($data)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($data['html'])) {
            $data['html'] = mb_convert_encoding($data['html'], 'UTF-8', 'UTF-8');
        }
        return $data;
    }

}