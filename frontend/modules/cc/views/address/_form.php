<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Address $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="address-form">

    <div class="row">
        <div class="col-md-9 map">

            <div id="map"></div>

        </div>
        <div class="col-md-3">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            <div style="display: none">
            <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'long')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>


<?php
    //
    $this->registerJs("
        // init map
    var map = L.map('map').setView([41.552269, 60.631571], 12);
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
    });
    osm.addTo(map);
    var singleMarker;
    map.on('click',function(e){
        $('#address-lat').val(e.latlng.lat);
        $('#address-long').val(e.latlng.lng);
        var myIcon = L.icon({
            iconUrl: '/icon/marker-blue.png',
            iconSize: [26, 36],
            iconAnchor: [15, 35],
            popupAnchor: [-3, -76],
//            shadowSize: [68, 50],
            shadowAnchor: [15, 35]
        });
        if(singleMarker){
            map.removeLayer(singleMarker)
        }
        singleMarker = L.marker([e.latlng.lat, e.latlng.lng],{icon: myIcon});
        singleMarker.addTo(map);
    })
    ")

?>