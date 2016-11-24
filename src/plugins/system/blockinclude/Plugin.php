<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\plugins\system\blockinclude;

use Yii;
use yii\web\Response;
use bigbrush\big\core\Plugin as BasePlugin;
use bigbrush\big\models\Block;

/**
 * This plugin processes content created with [[bigbrush\cms\widgets\Editor]] by replacing block include statements with block content.
 * It only runs when the Cms is in frontend scope.
 * 
 * An include statement looks like the following:
 * 
 * ~~~html
 * {block Contact}
 * ~~~
 * 
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
            $app->response->on(Response::EVENT_AFTER_PREPARE, [$this, 'process']);
        }
    }

    /**
     * Processes content created with the [[Editor]] by replacing block
     * include statements with block content.
     *
     * Note that this method runs after Big has handled dynamic content.
     *
     * @param yii\base\Event $event the event being triggered.
     */
    public function process($event)
    {
        $data = Yii::$app->getResponse()->content;

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
                if (isset($models[$blockTitle])) {
                    $block = $manager->createBlockFromData($models[$blockTitle]);
                    $content = $block->run();
                } else {
                    $content = '';
                }
                $data = preg_replace("|$statement|", addcslashes($content, '\\$'), $data, 1);
            }
        }

        // this plugin needs to parse the urls because Big only handles the Response::FORMAT_HTML format while this plugin supports
        // all response formats.
        // Further more Big runs before this plugin is called
        // Urls are parsed so blocks with links and images are displayed properly
        $parser = Yii::$app->big->getParser();
        $parser->data = $data;
        $parser->parseUrls();
        $data = $parser->data;
        $parser->clear();

        // reassign the response data
        Yii::$app->getResponse()->content = $data;
    }
}
