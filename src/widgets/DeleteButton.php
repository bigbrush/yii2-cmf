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
class DeleteButton extends \yii\base\Widget
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
     * @var array $options an array of widget options.
     */
    public $options;
    /**
     * @var string $content content for the confirm dialog.
     */
    public $content;


    /**
     * Intializes the widget.
     */
    public function init()
    {
        parent::init();

        if ($this->model === null && $this->action === null) {
            throw new InvalidConfigException("The 'model' property must be set in bigbrush\cms\widgets\DeleteButton.");
        }

        if ($this->action === null) {
            $this->action = ['delete', 'id' => $this->model['id']];
        }
        if ($this->content === null) {
            $this->content = Yii::t('cms', 'Are you sure?');
        }
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        return Html::a($this->label, $this->action, [
            'class' => 'btn btn-default btn-xs',
            'data' => [
                'method' => 'POST',
                'confirm' => $this->content,
                'params' => [
                    'id' => $this->model['id'],
                ],
            ],
        ]);
    }
}
