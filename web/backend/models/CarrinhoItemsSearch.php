<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CarrinhoItems;

/**
 * CarrinhoItemsSearch represents the model behind the search form of `app\models\CarrinhoItems`.
 */
class CarrinhoItemsSearch extends CarrinhoItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantidade', 'artigos_id', 'carrinhocompras_id'], 'integer'],
            [['valor', 'valor_iva'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = CarrinhoItems::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'quantidade' => $this->quantidade,
            'valor' => $this->valor,
            'valor_iva' => $this->valor_iva,
            'artigos_id' => $this->artigos_id,
            'carrinhocompras_id' => $this->carrinhocompras_id,
        ]);

        return $dataProvider;
    }
}
