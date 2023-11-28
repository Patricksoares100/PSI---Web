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
        $this->createTable('perfis', [
            'id' => $this->primaryKey(), //PRIMARY KEY INDICA QUE JÁ É INT, NOT NULL E CHAVE PRIMÁRIA COM AUTOINCREMENTO
            'nome' => $this->string()->notNull(),
            'telefone' => $this->integer(9)->notNull(),
            'nif' => $this->integer(9)->notNull(),
            'morada' => $this->string()->notNull(),
            'codigo_postal' => $this->string()->notNull(),
            'localidade' => $this->string()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createTable('categorias', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            //'categoria_mae' => $this->string()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createTable('empresa', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'telefone' => $this->integer(9)->notNull(),
            'nif' => $this->integer(9)->notNull(),
            'morada' => $this->string()->notNull(),
            'codigo_postal' => $this->string()->notNull(),
            'localidade' => $this->string()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createTable('artigos', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'descricao' => $this->string()->notNull(),
            'referencia' => $this->string()->notNull(),
            'preco' => $this->double()->notNull(),
            'stock_atual' => $this->integer()->notNull(),
            'iva_id' => $this->integer()->notNull(),
            'fornecedor_id' => $this->integer()->notNull(),
            'categoria_id' => $this->integer()->notNull(),
            'perfil_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createTable('fornecedores', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(),
            'telefone' => $this->integer(9),
            'nif' => $this->integer(9),
            'morada' => $this->string(),
        ], 'ENGINE=InnoDB');

        $this->createTable('linhas_carrinho', [
            'id' => $this->primaryKey(),
            'quantidade' => $this->integer()->notNull(),
            'artigo_id' => $this->integer()->notNull(),
            'perfil_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createTable('linhas_faturas', [
            'id' => $this->primaryKey(),
            'quantidade' => $this->integer()->notNull(),
            'valor' => $this->double()->notNull(),
            'valor_iva' => $this->double()->notNull(),
            'artigo_id' => $this->integer()->notNull(),
            'fatura_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createTable('ivas', [
            'id' => $this->primaryKey(),
            'em_vigor' => "ENUM('Sim', 'Não')",
            'descricao' => $this->string()->notNull(),
            'percentagem' => $this->double()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createTable('faturas', [
            'id' => $this->primaryKey(),
            'data' => $this->dateTime()->notNull(),
            'valor_fatura' => $this->double()->notNull(),
            'estado' => "ENUM('Emitida', 'Paga')",
            'perfil_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createTable('avaliacaos', [
            'id' => $this->primaryKey(),
            'comentario' => $this->string()->notNull(),
            'classificacao' => "ENUM('1', '2', '3', '4', '5')",
            'artigo_id' => $this->integer()->notNull(),
            'perfil_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        $this->createTable('favoritos', [
            'id' => $this->primaryKey(),
            'artigo_id' => $this->integer()->notNull(),
            'perfil_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');


        //CHAVES ESTRANGEIRAS https://www.yiiframework.com/doc/guide/2.0/en/db-migrations
        //atenção aos comentarios que não estao no manual do yii
        // TEMOS QUE FAZER DROP DAS CHAVES? PERGUNTAR AO PROFESSOR

        /*INICIO CHAVES ESTRANGEIRAS DA TABELA  favoritos*/

        $this->addForeignKey(
            'fk-favoritos-artigos_id',
            'favoritos',
            'artigo_id',
            'artigos',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-favoritos-perfil_id',
            'favoritos',
            'perfil_id',
            'perfis',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /*FIM CHAVES ESTRANGEIRAS DA TABELA  favoritos*/

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
            'fornecedor_id',
            'fornecedores',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-artigos-perfil_id',
            'artigos',
            'perfil_id',
            'perfis',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-artigos-categoria_id',
            'artigos',
            'categoria_id',
            'categorias',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /*FIM CHAVES ESTRANGEIRAS DA TABELA ARTIGOS */

        /*INICIO CHAVES ESTRANGEIRAS DA TABELA CARRINHO_linha */

        $this->addForeignKey(
            'fk-linhascarrinho-artigos_id',
            'linhas_carrinho',
            'artigo_id',
            'artigos',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-linhascarrinho-perfil_id',
            'linhas_carrinho',
            'perfil_id',
            'perfis',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /*FIM CHAVES ESTRANGEIRAS DA TABELA CARRINHO_LINHA */

        /*INICIO CHAVES ESTRANGEIRAS DA TABELA fatura_ITEMS */

        $this->addForeignKey(
            'fk-linhasfaturas-artigos_id',
            'linhas_faturas',
            'artigo_id',
            'artigos',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-linhasfaturas-faturas_id',
            'linhas_faturas',
            'fatura_id',
            'faturas',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /*FIM CHAVES ESTRANGEIRAS DA TABELA fatura_ITEMS */

        /*INICIO CHAVES ESTRANGEIRAS DA TABELA  avaliacaos*/

        $this->addForeignKey(
            'fk-avaliacaos-artigos_id',
            'avaliacaos',
            'artigo_id',
            'artigos',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-avaliacaos-perfil_id',
            'avaliacaos',
            'perfil_id',
            'perfis',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /*FIM CHAVES ESTRANGEIRAS DA TABELA  avaliacaos*/

        /*INICIO CHAVES ESTRANGEIRAS DA TABELA faturas */

        $this->addForeignKey(
            'fk-faturas-perfil_id',
            'faturas',
            'perfil_id',
            'perfis',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /*FIM CHAVES ESTRANGEIRAS DA TABELA  faturas*/

        /*INICIO CHAVES ESTRANGEIRAS DA TABELA perfis */

        $this->addForeignKey(
            'fk-perfis-user',
            'perfis',
            'id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('perfis');
        $this->dropTable('empresa');
        $this->dropTable('fornecedores');
        $this->dropTable('artigos');
        $this->dropTable('linhas_carrinho');
        $this->dropTable('ivas');
        $this->dropTable('faturas');
        $this->dropTable('avaliacoes');
        $this->dropTable('categorias');
        $this->dropTable('linhas_faturas');
        $this->dropTable('favoritos');
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
