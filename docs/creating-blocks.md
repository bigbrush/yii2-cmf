# Creating blocks in Big Cms

A block resembles a Yii 2 widget quite a bit. The main differences is that a block has one additional method which
ensures backend compatibility and doesn't provide the `widget()` method. Like Yii2 widgets it provides relative
view names which means you can call `$this->render()` in a block.

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
 * @property \bigbrush\big\models\Block $model a model associated with this block.
 */
class MyBlock extends Block
{
    /**
     * Executes this block.
     *
     * @return string the result of block execution to be outputted.
     */
    public function run()
    {
        return 'Hello ' . $this->content;
    }

    /**
     * Edits this block.
     *
     * @param \bigbrush\big\models\Block $model the model for this block
     * @param yii\bootstrap\ActiveForm $form the form used when editing the block. Only has effect when
     * [[getEditRaw()]] returns true. Otherwise this parameter will be null.
     * @return string the result of block execution to be outputted.
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
  4. Click "Save".


## Using a block

After a block has been installed it is ready to use:

  1. In the backend navigate to "Templates"
  2. Create/edit a template
  3. Drag n' drop the block to its desired position.
  4. Click "Save"

The block is now assigned to the desired position in that specific template. In another template the block could be placed
in another position.


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


## Advanced block development

In this example our block class extends from `bigbrush\big\core\Block` but this is not required. What is required is that
a block implements the `bigbrush\big\core\BlockInterface` interface. This enables you to convert any class into a block.

Because of the interface a block has additional methods defined. For instance the `onBeforeSave($event)` method which is
an event handler for the `ActiveRecord::EVENT_BEFORE_INSERT` and `ActiveRecord::EVENT_BEFORE_UPDATE` events. Use this
method to perform block specfic logic and set `$event->isValid = false` if the block should not be saved.

Take a look at [BlockInterface](http://bigbrush-agency.com/api/big/bigbrush-big-core-blockinterface.html) for 
more information.

If your block extends from `bigbrush\big\core\Block` you can use the `save($model)` method to stop the save process
from being executed. For instance:

~~~php
/**
 * This method gets called right before a block model is saved. The model is validated at this point.
 * In this method any Block specific logic should run. For example saving a block specific model.
 * 
 * @param \bigbrush\big\models\Block the model being saved.
 * @return boolean whether the current save procedure should proceed. If any block.
 * specific logic fails false should be returned - i.e. return $blockSpecificModel->save();
 */
public function save($model)
{
    $blockSpecificModel = new someModel();
    ...
    // do your thing
    ...
    return $blockSpecificModel->save();
}
~~~
