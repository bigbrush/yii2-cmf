<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\plugins\system\blockinclude;

use Yii;
use bigbrush\big\core\Plugin as BasePlugin;
use bigbrush\big\models\Block;

/**
 * This plugin processes content created with [[bigbrush\cms\widgets\Editor]] by replacing block include statements with block content.
 * It only runs when the Cms is in frontend scope.
 * 
 * An include statement looks like the following:
 * ~~~
 * {block Contact}
 * ~~~
 * The first part (block) is required and the second part (Contact) is the title of a block.
 */
class Plugin extends BasePlugin
{
    /**
     * Registers event handlers used in this plugin.
     *
     * @param PluginManager $manager the plugin manager.
     */
    public function register($manager)
    {
        $app = Yii::$app;
        if ($app->cms->isFrontend) {
            $app->on($app::EVENT_AFTER_REQUEST, [$this, 'process']);
        }
    }

    /**
     * Processes content created with the [[Editor]] by replacing block
     * include statements with block content.
     *
     * @param yii\base\Event $event the event being triggered.
     */
    public function process($event)
    {
        $data = Yii::$app->getResponse()->data;

        // simple performance check to determine whether further processing is required
        if (strpos($data, 'block') === false) {
            return $data;
        }

        // Find all instances of block and put in $matches
        // $matches[0] is full pattern match, $matches[1] is the block title
        $regex = '/{block\s(.*?)}/i';
        preg_match_all($regex, $data, $matches, PREG_SET_ORDER);

        // no matches, do nothing
        if ($matches) {
            $manager = Yii::$app->big->blockManager;
            $titles = [];

            // collect all block titles so blocks are loaded in one query
            foreach ($matches as $match) {
                $titles[] = $match[1];
            }
            $models = $manager->getModel()
                ->find()
                ->where(['title' => $titles, 'state' => Block::STATE_ACTIVE])
                ->asArray()
                ->indexBy('title')
                ->all();

            // replace include statements with block content
            foreach ($matches as $match) {
                $statement = $match[0];
                $blockTitle = $match[1];
                if (array_key_exists($blockTitle, $models)) {
                    $block = $manager->createBlockFromData($models[$blockTitle]);
                    $content = $block->run();
                } else {
                    $content = '';
                }
                $data = preg_replace("|$statement|", addcslashes($content, '\\$'), $data, 1);
            }
        }

        // reassign the response data
        Yii::$app->getResponse()->data = $data;
    }
}
