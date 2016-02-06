<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\plugins\system\youtube;

use Yii;
use bigbrush\big\core\Plugin as BasePlugin;

/**
 * This plugin processes content created with [[bigbrush\cms\widgets\Editor]] by replacing youtube
 * include statements with embedded youtube videoes. It only runs when the Cms is in frontend scope.
 * 
 * An include statement looks like the following:
 * ~~~
 * {youtube xxxxx}
 * ~~~
 * Where "xxxxx" equals a youtube video ID, like so: https://www.youtube.com/watch?v=xxxxx
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
     * Processes content created with the [[Editor]] by replacing youtube
     * include statements with youtube videos.
     *
     * @param yii\base\Event $event the event being triggered.
     */
    public function process($event)
    {
        $data = Yii::$app->getResponse()->data;

        // simple performance check to determine whether further processing is required
        if (strpos($data, 'youtube') === false) {
            return $data;
        }

        $regex = '/{youtube\s+(.*?)}/i';
        preg_match_all($regex, $data, $matches, PREG_SET_ORDER);
        if($matches)
        {
            foreach($matches as $match)
            {
                $videoId = $match[1];
                $replacement = '<iframe width="560" height="315"
                                src="//www.youtube.com/embed/'.$videoId.'"
                                frameborder="0"
                                allowfullscreen></iframe>';
                $data = preg_replace("|$match[0]|", $replacement, $data);
            }
        }

        // reassign the response data
        Yii::$app->getResponse()->data = $data;
    }
}
