<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\validators\StringValidator;
use yii\helpers\HtmlPurifier;
use yii\helpers\Inflector;
use yii\helpers\Json;
use bigbrush\big\models\Template;
use bigbrush\big\models\Category;
use bigbrush\cms\models\User;
use bigbrush\cms\models\EditorBehavior;

/**
 * Page
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $intro_content
 * @property string $content
 * @property integer $category_id
 * @property integer $state
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $template_id
 */
class Page extends ActiveRecord
{
    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 2;
    const STATE_THRASHED = 100;

    /**
     * @var array $images list of images assigned to this page.
     */
    public $images = [];


    /**
     * Registers default values for a page.
     */
    public function init()
    {
        parent::init();
        $this->params = ['show_title' => 1];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('cms', 'Title'),
            'alias' => Yii::t('cms', 'Alias'),
            'content' => Yii::t('cms', 'Content'),
            'category_id' => Yii::t('cms', 'Category'),
            'state' => Yii::t('cms', 'State'),
            'created_at' => Yii::t('cms', 'Created'),
            'updated_at' => Yii::t('cms', 'Updated'),
            'created_by' => Yii::t('cms', 'Created by'),
            'updated_by' => Yii::t('cms', 'Updated by'),
            'meta_title' => Yii::t('cms', 'Meta title'),
            'meta_description' => Yii::t('cms', 'Meta description'),
            'meta_keywords' => Yii::t('cms', 'Meta keywords'),
            'template_id' => Yii::t('cms', 'Template'),

            // methods
            'createdAtText' => Yii::t('cms', 'Created'),
            'updatedAtText' => Yii::t('cms', 'Updated'),
            'stateText' => Yii::t('cms', 'State'),
        ];
    }

    /**
     * Returns an array used in dropdown lists for field [[state]]
     *
     * @return array
     */
    public function getStateOptions()
    {
        return [
            self::STATE_ACTIVE => Yii::t('cms', 'Active'),
            self::STATE_INACTIVE => Yii::t('cms', 'Inactive'),
            self::STATE_THRASHED => Yii::t('cms', 'Trashed'),
        ];
    }

    /**
     * Returns the text value of the [[state]] property.
     * 
     * @return string the [[state]] property as a string representation.
     */
    public function getStateText()
    {
        $options = $this->getStateOptions();
        return isset($options[$this->state]) ? $options[$this->state] : '';
    }

    /**
     * Returns the "created_at" property as a formatted date.
     *
     * @return string a formatted date.
     */
    public function getCreatedAtText()
    {
        return Yii::$app->getFormatter()->asDateTime($this->created_at);
    }

    /**
     * Returns the "created_at" property as a formatted date.
     *
     * @return string a formatted date.
     */
    public function getUpdatedAtText()
    {
        return Yii::$app->getFormatter()->asDateTime($this->updated_at);
    }

    /**
     * Returns the author of this page.
     *
     * @return ActiveQueryInterface the relational query object.
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Returns the category of this page.
     *
     * @return ActiveQueryInterface the relational query object.
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Returns the editor of this page.
     *
     * @return ActiveQueryInterface the relational query object.
     */
    public function getEditor()
    {
        if ($this->updated_by == $this->created_by) {
            return $this->getAuthor();
        }
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * Returns the template of this page.
     *
     * @return ActiveQueryInterface the relational query object.
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            ['content', 'filter', 'filter' => function($value) {
                return HtmlPurifier::process($value, [
                    'Attr.EnableID' => true,
                ]);
            }],
            ['state', 'default', 'value' => self::STATE_ACTIVE],
            ['state', 'in', 'range' => array_keys($this->getStateOptions())],
            [['meta_title', 'meta_description', 'meta_keywords', 'alias'], 'string', 'max' => 255],
            ['template_id', 'integer'],
            ['params', 'each', 'rule' => ['string']],
            ['alias', 'validateAlias'],
            ['images', 'validateImages'],
        ];
    }

    /**
     * Validates the [[alias]] attributes. If another page with the same alias exists
     * the current alias will automatically be made unique by appending an incremental counter.
     * Can't figure out how this is covered by SluggableBehavior.
     *
     * @param string $attribute the attribute currently being validated
     * @param mixed $params the value of the "params" given in the rule
     */
    public function validateAlias($attribute, $params)
    {
        $alias = empty($this->alias) ? Inflector::slug($this->title) : $this->alias;
        $counter = 0;
        while (($model = $this->findOne(['alias' => $alias])) !== null && $model->id != $this->id) {
            $counter++;
            $alias = $alias . '-' . $counter;
        }
        $this->alias = $alias;
    }

    /**
     * Validates images assigned to the page.
     *
     * @param string $attribute the attribute currently being validated
     * @param mixed $params the value of the "params" given in the rule
     */
    public function validateImages($attribute, $params)
    {
        $validator = new StringValidator();
        foreach ($this->$attribute as $image) {
            if (!empty($image['image']) && !$validator->validate($image['image'], $error)) {
                $this->addError($attribute, Yii::t('cms', 'Image must be a string.'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // handle images
            $params = $this->params;
            $params['images'] = $this->images;
            $this->params = Json::encode($params);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->params = Json::decode($this->params);
        if (isset($this->params['images'])) {
            $this->images = $this->params['images'];
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'alias',
                'ensureUnique' => true,
            ],
            [
                'class' => EditorBehavior::className(),
                'active' => Yii::$app->cms->isBackend,
                'introAttribute' => 'intro_content',
                'contentAttribute' => 'content',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }
}