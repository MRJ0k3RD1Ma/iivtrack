<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-md-7">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'username',)->widget(MaskedInput::class, [
                'mask' => '(99)999-9999',
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>




            <?= $form->field($model, 'status')->dropDownList([1=>'Aktiv',0=>"Deaktiv",-1=>'O`chirilgan']) ?>


            <?= $form->field($model, 'role_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\UserRole::find()->all(),'id','name'),['prompt'=>'']) ?>

            <?= $form->field($model, 'hudud')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'pozivnoy')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-5">

            <div class="form-group">
                <img src="/upload/<?= $model->isNewRecord ? 'default/avatar.png' : $model->image?>" id="blah" style="height:200px; width:auto;">
            </div>
            <br>
            <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>




        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
        function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
              $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
          }
        }
        
        $('#user-image').change(function() {
          readURL(this);
        });
        
");