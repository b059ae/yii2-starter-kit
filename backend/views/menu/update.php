<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $item common\models\MenuItem */

$this->title = 'Update Menu: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="menu-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?=$this->render('_form_item', [
        'model' => $item,
    ]) ?>

</div>
