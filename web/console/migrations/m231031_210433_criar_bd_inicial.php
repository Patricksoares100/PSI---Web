<?php

use yii\db\Migration;

use function PHPUnit\Framework\assertNotNull;

/**
 * Class m231031_210433_criar_bd_inicial
 */
class m231031_210433_criar_bd_inicial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pessoas', [
            'id' => $this->primaryKey(), //PRIMARY LEY INDICA QUE JÁ É INT, NOT NULL E CHAVE PRIMÁRIA COM AUTOINCREMENTO
            'nome' => $this->string()->notNull(),
            'telefone' => $this->integer(9)->notNull(),
            'nif' => $this->integer(9)->notNull(),
            'morada' => $this->string()->notNull(),
            'codigoPostal' => $this->string()->notNull(),
            'localidade' => $this->string()->notNull(),
        ]);

        $this->createTable('empresas', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'telefone' => $this->integer(9)->notNull(),
            'nif' => $this->integer(9)->notNull(),
            'morada' => $this->integer()->notNull(),
            'codigoPostal' => $this->string()->notNull(),
            'localidade' => $this->string()->notNull(),
        ]);
        
        $this->createTable('artigos',[
            'id' =>$this->primaryKey(),
            'nome' =>$this->string()->notNull(),
            'descricao' =>$this->string()->notNull(),
            'valor' =>$this->double()->notNull(),
            'stockAtual' =>$this->integer()->notNull(),
        ]);

        $this->createTable('fornecedor',[
            'id' => $this->primaryKey(),
            'nome' => $this->string(),
        ]);

        $this->createTable('carrinho_items', [
            'id' => $this->primaryKey(),
            'quantidade' => $this->integer()->notNull(),
            'valor' => $this->double()->notNull(),
            'valorIva' => $this->double()->notNull(),
        ]);

        $this->createTable('ivas', [
            'id' =>$this->primaryKey(),
            'emVigor' =>"ENUM('sim', 'nao')",
            'descricao' =>$this->string()->notNull(),
            'percentagem' =>$this->double()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('pessoas');
        $this->dropTable('empresas');
        $this->dropTable('fornecedor');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231031_210433_criar_bd_inicial cannot be reverted.\n";

        return false;
    }
    */
}
