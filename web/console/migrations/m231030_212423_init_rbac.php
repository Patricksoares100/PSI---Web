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

        // Criar os roles
        $role_admin = $auth->createRole('admin');
        $auth->add($role_admin);
        
        $role_cliente = $auth->createRole('cliente');
        $auth->add($role_cliente);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231030_212423_init_rbac cannot be reverted.\n";

        return false;
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
