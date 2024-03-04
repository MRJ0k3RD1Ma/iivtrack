<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */
/** @var common\models\Event $model */

$this->title = $model->address;
$this->params['breadcrumbs'][] = ['label' => 'Tadbirlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="event-view">

    <div class="card">
        <div class="card-body">
            <?php if(false){?>
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
            <?php }?>

            <div class="row">
                <div class="col-md-6 map">
                    <div id="map"></div>
                </div>
                <div class="col-md-3">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
//            'id',
//            'user_id',
                            'address',

                            'date_start:date',
                            'date_end:date',
//            'radius',
                            [
                                'attribute'=>'radius',
                                'value'=>function($d){
                                    return $d->radius .' metr';
                                }
                            ],
                            'detail:ntext',
//            'type_id',
                            [
                                'attribute'=>'type_id',
                                'value'=>function ($d) {
                                    return $d->type->name;
                                }
                            ],

                            'lat',
                            'long',
                            [
                                'attribute'=>'user_id',
                                'value'=>function ($d) {
                                    return $d->user->name;
                                }
                            ],
                            'created',
                            'updated',
                            [
                                'attribute'=>'status',
                                'value'=>function ($d) {
                                    return Yii::$app->params['ustatus'][$d->status];
                                },
                            ],
                        ],
                    ]) ?>

                    <hr>
                    <?php if($model->status < 3){?>
                    <h4>Statusni yanglilash</h4>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cc/event/changestatus','id'=>$model->id])?>" class="btn btn-primary">Keyingi status: <?= Yii::$app->params['ustatus'][$model->status+1]?></a>

                    <?php }?>
                </div>

                <div class="col-md-3">
                    <?php $form = ActiveForm::begin()?>

                    <?= $form->field($user,'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\User::find()
                        ->where('id not in (select user_id from event_user where event_id='.$model->id.')')
                        ->andWhere('id not in (select event_user.user_id from event_user where event_user.event_id in (select event.id from event where event.status = 2 and "'.date('Y-m-d').'" BETWEEN event.date_start AND event.date_end ))')
                        ->all(),'id','name'))?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($user,'time_start')->textInput(['type'=>'time'])?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($user,'time_end')->textInput(['type'=>'time'])?>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Saqlash</button>

                    <?php ActiveForm::end()?>


                    <hr>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>FIO</th>
                                <th>Boshi</th>
                                <th>Tugashi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $users = \common\models\EventUser::find()->where(['event_id'=>$model->id])->all();
                            foreach ($users as $key=>$item):?>

                            <tr>
                                <td><?= $key+1?></td>
                                <td><?= $item->user->name?></td>
                                <td><?= $item->time_start?></td>
                                <td><?= $item->time_end?></td>
                            </tr>

                            <?php endforeach;?>
                        </tbody>
                    </table>

                </div>



            </div>
        </div>
    </div>

</div>


<?php
//

$this->registerJs("
        // init map
        var map = L.map('map').setView([{$model->lat}, $model->long], 16);
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 20,
            attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
        });
        osm.addTo(map);
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        
        var circle = L.circle([{$model->lat}, {$model->long}], {$model->radius});
        circle.addTo(map);

        
  
  
    ")

?>