<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use bigbrush\cms\Cms;

/**
 * BlockSearch can be used to search blocks by their `title` and optionally `scope`.
 *
 * Usage:
 *
 * ~~~php
 * use bigbrush\cms\model\BlockSearch;
 * $model = new BlockSearch();
 * $dataProvider = $searchModel->search([
 *     'q' => 'some title',
 * ]);
 *
 * // or define a scope. Defaults to Cms::SCOPE_FRONTEND.
 *
 * $dataProvider = $searchModel->search([
 *     'scope' => \bigbrush\cms\Cms::SCOPE_FRONTEND,
 *     'q' => 'some title',
 * ]);
 * ~~~
 *
 */
class BlockSearch extends Model
{
    /**
     * @var string $q a string to search blocks by their `title`.
     */
    public $q;
    /**
     * @var string $scope an optional `scope` to filter blocks by. Defaults to [[Cms::SCOPE_FRONTEND]].
     */
    public $scope;


    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->scope === null) {
            $this->scope = Cms::SCOPE_FRONTEND;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q', 'scope'], 'string'],
        ];
    }

    /**
     * Returns a `ActiveDataProvider` filtered by block titles.
     *
     * @param array $params list of parameters to filter blocks by.
     */
    public function search($params)
    {
        $query = Yii::$app->big->blockManager->getModel()->find()->with(['extension']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if (!($this->load($params, '') && $this->validate())) {
            return $dataProvider;
        }

        if ($this->scope) {
            $query->andWhere(['scope' => $this->scope]);
        }
        if ($this->q) {
            $query->andWhere(['like', 'title', $this->q]);
        }

        $dataProvider->query = $query;

        return $dataProvider;
    }
}
