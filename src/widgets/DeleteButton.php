<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * DeleteButton renders a form with the action of [[action]] in a bootstrap popover. If [[action]] is not set
 * if defaults to `['delete', 'id' => $this->model['id']]`.
 *
 * For instance:
 *
 * ```php
 * echo DeleteButton::widget([
 *     'model' => $model,
 * ]);
 * ```
 * 
 * The `model` property can be a item returned from a Big manager - for instance [[\bigbrush\big\core\MenuManager]].
 *
 * @see http://getbootstrap.com/javascript/#popovers
 */
class DeleteButton extends PopoverButton
{
    /**
     * @var array|ActiveRecord a model used to render a hidden form field within a form.
     */
    public $model;
    /**
     * @var string|array action used in a form rendered in the popover.
     */
    public $action;
    /**
     * @var string the button label. Overridden from parent impementation to set a different default value.
     */
    public $label = '<i class="fa fa-trash"></i>';
    /**
     * @var string whether the label should be HTML-encoded. Overridden from parent impementation to set a different default value.
     */
    public $encodeLabel = false;
    /**
     * @var string defines the button class.
     */
    public $buttonClass = 'btn-default';
    /**
     * @var string the text for the popover button.
     */
    public $btnText = '<i class="fa fa-check"></i>';


    /**
     * Intializes the widget.
     */
    public function init()
    {
        if ($this->model === null && $this->action === null && $this->content === null) {
            throw new InvalidConfigException("The 'model' property must be set in bigbrush\cms\widgets\DeleteButton.");
        }

        parent::init();
        $this->useHtml = true;
        Html::addCssClass($this->options, $this->buttonClass);

        if ($this->title === null) {
            $this->title = '<strong>' . Yii::t('cms', 'Sure?') . '</strong>';
        }
        if ($this->action === null) {
            $this->action = ['delete', 'id' => $this->model['id']];
        }
    }

    /**
     * Runs the widget.
     */
    public function run()
    {        
        $popover = '';
        $popover .= Html::beginForm($this->action);
        if ($this->content) {
            $popover .= $this->content;
        }
        $popover .= Html::submitButton($this->btnText, [
            'class' => 'btn btn-success',
        ]);
        $popover .= Html::hiddenInput('id', $this->model['id']);
        $popover .= Html::endForm();
        
        $this->content = $popover;

        return parent::run();
    }
}
