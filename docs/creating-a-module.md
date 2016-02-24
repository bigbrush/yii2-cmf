# Creating a module

Creating a module in Big Cms is exactly the same as creating a regular Yii 2 module. You can read up
on [creating a Yii 2 module here](http://www.yiiframework.com/doc-2.0/guide-structure-modules.html).

But let's go through an example to show how to integrate a module with Big Cms. We exemplify it here by creating a
small part of a shopping cart - specifically the frontend part of a product page.

First off, the file structure:

```
cart
  |-- controllers
        ProductController.php
  |-- models
        Product.php
  |-- views
        |-- product
              show.php
  Module.php
  UrlRule.php
```

As illustrated above we have a folder name "cart" which contains 2 files (Module.php and UrlRule.php) and 3
folders (controllers, models and views).

So let's start creating our shopping cart.
We will use the namespace: `bigbrush\cart` for this tutorial. First off is the file `Module.php`


## Module.php <span id="module"></span>

~~~php
namespace bigbrush\cart;

/**
 * Module
 */
class Module extends \yii\base\Module
{
}
~~~

As you can see nothing special is going on here. Next is the product controller.


## ProductController.php <span id="productcontroller"></span>

~~~php
namespace bigbrush\cart\controllers;

use Yii;
use yii\web\Controller;
use bigbrush\cart\models\Product;

/**
 * ProductController
 */
class ProductController extends Controller
{
    /**
     * Shows a page of a single product.
     *
     * @param string $slug a slug of a Product model.
     */
    public function actionShow($slug)
    {
      $model = Product::findOne(['slug' => $slug]);
      return $this->render('show', ['model' => $product]);
    }
}
~~~

Just a basic controller loading a model from the database and displaying a page with it. Take note that we are using the
`$slug` to load a page. This is relevant for creating the url rule later.

## Product.php  <span id="product"></span>

The product model is a regular [Yii 2 ActiveRecord](http://www.yiiframework.com/doc-2.0/guide-db-active-record.html). Please read the guide to create this part. But note that because we are using the slug to load a page in the controller this field should have the [unique validator](http://www.yiiframework.com/doc-2.0/yii-validators-uniquevalidator.html) attached as a validation rule.


## The View <span id="the-view"></span>

Same goes for the view. It has no special content different from a Yii 2 view.

**Until now there's nothing different from a regular Yii2 module**

From here we will start to integrate the module with Big Cms.


## UrlRule.php <span id="urlrule"></span>

Url rules gives you full control over urls in your module and it is automatically detected and activated by Big Cms. An url rule can extend any class but it must implement the `yii\web\UrlRuleInterface` interface.

Note that the file must be named `UrlRule.php` and be placed in the root directory of the module for Big Cms to recognize
it. In the example below is the same directory as `Module.php`.

Here's an example:

~~~php
use yii\base\Object;
use yii\web\UrlRuleInterface;

class UrlRule extends Object implements UrlRuleInterface
{
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
    }
}
~~~

The `createUrl($manager, $route, $params)` method is called when you create urls in Yii. For instance when calling `Html::a('A link', ['/cart/product/show', 'slug' => 'page-one'])` the `$route` parameter is `'cart/product/show'` and `$params` is an array like `['slug' => 'page-one']`. 

This enables us to determine whether this url rule should react to the route. For instance:

~~~php
public function createUrl($manager, $route, $params)
{
    if ($route === 'cart/product/show') {
        // will create a the url 'cart/page-one'
        return 'cart/' . $params['slug'];
    }
    return false;
}
~~~

If the route has a structure that matches the urls of our module we return a custom url which uses our `slug`. Otherwise false is returned which tells Big Cms that this url rule can not be used for creating the url. Big Cms will then try the next url rule.

Note that url rules are only called when no menu item points to the desired route. This applies to `createUrl()` as
well as `parseUrl()`.

Also note that Big Cms implements these dynamic url rules as a rule it self. Big Cms uses the default Yii2 UrlManager
and assigns itself as an url rule to provide this feature (this can be disabled). By doing it this way you can use your
own UrlManager if needed.

Next is url parsing. This is done when the user tries to load a page (controller). Here's an example:

~~~php
public function parseRequest($manager, $request)
{
    // the path (url) currently requested
    $pathInfo = $request->getPathInfo();

    // handle suffix - Big Cms uses a "/" as default
    $suffix = Yii::$app->getUrlManager()->suffix;
    if ($suffix !== null) {
        $pathInfo = substr($pathInfo, 0, -strlen($suffix));
    }
    
    // check that the requested path (url) starts with 'cart/'
    if (strpos($pathInfo, 'cart/') === 0) {
        // $segments = ['cart', 'page-one'];
        $segments = explode('/', $pathInfo);

        return ['cart/product/show', ['slug' => $segments[1]]];
    }
    return false;
}
~~~

The url we created in `createUrl)()` was `cart/page-one`. Based on this we can determine whether the url relates to this module.
If it does it starts with `cart/`. This is checked by the statement `strpos($pathInfo, 'cart/') === 0`. 

For more information on `parseUrl()` check the [Yii documentation on rule classes](http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html#creating-rules).

Also check out the `Pages` module of Big Cms. It has a more [complex UrlRule implemented](https://github.com/bigbrush/yii2-cmf/blob/master/src/modules/pages/frontend/UrlRule.php#L51).


## Implementing Big Cms templates <span id="implementing-templates"></span>

For Big Cms to render a specific template for a product page we need to tell it what template to use.

This is done in `ProductController.php` like so:

~~~php
public function actionShow($slug)
{
  $model = Product::findOne(['slug' => $slug]);
  Yii::$app->big->setTemplate($model->template_id); // <-- this is added
  return $this->render('show', ['model' => $product]);
}
~~~

As the example shows it's easy to set a specific template. For instance:

~~~php
// set a template ID
Yii::$app->big->setTemplate(TEMPLATE_ID);

// set a template object
$template = Yii::$app->big->templateManager->getItem(TEMPLATE_ID);
Yii::$app->big->setTemplate($template);
~~~

How you store information about which template to use is up to you. The `Pages` modules of Big Cms has a database column
named `template_id` which is used just like in the example above.


## Hooking into Big Cms search  <span id="bigcms-search"></span>

Various places in Big Cms there's a search system running in the background. For instance when using the editor and inserting
a link. When the search icon is clicked a modal pops up with seach results from different sections of Big Cms. Modules can hook
into this search process in various ways.

Here's a couple of examples where the application configuration is updated:

~~~php
return [
     'id' => 'APPLICATION ID',
     ...
     'on big.search' => function($event){
         $event->addItem([
             'title' => 'The title',
             'route' => ['app/page/show', 'id' => 3],
             'text' => 'Text or description of the item',
             'date' => 'An important date to the item (could be creation date)'
             'section' => 'The section of the item',
         ]);
     },
     'components' => [...],
 ];
 ~~~

 Another way to plug into the searches in Big Cms is to use objects. To do so add the following to the application
 configuration file:

 ~~~php
 return [
     'id' => 'APPLICATION ID',
     ...
     'components' => [
         'big' => [
             'searchHandlers' => [
                 ['app\components\SearchHandler', 'onSearch'],
             ],
         ],
         ...
     ],
 ];
 ~~~

With the above change the object could look like this:

~~~php
namespace app\components;

/**
 * SearchHandler
 */
class SearchHandler
{
	/**
     * @param \bigbrush\big\core\SearchEvent $event the event being triggered
     */
    public static function onSearch($event)
    {
        $event->addItem([
            'title' => 'The title',
            'route' => ['app/page/show', 'id' => 3],
            'text' => 'Text or description of the item',
            'date' => 'An important date to the item (could be creation date)'
            'section' => 'My Section',
        ]);
	}
}
~~~

This makes the section available from a drop down list when Big Cms performs a search. You can add multiple
items to the event which will be shown in a [Yii2 GridView](http://www.yiiframework.com/doc-2.0/yii-grid-gridview.html)
under the value of `section`.

Note that all shown array keys `title`, `route`, `text`, `date` and `section` must be provided to `$event->addItem([...])`.
