<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CallType $model */

$this->title = 'Qo`shish';
$this->params['breadcrumbs'][] = ['label' => 'Chaqiruv turlari', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-type-create">

    <div class="card">
        <div class="card-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
