<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\components;

use Yii;
use bigbrush\cms\modules\pages\models\Page;

/**
 * PageFinder
 */
class PageFinder
{
    /**
     * Registers page content when big performs a search.
     * See [[bigbrush\big\core\Big::search()]] for more information about the search process.
     *
     * @param bigbrush\big\core\SearchEvent $event the event being triggered
     */
    public static function onSearch($event)
    {
        $query = Page::find()->select(['id', 'title', 'category_id', 'alias', 'intro_content', 'created_at'])->orderBy('title')->asArray();
        // adjust query if $event->value is not empty. Then a search for a specific value is being made.
        if (!empty($event->value)) {
            $query->orWhere(['like', 'title', $event->value]);
            $query->orWhere(['like', 'content', $event->value]);
        }
        $items = $query->all();
        foreach ($items as $item) {
            $event->addItem([
                'title' => $item['title'],
                'route' => Route::page($item),
                'text' => $item['intro_content'],
                'date' => $item['created_at'],
                'section' => Yii::t('cms', 'Pages'),
            ]);
        }

        // pages categories
        foreach (Yii::$app->big->categoryManager->getItems('pages') as $item) {
            // $event->value is a value being searched for. If set then only include the category when its title matches
            // the search string
            if (!empty($event->value) && strpos($item->title, $event->value) === false) {
                continue;
            }
            // match found so add it in the $event
            $event->addItem([
                'title' => str_repeat('- ', $item->depth - 1) . $item->title,
                'route' => Route::category($item),
                'text' => $item->content,
                'date' => $item->created_at,
                'section' => Yii::t('cms', 'Pages categories'),
            ]);
        }
    }
}
