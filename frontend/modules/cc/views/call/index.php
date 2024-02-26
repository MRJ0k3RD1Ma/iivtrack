<?php

use common\models\Call;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\CallSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Chaqiruvlar ro`yhati';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-index">

    <div class="card">
        <div class="card-body">


            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'code',
                    [
                        'attribute'=>'code',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cc/call/view','id'=>$d->id]);
                            return "<a href='{$url}'><span class='fa fa-eye'></span> {$d->code}</a>";
                        },
                        'format'=>'raw'
                    ],
//            'code_id',
                    'name',
                    'phone',
                    //'gender',
//            'type_id',
                    [
                        'attribute'=>'type_id',
                        'value'=>function($d){return $d->type->name;}
                    ],
                    //'detail',
                    'address',
                    //'user_id',
                    'created',
                    //'updated',
                    //'status',
                ],
            ]); ?>
        </div>
    </div>


</div>
