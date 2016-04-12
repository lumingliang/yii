<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Country;
use yii\data\Pagination;

/**
 * CountrySearch represents the model behind the search form about `app\models\Country`.
 */
class CountrySearch extends Country
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'safe'],
            [['population'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Country::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'population' => $this->population,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name]);

         $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        $t = $query->orderBy('name')->offset($pagination->offset)->limit($pagination->limit)->all();
        // var_dump($dataProvider);
        // exit;
        return [$dataProvider, $pagination];
    }
}
