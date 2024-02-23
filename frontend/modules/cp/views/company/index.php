<?php

use common\models\Company;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\CompanySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Restoran/kafelar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">
                    <p>
                        <?= Html::a('Restoran/kafe qo`shish', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//                            'name',
                            [
                                'attribute'=>'name',
                                'value'=>function($d){
                                    $url = Yii::$app->urlManager->createUrl(['/cp/company/view','id'=>$d->id]);
                                    return "<a href='{$url}'>{$d->name}</a>";
                                },
                                'format'=>'raw'
                            ],
//            'logo',
//            'location:ntext',
//            'lat',
                            //'long',
                            'phone',
                            //'phone2',
                            //'wifi',
                            //'work_begin',
                            //'work_end',
//            'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($d){
                                    return Yii::$app->params['company.status'][$d->status];
                                },
                                'filter'=>Yii::$app->params['company.status']
                            ],
                            //'work_status',
                            //'theme_id',
                            'created',
                            //'updated',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>


</div>
