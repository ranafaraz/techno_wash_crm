<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CardType;

/**
 * CardTypeSearch represents the model behind the search form about `common\models\CardType`.
 */
class CardTypeSearch extends CardType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_type_id', 'card_price', 'created_by', 'updated_by'], 'integer'],
            [['card_name', 'card_description', 'card_services', 'created_at', 'updated_at'], 'safe'],
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
        $query = CardType::find();

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
            'card_type_id' => $this->card_type_id,
            'card_price' => $this->card_price,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'card_name', $this->card_name])
            ->andFilterWhere(['like', 'card_description', $this->card_description])
            ->andFilterWhere(['like', 'card_services', $this->card_services]);

        return $dataProvider;
    }
}
