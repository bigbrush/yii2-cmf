# Themes

Big Cms adds dynamic functionality to [Yii2 themes](http://www.yiiframework.com/doc-2.0/guide-output-theming.html) by
providing `include statements`. In Big Cms a theme is the foundation for any application (for backend and frontend).


## Include statements <span id="include-statements"></span>

Include statements should be added to a layout file of a theme. Each include statement is a placeholder for a block position. A block
position can contain multiple blocks.

To add a block position to a theme add the following:

```
<big:block position="sidebar" />
```

This adds the "sidebar" position to the theme. Blocks assigned to this position will be rendered by Big Cms right before
Yii renders the page.


## Assigning blocks to positions <span id="templates-assigning-blocks"></span>

In the backend of Big Cms navigate to "Templates" using the main menu. Here you can manage and create templates. It enables you to
select a specific layout for each template and assign blocks to positions by drag and drop.


## Using a template <span id="using-a-template"></span>

In the backend of Big Cms navigate to "Content->Pages" using the main menu. Select or create a page and select your template from
the "Templates" drop down list. This page will now be rendered with the template your select. Any page can have their own customized
template.


## Determining if a position is active <span id="is-position-active"></span>

You can determine whether a position is active like so (example uses Bootstrap classes to illustrate):

~~~php
<?php if (Yii::$app->big->isPositionActive('sidebar')) : ?>
<div id="maincontent" class="col-md-9">
    <?= $content ?>
</div>
<div id="sidebar" class="col-md-3">
    <big:block position="sidebar" />
</div>
<?php else : ?>
<div id="maincontent" class="col-md-12">
    <?= $content ?>
</div>
<?php endif; ?>
~~~

Another way to handle this specific example is to create
[nested layouts](http://www.yiiframework.com/doc-2.0/guide-structure-views.html#nested-layouts) as described
in the Yii2 tutorial.

## Theme specific block positions

Big Cms looks for the file `positions.php` in the active theme to determine available theme positions. The
file must return an array where the keys are position IDs and the values are position names.

For instance:

~~~php
return [
    'POSITION ID' => 'POSITION NAME',
    'gallery' => 'Gallery',
    'mainmenu' => 'Main menu',
    ...
];
~~~


## Changing theme
There are [4 config files](introduction.md#configuration) in Big Cms that controls the application.

When changing the frontend theme the files `web.php` and `admin.php` needs to be updated.

Update `web.php` like so:

~~~php
'view' => [
    'theme' => [
        'basePath' => '@app/themes/web', // <-- this line must match in admin.php
        'baseUrl' => '@web/themes/web',
    ],
],
~~~

Update the `frontendTheme` property in `admin.php` to the `basePath` property from `web.php`:

~~~php
'big' => [
    'class' => 'bigbrush\big\core\Big',
    'frontendTheme' => '@app/themes/web', // <-- change this line
    'searchHandlers' => [
        ['bigbrush\cms\modules\pages\components\PageFinder', 'onSearch'],
    ],
],
~~~

## Overriding Big Cms views

As described in the Yii tutorial on [themes](http://www.yiiframework.com/doc-2.0/guide-output-theming.html)
the property `pathMap` of a [Yii2 theme](http://www.yiiframework.com/doc-2.0/yii-base-theme.html) can be
used to replace view files.

If you want to override view files of the Pages module with your own, add the following to the
application configuration:

~~~php
...
'view' => [
    'theme' => [
        'basePath' => '@app/themes/YOUR_THEME',
        'baseUrl' => '@web/themes/YOUR_THEME',
        'pathMap' => [
        	// override layout
            '@app/views' => '@app/themes/YOUR_THEME/views',

            // override views of pages module
            '@bigbrush/cms/modules/pages/frontend/views' => [
            	// define override views
                '@app/themes/YOUR_THEME/overrides/pages/views',

                // define default views when no override exists
                '@bigbrush/cms/modules/pages/frontend/views',
            ],
        ]
    ],
],
...
~~~

Remember to change `YOUR_THEME` to the name of your theme.

After this change create a folder in your theme called `overrides`. In this folder create the folder `pages`
and within `pages` create the folder `views`.

In the `views` folder you can create views files that will replace the default view files of the Pages module.
Or better yet copy the default view files and make the changes you need.

Navigate to the folder: `vendor/bigbrush/cmf/src/modules/pages/frontend/views/` and copy the two folders
`category` and `page` to your new `views` folder. Now you can change the default view files according to your specific needs.

This example uses the `Pages` module but the implementation can be applied to any module.
