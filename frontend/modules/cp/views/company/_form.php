<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Company $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'target')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone2')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'wifi')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'work_begin')->textInput(['type' => 'time']) ?>

            <?= $form->field($model, 'work_end')->textInput(['type' => 'time']) ?>

            <?= $form->field($model, 'work_status')->dropDownList(Yii::$app->params['company.work_status']) ?>

            <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['company.status']) ?>


        </div>
        <div class="col-md-6">

            <div class="form-group">
                <img src="/upload/<?= $model->isNewRecord ? 'default/company.png' : $model->logo?>" id="blah" style="height:200px; width:auto;">
            </div>
            <br>

            <?= $form->field($model, 'logo')->fileInput() ?>

            <?= $form->field($model, 'location')->textInput() ?>

            <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'long')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model,'region_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\RegionView::find()->all(),'region_id','name_lot'))?>

            <?= $form->field($model,'soato_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\DistrictView::find()->where(['region_id'=>$model->region_id])->all(),'id','name_lot'))?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$url = Yii::$app->urlManager->createUrl(['/cp/default/getdistrict']);
$this->registerJs("

        $('#company-region_id').change(function(){
           $.get('{$url}?id='+$('#company-region_id').val()).done(function(data){
                $('#company-soato_id').empty();
                $('#company-soato_id').append(data);
           }) 
        });
        function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
              $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
          }
        }
        
        $('#company-logo').change(function() {
          readURL(this);
        });
        
");