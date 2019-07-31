<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 16.02.2018
 * Time: 16:44
 */

namespace frontend\models;

use common\components\Telegram;
use common\models\FilRecord;
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
            $url = $fil->url . '?lastid=' . $fil->limp . '&count=100';
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

    public static function doReport()
    {
        $reps=RepRecord::find()->orderBy('fil')->all();
        $site=FilRecord::find()->orderBy('id')->all();
        $sites=[];
        foreach($site as $item) $sites[$item->id]=$item->nam;
        $db=yii::$app->db;
        foreach($reps as $fil)
        {
            ob_start();
            $info=$sites[$fil->fil];
            $query="SELECT count(*) cnt,max(id) id,
	          sum(case WHEN typ='c0' then 1 else 0 end) nr,
              sum(case when typ='c1' then 1 else 0 end) c1,
              sum(case when typ='c5' then 1 else 0 end) c5,
              sum(case when typ='c21' then 1 else 0 end) c21,
              sum(case when typ='c42' then 1 else 0 end) c42,
              sum(case when typ='c30' then 1 else 0 end) c30
          FROM `sys_messages`
            WHERE fil={$fil->fil}
              and id>{$fil->last}";
            $rez=$db->createCommand($query)->queryAll();
            $qua=$rez[0]['cnt'];
            if (!$qua) $qua=0;
            $vl="Импортировано: ".$qua;
            self::out($vl,$info);
            $qua=$rez[0]['nr'];
            if (!$qua) $qua=0;
            self::out("Новых записей: ".$qua);
            self::out("Напоминаний: ");
            $qua=$rez[0]['c1'];
            if ($qua) self::out("C1: ".$qua);
            $qua=$rez[0]['c5'];
            if ($qua) self::out("C5: ".$qua);
            $qua=$rez[0]['c21'];
            if ($qua) self::out("C21: ".$qua);
            $qua=$rez[0]['c42'];
            if ($qua) self::out("C42: ".$qua);
            $qua=$rez[0]['c30'];
            if ($qua) self::out("C30: ".$qua);

            $fil->setAttribute('last',$rez[0]['id']);
            $fil->save();

        }
    }

    private static function out($msg,$info=null)
    {
        Telegram::instance()->sendMessageAll($msg,$info);
    }
}