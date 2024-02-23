<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Foydalanuvchilar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">

                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">
                                Foydalanuvchi ma`lumotlari
                            </h4>
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

                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'id',
                                    [
                                        'attribute'=>'image',
                                        'value'=>function($d){
                                            return "<img style='height: 200px' src='/upload/{$d->image}'/>";
                                        },
                                        'format'=>'raw'
                                    ],
                                    'name',
                                    'username',
//                            'password',
//                            'auth_key',
//                            'token',
                                    'code',
//                            'access_token',
                                    'created',
                                    'updated',
                                    [
                                        'attribute'=>'status',
                                        'value'=>function($d){
                                            return Yii::$app->params['user.status'][$d->status];
                                        }
                                    ],
                                    [
                                        'attribute'=>'role_id',
                                        'value'=>function($d){
                                            return $d->role->name;
                                        }
                                    ]
//                            'status',
//                            'role_id',
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <h4 class="card-title">
                                Qo`shimcha ma`lumotlar
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
