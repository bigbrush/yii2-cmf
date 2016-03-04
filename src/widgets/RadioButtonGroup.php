<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\widgets;

use Yii;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\BootstrapPluginAsset;

/**
 * RadioButtonGroup renders a bootstrap button group with radio buttons which can be used in a form.
 *
 * Usage:
 *
 * ~~~php
 * $form->field($model, 'attribute')->widget(RadioButtonGroup::className());
 * ~~~
 *
 * Or by setting a specific name and value:
 *
 * ~~~php
 * $form->field($model, 'attribute')->widget(RadioButtonGroup::className(), [
 *     'name' => 'field_name',
 *     'value' => 'field_value',
 * ]);
 * ~~~
 *
 * Registering custom buttons:
 *
 * ~~~php
 * $form->field($model, 'attribute')->widget(RadioButtonGroup::className(), [
 *     'buttons' => [
 *         ['label' => 'Yes', 'value' => '1', 'options' => ['class' => 'btn btn-primary']]
 *         ['label' => 'No', 'value' => '0', 'options' => ['class' => 'btn btn-primary']]
 *     ],
 * ]);
 * ~~~
 *
 * One of the buttons will automatically be set as active. See 
 */
class RadioButtonGroup extends InputWidget
{
    /**
     * @var array list of buttons. Each array element represents a single button
     * which can be specified as an array of the following structure:
     *
     * - label: string, required, the label.
     * - value: string, required, the value.
     * - options: array, optional, key => value array used as options for each label.
     *
     * Defaults to a "yes/no" button.
     */
    public $buttons;
    /**
     * @var string defines the button class used with radio buttons.
     */
    public $buttonClass = 'btn-primary';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->buttons === null) {
            $this->buttons = [
                ['label' => Yii::t('cms', 'Yes'), 'value' => '1', 'options' => ['class' => 'btn btn-primary']],
                ['label' => Yii::t('cms', 'No'), 'value' => '0', 'options' => ['class' => 'btn btn-primary']],
            ];
        }
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        $attribute = $this->attribute;
        $buttons = [];
        foreach ($this->buttons as $button) {
            if (is_array($button)) {
                $name = $this->name ?: $this->model->{$this->attribute};
                $value = isset($button['value']) ? $button['value'] : $this->value;
                $checked = $value == $this->value;
                $options = isset($button['options']) ? $button['options'] : [];
                
                if (!isset($options['class'])) {
                    Html::addCssClass($options, 'btn btn-primary');
                }
                if ($checked) {
                    Html::addCssClass($options, 'active');
                }

                $buttons[] = Html::radio($name, $checked, [
                    'label' => $button['label'],
                    'value' => $value,
                    'uncheck' => null, // removes hidden field
                    'labelOptions' => $options,
                ]);
            } else {
                $buttons[] = $button;
            }
        }

        $view = $this->getView();
        BootstrapPluginAsset::register($view);
        $view->registerJs('
            $(".button-group-wrapper .btn").button();
        ');

        return Html::tag('div', ButtonGroup::widget([
            'options' => ['class' => 'btn-group btn-toggle', ' data-toggle' => 'buttons'],
            'buttons' => $buttons,
        ]), ['class' => 'button-group-wrapper']);
    }
}
