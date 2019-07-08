<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 16.02.2018
 * Time: 16:44
 */

namespace frontend\models;

use common\models\Sysmessages;
use yii;
use common\models\SysImport;

class JobsModel extends \stdClass
{

    public static function loadMsg()
    {
        $fils=SysImport::find()->where('work=1')->all();
        $db = yii::$app->db;
        foreach($fils as $fil) {
            $arr=false;
            $url = $fil->url . '?lastid=' . $fil->limp . '&count=10';
            $str = file_get_contents($url);
            $arr = json_decode($str);

            if (!is_array($arr)) continue;
            if (count($arr)==0) continue;
            $tr = $db->beginTransaction();
            foreach ($arr as $item) {
                $row = new Sysmessages();
                $row->typ = $item->type;
                $row->phone = $item->phone;
                $row->grp = $item->grp;
                $row->info = $item->info;
                $row->msg = $item->msg;
                $row->dt = $item->dt;
                $row->fil=$fil->fil;
                if (preg_match('/c\d+/',$row->info,$arr)>0) $row->typ=$arr[0];
                $row->save();
                $limp=$item->id;
            }
            $fil->limp=$limp;
            $fil->save();
            $tr->commit();
        }
        return;
    }
}