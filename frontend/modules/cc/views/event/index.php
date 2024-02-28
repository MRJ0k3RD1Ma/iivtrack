<?php

use common\models\Event;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\EventSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tadbirlar ro`yhati';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('Tadbir qo`shish', ['/cc/default/event'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'user_id',
                    [
                        'attribute'=>'address',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cc/event/view','id'=>$d->id]);
                            return "<a href='{$url}'>{$d->address}</a>";
                        },
                        'format'=>'raw'
                    ],
                    'date_start:date',
                    'date_end:date',
//                    'radius',
                    //'detail:ntext',
//                    'type_id',
                    [
                        'attribute'=>'type_id',
                        'value'=>function($d){
                            return $d->type->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\EventType::find()->all(),'id','name')
                    ],
                    //'lat',
                    //'long',
                    'created',
                    //'updated',
//                    'status',
                    [
                        'attribute'=>'status',
                        'value'=>function ($d) {
                            return Yii::$app->params['ustatus'][$d->status];
                        },
                        'filter'=>Yii::$app->params['ustatus']
                    ],
                ],
            ]); ?>
        </div>
    </div>


</div>
