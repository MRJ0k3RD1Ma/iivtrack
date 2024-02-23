<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Foydalanuvchilar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">


    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">
                    <p>
                        <?= Html::a('Foydalanuvchi qo`shish', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

//                            'id',
//                            'name',
                            [
                                'attribute'=>'name',
                                'value'=>function ($d){
                                    $url = Yii::$app->urlManager->createUrl(['/cp/user/view','id'=>$d->id]);
                                    return "<a href='{$url}'>{$d->name}</a>";
                                },
                                'format'=>'raw'
                            ],
                            'username',
                            [
                                'attribute'=>'role_id',
                                'value'=>function($d){
                                    return $d->role->name;
                                },
                                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\UserRole::find()->all(),'id','name')
                            ],
//                            'password',
//                            'auth_key',
                            //'token',
                            //'code',
                            //'access_token',

                            //'updated',
                            //'status',
//                            'role_id',
                            [
                                'attribute'=>'status',
                                'value'=>function($d){
                                    return Yii::$app->params['user.status'][$d->status];
                                },
                                'filter'=>Yii::$app->params['user.status']
                            ],
                            'created',

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

</div>
