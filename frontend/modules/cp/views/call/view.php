<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Call $model */

$this->title = $model->code.' '.Yii::$app->params['ustatus'][$model->status];
$this->params['breadcrumbs'][] = ['label' => 'Chaqiruvlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="call-view">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?php
                    if($model->status == 1 or $model->status == 2){
                    $form = \yii\widgets\ActiveForm::begin()?>

                    <?= $form->field($result,'result')->textarea(['rows'=>6])?>

                    <button type="submit" class="btn btn-success">Chaqiruvni tugallash</button>

                    <?php \yii\widgets\ActiveForm::end(); }elseif($model->status == 3){?>

                    <?php }elseif($model->status == 4){?>
                            <h4>Chaqiruv natijasi:</h4>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Batafsil</th>
                                    <th>Kiritdi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($results as $key=>$item):?>
                                    <tr>
                                        <td><?= $key+1?></td>
                                        <td>
                                            <?= $item->result ?>
                                            <br>

                                            <?php if($item->status == 1){?>
                                                <p>
                                                    <a href="<?= Yii::$app->urlManager->createUrl(['/cc/call/accept','id'=>$item->id,'call_id'=>$item->call_id])?>" class="btn btn-success">Tasdiqlash</a>
                                                    <a href="<?= Yii::$app->urlManager->createUrl(['/cc/call/deny','id'=>$item->id,'call_id'=>$item->call_id])?>" class="btn btn-success">Rad qilish</a>
                                                </p>
                                            <?php }?>
                                        </td>

                                        <td>
                                            <?= $item->user->name?>
                                            <br>
                                            <?= $item->created ?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                    <?php }?>
                </div>
                <div class="col-md-6">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'code',
//                    'code_id',
                            'name',
                            'phone',
//                    'gender',
                            [
                                'attribute'=>'gender',
                                'value'=>function($d){return Yii::$app->params['gender'][$d->gender];}
                            ],
//                    'type_id',
                            [
                                'attribute'=>'type_id',
                                'value'=>function($d){return $d->type->name;}
                            ],
                            'detail',
                            'address',
//                    'user_id',
                            [
                                'attribute'=>'user_id',
                                'value'=>function($d){return $d->user->name; }
                            ],
                            'created',
                            'updated',
//                    'status',
                            [
                                'attribute'=>'status',
                                'value'=>function ($d) {
                                    return Yii::$app->params['ustatus'][$d->status];
                                }
                            ],

                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>


</div>
