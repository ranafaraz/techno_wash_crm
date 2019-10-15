<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpLanguage;

/**
 * EmpLanguageSearch represents the model behind the search form about `common\models\EmpLanguage`.
 */
class EmpLanguageSearch extends EmpLanguage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_lang_id', 'emp_id', 'created_by', 'updated_by'], 'integer'],
            [['emp_language', 'lang_read', 'lang_wirte', 'lang_speak', 'lang_remarks', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmpLanguage::find();

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
            'emp_lang_id' => $this->emp_lang_id,
            'emp_id' => $this->emp_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'emp_language', $this->emp_language])
            ->andFilterWhere(['like', 'lang_read', $this->lang_read])
            ->andFilterWhere(['like', 'lang_wirte', $this->lang_wirte])
            ->andFilterWhere(['like', 'lang_speak', $this->lang_speak])
            ->andFilterWhere(['like', 'lang_remarks', $this->lang_remarks]);

        return $dataProvider;
    }
}
