<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/default/';
    public $css = [
        'assets/css/bootstrap.min.css',
        'assets/css/icons.min.css',
        'assets/libs/select2/css/select2.min.css',
        'assets/libs/sweetalert2/sweetalert2.min.css',
        'assets/css/app.min.css',
        'assets/css/site.css',
//        '../map/leaflet.css',
    ];
    public $js = [
        'assets/libs/bootstrap/js/bootstrap.bundle.min.js',
        'assets/libs/metismenu/metisMenu.min.js',
        'assets/libs/simplebar/simplebar.min.js',
        'assets/libs/node-waves/waves.min.js',
        'assets/libs/feather-icons/feather.min.js',
        'assets/libs/select2/js/select2.min.js',
        'assets/libs/apexcharts/apexcharts.min.js',
        'assets/libs/sweetalert2/sweetalert2.min.js',
        "assets/libs/imask/imask.min.js",
        'assets/js/app.js',
        'assets/js/pages/ecommerce-select2.init.js',
//        '../map/leaflet.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
