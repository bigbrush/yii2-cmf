<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\models;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;

/**
 * EditorBehavior integrates functionality provided by [[bigbrush\cms\widgets\Editor]] with
 * an [[ActiveRecord]]. This behavior does 2 things:
 * 1. It splits up html text created with the editor into [[contentField]] and [[introField]] when
 * a "Readmore" <hr> tag is inserted. If a "Readmore" tag is not present the field [[introAttribute]]
 * is populated with content of the [[contentAttribute]] while [[contentAttribute]] is populted with
 * an empty string.
 *
 * This behavior reacts to the following events:
 *    - ActiveRecord::EVENT_BEFORE_INSERT
 *    - ActiveRecord::EVENT_BEFORE_UPDATE
 *    - ActiveRecord::EVENT_AFTER_FIND
 *
 * Usage:
 * In a model extending [[ActiveRecord]] add the following:
 * ~~~php
 * use bigbrush\cms\models\EditorBehavior;
 * 
 * ...
 * 
 * public function rules()
 * {
 *      return [
 *          ['contentAttribute', 'string'],
 *      ];
 * }
 * 
 * ...
 * 
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => EditorBehavior::className(),
 *             'introAttribute' => 'THE ATTRIBUTE TO ASSIGN THE INTRO CONTENT',
 *             'contentAttribute' => 'THE ATTRIBUTE TO ASSIGN THE FULL CONTENT - WITHOUT THE INTRO CONTENT',
 *             'isEditing' => TRUE WHEN DISPLAYING THE EDITOR FALSE WHEN DISPLAYING CONTENT CREATED WITH THE EDITOR,
 *             'purifyContent' => 'TRUE WHEN HtmlPurifier SHOULD PROCESS "contentAttribute"',
 *         ],
 *     ];
 * }
 * 
 * ...
 * ~~~
 * And then use "contentAttribute" in a form displaying the [[bigbrush\cms\widgets\Editor]] editor.
 * 
 * @property ActiveRecord $owner
 */
class EditorBehavior extends Behavior
{
    /**
     * @var string $introAttribute
     */
    public $introAttribute;
    /**
     * @var string $contentAttribute
     */
    public $contentAttribute;
    /**
     * @var bool $isEditing defines whether this behavior will update [[owner]] in [[afterFind()]].
     * Set this to true when displaying the editor (backend) and false when displaying the content (frontend).
     */
    public $isEditing = true;
    /**
     * @var bool $purifyContent defines whether this behavior will purify [[contentAttribute]].
     * If true [[contentAttribute]] will be purified by [[HtmlPurifier]] before [[owner]] is saved.
     */
    public $purifyContent = false;


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->introAttribute === null || $this->contentAttribute === null) {
            throw new InvalidConfigException("The properties 'introAttribute' and 'contentAttribute' must be set in " . get_class($this));
        }
    }

    /**
     * Event handler for "beforeSave" in [[owner]].
     *
     * Splits up [[contentAttribute]] if the following tag is present: <hr id="system-readmore" />.
     * When present the content before the tag is assigned to [[introAttribute]] while the content
     * after the tag is assigned to [[contentAttribute]]. If the tag is not present [[introAttribute]]
     * is populated with the content and [[contentAttribute]] is empty an empty string.
     *
     * @param yii\base\ModelEvent $event the event being triggered.
     */
    public function beforeSave($event)
    {
        $intro = $this->owner->getAttribute($this->introAttribute);
        $content = $this->owner->getAttribute($this->contentAttribute);

        if ($this->purifyContent) {
            $content = HtmlPurifier::process($content, [
                'Attr.EnableID' => true, // needs to be set because the <hr> uses the id attribute
            ]);
        }

        $pattern = '#<hr\s+id=("|\')system-readmore("|\')\s*\/*>#i';
        $tagPos = preg_match($pattern, $content);
        if ($tagPos == 0) {
            $intro = '';
            $content = $intro . $content;
        } else {
            list($intro, $content) = preg_split($pattern, $content, 2);
        }

        $this->owner->setAttribute($this->introAttribute, $intro);
        $this->owner->setAttribute($this->contentAttribute, $content);
    }

    /**
     * Event handler for "afterFind" in [[owner]].
     *
     * Only runs when [[isEditing]] is true. If [[introAttribute]] is not empty [[contentAttribute]]
     * will be prepended with [[introAttribute]] and a <hr id="system-readmore" /> tag.
     *
     * @param yii\base\ModelEvent $event the event being triggered.
     */
    public function afterFind($event)
    {
        $intro = $this->owner->getAttribute($this->introAttribute);
        $content = $this->owner->getAttribute($this->contentAttribute);
        if ($this->isEditing) {
            if (trim($intro) != '') {
                $content = $intro . "<hr id=\"system-readmore\" />" . $content;
                $this->owner->setAttribute($this->contentAttribute, $content);
            }
        }
    }
}
