<?php

use common\models\CallType;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\CallTypeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Chaqiruv turlari';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-type-index">


    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('Qo`shish', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'name',
                    [
                        'attribute'=>'name',
                        'format'=>'raw',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cc/call-type/view','id'=>$d->id]);
                            return "<a href='{$url}'>{$d->name}</a>";
                        }
                    ],
                ],
            ]); ?>

        </div>
    </div>

</div>
