<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Address $model */

$this->title = 'Update Address: ' . $model->address;
$this->params['breadcrumbs'][] = ['label' => 'Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->address, 'url' => ['view', 'address' => $model->address]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="address-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
