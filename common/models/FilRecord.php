<?php
/**
 * Created by PhpStorm.
 * User: Alekseym
 * Date: 10.07.2019
 * Time: 17:46
 */

namespace common\models;


use yii\db\ActiveRecord;

class FilRecord extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%fil}}';
    }
}