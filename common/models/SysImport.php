<?php
/**
 * Created by PhpStorm.
 * User: Alekseym
 * Date: 30.06.2019
 * Time: 18:17
 */

namespace common\models;


use yii\db\ActiveRecord;

class SysImport extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%sys_import}}';
    }
}