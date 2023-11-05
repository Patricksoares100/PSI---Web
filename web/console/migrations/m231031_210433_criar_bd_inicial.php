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

        $this->createTable('artigos', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'descricao' => $this->string()->notNull(),
            'valor' => $this->double()->notNull(),
            'stock_atual' => $this->integer()->notNull(),
            'iva_id' => $this->integer()->notNull(),
            'fornecedores_id' => $this->integer()->notNull(),
            'categorias_id' => $this->integer()->notNull(),
            'pessoas_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('fornecedores', [
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
            'artigos_id' => $this->integer()->notNull(),
            'carrinhocompras_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('ivas', [
            'id' => $this->primaryKey(),
            'em_vigor' => "ENUM('sim', 'nao')",
            'descricao' => $this->string()->notNull(),
            'percentagem' => $this->double()->notNull(),
        ]);

        $this->createTable('carrinho_compras', [
            'id' => $this->primaryKey(),
            'data' => $this->dateTime()->notNull(),
            'valor_total' => $this->double()->notNull(),
            'iva_total' => $this->integer()->notNull(),
            'pessoas_id' => $this->integer()->notNull(),
            'estado' => "ENUM('activo', 'inactivo')",
        ]);

        $this->createTable('faturas', [
            'id' => $this->primaryKey(),
            'data' => $this->dateTime()->notNull(),
            'valor_fatura' => $this->double()->notNull(),
            'estado' => "ENUM('emitida', 'paga', 'cancelada')",
        ]);

        $this->createTable('avaliacaos', [
            'id' => $this->primaryKey(),
            'comentario' => $this->string()->notNull(),
            'artigos_id' => $this->integer()->notNull(),
            'pessoas_id' => $this->integer()->notNull(),
            'classificacao' => "ENUM('1', '2', '3', '4', '5')",
        ]);
        //CHAVES ESTRANGEIRAS https://www.yiiframework.com/doc/guide/2.0/en/db-migrations
        //atenção aos comentarios que não estao no manual do yii
        // TEMOS QUE FAZER DROP DAS CHAVES? PERGUNTAR AO PROFESSOR

        /*INICIO CHAVES ESTRANGEIRAS DA TABELA ARTIGOS */
        $this->addForeignKey(
            'fk-artigos-iva_id', // Nome da chave estrangeira (pode ser qualquer nome único)
            'artigos', // Tabela da chave estrangeira(ou seja onde a chave estrangeira esta)
            'iva_id', // Coluna da tabela 'artigos' que é a chave estrangeira
            'ivas', // Tabela de referência
            'id', // Coluna de referência na tabela 'ivas'
            'CASCADE', // Ação a ser executada quando um registro relacionado na tabela 'ivas' é excluído
            'CASCADE' // Ação a ser executada quando um registro relacionado na tabela 'ivas' é atualizado
        );
        $this->addForeignKey(
            'fk-artigos-fornecedores_id',
            'artigos',
            'fornecedores_id',
            'fornecedores',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-artigos-categoria_id',
            'artigos',
            'categorias_id',
            'categorias',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-artigos-pessoas_id',
            'artigos',
            'pessoas_id',
            'pessoas',
            'id',
            'CASCADE',
            'CASCADE'
        );
        /*FIM CHAVES ESTRANGEIRAS DA TABELA ARTIGOS */

        /*INICIO CHAVES ESTRANGEIRAS DA TABELA CARRINHO_ITEMS */

        $this->addForeignKey(
            'fk-carrinhoitems-artigos_id', 
            'carrinho_items', 
            'artigos_id', 
            'artigos', 
            'id', 
            'CASCADE', 
            'CASCADE' 
        );
        $this->addForeignKey(
            'fk-carrinhoitems-carrinhocompras_id', 
            'carrinho_items', 
            'carrinhocompras_id', 
            'carrinho_compras', 
            'id', 
            'CASCADE', 
            'CASCADE' 
        );
        /*FIM CHAVES ESTRANGEIRAS DA TABELA CARRINHO_ITEMS */

        /*INICIO CHAVES ESTRANGEIRAS DA TABELA  CARRINHO_COMPRAS*/
        $this->addForeignKey(
            'fk-carrinhocompras-pessoas_id',
            'carrinho_compras',
            'pessoas_id',
            'pessoas',
            'id',
            'CASCADE',
            'CASCADE'
        );
        /*FIM CHAVES ESTRANGEIRAS DA TABELA  CARRINHO_COMPRAS*/

        /*INICIO CHAVES ESTRANGEIRAS DA TABELA  avaliacaos*/
        $this->addForeignKey(
            'fk-avaliacaos-artigos_id', 
            'avaliacaos', 
            'artigos_id', 
            'artigos', 
            'id', 
            'CASCADE', 
            'CASCADE' 
        );
        $this->addForeignKey(
            'fk-avaliacaos-pessoas_id',
            'avaliacaos',
            'pessoas_id',
            'pessoas',
            'id',
            'CASCADE',
            'CASCADE'
        );
        /*FIM CHAVES ESTRANGEIRAS DA TABELA  avaliacaos*/
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
        $this->dropTable('carrinho_compras');
        $this->dropTable('faturas');
        $this->dropTable('avaliacaos');
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
