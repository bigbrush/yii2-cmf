<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\widgets;

use yii\web\AssetBundle;

/**
 * GalleryAsset
 */
class GalleryAsset extends AssetBundle
{
    public $sourcePath = '@bigbrush/cms/modules/pages/assets';
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
