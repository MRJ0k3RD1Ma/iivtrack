<?php
use yii\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-md-9 map">

        <div id="map"></div>

    </div>
    <div class="col-md-3">
        <?php $form = ActiveForm::begin()?>
            <?= $form->field($model,'address')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Address::find()->all(),'address','address'),['prompt'=>'Manzilni tanlang','class'=>'form-control select2'])?>
            <?= $form->field($model,'name')->textInput()?>
            <?= $form->field($model,'phone')->textInput()?>
            <?= $form->field($model,'gender')->dropDownList(Yii::$app->params['gender'])?>
            <?= $form->field($model,'type_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\CallType::find()->all(),'id','name'),['prompt'=>'Murojaat turini tanlang'])?>
            <?= $form->field($model,'detail')->textarea()?>
            <?= $form->field($model,'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['<','role_id',30])->all(),'id','name'))?>

            <button class="btn btn-primary">Saqlash</button>
        <?php ActiveForm::end() ?>
    </div>

</div>



<?php
//
$this->registerJs("
        // init map
    var map = L.map('map').setView([41.552269, 60.631571], 12);
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        preferCanvas: true,
        attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
    });
    osm.addTo(map);
    var locations = {$markers};
    
    for (var i = 0; i < locations.length; i++) {
      var icn = '/icon/marker-blue.png';
      if(locations[i][3] != 0){
         icn = '/icon/marker-red.png';;
      }
      var myIcon = L.icon({
            iconUrl: icn,
            iconSize: [26, 36],
            iconAnchor: [15, 35],
            popupAnchor: [-3, -76],
            shadowAnchor: [15, 35]
        });
      marker = new L.marker([locations[i][1], locations[i][2]],{icon: myIcon})
        .bindPopup(locations[i][0])
        .addTo(map);
    }
    
    var iconDotGreen = L.icon({
            iconUrl: '/icon/dot_green.png',
            iconSize: [26, 26],
            iconAnchor: [15, 15],
            popupAnchor: [-3, -76],
            shadowAnchor: [15, 15]
        });
    
    var circleMarker = new L.circleMarker([41.550864667292245, 60.63274706148625],{color: '#564ab1'})
        .bindPopup('Mayor Dilmurod Allabergenov')
        .addTo(map);
        
    ")

?>