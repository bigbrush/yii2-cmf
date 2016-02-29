# The Editor in Big Cms

Big Cms comes with a TinyMCE 4 editor which is tailored specifically to Big Cms. This includes 2 extra menu
items under the "Insert" menu and 2 extra formats under the "Format" menu.


## Usage <span id="usage"></span>

~~~php
use bigbrush\cms\widgets\Editor;

$form->field($model, 'content')->widget(Editor::className());
~~~

The editor has several properties that enables you to customize it.

  - **useReadMore**: boolean defining whether the "Read more" menu item is shown
  - **clientOptions**: an array (key => value) of TinyMCE client configurations. If provided it will be merged
                       with the default client options.

To configure the `Editor` do the following:

~~~php
$form->field($model, 'content')->widget(Editor::className(), ['useReadMore' => false]);
~~~


## Dynamic content <span id="dynamic-content"></span>

Links inserted to the editor are created to be SEO optimized and portable. If you insert a link it will have the
following format:

~~~
index.php?r=module/controller/action&param1=value1&param2=value2
~~~

This makes the content created with the editor portable from one domain to another without having to modify all links. Every link
with the above format is parsed by the Big Cms [Parser](http://bigbrush-agency.com/api/big/bigbrush-big-core-parser.html)
right before Yii2 renders the page. This can be disabled by setting [Big::enableDynamicContent ](http://bigbrush-agency.com/api/big/bigbrush-big-core-big.html#$enableDynamicContent-detail) to `false`.

Another kind of dynamic content is `include tags` which is covered next.


## Include tags <span id="include-tags"></span>

The editor support 2 different kinds of `include tags`. One that include a block and one that
embeds a youtube video.

To embed a Youtube video do the following:

~~~
{youtube xxxxxx}
~~~

Where `xxxxxx` equals a Youtube video ID like so: https://www.youtube.com/watch?v=xxxxx

To include a block do the following:

~~~
{block BLOCK_TITLE}
~~~

If you have created a block with the title `Contact us` the block can be included like this:

~~~
{block Contact us}
~~~

Multiple Youtube videoes and blocks can be included in the editor.


## How it works <span id="how-it-works"></span>

Big Cms uses the [Plugin system](the-plugin-system.md) to parse `include tags` on each page
request. Read up on the plugin guide to dive into how it works.
