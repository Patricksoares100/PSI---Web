<?php

use yii\db\Migration;
use console\models\AuthorDadosPessoaisRule;

/**
 * Class m231030_212423_init_rbac
 */
class m231030_212423_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // The authManager can now be accessed via \Yii::$app->authManager.
        $auth = Yii::$app->authManager;

        $rule = new AuthorDadosPessoaisRule;
        $auth->add($rule);

        // Criar os roles - $auth->createRole();
        $role_admin = $auth->createRole('Admin');
        $auth->add($role_admin);

        $role_funcionario = $auth->createRole("Funcionario");
        $auth->add($role_funcionario);

        $role_cliente = $auth->createRole('Cliente');
        $auth->add($role_cliente);

        //Criar permissões - $auth->createPermission();
        $permission_edit_roles = $auth->createPermission('editRoles');
        $permission_edit_roles->description = 'Permissão para editar os roles';
        $auth->add($permission_edit_roles);

        $permission_gerir_produtos = $auth->createPermission('gerirProdutos');
        $permission_gerir_produtos->description = 'Permissão para gerir produtos';
        $auth->add($permission_gerir_produtos);

        $permission_edit_empresa = $auth->createPermission('editEmpresa');
        $permission_edit_empresa->description = 'Permissão para editar os dados da empresa';
        $auth->add($permission_edit_empresa);


        $permission_backoffice = $auth->createPermission('permissionBackoffice');
        $permission_backoffice->description = 'Permissão para entrar no backoffice';
        $auth->add($permission_backoffice);

        $permission_frontoffice = $auth->createPermission('permissionFrontoffice');
        $permission_frontoffice->description = 'Permissão para entrar no front office';
        $auth->add($permission_frontoffice);


        $permissaoDadosPessoais = $auth->createPermission('updateDadosPessoais');
        $permissaoDadosPessoais->description = 'Atualizar dados pessoais';
        $permissaoDadosPessoais->ruleName = 'isAuthorDadosPessoais'; // Nome da regra
        $auth->add($permissaoDadosPessoais);


        // dar heranças addChild
        $auth->addChild($role_funcionario, $permission_gerir_produtos);
        $auth->addChild($role_funcionario, $permission_backoffice);
        $auth->addChild($role_funcionario, $permissaoDadosPessoais);

        $auth->addChild($role_admin, $permission_edit_roles);
        $auth->addChild($role_admin, $permission_edit_empresa);
        $auth->addChild($role_admin, $role_funcionario);

        // o primeiro utilizador vai ser ADMIN
        $auth->assign($role_admin, 1);

        //permissao frontoffice
        $auth->addChild($role_cliente, $permission_frontoffice);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231030_212423_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
