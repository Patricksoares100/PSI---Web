<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Empresa;

/**
 * EmpresaSearch represents the model behind the search form of `app\models\Empresa`.
 */
class EmpresaSearch extends Empresa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'telefone', 'nif', 'morada'], 'integer'],
            [['nome', 'email', 'codigo_postal', 'localidade'], 'safe'],
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
        $query = Empresa::find();

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
            'telefone' => $this->telefone,
            'nif' => $this->nif,
            'morada' => $this->morada,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'codigo_postal', $this->codigo_postal])
            ->andFilterWhere(['like', 'localidade', $this->localidade]);

        return $dataProvider;
    }
}
