# Introduction to Big Cms

Big Cms is a Yii2 starter application which covers basic needs for creating modern website.

While covering common needs for creating a modern website it is designed to be an open Yii2 application template for
customized solutions. Big Cms consists of modules, blocks and plugins. All of them follows the coding style
and configuration pattern of Yii2.


## Installation
Big Cms is ready to use after installation. You can read the [install guide](installing-big-cms.md) to get going.


## Themes
Yii2 themes is an essential part of Big Cms. With themes you can create dynamic page templates which goes beyond what Yii2 themes offers.

Start by read through the [Yii2 guide on Themes](http://www.yiiframework.com/doc-2.0/guide-output-theming.html). As described in
the guide a theme is like a design template for a page. Within a theme you can add include statements to enable dynamic content.
Add the following include statement to the active theme:

```
<big:block position="sidebar" />
```
This adds the "sidebar" position to the theme. Here blocks will be inserted right before the page is rendered.

For more information on theming read the [guide on themes](themes.md). 


## Blocks
A block is a [Yii2 widget](http://www.yiiframework.com/doc-2.0/guide-structure-widgets.html) with one additional method. A block is
considered as a building block in views.

Big Cms comes installed with 4 blocks
  - **Contact** displays dynamic contact forms.
  - **Menu** displays bootstrap menus
  - **Pages categories** displays a list of categories
  - **Text** displays content created with a TinyMce editor.

## Plugins
Plugins are used to inject custom code a certain execution points. Plugins are divided into groups which is assigned
before the plugins are called.

See the [guide on plugins](the-plugin-system.md) for more information.

## Configuration
