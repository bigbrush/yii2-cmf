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

/**
 * EditorBehavior integrates functionality provided by [[bigbrush\cms\widgets\Editor]] with
 * an [[ActiveRecord]]. This behavior does 2 things:
 * 1. It splits up html text created with the editor into [[contentField]] and [[introField]] when
 * a "Readmore" <hr> tag is inserted. If the tag is not present in the editor content the field [[defaultField]]
 * is populated with the content.
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
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => EditorBehavior::className(),
 *             'introAttribute' => 'THE ATTRIBUTE TO ASSIGN THE INTRO CONTENT',
 *             'contentAttribute' => 'THE ATTRIBUTE TO ASSIGN THE FULL CONTENT - WITHOUT THE INTRO CONTENT',
 *         ],
 *     ];
 * }
 * 
 * ...
 * ~~~
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
     * @var bool $active
     */
    public $active = true;
    /**
     * @var bool $asValidator defines whether this behavior will act as a validator for [[contentField]].
     * If true the [[contentField]] will be processed by [[yii\helpers\HtmlPurifier]] before being saved.
     */
    public $asValidator = true;


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
     * @param yii\base\ModelEvent $event the event being triggered.
     */
    public function beforeSave($event)
    {
        $intro = $this->owner->getAttribute($this->introAttribute);
        $content = $this->owner->getAttribute($this->contentAttribute);

        $pattern = '#<hr\s+id=("|\')system-readmore("|\')\s*\/*>#i';
        $tagPos = preg_match($pattern, $content);
        if ($tagPos == 0) {
            $intro = $this->owner->content;
            $content = '';
        } else {
            list($intro, $content) = preg_split($pattern, $content, 2);
        }

        $this->owner->setAttribute($this->introAttribute, $intro);
        $this->owner->setAttribute($this->contentAttribute, $content);
    }

    /**
     * Event handler for "afterFind" in [[owner]].
     *
     * @param yii\base\ModelEvent $event the event being triggered.
     */
    public function afterFind($event)
    {
        if ($this->active) {
            $intro = $this->owner->getAttribute($this->introAttribute);
            $content = $this->owner->getAttribute($this->contentAttribute);
            
            if (trim($content) != '') {
                $content = $intro . "<hr id=\"system-readmore\" />" . $content;
            } else {
                $content = $intro;
            }

            $this->owner->setAttribute($this->contentAttribute, $content);
        }
    }
}

