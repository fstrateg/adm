<?php
use \yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title="Просмотр сообщений";
$data=['1' => 'LaLetty KG',
    '2' => 'LaLetty KZ',
    '3'=>'Fix Letty'];
echo Html::label('Сервис:','srv');
echo Html::dropDownList('srv', null, $data,['prompt'=>'- Выберите сервис -','onchange'=>'
	$.pjax.reload({
		url: "'.Url::to(['msg']).'?MessagesSearch[fil]="+$(this).val(),
		container: "#pjax-gridview",
		timeout: 1000,
	});
','class'=>'form-control']);
echo "<p>&nbsp;</p>";
Pjax::begin(['id' => 'pjax-gridview']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'=>$searchModel,
    'columns' => [
        'phone',
        'info',
        [
            'attribute'=>'msg',
            'contentOptions' => ['style' => 'width:50%; white-space: normal;'],
        ],
        ['attribute' => 'dt','value' => function($sModel) {
            $date = new DateTime($sModel->dt);
            return $date->format('d.m.y H:i:s');
        }],
        ['attribute'=>'grp','filter'=>array("sms"=>"SMS","err"=>"Ошибка")],
    ],
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'timeZone' => 'Asia/Bishkek'
    ],
]);
Pjax::end();
?>