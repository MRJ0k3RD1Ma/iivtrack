<?php
$this->title = "Hodimning borgan joylari";
?>


<div class="row">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <select name="user" id="user" class="form-control select2">
                    <?php foreach (\common\models\User::find()->all() as $item):?>
                        <option value="<?= $item->id?>" <?= $item->id == $model->id ? 'selected' : '' ?>><?= $item->name ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="date" name="date" class="form-control" id="date" value="<?= $date?>">
            </div>
        </div>
    </div>


    <div class="col-md-10 map">
        <div id="map"></div>
    </div>
    <div class="col-md-2">
            <h4>Holat o'zgarishlari</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Vaqti</td>
                        <td>Holat</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $his = \common\models\UserActiveHistory::find()->where(['user_id'=>$model->id])->andFilterWhere(['like','active',$date])->orderBy(['active'=>SORT_ASC])->all();
                        foreach ($his as $key=>$item):?>
                        <tr>
                            <td><?= $key+1?></td>
                            <td><?= $item->active ?></td>
                            <td><?= Yii::$app->params['active_type'][$item->type]?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
$url = Yii::$app->urlManager->createUrl(['/cp/default/view']);
$this->registerJs("
    var map = L.map('map').setView([41.552269, 60.631571], 12);
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        preferCanvas: true,
        attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
    });
    osm.addTo(map);
    
    var start = {$start};
    if(start){
    
         icn = '/icon/marker-red.png';
          var myIcon = L.icon({
            iconUrl: icn,
            iconSize: [26, 36],
            iconAnchor: [13, 36],
            popupAnchor: [-3, -30],
        });
        marker = new L.marker([start[0], start[1]],{icon: myIcon})
        .bindPopup('{$model->name} <br> Harakat boshlangan joy')
        .addTo(map);
      }
      var end = {$end};
      if(end){
         icn = '/icon/marker-blue.png';
          var myIcon = L.icon({
            iconUrl: icn,
            iconSize: [26, 36],
            iconAnchor: [13, 36],
            popupAnchor: [-3, -30],
        });
        marker = new L.marker([end[0], end[1]],{icon: myIcon})
        .bindPopup('{$model->name} <br>Harakat tugallangan joy')
        .addTo(map);
      }
      
      
    var locations = {$locations};
    if(locations){
      var polyline = L.polyline(locations, {color: 'red'}).addTo(map);
      map.fitBounds(polyline.getBounds());
    
    }
    
    
    function change(){
        location.href = '{$url}?id='+$('#user').val()+'&date='+$('#date').val();
    }
    
    $('#user').change(function(){
        change();
    });
    $('#date').change(function(){
        change();
    });
    
    
")
?>