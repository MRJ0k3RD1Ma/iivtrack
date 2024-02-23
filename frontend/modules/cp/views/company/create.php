<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Company $model */

$this->title = 'Restoran/kafe qo`shish';
$this->params['breadcrumbs'][] = ['label' => 'Restoran/kafelar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-create">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>

</div>
