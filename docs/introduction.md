# Introduction to Big Cms

Big Cms is a Yii2 starter application which covers basic needs for creating modern websites.

But theres another side to Big Cms. It is designed to be an open Yii2 application template for
customized solutions. Big Cms consists of modules, blocks and plugins. All of them follows the coding style
and configuration pattern of Yii2.


## Installation <span id="installation"></span>

Big Cms is ready to use after installation. Read the [install guide](installing-big-cms.md) to get started.


## Themes <span id="themes"></span>

Yii2 themes is an essential part of Big Cms. With themes you can create dynamic page templates which goes beyond what Yii2 themes offers.

Start by reading through the [Yii2 guide on Themes](http://www.yiiframework.com/doc-2.0/guide-output-theming.html). As described in
the guide a theme is like a design template for a page. Within a theme you can add `include statements` to enable dynamic content.
Add the following `include statement` to the active theme:

```
<big:block position="sidebar" />
```
This adds the "sidebar" position to the theme. Here blocks will be inserted right before the page is rendered.

For more information on theming read the [guide on themes](themes.md). 


## Blocks <span id="blocks"></span>

A block is a [Yii2 widget](http://www.yiiframework.com/doc-2.0/guide-structure-widgets.html) with one additional method. A block is
considered as a building block in views and is primarily implemented by `include statements`.

Big Cms comes installed with 4 blocks
  - **Contact** displays dynamic contact forms.
  - **Menu** displays bootstrap menus
  - **Pages categories** displays a list of categories
  - **Text** displays content created with a TinyMce editor.

[Here's a tutorial on creating blocks](creating-blocks.md).


## Plugins <span id="plugins"></span>

Plugins are used to inject custom code a certain execution points. Plugins are divided into groups which is assigned
before the plugins are called. This provides a logical structure for custom plugin packages.

See the [guide on plugins](the-plugin-system.md) for more information.


## Configuration <span id="configuration"></span>

Big Cms follows the configuration conventions promoted by Yii2. This means that all managers can be configured through
the application configuration, just like Yii2 components.


## The philosophy <span id="the-philosophy"></span>

Our background comes from Joomla and we have created hundreds of websites, webshops, intranets and customized marketing solutions for 
all kinds of businesses. A clear tendency in the feedback we got from our customers was: Joomla can do so much but we only use
a minimal part of it - it confuses us and has no point. 

At the same time, we became aware of the change that was occuring in technology driven marketing campaings. The technology is
the campaing as much as the content! For us this meant that *one size fits all* open source systems was dying. We needed a
more flexible and efficient application platform and therefore created Big Cms. An application template
that solves 3 challenges:

  1. The basic needs for most online application (navigation, content, media library, backend)
  2. One size fits none - create a flexible platform for customized solutions.
  3. Rapid prototyping for customized solutions
