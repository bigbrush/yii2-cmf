<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\widgets;

use ReflectionClass;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Gallery
 */
class Gallery extends Widget
{
    const TYPE_DISABLED = 'disabled';
    const TYPE_PLAIN = 'plain';
    const TYPE_FADE = 'fade';

    /**
     * @var array $images list of images to render in the gallery.
     * Each array element is an array with the following structure:
     * [
     *    'image' => 'URL TO THE IMAGE',
     *    'alt' => 'OPTIONAL ALT ATTRIBUTE OF THE IMAGE',
     *    'link' => 'OPTIONAL LINK - IMAGE WILL BE WRAPPED IN AN <a> TAG',
     *    'imgClass' => 'OPTIONAL CLASS TO ADD TO THE <img> tag',
     *    'linkClass' => 'OPTIONAL CLASS TO ADD TO THE <a> tag',
     * ]
     * 
     * Mandatory: image
     * Optional: imgClass, linkClass, alt, link
     */
    public $images = [];
    /**
     * @var array $options options array for the gallery.
     * @see getDefaultOptions()
     */
    public $options = [];


    /**
     * Returns a list of different types of UI for the gallery.
     * The different types are defined by the class constants. 
     */
    public static function getGalleryTypes()
    {
        $reflection = new ReflectionClass(new self());
        $options = [];
        foreach ($reflection->getConstants() as $name => $value) {
            $options[$value] = Yii::t('cms', ucfirst($value));
        }
        return $options;
    }

    /**
     * Returns an array with default configuration for the gallery widget.
     *
     * @return array a configuration array.
     */
    public static function getDefaultOptions()
    {
        return [
            'type' => static::TYPE_FADE,
            'enableJs' => 1,
            'enableCss' => 1,
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->options = ArrayHelper::merge(static::getDefaultOptions(), $this->options);
    }

    /**
     * Renders a gallery.
     */
    public function run()
    {
        if (empty($this->images)) {
            return;
        }

        $view = $this->getView();
        $options = $this->options;
        $type = $options['type'];
        $viewFile = 'gallery_' . $type;
        $bundle = GalleryAsset::register($view);

        if ($type === static::TYPE_DISABLED) {
            return;
        } elseif ($type !== static::TYPE_PLAIN) {
            if ($options['enableJs']) {
                $bundle->js[] = 'js/' . $viewFile . '.js';
                $view->registerJS('
                    Gallery.start();
                ');
            }

            if ($options['enableCss']) {
                $bundle->css[] = 'css/' . $viewFile . '.css';
            }
        }

        return $this->render($viewFile, [
            'images' => $this->images,
        ]);
    }
}
