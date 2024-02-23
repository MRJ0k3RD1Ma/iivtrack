<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Address $model */

$this->title = 'Manzil qo`shish';
$this->params['breadcrumbs'][] = ['label' => 'Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
