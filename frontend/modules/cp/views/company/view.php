<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Company $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Restoran/kafelar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="company-view">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-4 table-responsive">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Restoran/kafe ma`lumotlari</h4>
                            <div class="row">
                                <div class="col-md-8">
                                    <p>
                                        <?= Html::a('O`zgartirish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
                                            'class' => 'btn btn-danger',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </p>
                                </div>
                                <div class="col-md-1">

                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-switch-lg mb-3" >
                                        <?php $open = $model->work_status;?>

                                        <label class="form-check-label workstatustext"><?= Yii::$app->params['company.work_status'][$open]?></label>

                                        <input type="checkbox" class="form-check-input workcheckbox" <?= $open == 1 ? "checked" : ''?> value="<?= $model->id?>">
                                    </div>
                                </div>
                            </div>


                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'id',
                                    'name',
//                            'logo',
                                    [
                                        'attribute'=>'logo',
                                        'value'=>function($d){
                                            return "<img src='/upload/{$d->logo}'/>";
                                        },
                                        'format'=>'raw'
                                    ],
                                    'phone',
                                    'phone2',
                                    'wifi',
                                    [
                                        'label'=>'Ish vaqti',
                                        'value'=>function($d){
                                            return $d->work_begin.'-'.$d->work_end;
                                        }
                                    ],
                                    [
                                        'attribute'=>'status',
                                        'value'=>function($d){
                                            return Yii::$app->params['company.status'][$d->status];
                                        }
                                    ],

                                    [
                                        'attribute'=>'soato_id',
                                        'value'=>function($d){
                                            return $d->fulldistrict;
                                        }
                                    ],
                                    'address',
                                    'target',
//                            'theme_id',
                                    'created',
                                    'updated',
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <h4>Qo`shimcha ma`lumotlar</h4>
                            <p>
                                <button class="btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#addUser" aria-controls="addUser"><span class="fa fa-user"></span> Foydalanuvchi qo'shish</button>
                            </p>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Foydalanuvchilar
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <?= $this->render("_user",[
                                                    'model'=>$model
                                            ])?>



                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Kartadagi joylashuv
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <?= $model->location?>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Ijtimoiy tarmoqlar
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <?= $this->render("social",['company'=>$model])?>


                                        </div>
                                    </div>
                                </div>


                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            Ish kunlari
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <?= $this->render('work_days',[
                                                    'company'=>$model
                                            ])?>


                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- right offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addUser" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Foydalanuvchi qo`shish</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?= $this->render("_adduser",['company'=>$model])?>
    </div>
</div>

<?php
$url = Yii::$app->urlManager->createUrl(['/cp/company/workstatus']);
$this->registerJs("
    $('.workcheckbox').change(function(){
        if($(this).is(':checked')){
            $.get('{$url}?id='+$(this).val()+'&code=open').done(function(data){
                $('.workstatustext').empty();
                $('.workstatustext').append('Ochiq');
            });
        }else{
            $.get('{$url}?id='+$(this).val()+'&code=close').done(function(data){
                $('.workstatustext').empty();
                $('.workstatustext').append('Yopiq');
            });
        }
    })
")
?>