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
            <?= $form->field($model,'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['<','role_id',30])->andWhere(['status'=>1])->all(),'id','name'),['class'=>'form-control select2'])?>
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
$url = Yii::$app->urlManager->createUrl(['/cc/default/police']);
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
    
    function getBearing(lat1, lon1, lat2, lon2) {
        var dLon = (lon2 - lon1) * Math.PI / 180;
        lat1 = lat1 * Math.PI / 180;
        lat2 = lat2 * Math.PI / 180;

        var y = Math.sin(dLon) * Math.cos(lat2);
        var x = Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1) * Math.cos(lat2) * Math.cos(dLon);

        var brng = Math.atan2(y, x) * 180 / Math.PI;
        return (brng + 360) % 360; // Normalize to 0-360
    }
    
    
    function polices(){
        $.get('{$url}').done(function(data){
            
            var locations = JSON.parse(data);
           
            var aktiv = 0;
            markers.forEach((marker) => {
                map.removeLayer(marker);
            });
            
            for (var i = 0; i < locations.length; i++) {
          
            var icn = '/icon/'+locations[i]['icon']+'/police.png?v=1';
            if(locations[i]['active'] == 0){
               icn = '/icon/'+locations[i]['icon']+'/police_green.png?v=1';
            }else{
                aktiv ++;
            }
            if(locations[i]['radius'] != -1){
                var _first = new L.latLng(locations[i]['lat'], locations[i]['long']);
                var _second = new L.latLng(locations[i]['elat'], locations[i]['elong']);
           
                var radius = locations[i]['radius'];
                let distance = map.distance(_first,_second);
                if(radius < distance){
                    icn = '/icon/'+locations[i]['icon']+'/police_red.png?v=1';
                }
            }
            myIcon = L.icon({
               iconUrl: icn,
               iconSize: [34, 46],
               iconAnchor: [17, 46],
               popupAnchor: [-3, -40],
            });
            if(locations[i]['role_id'] < 20 && locations[i]['last_lat']){
            
                marker = new L.marker([locations[i]['lat'], locations[i]['long']],{icon: myIcon,rotationAngle:getBearing(locations[i]['lat'],locations[i]['long'],locations[i]['last_lat'],locations[i]['last_long'])})
                .bindPopup(locations[i]['text'])
                .addTo(map);
                
            }else{
                marker = new L.marker([locations[i]['lat'], locations[i]['long']],{icon: myIcon})
                .bindPopup(locations[i]['text'])
                .addTo(map);

            }
            
            
            markers[locations[i]['id']] = marker; 
            
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

<?php if(false){?>
<!--    Xaritaga yurgan yo'lni chizish-->
    <script type="text/javascript">
        window.onload=function(){
            var map = L.map("map");
            L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png").addTo(map);
            map.setView([48.85, 2.35], 12);
            var myPolyline = L.polyline([
                [48.86, 2.34],
                [48.85, 2.35]
            ]).addTo(map).bindPopup("popup").openPopup();
            var count = 1;
            document.getElementById("button").addEventListener("click", function (event) {
                event.preventDefault();
                myPolyline.addLatLng([
                    48.85 - (count + Math.random()) * 0.01,
                    2.35 + (count + Math.random()) * 0.01
                ]);
                count += 1;
            });
        }

    </script>


<?php }?>
