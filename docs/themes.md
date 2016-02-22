# Themes

Include statements can be added within a theme. Each include statement is a placeholder for a block position. A block position can
contain multiple blocks.

To add a block position to a theme add the following:

```
<big:block position="sidebar" />
```
This adds the "sidebar" position to the theme. Blocks assigned to this position will be rendered by Big Cms right before
Yii renders the page.


## Templates - assigning blocks to positions
In the backend of Big Cms navigate to "Templates" using the main menu. Here you can manage and create templates. It enables you to
select a specific layout for each template and assign blocks to positions by drag and drop.

## Using a template
In the backend of Big Cms navigate to "Content->Pages" using the main menu. Select or crete a page and select your template from
the "Templates" drop down list.

## Determining if a position is active
You can determine whether a position is active in the active template like so (example uses Bootstrap to illustrate):

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
