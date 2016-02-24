# Creating blocks in Big Cms

A block is an extended version of a Yii 2 widget with one additional method which ensures backend compatibility.

Besides the well-known `run()` method a block must also define the `edit()` method. This method is called when
a block is being created/edited through the backend.


## Creating a block

A block can be located in any folder. All blocks have a model associated which can be accessed with `$this->model`.

The [BlockManager](http://bigbrush-agency.com/api/big/bigbrush-big-core-blockmanager.html) controls all blocks and
is optimized so the model is only loaded through the ActiveRecord in the backend. When blocks are being
rendered in the frontend models are populated with data to avoid the big memory footprint of ActiveRecords.

Block models have the `content` property which can be used to store block data. 

Now let's create a block which says "Hello" to a name that you enter in a form field.

Create a file called `MyBlock.php` anywhere in your application and insert the following (change the namespace):

~~~php
namespace your\custom\namespace;

use yii\validators\Validator;
use bigbrush\big\core\Block;

/**
 * MyBlock
 *
 * @property bigbrush\big\models\Block $model a model associated with this block.
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
        return 'Hello ' . $this->content;
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
    	// add a 'required' validation rule to the model
    	$model->validators[] = Validator::createValidator('required', $model, 'content');

        // return a form field
        return $form->field($model, 'content')->label('Write your name');
    }
}
~~~

As you can see the block consists of 2 methods - `run()` and `edit()`. `run()` works just like a Yii 2 widget while edit()
is an extra method that must be defined as it handles backend creation/editing.

## Installing a block

With the block created we need to install it in Big Cms:
  
  1. In the backend navigate to "System->Extensions" using the main menu.
  2. Click on the drop down menu "Install extension" and click "Block".
  3. Fill out "Name" and "Namespace" in the form. The namespace in our example would be `your\custom\namespace\MyBlock`.
  4. Done.

You can now use the block by navigating to "Blocks" using the main menu.


## Take control when editing

By default a block should only render form fields relevant to the block - but this behavior can be overridden by adding one extra method.

~~~php
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
~~~

After this change the `$form` parameter of the `edit()` method will be null. You now have complete control over the UI when
editing the block in Big Cms.
