# Introduction to Big Cms

Big Cms is a Yii2 starter application which covers basic needs for creating modern web applications.

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
  - **Pages categories** displays a list of pages within a category
  - **Text** displays content created with a TinyMCE editor.

[Here's a tutorial on creating blocks](creating-blocks.md).


## Plugins <span id="plugins"></span>

Plugins are used to inject custom code a certain execution points. Plugins are divided into groups which is assigned
before the plugins are called. This provides a logical structure for custom plugin packages.

See the [guide on plugins](the-plugin-system.md) for more information.


## Configuration <span id="configuration"></span>

Big Cms follows the configuration conventions promoted by Yii2. This means that all managers can be configured through
the application configuration, just like Yii2 components.

Config files used by Big Cms can be found in the folder `common/config` where 4 config files are located:

  - **admin.php**: backend specific configurations.
  - **console.php**: used when Big Cms installs.
  - **db.php**: defines database login credentials.
  - **web.php**: frontend specific configurations.

The config files follows the standard Yii2 way of configuring the application and related components. You can therefore
tailor the files to suit your needs.

## Application overview <span id="application-overview"></span>
After Big Cms has been installed the actual Cms is stored in the `vendor` folder. This gives you the option to place the
vendor folder outside of the web accessible folder as well as running it on shared hosts.

Big Cms is therefore an application template where only domain/customer specific solutions is placed while the application
itself can be moved around. Big Cms is actually a combination of two Github repos which can be found here: `vendor/bigbrush/yii2-big`
and `vendor/bigbrush/yii2-cmf`.

The file structure after Big Cms is installed is:

```
big-cms
  |-- admin
      |-- assets
      .htaccess
      index.php
  |-- assets
  |-- common
    |-- config
      admin.php
      console.php
      db.php
      web.php
  |-- media
    |-- filemanager
  |-- runtime
  |-- themes
  |-- vendor
  .htaccess
  index.php
```

Main folders are:

  - **common**: holds config files and can be used to application specific components, modules, etc.
  - **themes**: holds themes used in Big Cms. Mainly frontend themes but could be backend as well.
  - **media**: stores media files uploaded with the file manager.


## The philosophy <span id="the-philosophy"></span>

Our background comes from Joomla and we have created hundreds of websites, webshops, intranets and customized marketing solutions for 
all kinds of businesses. A clear tendency in the feedback we got from our customers was: Joomla can do so much but we only use
a minimal part of it - it confuses us and has no point. 

At the same time, we became aware of the change that was occuring in technology driven marketing campaings. The technology is
the campaing as much as the content! For us this means that *one size fits all* open source systems are dying (not by
the numbers though). We needed a more flexible and efficient application platform and therefore created Big Cms.
An application template that solves 3 challenges:

  1. The basic needs for most web application (navigation, content, media library, backend) are covered
  2. One size fits none - create a flexible platform for customized solutions.
  3. Rapid prototyping for customized solutions
