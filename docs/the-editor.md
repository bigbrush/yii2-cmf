# The Editor in Big Cms

Big Cms comes with a TinyMCE 4 editor which is tailored specifically to Big Cms. This includes 2 extra menu
items under the "Insert" menu and 2 extra formats under the "Format" menu.


## Usage <span id="usage"></span>

~~~
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
