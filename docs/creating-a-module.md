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

## Module.php
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

## ProductController.php
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
      Yii::$app->big->setTemplate($model->template_id); // <-- we'll get to this part later
      return $this->render('show', ['model' => $product]);
    }
}
~~~

Just a basic controller loading a model from the database and displaying a page with it. Take note that we are using the `$slug` to load a page. This is relevant for creating the url rule later. We'll also cover the `setTemplate()` part in a bit.

## Product.php
The product model is a regular [Yii 2 ActiveRecord](http://www.yiiframework.com/doc-2.0/guide-db-active-record.html). Please read the guide to create this part. But note that because we are using the slug to load a page in the controller this field should have the [unique validator](http://www.yiiframework.com/doc-2.0/yii-validators-uniquevalidator.html) attached as a validation rule.

## The View
Same goes for the view. It has no special content different from a Yii 2 view.

## UrlRule.php
Now it gets a little more exiting, because the url rule gives you full control over urls in your module and it is automatically detected and activated by Big Cms. An url rule can extend any class but it must implement the `yii\web\UrlRuleInterface`. Here's is an example:

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

If the route matches the structure of the urls of our module we return a custom url which uses our `slug`. Otherwise false is returned which tells Yii that this url rule can not be used for creating the url.

Next is parsing of urls. This is done by Yii when the user tries to load a page (controller). Here's an example:
~~~php
public function parseRequest($manager, $request)
{
    $pathInfo = $request->getPathInfo();
    $suffix = Yii::$app->getUrlManager()->suffix;
    if ($suffix !== null) {
        $pathInfo = substr($pathInfo, 0, -strlen($suffix));
    }
    
    // check that the requested path (url) starts with 'cart/'
    if (strpos($pathInfo, 'cart/') === 0) {
        $segments = explode('/', $pathInfo);
        return ['cart/product/show', ['alias' => $segments[1]]];
    }
    return false;
}
~~~

TO BE FINISHED...
