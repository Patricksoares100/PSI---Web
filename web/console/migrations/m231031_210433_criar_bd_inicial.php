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
            'codigo_postal' => $this->string()->notNull(),
            'localidade' => $this->string()->notNull(),
        ]);

        $this->createTable('empresas', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'telefone' => $this->integer(9)->notNull(),
            'nif' => $this->integer(9)->notNull(),
            'morada' => $this->integer()->notNull(),
            'codigo_postal' => $this->string()->notNull(),
            'localidade' => $this->string()->notNull(),
        ]);
        
        $this->createTable('artigos',[
            'id' =>$this->primaryKey(),
            'nome' =>$this->string()->notNull(),
            'descricao' =>$this->string()->notNull(),
            'valor' =>$this->double()->notNull(),
            'stock_atual' =>$this->integer()->notNull(),
        ]);

        $this->createTable('fornecedores',[
            'id' => $this->primaryKey(),
            'nome' => $this->string(),
            'telefone' => $this->integer(9),
            'nif' => $this->integer(9),
            'morada' => $this->string(),
        ]);

        $this->createTable('carrinho_items', [
            'id' => $this->primaryKey(),
            'quantidade' => $this->integer()->notNull(),
            'valor' => $this->double()->notNull(),
            'valor_iva' => $this->double()->notNull(),
        ]);

        $this->createTable('ivas', [
            'id' =>$this->primaryKey(),
            'em_vigor' =>"ENUM('sim', 'nao')",
            'descricao' =>$this->string()->notNull(),
            'percentagem' =>$this->double()->notNull(),
        ]);

        $this->createTable('carrinho_compras', [
            'id' =>$this->primaryKey(),
            'data' =>$this->dateTime()->notNull(),
            'valor_total' =>$this->double()->notNull(),
            'iva_total' =>$this->integer()->notNull(),
            'estado' =>"ENUM('activo', 'inactivo')",
        ]);

        $this->createTable('faturas', [
            'id' =>$this->primaryKey(),
            'data' =>$this->dateTime()->notNull(),
            'valor_fatura' =>$this->double()->notNull(),
            'estado' =>"ENUM('emitida', 'paga', 'cancelada')",
        ]);

        $this->createTable('avaliacaos', [
            'id' =>$this->primaryKey(),
            'comentario' =>$this->string()->notNull(),
            'classificacao' =>"ENUM('1', '2', '3', '4', '5')",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('pessoas');
        $this->dropTable('empresas');
        $this->dropTable('fornecedores');
        $this->dropTable('artigos');
        $this->dropTable('carrinho_items');
        $this->dropTable('ivas');
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
