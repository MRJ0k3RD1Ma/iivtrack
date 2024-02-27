<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/map/';
    public $css = [
        'leaflet.css',
        'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css',
        'https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.2/leaflet.draw.css',
    ];
    public $js = [
        'leaflet.js',
        'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js',
        'https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.2/leaflet.draw-src.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
