<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;


/**
 * Alterar Password form
 */
class AlterarPasswordForm extends Model
{
    public $atualPassword;
    public $novaPassword;
    public $confirmarPassword;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['atualPassword', 'novaPassword', 'confirmarPassword'], 'required'],
            ['atualPassword', 'validateCurrentPassword'],
            ['confirmarPassword', 'compare', 'compareAttribute' => 'novaPassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'atualPassword' => 'Password Atual',
            'novaPassword' => 'Nova Password',
            'confirmarPassword' => 'Confirmar Nova Password',
        ];
    }

    public function validateCurrentPassword($attribute, $params)
    {
        $user = User::findOne(Yii::$app->user->id);

        if (!$user || !$user->validatePassword($this->atualPassword)) {
            $this->addError($attribute, 'A password atual está incorreta.');
        }
    }
}
