<?php
/**
 * Created by PhpStorm.
 * User: Alekseym
 * Date: 09.07.2019
 * Time: 23:32
 */

namespace frontend\models;

use yii\db\ActiveRecord;


class RepRecord extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%rep}}';
    }
}