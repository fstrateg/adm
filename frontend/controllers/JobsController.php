<?php
namespace frontend\controllers;

use common\models\SysImport;
use frontend\models\JobsModel;
use Yii;
use yii\base\Controller;

/**
 * Site controller
 */
class JobsController extends Controller
{
    public function actionLoadmsg()
    {
        JobsModel::loadMsg();
    }

    public function actionDoreport()
    {
        JobsModel::doReport();
    }
}
