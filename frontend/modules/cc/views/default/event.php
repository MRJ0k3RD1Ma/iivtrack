<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Address $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="address-form">

    <div class="row">
        <div class="col-md-12 map">

            <div id="map"></div>

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