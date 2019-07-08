<?php
/**
 * Created by PhpStorm.
 * User: Alekseym
 * Date: 30.06.2019
 * Time: 18:29
 */

namespace common\models;

use yii\db\ActiveRecord;


class Sysmessages extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%sys_messages}}';
    }
    public function attributeLabels() {
        return [
            /* Другие названия атрибутов */
            'dt' => 'Дата',
            'msg' => 'Сообщение',
            'phone' => 'Номер клиента',
            'grp'=>'Группа',
            'info'=>'Информация'
        ];
    }
}