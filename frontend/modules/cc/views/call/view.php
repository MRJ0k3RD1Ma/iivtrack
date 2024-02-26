<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Call $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Calls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="call-view">




    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'code_id',
            'name',
            'phone',
            'gender',
            'type_id',
            'detail',
            'address',
            'user_id',
            'created',
            'updated',
            'status',
        ],
    ]) ?>

</div>
