<?php

use yii\db\Migration;

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

        // Criar os roles - $auth->createRole();
        $role_admin = $auth->createRole('admin');
        $auth->add($role_admin);

        $role_funcionrario = $auth->createRole("funcionario");
        $auth->add($role_funcionrario);

        $role_cliente = $auth->createRole('cliente');
        $auth->add($role_cliente);
        //Criar permissões - $auth->createPermission();

        $permission_edit_roles = $auth->createPermission('editRoles');
        $auth->add($permission_edit_roles);

        // dar heranças addChild

        $auth->addChild($role_admin, $permission_edit_roles);
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
