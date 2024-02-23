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
    ];
    public $js = [
        'leaflet.js',
        'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
