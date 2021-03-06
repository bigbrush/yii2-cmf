<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\themes\adminlte;

use yii\web\AssetBundle;

/**
 * AdminLteAsset
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $css = [
        '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
        '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/skins/skin-blue.min.css',
    ];
    public $js = [
        'js/adminlte.min.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
