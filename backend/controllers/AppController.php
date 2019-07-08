<?php
namespace backend\controllers;

use backend\models\MessagesSearch;
use common\models\SettingsRecord;
use common\models\StaffRecord;
use common\models\StaffUserRecord;
use common\models\SysMessagesRecord;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use common\models\Access;

class AppController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['quality','qualitysave','qualitymsg','masters','msg'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!Access::isAdmin())
            throw new ForbiddenHttpException('Доступ к этому разделу запрещен!');
        return parent::beforeAction($action);
    }

    public function actionMsg()
    {
        $searchModel = new MessagesSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render("msglog",['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);
    }
}