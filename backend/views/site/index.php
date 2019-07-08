<?php
use common\components\cpanel\CPanelBtn;
/* @var $this yii\web\View */

$this->title = 'Fix-Litty';
?>
<div class="site-index">
    <? $panel=CPanelBtn::begin();
    $panel->addPanelBtn([
        'text'=>'Сообщения',
        'url'=>\yii\helpers\Url::toRoute('/app/msg'),
        'img'=>'msg',
    ]);
    $panel->end();
    ?>
</div>
