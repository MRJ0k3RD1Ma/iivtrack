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


    <div class="row">
        <div class="col-md-4">
            <?php  echo $form->field($model, 'status')->dropDownList(Yii::$app->params['ustatus'],['prompt'=>'Statusni tanlang']) ?>
        </div>
        <div class="col-md-4">
            <?php  echo $form->field($model, 'to')->textInput(['type'=>'date']) ?>

        </div>
        <div class="col-md-4">
            <?php  echo $form->field($model, 'do')->textInput(['type'=>'date']) ?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'code') ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'name') ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone') ?>

        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'gender')->dropDownList(Yii::$app->params['gender'],['prompt'=>'Jinsini tanlang']) ?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?php  echo $form->field($model, 'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['status'=>1])->all(),'id','name'),['prompt'=>'Inspektorni tanlang']) ?>

        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'type_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\CallType::find()->all(),'id','name'),['prompt'=>'Chaqiruv turini tanlang']) ?>

        </div>
        <div class="col-md-3">
            <?php echo $form->field($model, 'address') ?>

        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'detail') ?>
        </div>
    </div>








    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>


    <div class="form-group">
        <?= Html::submitButton('Qidiruv', ['class' => 'btn btn-primary']) ?>
        <a href="<?= Yii::$app->urlManager->createUrl(['/cc/call'])?>" class="btn btn-outline-secondary">Tozalash</a>
    </div>
    <br>
    <?php ActiveForm::end(); ?>

</div>
