<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PageSearch
 */
class PageSearch extends Model
{
    public $id; // a category id
    public $q; // search string for page title


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['q', 'string'],
        ];
    }

    /**
     * Returns a [[ActiveDataProvider]] filter by the provided paramters.
     *
     * @param array $params list of parameters to filter pages by.
     */
    public function search($params)
    {
        $query = Page::find()->with(['category']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if (!($this->load($params, '') && $this->validate())) {
            return $dataProvider;
        }

        if ($this->id) {
            $query->byCategory($this->id);
        }
        if ($this->q) {
            $query->andWhere(['like', 'title', $this->q]);
        }

        $dataProvider->query = $query;

        return $dataProvider;
    }
}
