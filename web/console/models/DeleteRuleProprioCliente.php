<?php

namespace console\models;

use yii\rbac\Rule;

class DeleteRuleProprioCliente extends Rule
{
    public $name = 'isDeleteProprioCliente';
    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */

    public function execute($user, $item, $params)
    {
        // Verifica se o usuário possui o ID passado via parâmetro
        return isset($params['perfil']) ? $params['perfil'] == $user : false;
    } // vai buscar o modelo e nao o ID
}
