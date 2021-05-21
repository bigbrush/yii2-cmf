<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

echo "<?php\n";
?>
/**
 * This file is generated automatically with the install console command.
 *
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

$config = [
    'id' => 'Big',
    'basePath' => dirname(dirname(__DIR__)),
    'language' => '<?= $language ?>',
    'bootstrap' => [
        'big',
        'cms',
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'big' => ['class' => 'bigbrush\cms\modules\big\frontend\Module'],
        'pages' => ['class' => 'bigbrush\cms\modules\pages\frontend\Module'],
    ],
    'components' => [
        'cms' => [
            'class' => 'bigbrush\cms\Cms',
            'activatePlugins' => true,
        ],
        'big' => [
            'class' => 'bigbrush\big\core\Big',
            'setApplicationDefaultRoute' => true,
            'enableDynamicContent' => true,
            'managers' => [
                'urlManager' => [
                    'enableUrlRules' => true,
                ],
                'menuManager' => [
                    'autoload' => true,
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => '<?= $cookieValidationKey ?>',
            'csrfParam' => '_frontendCSRF',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '/',
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/parallax',
                'baseUrl' => '@web/themes/parallax',
            ],
        ],
        'user' => [
            'identityClass' => 'bigbrush\cms\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_frontendUser',
            ],
        ],
        'session' => [
            'name' => 'FRONTENDSESSIONID',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'errorHandler' => [
            'errorAction' => 'big/cms/error',
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
];

return $config;
