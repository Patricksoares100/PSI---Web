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
            ['novaPassword', 'required'],
            ['confirmarPassword', 'compare', 'compareAttribute' => 'novaPassword', 'on' => 'alterarPassword'],
        ];
    }

    public function findPasswords($attribute, $params)
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user->password != md5($this->atualPassword))
            $this->addError($attribute, 'A password atual está incorreta!');
    }
}
