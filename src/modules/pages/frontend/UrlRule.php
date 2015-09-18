<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\frontend;

use Yii;
use yii\base\Object;
use yii\web\UrlRuleInterface;
use bigbrush\cms\modules\pages\components\Route;

/**
 * UrlRule creates and parses urls for the pages module.
 *
 * This url rule takes the [[yii\web\UrlManager::suffix]] into consideration when parsing a request. This is because the page slug
 * is used when creating urls. Whether an url rule needs to take the suffix into consideration depends on how the url is constructed.
 * If for instance the url was created like (but it is not):
 * ~~~
 * www.yoursite.com/page/33:the-page-slug.html
 * ~~~
 * the identifier would be the page id ("33"). This could be extracted without taking the suffix into consideration. Make
 * this distinction when creating url rules.
 */
class UrlRule extends Object implements UrlRuleInterface
{
    /**
     * @var string defines the id of this url rule. Rules needs
     * an id to identify whether it should react when parsing. Different
     * rules could use the same url pattern which would make it difficult
     * to separate them.
     * The id is only used when no menu points to this module.
     */
    private $_id = 'page';
    /**
     *
     */
    private $_categoryId = 'pcategory';


    /**
     * Creates a URL according to the given route and parameters.
     * 
     * @param UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'pages/page/show') {
            $category = Yii::$app->big->categoryManager->getItem($params['catid']);
            // a category must be selected when creating a page. The category could have been deleted though
            $menu = false;
            if ($category) {
                $route = Route::raw($category, Route::TYPE_CATEGORY);
                $menuManager = Yii::$app->big->menuManager;
                $menu = $menuManager->search('route', $route);
            }

            // check if a menu has been created for the page category
            // if so prepend the menu query to the created url
            // if not prepend the id of this url rule
            if ($menu) {
                $prepend = $menu->getQuery();
            } else {
                $prepend = $this->_id;
            }
            return $prepend . '/' . $params['alias'];
        } elseif ($route === 'pages/category/pages') {
            return $this->_categoryId . '/' . $params['catid'] . '/' . $params['alias'];
        }
        return false;
    }

    /**
     * Parses the given request and returns the corresponding route and parameters.
     * 
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|boolean the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $suffix = Yii::$app->getUrlManager()->suffix;
        if ($suffix !== null) {
            $pathInfo = substr($pathInfo, 0, -strlen($suffix));
        }
        // this url rule will always have minimum 2 url path segments (separated by a "/")
        if (strpos($pathInfo, '/') !== false) {
            // split the current path into segments
            $segments = explode('/', $pathInfo);
            $identifier = false;
            
            // if the first segment matches the id of this url rule we have a match.
            // in this case we also know that no menu points directly to the requested page (otherwise this url rule would never get activated)
            // use the second segment
            if ($segments[0] === $this->_id) {
                return ['pages/page/show', ['alias' => $segments[1]]];
            } elseif ($segments[0] === $this->_categoryId) {
                $identifier = $segments[1];
                return ['pages/category/pages', ['catid' => $segments[1]]];
            } else {
                // last segment could be our identifier, we need the segment right before that
                // to check if it matches a menu pointing to a pages category
                $alias = $segments[count($segments) - 2];
                $menu = Yii::$app->big->menuManager->search('alias', $alias);
                // the menu points to a page category
                if ($menu && strpos($menu->route, 'pages/category/pages') === 0) {
                    return ['pages/page/show', ['alias' => array_pop($segments)]];
                }
            }
        }
        return false;
    }
}
