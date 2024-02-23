<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\CompanySocial $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>


    <h4><?= $model->social->name ?> manzilni kiritish</h4>
    <?= $form->field($model,'url')->textInput(['type'=>'url'])?>
    <?= $form->field($model,'username')->textInput()?>
    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

