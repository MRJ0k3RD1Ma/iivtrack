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

        <div class="col-md-3" id="coords">

            <?php $form = ActiveForm::begin()?>

                <?= $form->field($model,'date_start')->textInput(['type'=>'date'])?>

                <?= $form->field($model,'date_end')->textInput(['type'=>'date'])?>

                <?= $form->field($model,'type_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\EventType::find()->all(),'id','name'),['prompt'=>'Tadbir turini tanlang']) ?>

                <?= $form->field($model,'detail')->textarea()?>

                <?= $form->field($model,'address')->textInput()?>

                <div hidden="hidden" class="hidden">
                    <?= $form->field($model,'radius')->textInput()?>

                    <?= $form->field($model,'lat')->textInput()?>

                    <?= $form->field($model,'long')->textInput()?>
                </div>

                <button type="submit" class="btn btn-primary">Saqlash</button>

            <?php ActiveForm::end()?>

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
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
       
        var drawControl = new L.Control.Draw({
         draw : {
            polygon : false,
            polyline : false,
            rectangle : false,
            circlemarker: false,
            circle: true,
            marker: false
          },
          edit: {
            featureGroup: drawnItems,
            edit:false
          }
        });
        
        map.addControl(drawControl);
        
        map.on(L.Draw.Event.CREATED, function (e) {
          console.clear();
          var type = e.layerType
          var layer = e.layer;
          
        
          // Do whatever else you need to. (save to db, add to map etc)
          
          drawnItems.addLayer(layer);
          
          console.log('Coordinates:');
          
          if (type == 'marker' || type == 'circle' || type == 'circlemarker'){
            console.log([layer.getLatLng().lat, layer.getLatLng().lng]);
            $('#event-lat').val(layer.getLatLng().lat);
            $('#event-long').val(layer.getLatLng().lng);
            $('#event-radius').val(parseInt(layer.getRadius()));
          }
          else {
            var objects = layer.getLatLngs()[0];
            for (var i = 0; i < objects.length; i++){
              console.log([objects[i].lat,objects[i].lng]);
            }
            console.log(layer)
          }
          
           
        });
  
        $('.leaflet-draw-draw-circle').click(function(){
            map.eachLayer((layer) => {
             if(layer['_latlng']!=undefined)
                 layer.remove();
            });
        })
  
  
    ")

?>