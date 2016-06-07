<?php

namespace app\modules\comments\actions;

use app\modules\api\actions\ApiAction;
use app\modules\comments\models\Comments;
use Yii;


class CommentCreateAction extends ApiAction
{

    public function init()
    {
        $this->ajaxOnly = true;
        $this->jsonOnly = true;
        return parent::init();
    }

    public function run()
    {
        $model = new Comments();

        $model->user_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : 1; //TODO

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->children = NULL;
            $models = [$model];
            return $this->render([
                'message'=>'success',
                'id'=>$model->id,
                'html'=>$this->controller->renderPartial('@app/modules/comments/widgets/views/_index_item.php', [
                    'models' => $models,
                    'options'=>[
                        'answers' => false
                    ]
                ])
            ]);
        } else {
            return $this->render([
                'message'=>'error',
                'error'=>$model->getErrors()
            ]);
        }

    }

}