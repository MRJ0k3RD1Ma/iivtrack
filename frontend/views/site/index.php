
<style>
    #map {
        height: 100vh;
        width: 100%;
        z-index: 1;
    }
    .btn{
        position: absolute;
        top: 0;
        right: 0;
        z-index: 999;
        padding:10px;
        width: 100px;
        height: 30px;
        background: #0a53be;
    }
</style>
<div id="map"></div>

<button class="btn">
    Click
</button>

<script>
    // init map
    var map = L.map('map').setView([41.552269, 60.631571], 12);
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });
    osm.addTo(map);

    // 1 dona marker qo'shish
    /*var myIcon = L.icon({
        iconUrl: '/icon/marker-red.png',
        iconSize: [38, 95],
        iconAnchor: [22, 94],
        popupAnchor: [-3, -76],
        shadowSize: [68, 95],
        shadowAnchor: [22, 94]
    });
*/
    var singleMarker = L.marker([41.552269, 60.631571]);
    singleMarker.addTo(map);


</script>
