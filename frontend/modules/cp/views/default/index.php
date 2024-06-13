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
            <?= $form->field($model,'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\User::find()
                ->where(['<','role_id',30])->all(),'id','name'),['class'=>'form-control select2'])?>
        <br>

            <button class="btn btn-primary">Saqlash</button>
        <?php ActiveForm::end() ?>

        <hr>
        <h4 class="text text-danger">Izohlar</h4>
        <p><img src="/icon/marker-blue.png" alt="" style="float: left; width: 20px;"> - Joy manzili</p>
        <br>
        <p><img src="/icon/marker-red.png" alt="" style="float: left; width: 20px;"> - Chaqiruv manzili</p>
        <br>
        <p><img src="/icon/police.png" alt="" style="float: left; width: 20px;"> - Inspektor</p>
        <br>
        <p><img src="/icon/police_red.png" alt="" style="float: left; width: 20px;"> - O`z joyida bo'lmagan Inspektor</p>
        <br>
        <p><img src="/icon/police_green.png" alt="" style="float: left; width: 20px;"> - Inspektor bilan aloqa yo'q</p>
        <br>
    </div>

</div>



<?php
//
$url = Yii::$app->urlManager->createUrl(['/cp/default/police']);
$active_url = Yii::$app->urlManager->createUrl(['/site/active-police']);
$this->registerJs("
        // init map
        
    var markers = [];    
    var map = L.map('map').setView([41.552269, 60.631571], 12);
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        preferCanvas: true,
        attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
    });
    osm.addTo(map);
    var locations = {$locs};
     for (var i = 0; i < locations.length; i++) {
      var icn = '/icon/marker-red.png';
      
      var myIcon = L.icon({
            iconUrl: icn,
            iconSize: [26, 36],
            iconAnchor: [13, 36],
            popupAnchor: [-3, -30],
        });
      marker = new L.marker([locations[i][1], locations[i][2]],{icon: myIcon})
        .bindPopup(locations[i][0])
        .addTo(map);
    }
    locations = {$ev_locs};
    var events = [];
    for (var i = 0; i < locations.length; i++) {
      marker = new L.circle([locations[i][0], locations[i][1]],parseInt(locations[i][2]));
      marker.addTo(map);
    }
    
    function polices(){
        $.get('{$url}').done(function(data){
            
            var locations = JSON.parse(data);
           
            var aktiv = 0;
            markers.forEach((marker) => {
                map.removeLayer(marker);
            });
            
            for (var i = 0; i < locations.length; i++) {
          
            var icn = '/icon/police.png';
            if(locations[i][3] == 0){
               icn = '/icon/police_green.png';
            }else{
                aktiv ++;
            }
            if(locations[i][6] != -1){
                var _first = new L.latLng(locations[i][1], locations[i][2]);
                var _second = new L.latLng(locations[i][7], locations[i][8]);
           
                var radius = locations[i][6];
                let distance = map.distance(_first,_second);
                if(radius < distance){
                    icn = '/icon/police_red.png';
                }
            }
            
            myIcon = L.icon({
               iconUrl: icn,
               iconSize: [34, 46],
               iconAnchor: [17, 46],
               popupAnchor: [-3, -40],
            });
            marker = new L.marker([locations[i][1], locations[i][2]],{icon: myIcon})
            .bindPopup(locations[i][0])
            .addTo(map);

            markers[locations[i][5]] = marker; 
            
            $('#aktiv-hodim').empty();
            $('#aktiv-hodim').append(aktiv);
        
            }
        })
    }
    
    polices();
    
     
    setInterval(function(){
         polices();
     },10000);
     
     function police_active(){
        $.ajax({
            url: '{$active_url}',
        });
     }
     police_active();
     setInterval(function(){
         police_active();
     },60000);
       
       
       
       
    ")

?>