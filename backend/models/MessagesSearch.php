<?php
namespace backend\models;

use common\models\Sysmessages;
use yii\data\ActiveDataProvider;

class MessagesSearch extends Sysmessages
{
    public function rules()
    {
        // только поля определенные в rules() будут доступны для поиска
        return [
            [['phone'], 'string'],
            [['grp', 'dt', 'msg','info','fil'], 'safe'],
        ];
    }

    public function search($param)
    {
        $query = Sysmessages::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ // постраничная разбивка
                'pageSize' => 50, // 10 новостей на странице
            ],
            'sort' => [ // сортировка по умолчанию
                'defaultOrder' => ['dt' => SORT_DESC],
            ],
        ]);

        /*$dataProvider->setSort([
            'attributes' => [
                'grp',
                'dt' => [
                    'default' => SORT_DESC
                ]
            ]
        ]);*/
        if (!($this->load($param) && $this->validate())) {
            return $dataProvider;
        }

        $query->andWhere('phone like "%'.$this->phone.'%"');
        $query->andWhere('info like "%'.$this->info.'%"');
        $query->andWhere('msg like "%'.$this->msg.'%"');
        if ($this->fil) $query->andWhere('fil='.$this->fil);
        if ($this->grp) $query->andWhere('grp="'.$this->grp.'"');
        return $dataProvider;

    }
}
