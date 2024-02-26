<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\CallSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="call-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'code_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'type_id') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
