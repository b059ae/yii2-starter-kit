<?php
/** @var $model \common\models\WidgetMenu */
backend\modules\menu\MenuAsset::register($this);
$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
<?=$this->render('_form', [
	'model' => $model,
]) ?>
</div>
<?php
$this->registerJs("var menu = new MyMENU.Menu({
	config: {
		setMysql: true,
		getMysql: true
	}

});", 4);
?>
