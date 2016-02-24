# The plugin system in Big Cms

Big Cms has a simple but very flexible plugin system which builds on Yii2 events. The plugin system is based
on the [PluginManager](http://bigbrush-agency.com/api/big/bigbrush-big-core-pluginmanager.html) which separates
plugins into `groups`.

A `group` is a folder containing plugins with a special purpose. If for instance we imagine to have a shopping cart
running in Big Cms we could use plugins as a way to dynamically implement payment methods, shipment methods and VAT.

The aim of the plugin system is to have the PluginManager ask a group of plugins to react to certain events. This
is opposite of Yii2 events where the event has to tell when to be notified.


## Using the plugin system

In our shopping cart example the folder structure for plugins could look like the following:

```
plugins
  |-- payment
        |-- paypal
              Plugin.php
        |-- bitcoin
              Plugin.php
        |-- creditcard
              Plugin.php
  |-- shipment
        |-- shipper_1
              Plugin.php
        |-- shipper_2
              Plugin.php
  |-- vat
        |-- vatmodifier
              Plugin.php
```

The groups in this example are `payment`, `shipment` and `vat`.

To trigger a group of plugins do the following:

~~~php
Yii::$app->big->pluginManager
	->setGroup('payment')
	->trigger('payment.validate');
~~~

This will trigger a `payment.validate` event to all plugins in the `payment` group.


## Developing a plugin

Plugins doesn't need to extend any specific class. But it does get some benefits when it extends `bigbrush\big\core\Plugin`. This
object supports relative view names which means you can call `$this->render([...])` in a plugin. Another options is to implement
the `bigbrush\big\core\PluginInterface` interface. By doing so you get the `register($manager)` method which let's the plugin
register itself as event handler for certain events before they are being triggered by the `PluginManager`.

An example plugin could look like the following:

~~~php
namespace app\plugins\payment\creditcard;

use bigbrush\big\core\Plugin as BasePlugin;

/**
 * Plugin validates a payment when the payment type is 'Credit card'.
 */
class Plugin extends BasePlugin
{
	public $paymentType = 'creditcard';


    /**
     * Registers event handlers used in this plugin.
     *
     * @param PluginManager $manager the plugin manager.
     */
    public function register($manager)
    {
        $manager->on('payment.validate', 'onPaymentValidate'); 
    }

    /**
     * Validates a payment.
     *
     * @param PaymentEvent $event the payment event being triggered.
     */
    function onPaymentValidate($event)
    {
    	if ($event->paymentType === $this->paymentType) {
    		$amount = $event->amount;
    		$bank = new Bank();
    		$event->paymentValid = $bank->haveEnoughMoney($amount);
    	}
    }
}
~~~

The example above is illustrative. The important things to note are:

  1. The `register($manager)` method is provided because the class extends from `bigbrush-agency\big\core\Plugin` which
     implements the `bigbrush\big\core\PluginInterface` interface.
  2. The event parameter for `onPaymentValidate($event)` is a custom made event.

To create custom made events have a look at the [Yii2 documentation on events](http://www.yiiframework.com/doc-2.0/guide-concept-events.html).

Triggering the event is just like a regular Yii2 event.

For instance:

~~~php
$event = new PaymentEvent();
Yii::$app->big->pluginManager->setGroup('payment')->trigger('payment.validate', $event);
if ($event->paymentValid) {
	echo 'Thanks for  your order.';
} else {
	echo 'You are out of cash, sorry. Have a snickers.';
}
~~~


## Configuring the PluginManager


## Plugins used in Big Cms
