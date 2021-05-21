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
    'defaultRoute' => 'big/cms/index',
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
        'big' => ['class' => 'bigbrush\cms\modules\big\backend\Module'],
        'pages' => ['class' => 'bigbrush\cms\modules\pages\backend\Module'],
    ],
    'components' => [
        'cms' => [
            'class' => 'bigbrush\cms\Cms',
            'scope' => \bigbrush\cms\Cms::SCOPE_BACKEND,
        ],
        'big' => [
            'class' => 'bigbrush\big\core\Big',
            'frontendTheme' => '@app/themes/parallax',
            'searchHandlers' => [
                ['bigbrush\cms\modules\pages\components\PageFinder', 'onSearch'],
            ],
        ],
        'toolbar' => [
            'class' => 'bigbrush\cms\components\Toolbar',
        ],
        'request' => [
            'cookieValidationKey' => '<?= $cookieValidationKey ?>',
            'csrfParam' => '_backendCSRF',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'view' => [
            'theme' => [
                'basePath' => '@bigbrush/cms/themes/adminlte',
                'baseUrl' => '@bigbrush/cms/themes/adminlte',
            ],
        ],
        'user' => [
            'identityClass' => 'bigbrush\cms\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_backendUser',
            ],
            'loginUrl' => [''],
        ],
        'session' => [
            'name' => 'BACKENDSESSIONID',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
];

return $config;
