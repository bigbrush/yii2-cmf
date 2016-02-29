# The config system

The config system in Big Cms is based on the [ConfigManager](http://bigbrush-agency.com/api/big/bigbrush-big-core-configmanager.html).

It makes it easy to implement a key => value config system in modules. All you need to do is visit an url with
the following structure:

~~~
www.YOUR_SITE.com/admin/big/config/show?section=INSERT_SECTION
~~~

Replace `INSERT_SECTION` with the name of your module. This can be seen in action in the backend of Big Cms. With the
main menu navigate to "System->Settings" and you'll see an example of the default UI in the config system.


## Configuring the ConfigManager

Like all other managers the `ConfigManager` can be configured in several ways. Here's a couple of examples:

Through application configuration:

~~~php
'components' => [
    'big' => [
        'managers' => [
              'configManager' => [
                  'rules' => [
                      'cart' =>[
                          'lockedFields' => ['category.products_per_page', 'product.show_prices'],
                          'changeLockedFields' => true,
                      ],
                      'cms' =>[
                          'lockedFields' => ['appName', 'systemEmail'],
                          'changeLockedFields' => true,
                      ],
                  ],
              ],
        ],
    ],
]
~~~

With code (this is how Big Cms uses the ConfigManager):

~~~php
Yii::$app->big->configManager->configureSection('cms', [
   'lockedFields' => ['appName', 'systemEmail'],
   'changeLockedFields' => true,
]);
~~~

The above configuration locks the fields `appName` and `systemEmail` of the `cms` section. Locking
fields makes the user unable to delete them. These fields are used by the backend of Big Cms and
therefore we don't want them to be deleted.

Locking config fields are done thorugh a config manager rule which we'll cover next.


## Config rules

As the previous url suggests the `ConfigManager` is divided into sections. Each section has a config rule attached which 
allows you to plug into the save and delete process of the `ConfigManager`. With the rule that comes with Big Cms you can
lock certain fields and optionally make the user unable to change them.


## Creating a config rule

You can create your own config rules. A config rule can extend any class but it must implement the
[ConfigManagerRuleInterface](http://bigbrush-agency.com/api/big/bigbrush-big-core-configmanagerruleinterface.html) interface.

A custom config rule which only accepts numeric config values, could look like the following:

~~~php
namespace app\modules\mymodule\rules;

use yii\base\Object;
use bigbrush\big\core\ConfigManagerRuleInterface;

/**
 * NumericRule ensures all config values are numeric.
 */
class NumericRule extends Object implements ConfigManagerRuleInterface
{
    /**
     * Registers validation rules used in this config rule. These rules is used when validating
     * in [[onBeforeSave()]] and [[onBeforeSave()]].
     *
     * @param array $rules a key=>value array of rules for this config rule.
     */
    public function setRules($rules)
    {
        // this method must be defined
    }

    /**
     * Validates that the specified model can be updated.
     *
     * @param yii\db\ActiveRecord $model a model to validate.
     * @return bool true if model can be updated, false if not.
     */
    public function onBeforeSave($model)
    {
        if (!is_numeric($model->value)) {
            $this->message = 'A config entry must have a numeric value';
            return false;
        } else {
            return true;
        }
    }

    /**
     * Validates that the specified model can be deleted.
     *
     * @param yii\db\ActiveRecord $model a model to validate.
     * @return bool true if model can be deleted, false if not.
     */
    public function onBeforeDelete($model)
    {
        return true;
    }

    /**
     * Returns the most message of this rule.
     *
     * @return string a message.
     */
    public function getMessage()
    {
        return $this->message;
    }
}
~~~

The above config rule can be used like so:

~~~php
Yii::$app->big->configManager->configureSection('section', [
    'class' => 'app\modules\mymodule\rules\NumericRule',
]);

// or use an object

use app\modules\mymodule\rules\NumericRule;
$myRule = new NumericRule();
Yii::$app->big->configManager->configureSection('mymodule', $myRule);
~~~

The `ConfigManager` will then use this custom rule each time config entries are created/updated/deleted
in the `mymodule` section. 


## Using the ConfigManager

You use the `ConfigManager` like so:

~~~php
$manager = Yii::$app->big->configManager;
$config = $manager->getItems('cms');

$systemEmail = $config->get('systemEmail'); // will return null if "systemEmail" is not set.
// or
$systemEmail = $config->systemEmail; // will throw exception if "systemEmail" is not set.

$isNull = $config->get('is_not_set', null);

// setting properties
$config->set('name', 'value');
// or
$manager->set('name', 'value', 'section');
// or
if ($config->set('name', 'value')) {
    echo 'value saved';
} else {
    echo 'value NOT saved';
}

// the manager has a shorthand method for retrieving config values:
$manager->get('section.name', 'defaultValue');
// for instance
$manager->get('cms.systemEmail', 'noreply@noreply.com');
~~~
