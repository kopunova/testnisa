<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Список новостей';
?>

<?php foreach ($models as $model): ?>

	<?= Html::a(Html::encode($model['name']), Url::to("view?id={$model['id']}"), ['target' => '_blank']) ?>
	<br>

<?php endforeach; ?>

<?=
    LinkPager::widget([
        'pagination' => $pages,
    ]);
?>














