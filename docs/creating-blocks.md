# Creating blocks in Big Cms

A block is an extended version of a Yii 2 widget. You can therefore use a block just like any other Yii 2 widget. But you can also integrate
it with Big Cms quite easily.


## Creating a block

A block can be located in any folder. Create a file called `MyBlock.php` anywhere in your application and insert the following:

~~~php
namespace your\custom\namespace;

use bigbrush\big\core\Block;

/**
 * MyBlock
 */
class MyBlock extends Block
{
    /**
     * Runs this block.
     *
     * @return string the rendering result
     */
    public function run()
    {
        $this->render('index');
    }

    /**
     * Edits this block.
     *
     * @param ActiveRecord $model the model associated with this block
     * @param yii\bootstrap\ActiveForm the form currently being rendered
     * @return string the rendering result
     */
    public function edit($model, $form)
    {
        // for simple blocks
        return $form->field($model, 'content')->label('Write your name');

        // for complex blocks
        $this->render('edit', [
            'model' => $model,
            'form' => $form,
        ]);
    }
}
~~~

As you can see the block consists of 2 methods - run() and edit(). run() works just like a Yii 2 widget while edit()
is an extra method that must be defined.

## Installing a block


## Dont mess with my block

By default a block should only render form fields relevant to the block - but this behavior can be overridden by adding one extra method.

~~~php
class MyBlock extends Block
{
    ...

    /**
     * Returns a boolean indicating whether the block will render a form when being created/edited. If false is returned
     * the [[edit()]] method is called within a form where required fields are added automatically. In this case the block should only
     * render form fields related to the block. If true is returned the [[edit()]] method is called without any additional
     * HMTL markup added. The block then has complete control over the UI when editing.
     *
     * @return boolean when true is returned the block being edited should render a form. When false is
     * returned [[edit()]] will be called within a form.
     */
     public function getEditRaw()
     {
         return true;
     }
}
~~~
