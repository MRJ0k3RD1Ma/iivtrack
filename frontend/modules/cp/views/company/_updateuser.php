<?php
use common\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this \yii\web\View*/
/* @var $model \common\models\User*/
?>

<?php $form = ActiveForm::begin(['action'=>Yii::$app->urlManager->createUrl(['/cp/company/updateuser','id'=>$model->id]),'method'=>'post'])?>


<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'username',)->widget(MaskedInput::class, [
    'mask' => '(99)999-9999',
]) ?>

<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>


<?= $form->field($model, 'status')->dropDownList([1=>'Aktiv',0=>"Deaktiv"]) ?>

<?= $form->field($model, 'role_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\UserRole::find()->where("30 <= id and id < 40")->all(),'id','name'),['prompt'=>'']) ?>

<div class="form-group">
    <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end()?>
