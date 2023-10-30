<?php

use yii\db\Migration;

/**
 * Class m231030_212503_init_rbac
 */
class m231030_212503_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $role_funcionrario = $auth->createPermission("funcionario");
        $auth->add($role_funcionrario);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231030_212503_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231030_212503_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
